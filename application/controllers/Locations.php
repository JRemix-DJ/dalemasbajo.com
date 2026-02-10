<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->library(array('session','form_validation'));
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->load->model('location_model');
		$this->load->database('default');
	}

	public function get_countries(){
		$countries = $this->location_model->get_countries(); 
		return $countries;
	}

}