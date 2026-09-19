<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model', 'plan_model'));
		$this->load->library(array('session','form_validation','cart', 'pagination', 'dmbfunctions'));
		$this->load->database('default');
		$this->users_model->check_payment();
	}

	public function index()
	{
		$data['title'] = "Dale Más Bajo - Audio & Video Remixes for DJs";
		$data['description'] = "Música para Djs y Vjs, los mejores remixes en un solo lugar";
		$data['styles'] = ['assets/front/css/pages/home.css'];
		$data['scripts'] = ['assets/front/js/pages/home.js'];

		$where = ['approved' => 1];
		$data['products'] = $this->products_model->get_current_page_records(
			5,
			0,
			$where,
			'gender_id',
			[45],
			null
		);

		$data['trending_audios'] = $this->products_model->get_trending_now(5);

		if ($data['products'] === false) {
			$data['products'] = [];
		}

		$data['plans'] = $this->plan_model->get_plans();
		$this->load->view('home', $data);
		$this->load->view('layouts/footer', $data);
	}
}
