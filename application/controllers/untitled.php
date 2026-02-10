<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model'));
		$this->load->library(array('session','form_validation'));
		$this->load->database('default');
	}

	public function index()
	{
		if($this->session->userdata('is_logued_in')){
				$data['title']="Mi Cuenta - Dale Más Bajo";
				$data['description']="Detalles de tu cuenta";
				$data['products']=$this->products_model->get_products();
				$data['generos']=$this->genero_model->get_generos();
				$data['users']=$this->users_model->get_users();

				$this->load->view('templates/header', $data);
				$this->load->view('micuenta');
				$this->load->view('templates/footer', $data);
		}else{
			$this->load->view('comingsoon');
		}
	}
}
?>