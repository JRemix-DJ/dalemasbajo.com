<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Response extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model'));
		$this->load->library(array('session','form_validation'));
		$this->load->database('default');
	}

	public function index()
	{
				$data['title']="Checkout - Dale Más Bajo";
				$data['description']="Finaliza tu pago";
				$data['products']=$this->products_model->get_products();
				$data['generos']=$this->genero_model->get_generos();
				$data['users']=$this->users_model->get_all_users();
				$data['cart_total'] = $this->totalCarrito();
				$this->load->view('templates/header', $data);
				$this->load->view('response');
				$this->load->view('templates/footer', $data);
	}

	public function totalCarrito(){
		$total = 0;
		foreach($_SESSION['cart']['items'] as $item){
			$total=$total+$item['price'];
		}
		return $total;
	}


}
