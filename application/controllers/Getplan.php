<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Getplan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'genero_model', 'plan_model', 'products_model', 'banners_model', 'faq_model', 'orders_model'));
		$this->load->library(array('session','form_validation'));
		$this->load->database('default');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in')){
			$data['title']="Checkout - Dale Más Bajo";
			$data['description']="Finaliza tu pago";
			$data['products']=$this->products_model->get_products();
			$data['generos']=$this->genero_model->get_generos();
			$data['users']=$this->users_model->get_all_users();
			$data['djs']=$this->users_model->get_djs();
			$plan_id=$_GET['plan_id'];
			$data['plan']=$this->plan_model->load_plan_info($plan_id);
			
			$this->load->view('templates/header', $data);
			$this->load->view('get_plan');
			$this->load->view('templates/footer', $data);
		}else{
			$data['title']="Checkout - Dale Más Bajo";
			$data['description']="Finaliza tu pago";
			$this->load->view('templates/header', $data);
			$this->load->view('checkout-registrate.php');
			$this->load->view('templates/footer', $data);
		}
	}

	public function create_order(){
		print_r($_POST);
		$user_id = $this->input->post('user_id');
		$plan_id = $this->input->post('plan_id');
		$plan=$this->plan_model->load_plan_info($plan_id);
		$data_order = array(
			'user_id'		=>	$this->session->userdata('id_usuario'),
			'date_order'	=> 	date("Y-m-d H:i:s"),
			'total_price'	=> 	$plan->price,
			'status'		=> 	1,
			'is_plan'		=>	1,
			'plan_id'		=>	$plan->id
		);
		$order_id = $this->orders_model->create_order_plan($data_order);
		echo $order_id;
	}


	public function test()
	{
		if($this->session->userdata('is_logued_in')){
			$data['title']="Checkout - Dale Más Bajo";
			$data['description']="Finaliza tu pago";
			$data['products']=$this->products_model->get_products();
			$data['generos']=$this->genero_model->get_generos();
			$data['users']=$this->users_model->get_all_users();
			$data['djs']=$this->users_model->get_djs();
			$plan_id=$_GET['plan_id'];
			$data['plan']=$this->plan_model->load_plan_info($plan_id);
			$data_order = array(
				'user_id'		=>	$this->session->userdata('id_usuario'),
				'date_order'	=> 	date("Y-m-d H:i:s"),
				'total_price'	=> 	$data['plan']->price,
				'status'		=> 	0,
				'is_plan'		=>	1,
				'plan_id'		=>	$data['plan']->id
			);
			if(isset($_SESSION['cart']['cupon'])){
				$data_order['discount']=1;
				$data_order['total_discount']=$_SESSION['cart']['cupon']['descuento_total'];
				$data_order['cupon_id'] = $_SESSION['cart']['cupon']['cupon_id'];
			}
			$order_id = $this->orders_model->create_order_plan($data_order);
			$data['order_id'] = $order_id;
			$this->load->view('templates/header', $data);
			$this->load->view('get_plan_test');
			$this->load->view('templates/footer', $data);
		}else{
			$data['title']="Checkout - Dale Más Bajo";
			$data['description']="Finaliza tu pago";
			$this->load->view('templates/header', $data);
			$this->load->view('checkout-registrate.php');
			$this->load->view('templates/footer', $data);
		}
	}

	public function totalCarrito(){
		$total = 0;
		if(isset($_SESSION['cart'])){ 
			foreach($_SESSION['cart'] as $item){
				$total=$total+$item['price'];
			}
		}
		return $total;
	}


}
