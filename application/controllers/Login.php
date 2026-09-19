<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('login_model', 'users_model'));
		$this->load->library(array('session','form_validation', 'email'));
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->load->helper(array('url','form'));
		$this->load->database('default');
	}

	public function index()
	{
		redirect(base_url().'admin/login');
	}

	public function getUserIpAddr(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	public function front(){
		if($this->input->post('email') && $this->input->post('password'))
		{
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$ip = $this->getUserIpAddr();
			$check_user = $this->login_model->login_front($email, $password, $ip);

			if($check_user != FALSE)
			{
				$tokens = $this->users_model->hasTokens($check_user->id);
				$tokens_video = $this->users_model->hasTokensVideo($check_user->id);
				$ilimitado = $this->users_model->isUnlimited($check_user->id);

				if($tokens == false && $tokens_video == false){
					$user_has_tokens = false;
					$tokens = 0;
					$tokens_video = 0;
					$user_is_unlimited = $ilimitado;
				}else{
					$user_has_tokens = true;
					$tokens = ($tokens != false) ? $tokens[0]->total : 0;
					$tokens_video = ($tokens_video != false) ? $tokens_video[0]->total : 0;
					$user_is_unlimited = ($ilimitado != false);
				}

				if($check_user->active == 0){
					$jsondata['success'] = false;
					$jsondata['message'] = "Usuario no activo, revisa tu correo y confirmalo para poder ingresar";
					header('Content-type: application/json; charset=utf-8');
					echo json_encode($jsondata);
				}else{
					switch($check_user->role_id){
						case 1:
							$role = "is_admin";
							break;
						case 2:
							$role = "is_subadmin";
							break;
						case 3:
							$role = "is_editor";
							break;
						default:
							$role = "is_normal";
							break;
					}

					$user_products = $this->users_model->get_user_products($check_user->id);
					$user_product_ids = array();
					foreach($user_products as $user_product){
						$user_product_ids[] = (string)$user_product->product_id;
					}

					$data = array(
						'is_logued_in' 		=> TRUE,
						'id_usuario' 		=> $check_user->id,
						'role'				=> $role,
						'first_name'		=> $check_user->first_name,
						'last_name'			=> $check_user->last_name,
						'username' 			=> $check_user->username,
						'profile_img' 		=> $check_user->profile_img,
						'email' 			=> $check_user->email,
						'is_user_tokens'	=> $user_has_tokens,
						'is_user_unlimited'	=> $user_is_unlimited,
						'tokens'			=> $tokens,
						'tokens_video'		=> $tokens_video,
						'user_products'		=> $user_product_ids
					);

					$this->session->set_userdata($data);
					$jsondata['success'] = true;
					header('Content-type: application/json; charset=utf-8');
					echo json_encode($jsondata);
				}
			}else{
				$jsondata['success'] = false;
				$jsondata['message'] = "Username o Password Incorrectos";
				header('Content-type: application/json; charset=utf-8');
				echo json_encode($jsondata);
			}
		}else{
			$jsondata['success'] = false;
			$jsondata['message'] = "Username y Password son Obligatorios";
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
		}
	}

	public function do()
	{
		if($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token'))
		{
			$this->form_validation->set_rules('email', 'nombre de usuario', 'required|trim|min_length[2]|max_length[150]');
			$this->form_validation->set_rules('password', 'password', 'required|trim|max_length[150]');

			if($this->form_validation->run() == FALSE)
			{
				$data['title'] = "Dale Más Bajo";
				$data['description'] = "Música para Djs y Vjs, los mejores remixes en un solo lugar";
				$data['token'] = $this->token();
				$this->load->view('admin/login', $data);
			}else{
				$username = $this->input->post('email');
				$password = $this->input->post('password');
				$ip = $this->getUserIpAddr();
				$check_user = $this->login_model->login_user($username, $password, $ip);
				if($check_user == TRUE)
				{
					switch($check_user->role_id){
						case 1:
							$role = "is_admin";
							break;
						case 2:
							$role = "is_subadmin";
							break;
						case 3:
							$role = "is_editor";
							break;
						default:
							$role = "is_normal";
							break;
					}

					$data = array(
						'is_logued_in' 	=> TRUE,
						'id_usuario' 	=> $check_user->id,
						'role'			=> $role,
						'first_name'	=> $check_user->first_name,
						'last_name'		=> $check_user->last_name,
						'username' 		=> $check_user->username,
						'profile_img' 	=> $check_user->profile_img,
						'email' 		=> $check_user->email
					);
					$this->session->set_userdata($data);
					redirect(base_url().'admin');
				}
			}
		}else{
			redirect(base_url().'admin/login');
		}
	}

	public function token(){
		$token = base64_encode(random_bytes(18));
		return strtr($token, '+/', '-_');
	}

	public function recuperar_contrasena(){
		if($this->input->post('email')){
			$email = $this->input->post('email');
			$where['email'] = $email;
			$user = $this->users_model->get_user_where_array($where);
			if($user){
				$token = $this->token();
				$data = array('activationcode' => $token);
				$this->users_model->update_user($user->id, $data);
				$this->send_change_password_email($email, $token);
				$jsondata['message'] = 'Hemos enviado un e-mail con los detalles para cambiar la contraseña';
				$jsondata['success'] = true;
				header('Content-type: application/json; charset=utf-8');
				echo json_encode($jsondata);
			}else{
				$jsondata['message'] = 'El e-mail que haz ingresado no esta en nuestra base de datos, confirma que haz escrito bien tu correo.';
				$jsondata['success'] = false;
				header('Content-type: application/json; charset=utf-8');
				echo json_encode($jsondata);
			}
		}else{
			$jsondata['message'] = 'Debes ingresar un correo electrónico';
			$jsondata['success'] = false;
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
		}
	}

	public function send_change_password_email($email, $token){
		$config['protocol']    = 'smtp';
		$config['smtp_host']   = SMTP_URL;
		$config['smtp_port']   = SMTP_PORT;
		$config['smtp_timeout']= '7';
		$config['smtp_user']   = SMTP_USER;
		$config['smtp_pass']   = SMTP_KEY;
		$config['charset']     = 'utf-8';
		$config['newline']     = "\r\n";
		$config['mailtype']    = 'html';
		$config['validation']  = TRUE;

		$this->email->initialize($config);
		$this->email->from('web@dalemasbajo.com', 'DALE MÁS BAJO');
		$this->email->to($email);
		$this->email->subject('Cambio de Contraseña');

		$data['token'] = $token;
		$data['email'] = $email;

		$mail = $this->load->view('emails/changepassword', $data, TRUE);
		$this->email->message($mail);
		$this->email->send();
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}