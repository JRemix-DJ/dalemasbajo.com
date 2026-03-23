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
        header('Content-type: application/json; charset=utf-8');

        $email = trim((string)$this->input->post('email'));
        $name = trim((string)$this->input->post('name'));
        $experience = trim((string)$this->input->post('experience'));
        $work = trim((string)$this->input->post('work'));
        $country = trim((string)$this->input->post('country'));
        $trabajos = trim((string)$this->input->post('trabajos'));
        $message = (string)$this->input->post('message');

        if($email === '' || $name === ''){
            echo json_encode(['success' => false]);
            return;
        }

        $mensaje = "
        <table width='100%'>
            <tr><td><strong>Name:</strong></td><td>{$name}</td></tr>
            <tr><td><strong>E-mail:</strong></td><td>{$email}</td></tr>
            <tr><td><strong>Experience:</strong></td><td>{$experience}</td></tr>
            <tr><td><strong>Country:</strong></td><td>{$country}</td></tr>
            <tr><td><strong>Do you work for other websites?:</strong></td><td>{$work}</td></tr>
            <tr><td><strong>Why do you want to join DMB?:</strong></td><td>{$message}</td></tr>
            <tr><td><strong>Works:</strong></td><td><a href='{$trabajos}' target='_blank' rel='noopener'>View</a></td></tr>
        </table>
    ";

        $this->email->clear(true);

        $this->load->config('email', true);
        $email_cfg = $this->config->item('email');
        if(is_array($email_cfg)){
            $this->email->initialize($email_cfg);
        }else{
            $this->email->initialize();
        }

        $this->email->from('dalemasbajo@gmail.com', 'DALE MÁS BAJO');
        $this->email->to('dalemasbajo@gmail.com');
        $this->email->subject('DJ WANTS TO BECOME A MEMBER');

        $data_mail = ['mensaje' => $mensaje];
        $mail = $this->load->view('emails/become_member', $data_mail, true);
        $this->email->message($mail);

        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");

        $ok = $this->email->send(false);

        if(!$ok){
            log_message('error', 'ser_miembro_mail FAIL :: '.$this->email->print_debugger(['headers','subject']));
        }

        echo json_encode(['success' => (bool)$ok]);
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

    public function request_remix(){
        $data['title'] = "Dale Más Bajo";
        $data['djs'] = $this->users_model->get_djs();
        $data['description'] = "Música para Djs y Vjs, los mejores remixes en un solo lugar";
        $data['paises'] = $this->get_countries();
        $data['generos'] = $this->genero_model->get_generos();

        $data['force_login_modal'] = false;
        $data['eligible'] = false;
        $data['user_email'] = null;

        // 1) Si no está logueado => mostrar modal login
        if(!$this->session->userdata('is_logued_in')){
            $data['force_login_modal'] = true;

            $this->load->view('templates/header', $data);
            $this->load->view('request_remix', $data);
            $this->load->view('templates/footer', $data);
            return;
        }

        $user_id = (int)$this->session->userdata('id_usuario');
        $data['eligible'] = $this->users_model->has_standard_or_higher_plan($user_id);

        $data['user_email'] = $this->session->userdata('email');

        $this->load->view('templates/header', $data);
        $this->load->view('request_remix', $data);
        $this->load->view('templates/footer', $data);
    }

    public function submit_request_remix(){
        header('Content-type: application/json; charset=utf-8');

        if(!$this->session->userdata('is_logued_in')){
            echo json_encode(['success' => false, 'message' => 'You must be logged in.']);
            return;
        }

        $user_id = (int)$this->session->userdata('id_usuario');

        if(!$this->users_model->has_standard_or_higher_plan($user_id)){
            echo json_encode(['success' => false, 'message' => 'You need an active Standard plan or higher.']);
            return;
        }

        $email = (string)$this->session->userdata('email');
        $song_link = trim((string)$this->input->post('song_link'));
        $instructions = trim((string)$this->input->post('instructions'));

        if($song_link === '' || !filter_var($song_link, FILTER_VALIDATE_URL)){
            echo json_encode(['success' => false, 'message' => 'Please provide a valid Song Link (URL).']);
            return;
        }

        $safe_instructions = nl2br(htmlspecialchars($instructions, ENT_QUOTES, 'UTF-8'));

        $mensaje = "
        <table width='100%' cellpadding='6' cellspacing='0' style='border-collapse:collapse;'>
            <tr><td><strong>User ID:</strong></td><td>{$user_id}</td></tr>
            <tr><td><strong>Email:</strong></td><td>{$email}</td></tr>
            <tr><td><strong>Song Link:</strong></td><td><a href='{$song_link}' target='_blank' rel='noopener'>Open link</a></td></tr>
            <tr><td><strong>Message:</strong></td><td>{$safe_instructions}</td></tr>
        </table>
    ";

        $this->email->clear(true);

        $this->load->config('email', true);
        $email_cfg = $this->config->item('email');
        if(is_array($email_cfg)){
            $this->email->initialize($email_cfg);
        }else{
            $this->email->initialize();
        }

        $this->email->from('dalemasbajo@gmail.com', 'DALE MÁS BAJO');
        $this->email->to('dalemasbajo@gmail.com');
        $this->email->subject('CUSTOM REMIX REQUEST');

        $data_mail = ['mensaje' => $mensaje];
        $mail = $this->load->view('emails/become_member', $data_mail, true);
        $this->email->message($mail);

        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");

        $ok = $this->email->send(false);

        if(!$ok){
            log_message('error', 'submit_request_remix FAIL :: '.$this->email->print_debugger(['headers','subject']));
        }

        echo json_encode(['success' => (bool)$ok]);
    }
}