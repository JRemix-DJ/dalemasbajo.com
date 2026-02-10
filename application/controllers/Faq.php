<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->library(array('session','form_validation'));
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model'));
		$this->load->database('default');
	}

	// public function get_all_products(){
	// 	$data['products']=$this->products_model->get_products();
	// }

	public function index(){
		$data['djs']=$this->users_model->get_djs();
		$data['title']="FAQ - Dale Más Bajo";
		$data['description']="Compra los mejores remixes para djs del continente";
		$data['products']=$this->products_model->get_products();
		$data['generos']=$this->genero_model->get_generos();
		$data['users']=$this->users_model->get_all_users();
		$data['faqs']=$this->faq_model->get_faq();

		$this->load->view('templates/header', $data);
		$this->load->view('faq');
		$this->load->view('templates/footer', $data);		
	}

}