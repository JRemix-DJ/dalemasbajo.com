<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Planes extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'genero_model', 'plan_model','products_model', 'banners_model', 'faq_model', 'orders_model'));
		$this->load->library(array('session','form_validation', 'email'));
		$this->load->database('default');
	}

	public function index()
	{
		$data['title']="Planes - Dale Más Bajo";
		$data['description']="Conoce los planes para ser miembro";
		$data['djs']=$this->users_model->get_djs();
		$data['generos']=$this->genero_model->get_generos();
		$data['plans']=$this->plan_model->get_plans();
		$this->load->view('templates/header', $data);
		$this->load->view('planes_new');
		$this->load->view('templates/footer', $data);
	}

	public function test()
	{
		$data['title']="Planes - Dale Más Bajo";
		$data['description']="Conoce los planes para ser miembro";
		$data['djs']=$this->users_model->get_djs();
		$data['generos']=$this->genero_model->get_generos();
		$data['plans']=$this->plan_model->get_plans();
		$this->load->view('templates/header', $data);
		$this->load->view('planes_new');
		$this->load->view('templates/footer', $data);
	}

}