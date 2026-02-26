<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->library(array('session','form_validation', 'email'));
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->load->model('users_model');
		$this->load->database('default');
		$this->load->model('location_model');
	}

	public function new_user(){
		$this->load->model('users_model');
    	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    	$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('passwordrepeat', 'Repetir Password', 'required|matches[password]');
		if($this->form_validation->run() == FALSE){
			$this->print_nuevo_usuario();
		}else{
			$username= $this->input->post('username');
			$email = $this->input->post('email');
			$country = $this->input->post('country_id');
			$role_id = $this->input->post('role_id');
			$password=$this->input->post('password');
			$encriptedpass =  password_hash($password, PASSWORD_BCRYPT);
			$percentage=$this->input->post('percentage');
			$fecha_registro=date('Y-m-d');
			$ip = $this->getUserIpAddr();
    			$data = array(
    				'username'=>$username,
					'email'=>$email,
					'country_id'=>$country,
					'role_id'=>$role_id,
					'password'=>$encriptedpass,
					'percentage'=>$percentage,
					'registered_on'=>$fecha_registro,
					'ip_registro'=>$ip,
					'active'=>1
				);
				$id=$this->users_model->create_user($data);
				$this->print_editar_usuario($id);

		}
	}

	public function getUserIpAddr(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			//ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

    public function registro() {
        $username = trim((string)$this->input->post('username', true));
        $email    = trim((string)$this->input->post('email', true));
        $password = (string)$this->input->post('password', true);

        header('Content-type: application/json; charset=utf-8');

        if ($username === '' || $email === '' || $password === '') {
            echo json_encode(['respuesta' => 'invalid']);
            exit;
        }

        $whereemail = ['email' => $email];
        $whereuser  = ['username' => $username];

        if ($this->users_model->get_user_where($whereemail)) {
            echo json_encode(['respuesta' => 'email_existe']);
            exit;
        }

        if ($this->users_model->get_user_where($whereuser)) {
            echo json_encode(['respuesta' => 'username_existe']);
            exit;
        }

        $encriptedpass  = password_hash($password, PASSWORD_BCRYPT);
        $fecha_registro = date('Y-m-d');
        $ip             = $this->getUserIpAddr();

        $data = [
            'username'       => $username,
            'email'          => $email,
            'role_id'        => 4,
            'password'       => $encriptedpass,
            'activationcode' => null,
            'registered_on'  => $fecha_registro,
            'active'         => 1,
            'ip_registro'    => $ip
        ];

        $id = $this->users_model->create_user($data);

        echo json_encode(['respuesta' => $id ? 'ok' : 'error']);
        exit;
    }

	public function print_nuevo_usuario(){
			$data['roles']=$this->users_model->get_roles();
			$data['title']="Añadir Usuario";
			$data['description']="Añade usuarios manualmente al sitio ";
			$data['paises']=$this->get_countries();
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/nuevo_usuario');
			$this->load->view('admin/footer');
	}

	public function update_user(){
		$this->load->model('users_model');
			$id = $this->input->post('user_id');
	    	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			if($this->form_validation->run() == FALSE){
				$this->print_editar_usuario($id);
			}else{
				$user_info = $this->users_model->load_user_info($id);
				$username= $this->input->post('username');
				$email = $this->input->post('email');
				$country = $this->input->post('country_id');
				$percentage = $this->input->post('percentage');
				
				$role_id = $this->input->post('role_id');
				$password=$this->input->post('password');
				$passwordrepeat=$this->input->post('passwordrepeat');
	    			$data = array(
						'username'=>$username,
						'email'=>$email,
						'country_id'=>$country,
						'role_id'=>$role_id,
						'percentage'=>$percentage
					);
					if ($password != "" || $passwordrepeat != "") {
						if ($user_info->password != $password) {
							if ($password == $passwordrepeat) {
								$encriptedpass =  password_hash($password, PASSWORD_BCRYPT);
								$data['password'] = $encriptedpass;
							}else{
								$mensaje = "Password deben ser iguales.";
								$this->print_editar_usuario($id, $mensaje);
							}
						}
					}else{
						$mensaje = "Campos de password son obligatorios.";
						$this->print_editar_usuario($id, $mensaje);
					}
					$mensaje = "Usuario actualizado con exito.";
					$this->users_model->update_user($id, $data);
					$this->print_editar_usuario($id, $mensaje);
			}
	}

	public function print_editar_usuario($user_id, $mensaje=NULL){
		$data['title']="Actualizar Usuario";
		$data['description']="Aquí podrás editar tu información";
		$user_info = $this->users_model->load_user_info($user_id);
		$data['usuario']=$user_info;
		//$data['token']=$this->token();
		$data['paises']=$this->get_countries();

		if(!is_null($mensaje)){ $data['mensaje']=$mensaje; }
		$data['roles']=$this->users_model->get_roles();
		
		$this->load->view('admin/head', $data);
		$this->load->view('admin/side');
		$this->load->view('admin/top');
		$this->load->view('admin/editar_usuario');
		$this->load->view('admin/footer');
	}

	public function editar_perfil(){
		$id = $this->session->id_usuario;
    	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if($this->form_validation->run() == FALSE){
			$data['title']="Actualizar Usuario";
			$data['description']="Aquí podrás editar tu información";
			$user_info = $this->users_model->load_user_info($this->session->id_usuario);
			$data['user_info']=$user_info;
			$data['paises']=$this->get_countries();
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/editar_perfil');
			$this->load->view('admin/footer');
		}else{
			$firstname = $this->input->post('firstname');
			$lastname = $this->input->post('lastname');
			$email = $this->input->post('email');
			$address = $this->input->post('address');
			$city = $this->input->post('city');
			$country = $this->input->post('country');
			$phone = $this->input->post('phone');
			if(!file_exists($_FILES['profile_img']['tmp_name']) || !is_uploaded_file($_FILES['profile_img']['tmp_name'])) {
    			$data = array(
					'first_name'=>$firstname,
					'last_name'=>$lastname,
					'email'=>$email,
					'address'=>$address,
					'city'=>$city,
					'country_id'=>$country,
					'phone'=>$phone
				);
				$this->users_model->update_user($id, $data);
				$data['title']="Actualizar Usuario";
				$data['description']="Aquí podrás editar tu información";
				$user_info = $this->users_model->load_user_info($this->session->id_usuario);
				$data['user_info']=$user_info;
				//$data['token']=$this->token();
				$data['paises']=$this->get_countries();

				$data['mensaje']="El usuario ha sido actualizado";
				$user_info = $this->users_model->load_user_info($this->session->id_usuario);
				$data['user_info']=$user_info;
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/editar_perfil');
				$this->load->view('admin/footer');
			}else{
				$image_folder='images/users/profile_img/';
				$temp = explode(".", $_FILES["profile_img"]["name"]);
				$newfilename = round(microtime(true)) . '.' . end($temp);
				$image_file=$image_folder.basename($_FILES['profile_img']['name']);

				if ($_FILES['profile_img']['error'] !== UPLOAD_ERR_OK) {
					die("Upload failed with error code " . $_FILES['profile_img']['error']);
				}

				$info = getimagesize($_FILES['profile_img']['tmp_name']);
				if ($info === FALSE) {
					die("Unable to determine image type of uploaded file");
				}

				if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
					die("Not a gif/jpeg/png");
				}
				if(move_uploaded_file($_FILES['profile_img']['tmp_name'], $image_folder.$newfilename)){
					

					$data = array(
						'first_name'=>$firstname,
						'last_name'=>$lastname,
						'email'=>$email,
						'address'=>$address,
						'city'=>$city,
						'country_id'=>$country,
						'phone'=>$phone,
						'profile_img'=>$newfilename,
					);
					$this->users_model->update_user($id, $data);
					$data['title']="Actualizar Usuario";
					$data['description']="Aquí podrás editar tu información";
					$user_info = $this->users_model->load_user_info($this->session->id_usuario);
					$data['user_info']=$user_info;
					//$data['token']=$this->token();
					$data['paises']=$this->get_countries();

					$data['mensaje']="El usuario ha sido actualizado";
					$user_info = $this->users_model->load_user_info($this->session->id_usuario);
					$data['user_info']=$user_info;
					$this->load->view('admin/head', $data);
					$this->load->view('admin/side');
					$this->load->view('admin/top');
					$this->load->view('admin/editar_perfil');
					$this->load->view('admin/footer');
				}
			}
		}
	}

	public function actualizar_password(){
		$id = $this->session->id_usuario;
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('passwordrepeat', 'Repetir Password', 'required|matches[password]');
		if($this->form_validation->run() == FALSE){
			$data['title']="Cambiar Contraseña";
			$data['description']="Aquí podrás editar tu contraseña";
			$user_info = $this->users_model->load_user_info($this->session->id_usuario);
			$data['user_info']=$user_info;
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/cambiar_pass');
			$this->load->view('admin/footer');
		}else{
			$pass = $this->input->post('password');
			$repeat = $this->input->post('passwordrepeat');
			$encriptedpass =  password_hash($pass, PASSWORD_BCRYPT);
			$data = array(
				'password'=> $encriptedpass,
			);
			$this->users_model->update_user($id, $data);
			$data['title']="Cambiar Contraseña";
			$data['description']="Aquí podrás editar tu contraseña";
			$data['mensaje']="Tu contraseña ha sido actualizada";
			$user_info = $this->users_model->load_user_info($this->session->id_usuario);
			$data['user_info']=$user_info;
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/cambiar_pass');
			$this->load->view('admin/footer');
		}	
	}

	public function token(){
		$token = base64_encode(random_bytes(18));
		$token = strtr($token, '+/', '-_');
		return $token;
	}
	
	public function get_countries(){
		$countries = $this->location_model->get_countries(); 
		return $countries;
	}

	public function changepass(){
		$pass=$this->input->post('pass');
		$rpass=$this->input->post('rpass');
		$id=$this->input->post('id');

		if($pass==$rpass){
			//echo 'entro';
			$encriptedpass =  password_hash($pass, PASSWORD_BCRYPT);
			$data = array(
				'password' => $encriptedpass,
			);
			$this->users_model->update_user($id, $data);
			$jsondata['success'] = true;
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
		}else{
			$jsondata['success'] = false;
			header('Content-type: application/json; charset=utf-8');
			echo json_encode($jsondata);
		}
	}

    public function send_registered_mail($email, $token)
    {
        $this->email->clear(true);

        $this->load->config('email', true);
        $email_cfg = $this->config->item('email');
        if (is_array($email_cfg)) {
            $this->email->initialize($email_cfg);
        } else {
            $this->email->initialize();
        }

        $this->email->from('dalemasbajo@gmail.com', 'DALE MÁS BAJO');
        $this->email->to((string)$email);
        $this->email->subject('Confirm your email');

        $data = [
            'token' => $token,
            'email' => $email
        ];

        $mail = $this->load->view('emails/confirmaccount', $data, true);
        $this->email->message($mail);

        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");

        $ok = $this->email->send(false);

        if (!$ok) {
            log_message('error', 'send_registered_mail FAIL :: '.$this->email->print_debugger(['headers','subject']));
        }

        return (bool)$ok;
    }
}