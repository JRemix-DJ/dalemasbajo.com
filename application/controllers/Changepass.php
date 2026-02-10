<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Changepass extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->library(array('session','form_validation'));
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model'));
		$this->load->database('default');
		$this->users_model->check_payment();
	}
	public function index(){
		$email = $this->input->get('email');
		$token = $this->input->get('token');
		if($email!=null&&$token!=null){
			$where=array(
				'email'				=>	$email,
				'activationcode'	=>	$token
			);
			//var_dump($where);
			$user = $this->users_model->get_user_where_array($where);
			//print_r($user);
			if($user){
				if($user->active==1){
					$data['title']="Account Confirmation - Dale Más Bajo";
					$data['description']="Confirma tu cuenta";
					$data['confirm']=0;
					$data['user_id'] = $user->id;
					$data['message']="Gracias, tu cuenta ha sido confirmada, ahora puedes ingresar";
					$this->load->view('templates/header', $data);
					$this->load->view('changepass');
					$this->load->view('templates/footer', $data);	
				}else{
					$data['title']="Cambiar Password - Dale Más Bajo";
					$data['description']="Cambiar Password";
					$data['confirm']=0;
					$data['message']="Tu cuenta fue confirmada previamente, ahora puedes ingresar de manera normal.";
					$this->load->view('templates/header', $data);
					$this->load->view('error');
					$this->load->view('templates/footer', $data);	
				}
			}else{
				$data['title']="Account Confirmation - Dale Más Bajo";
				$data['description']="Confirma tu cuenta";
				$data['confirm']=0;
				$data['message']="No hemos podido confirmar tu cuenta";
				$this->load->view('templates/header', $data);
				$this->load->view('error');
				$this->load->view('templates/footer', $data);	
			}
		}else{
			$data['title']="Account Confirmation - Dale Más Bajo";
			$data['description']="Confirma tu cuenta";
			$data['confirm']=0;
			$data['message']="No hemos podido confirmar tu cuenta";
			$this->load->view('templates/header', $data);
			$this->load->view('error');
			$this->load->view('templates/footer', $data);	
		}
	}
}