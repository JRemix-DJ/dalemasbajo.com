<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model', 'location_model'));
		$this->load->library(array('session','form_validation','cart', 'pagination', 'email'));
		$this->load->database('default');
	}

	public function become_a_member(){
		$data['title']="Dale Más Bajo";
		$data['djs']=$this->users_model->get_djs();
		$data['description']="Música para Djs y Vjs, los mejores remixes en un solo lugar";
		$data['paises']=$this->get_countries();
		$data['generos']=$this->genero_model->get_generos();

		$this->load->view('templates/header', $data);
		$this->load->view('become_a_member');
		$this->load->view('templates/footer', $data);
	}
	public function get_countries(){
		$countries = $this->location_model->get_countries(); 
		return $countries;
	}
	public function ser_miembro_mail(){
		$email = $this->input->post('email');
		$name = $this->input->post('name');
		$experience = $this->input->post('experience');
		$work = $this->input->post('work');
		$country = $this->input->post('country');
		$trabajos = $this->input->post('trabajos');
		$message = $this->input->post('message');

		$mensaje = "
		<table width='100%'>
			<tr>
				<td><strong>Nombre: </strong></td>
				<td>$name</td>
			</tr>
			<tr>
				<td><strong>E-mail: </strong></td>
				<td>$email</td>
			</tr>
			<tr>
				<td><strong>Experiencia: </strong></td>
				<td>$experience</td>
			</tr>
			<tr>
				<td><strong>País: </strong></td>
				<td>$country</td>
			</tr>
			<tr>
				<td><strong>¿Trabaja para otros sitios web?: </strong></td>
				<td>$work</td>
			</tr>
			<tr>
				<td><strong>Quiere pertenecer a DMB porque: </strong></td>
				<td>$message</td>
			</tr>
			<tr>
				<td><strong>Trabajos </strong></td>
				<td><a href=".$trabajos.">Ver</a></td>
			</tr>
		</table>
		";
		$config['protocol']    = 'smtp';

		$config['smtp_host']    = SMTP_URL;

		$config['smtp_port']    = SMTP_PORT;

		$config['smtp_timeout'] = '7';

		$config['smtp_user']    = SMTP_USER;

		$config['smtp_pass']    = SMTP_KEY;

		$config['charset']    = 'utf-8';

		$config['newline']    = "\r\n";
		$config['mailtype'] = 'html'; // or html
		$config['validation'] = TRUE; // bool whether to validate email or not      
		$this->email->initialize($config);
		$this->email->from('dalemasbajo@gmail.com', 'DALE MÁS BAJO');
		$this->email->to("dalemasbajo@gmail.com");
		$this->email->subject('DJ QUIERE SER MIEMBRO');

		$data['mensaje'] = $mensaje;

		$mail = $this->load->view('emails/become_member', $data, TRUE);
		$this->email->message($mail);

		$this->email->send();
		$jsondata['success'] = true;
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata);
	}
	

	public function terms_conditions(){
		$data['title']="Dale Más Bajo";
		$data['djs']=$this->users_model->get_djs();
		$data['description']="Música para Djs y Vjs, los mejores remixes en un solo lugar";
		$data['paises']=$this->get_countries();
		$data['generos']=$this->genero_model->get_generos();

		$this->load->view('templates/header', $data);
		$this->load->view('terms_conditions');
		$this->load->view('templates/footer', $data);
		
	}


}