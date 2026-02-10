<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Micuenta extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model', 'orders_model'));
		$this->load->library(array('session','form_validation'));
		$this->load->database('default');
	}

	public function show_session(){
		echo '<pre>';
		print_r($_SESSION);
		echo '<br>';
		print_r($this->session->userdata('id_usuario'));
		echo '<br>';
		print_r($this->users_model->isUnlimited($this->session->userdata('id_usuario')));
		echo '<br>';
		$ilimitado = $this->users_model->isUnlimited($this->session->userdata('id_usuario'));	
		echo $ilimitado;
		echo '</pre>';
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in')){
			$data['title']="Mi Cuenta - Dale Más Bajo";
			$data['description']="Detalles de tu cuenta";
			$data['products']=$this->products_model->get_products();
			$data['generos']=$this->genero_model->get_generos();
			$data['users']=$this->users_model->get_all_users();
			$data['orders']=$this->orders_model->get_orders_by_user($this->session->userdata('id_usuario'));
			$data['djs']=$this->users_model->get_djs();
			$data['descargas']=$this->orders_model->load_descargas($this->session->userdata('id_usuario'));

			$this->load->view('templates/header', $data);
			$this->load->view('micuenta');
			$this->load->view('templates/footer', $data);
		}
	}

	public function compra(){
		if($this->session->userdata('is_logued_in')){
			$order_id=$this->uri->segment(3);
			$data['title']="Mi Cuenta - Dale Más Bajo";
			$data['description']="Detalles de tu cuenta";
			$data['products']=$this->products_model->get_products();
			$data['generos']=$this->genero_model->get_generos();
			$data['users']=$this->users_model->get_all_users();
			$data['orders']=$this->orders_model->get_orders_by_user($this->session->userdata('id_usuario'));
			$data['djs']=$this->users_model->get_djs();
			$data['descargas']=$this->orders_model->load_descargas_id($this->session->userdata('id_usuario'), $order_id);

			$this->load->view('templates/header', $data);
			$this->load->view('compra');
			$this->load->view('templates/footer', $data);
		}else{

		}

	}

	public function hasTokensPost(){
		if($this->session->userdata('is_logued_in')){
			$user_id=$this->session->userdata('id_usuario');
			$tokens = $this->users_model->hasTokens($user_id);
			if($this->session->userdata('is_user_unlimited')){
					$jsondata['success']=true;
					$jsondata['is_unlimited']=true;
					header('Content-type: application/json; charset=utf-8');
					echo json_encode($jsondata);
				return;
			}else{ 
				if($tokens==false){
					$tokens = 0;
				}else{
					$tokens = $tokens[0]->total;
				}
				if($tokens!=false){
					$jsondata['success']=true;
					$jsondata['tokens']=$tokens;
					header('Content-type: application/json; charset=utf-8');
					echo json_encode($jsondata);
				}else{
					$jsondata['tokens']=0;
					$jsondata['success']=true;
					header('Content-type: application/json; charset=utf-8');
					echo json_encode($jsondata);
				}
			}
		}else{
			$jsondata['success']=false;
			$jsondata['message']="NOTLOGGEDIN";
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
		}
	}

	public function hasTokensPostVideo(){
		$user_id=$this->session->userdata('id_usuario');
		$tokens = $this->users_model->hasTokensVideo($user_id);
		if($this->session->userdata('is_user_unlimited')){
			$jsondata['is_unlimited']=true;
				header('Content-type: application/json; charset=utf-8');
				echo json_encode($jsondata);
			return;
		}else{ 
			if($tokens==false){
				$tokens = 0;
			}else{
				$tokens = $tokens[0]->total;
			}
			if($tokens!=false){
				$jsondata['tokens_video']=$tokens;
				header('Content-type: application/json; charset=utf-8');
				echo json_encode($jsondata);
			}else{
				$jsondata['tokens_video']=0;
				header('Content-type: application/json; charset=utf-8');
				echo json_encode($jsondata);
			}
		}
	}

	public function descargar_producto(){
		if(isset($_POST['product_id'])){
			if($this->session->userdata('is_logued_in')){
				$user_id = $this->session->userdata('id_usuario');
				$product_id=$_POST['product_id'];
				$tokens= $this->users_model->hasTokens($this->session->userdata('id_usuario'));
				if($tokens==false){
					$tokenstotal = 0;
				}else{
					$tokenstotal = $tokens[0]->total;
				}
				if($tokenstotal>0||$this->orders_model->user_files($user_id, $product_id)||$this->session->userdata('is_user_unlimited')){
					$jsondata['success']=true;
					$tokens = $this->users_model->hasTokens($this->session->userdata('id_usuario'));
					$jsondata['total_tokens']=$tokenstotal;
					$jsondata['is_unlimited']=$this->session->userdata('is_user_unlimited');
					$this->session->set_userdata('tokens', $tokenstotal);
					$jsondata['message']='DESCARGANDO';
					if (!in_array($_POST['product_id'], $_SESSION['user_products'])){
						$_SESSION['user_products'][]=$_POST['product_id'];
					}
					header('Content-type: application/json; charset=utf-8');
					echo json_encode($jsondata);
				}else{
					$jsondata['success']=false;
					$jsondata['message']='NOTOKENS';
					header('Content-type: application/json; charset=utf-8');
					echo json_encode($jsondata);
				}
			}else{
				$jsondata['success']=false;
				$jsondata['message']='NOLOGGUEDIN';
				header('Content-type: application/json; charset=utf-8');
				echo json_encode($jsondata);
			}
		}else{
			header( "Location: ".base_url() );
		}
	}

	public function descargar_producto_video(){
		
		if(isset($_POST['product_id'])){
			if($this->session->userdata('is_logued_in')){
				$user_id = $this->session->userdata('id_usuario');
				$product_id=$_POST['product_id'];
				$tokens= $this->users_model->hasTokensVideo($this->session->userdata('id_usuario'));
				if($tokens==false){
					$tokenstotal = 0;
				}else{
					$tokenstotal = $tokens[0]->total;
				}
				if($tokenstotal>0||$this->orders_model->user_files($user_id, $product_id)||$this->session->userdata('is_user_unlimited')==1){
					$jsondata['success']=true;
					$tokens = $this->users_model->hasTokensVideo($this->session->userdata('id_usuario'));
					$jsondata['total_tokens']=$tokenstotal;
					$jsondata['is_unlimited']=$this->session->userdata('is_user_unlimited');
					$this->session->set_userdata('tokens_video', $tokenstotal);
					$jsondata['message']='DESCARGANDO';
					if (!in_array($_POST['product_id'], $_SESSION['user_products'])){
						$_SESSION['user_products'][]=$_POST['product_id'];
					}
					header('Content-type: application/json; charset=utf-8');
					echo json_encode($jsondata);
				}else{
					$jsondata['success']=false;
					$jsondata['message']='NOTOKENS';
					header('Content-type: application/json; charset=utf-8');
					echo json_encode($jsondata);
				}
			}else{
				$jsondata['success']=false;
				$jsondata['message']='NOLOGGUEDIN';
				header('Content-type: application/json; charset=utf-8');
				echo json_encode($jsondata);
			}
		}else{
			header( "Location: ".base_url() );
		}
	}


}
?>