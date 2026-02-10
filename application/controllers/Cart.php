<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'cupons_model', 'genero_model', 'products_model', 'banners_model', 'faq_model', 'orders_model'));
		$this->load->library(array('session','form_validation'));
		$this->load->database('default');
		$this->users_model->check_payment();
		$this->users_model->check_payment();
	}

	public function index()
	{
		$data['title']="Mi Carrito - Dale Más Bajo";
		$data['description']="Detalles de tu cuenta";
		$data['products']=$this->products_model->get_products();
		$data['generos']=$this->genero_model->get_generos();
		$data['users']=$this->users_model->get_all_users();
		if(isset($_SESSION['cart']['cupon'])){
			$this->reapplyCupon($_SESSION['cart']['cupon']['code']);
		}
		if(isset($_SESSION['cart'])){
			$data['cart_items'] = $_SESSION['cart']['items'];
		}
		$data['djs']=$this->users_model->get_djs();
		$data['cart_total'] = $this->totalCarrito();
		$this->load->view('templates/header', $data);
		$this->load->view('carrito');
		$this->load->view('templates/footer', $data);
	}


	/*
    CUPON TYPE
        1 = DESCUENTO
        2 = PAGO MINIMO DESCUENTO PORCENTAJE
        3 = PAGO MINIMO DESCUENTO TOTAL
    */

	public function reapplyCupon($cupon_code){
		$total = 0;
		$cupon = $this->products_model->get_cupon($cupon_code);
		foreach($_SESSION['cart']['items'] as $item){
			$total += $item['price'];
		}
		$descuento_total = $total*($cupon->discount/100);
		$descuento_total = round($descuento_total, 2);
		$descuento = array(
			'code'				=>	$cupon->code,
			'type'				=>	$cupon->type,
			'aplicado'			=>	true,
			'discount'			=>	$cupon->discount,
			'descuento_total'	=>	$descuento_total,
			'description'		=>	$cupon->description,
			'cupon_id'			=>	$cupon->id
		);
		if($cupon->type==2){
			if($this->check_discount_condition($cupon_code)){
				$_SESSION['cart']['cupon'] = $descuento;
			}else{
				unset($_SESSION['cart']['cupon']);
			}
		}else{
			$_SESSION['cart']['cupon'] = $descuento;
		}
	}

	public function removeCupon(){
		unset($_SESSION['cart']['cupon']);
		$jsondata['success'] = true;
		$jsondata['message'] = 'Cupon removido';
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata);
	}

	public function applyCupon(){
		$cupon_code = $_POST['cupon'];
		if($this->is_valid_cupon($cupon_code)){
			$cupon = $this->products_model->get_cupon($cupon_code);
			switch($cupon->type){
				case 1:
					$this->apply_discount($cupon);
					$jsondata['success'] = true;
					$jsondata['message'] = 'cupon válido';
					break;
					case 2:
					if($this->check_discount_condition($cupon_code)){
						$this->apply_discount($cupon);
						$jsondata['success'] = true;
						$jsondata['message'] = 'cupon válido';
					}else{
						$jsondata['success'] = false;
						$jsondata['message'] = 'No cumples las condiciones para obtener este cupon';
					}
					break;
					case 3:
					
					break;
				}
			$jsondata['cupon_id'] = $cupon->id;
				//print_r($cupon);
			
		}else{
			$jsondata['success'] = false;
			$jsondata['message'] = 'este cupon no existe';
		}
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata);
	}

	public function check_discount_condition($cupon_code){
		$cupon = $this->cupons_model->get_cupon($cupon_code);
		$total = 0;
		foreach($_SESSION['cart']['items'] as $item){
			$total += $item['price'];
		}
		if($total>=$cupon->parameter){
			return true;
		}else{
			return false;
		}
	}

	public function apply_discount($cupon){
		$total = 0;
		foreach($_SESSION['cart']['items'] as $item){
			$total += $item['price'];
		}
		$descuento_total = $total*($cupon->discount/100);
		$descuento_total = round($descuento_total, 2);
		$descuento = array(
			'code'				=>	$cupon->code,
			'aplicado'			=>	true,
			'type'				=>	$cupon->type,
			'discount'			=>	$cupon->discount,
			'descuento_total'	=>	$descuento_total,
			'description'		=>	$cupon->description,
			'cupon_id'			=>	$cupon->id
		);
		$_SESSION['cart']['cupon'] = $descuento;
	}

	public function apply_min_discount_percentage(){

	}

	public function apply_min_discount_total(){

	}

	public function is_valid_cupon($code){
		if($this->products_model->get_cupon_by_code($code)){
			return true;
		}else{
			return false;
		}
		return false;
	}

	public function totalCarrito(){
		$total = 0;
		if(isset($_SESSION['cart'])){
			foreach($_SESSION['cart']['items'] as $item){
				$total=$total+$item['price'];
			}
		}
		if(isset($_SESSION['cart']['cupon'])){
			$total = $total-$_SESSION['cart']['cupon']['descuento_total'];
		}
		return $total;
	}

	public function acciones(){
		$accion = $this->uri->segment(3);
		switch($accion){
			case 'add_to_cart':
				if(isset($_POST['id'])){
					$product_id = $_POST['id'];
					if($producto = $this->products_model->load_product_info($product_id)){
						$item = array(
							'id'		=>	$producto->id, 
							'name'		=>	$producto->name, 
							'price'		=>	$producto->price,
							'version'	=>	$producto->version,
							'bpm'		=>	$producto->bpm,
							'artist'	=>	$producto->artist
						);
						if (!isset($_SESSION['cart'])) {
							$_SESSION['cart'] = array();
							$_SESSION['cart']['items']=array();
						}
						if(!empty($_SESSION["cart"])) {
							if(array_search($producto->id,array_column($_SESSION["cart"]['items'], 'id'))!==false) {
								$jsondata['success'] = false;
								$jsondata['message'] = "Este producto ya fue añadido";
								$jsondata['cart'] = $_SESSION["cart"];
							} else {
								array_push($_SESSION["cart"]['items'],$item);
								$jsondata['cart_count'] = count($_SESSION["cart"]['items']);
								$jsondata['success'] = true;
							}
						} else {
							array_push($_SESSION["cart"]['items'],$item);
							$jsondata['cart_count'] = count($_SESSION["cart"]['items']);
							$jsondata['success'] = true;
						}
					}else{
						$jsondata['success'] = false;
						$jsondata['message'] = 'Este producto no existe';
					}
				}else{
					$jsondata['success'] = false;
					$jsondata['message'] = 'Algo extraño esta pasando 🤔';
				}
				header('Content-type: application/json; charset=utf-8');
				echo json_encode($jsondata);
			break;
			case 'remove_from_cart':
				if(isset($_POST['id'])){
					$_SESSION['cart']['items'] = array_values($_SESSION['cart']['items']);
					$product_id = $_POST['id'];
					$position = array_search($product_id,array_column($_SESSION["cart"]["items"], "id"));
					unset($_SESSION['cart']['items'][$position]);
					$jsondata['position']=$position;
					$jsondata['success'] = true;
					$jsondata['message'] = 'Hemos eliminado el producto del carrito';
				}else{
					$jsondata['success'] = false;
					$jsondata['message'] = 'Algo extraño esta pasando 🤔';
				}
				header('Content-type: application/json; charset=utf-8');
				echo json_encode($jsondata);
			break;
			case 'empty_cart':

			break;
		}
	}

	public function create_order(){
		if(isset($_POST['total'])){
			$data = array(
				'user_id'		=>	$this->session->userdata('id_usuario'),
				'date_order'	=> 	date("Y-m-d H:i:s"),
				'total_price'	=> 	$_POST['total'],
				'status'		=> 	0
			);
			if(isset($_SESSION['cart']['cupon'])){
				$data['discount']=1;
				$data['total_discount']=$_SESSION['cart']['cupon']['descuento_total'];
				$data['cupon_id'] = $_SESSION['cart']['cupon']['cupon_id'];
			}
			$order_id = $this->orders_model->create_order($data);
			$jsondata['order_id'] = $order_id;
			$jsondata['success'] = true;

			header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
		}else{
			$jsondata['success']=false;
			$jsondata['message']='algo raro esta ocurriendo';

			header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);

		}
	}
}
?>