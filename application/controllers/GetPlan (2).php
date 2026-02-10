<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Getplan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'genero_model', 'plan_model', 'products_model', 'banners_model', 'faq_model'));
		$this->load->library(array('session','form_validation','Flowapi'));
		$this->load->database('default');
	}

	public function index()
	{
		$data['title']="Checkout - Dale Más Bajo";
		$data['description']="Finaliza tu pago";
		$data['products']=$this->products_model->get_products();
		$data['generos']=$this->genero_model->get_generos();
		$data['users']=$this->users_model->get_all_users();
		$data['djs']=$this->users_model->get_djs();
		$plan_id=$_GET['plan_id'];
		$data['plan']=$this->plan_model->load_plan_info($plan_id);
		$this->load->view('templates/header', $data);
		$this->load->view('checkout');
		$this->load->view('templates/footer', $data);
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
