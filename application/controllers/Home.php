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
		$data['title']="Dale Más Bajo";
		$data['description']="Música para Djs y Vjs, los mejores remixes en un solo lugar";
        $where = ['approved' => 1];
        $data['products'] = $this->products_model->get_current_page_records(
            5,          // limit
            0,          // start
            $where,     // where_parameter
            'gender_id',// no_parameter (where_not_in column)
            [45],       // not_in
            null        // search
        );

        if ($data['products'] === false) $data['products'] = [];
		$data['plans']=$this->plan_model->get_plans();
		$this->load->view('home', $data);
		$this->load->view('templates/footer', $data);
	}

	public function comingsoon()
	{
		$this->load->view('comingsoon');
	}

}
