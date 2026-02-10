<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confirmaccount extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->library(array('session','form_validation'));
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model'));
		$this->load->database('default');
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
				if($user->active==0){
					$data=array(
						'active'=>1,
					);
					$this->users_model->update_user($user->id, $data);
					$data['title']="Account Confirmation - Dale Más Bajo";
					$data['description']="Confirma tu cuenta";
					$data['confirm']=0;
					$data['generos']=$this->genero_model->get_generos();
					$data['djs']=$this->users_model->get_djs();
					$data['message']="Gracias, tu cuenta ha sido confirmada, ahora puedes ingresar";
					$this->load->view('templates/header', $data);
					$this->load->view('confirmacion');
					$this->load->view('templates/footer', $data);	
				}else{
					$data['title']="Account Confirmation - Dale Más Bajo";
					$data['description']="Confirma tu cuenta";
					$data['confirm']=0;
					$data['generos']=$this->genero_model->get_generos();
					$data['djs']=$this->users_model->get_djs();
					$data['message']="Tu cuenta fue confirmada previamente, ahora puedes ingresar de manera normal.";
					$this->load->view('templates/header', $data);
					$this->load->view('confirmacion');
					$this->load->view('templates/footer', $data);	
				}
			}else{
				$data['title']="Account Confirmation - Dale Más Bajo";
				$data['description']="Confirma tu cuenta";
				$data['confirm']=0;
				$data['generos']=$this->genero_model->get_generos();
				$data['djs']=$this->users_model->get_djs();
				$data['message']="No hemos podido confirmar tu cuenta";
				$this->load->view('templates/header', $data);
				$this->load->view('confirmacion');
				$this->load->view('templates/footer', $data);	
			}
		}else{
			$data['title']="Account Confirmation - Dale Más Bajo";
			$data['description']="Confirma tu cuenta";
			$data['confirm']=0;
			$data['generos']=$this->genero_model->get_generos();
			$data['djs']=$this->users_model->get_djs();
			$data['message']="No hemos podido confirmar tu cuenta";
			$this->load->view('templates/header', $data);
			$this->load->view('confirmacion');
			$this->load->view('templates/footer', $data);	
		}
	}
}