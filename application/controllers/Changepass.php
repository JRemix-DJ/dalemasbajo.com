<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Changepass extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->helper(['url','form']);
        $this->load->library(['session']);
        $this->load->model('users_model');
        $this->load->database('default');
    }

    public function index(){
        $email = trim((string)$this->input->get('email', true));
        $token = trim((string)$this->input->get('token', true));

        if($email === '' || $token === ''){
            return $this->show_error_page("Link inválido.");
        }

        $token_hash = hash('sha256', $token);

        $row = $this->users_model->validate_password_reset_token($email, $token_hash);
        if(!$row){
            return $this->show_error_page("Este link ya fue usado o no es válido.");
        }

        $user = $this->users_model->get_user_by_email($email);
        if(!$user){
            return $this->show_error_page("No existe el usuario.");
        }

        $data['title'] = "Cambiar Password - Dale Más Bajo";
        $data['description'] = "Cambiar Password";

        // IMPORTANTE: pasa email+token para que el POST valide otra vez
        $data['reset_email'] = $email;
        $data['reset_token'] = $token;

        $this->load->view('templates/header', $data);
        $this->load->view('changepass', $data);
        $this->load->view('templates/footer', $data);
    }

    private function show_error_page($msg){
        $data['title'] = "Error - Dale Más Bajo";
        $data['description'] = "Error";
        $data['message'] = $msg;

        $this->load->view('templates/header', $data);
        $this->load->view('error', $data);
        $this->load->view('templates/footer', $data);
    }
}