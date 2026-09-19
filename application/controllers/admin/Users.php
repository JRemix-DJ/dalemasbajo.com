<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller {

	public function force_new_pass(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$users_who_pay = $this->users_model->get_users_who_pay();
				$i=0;
				foreach($users_who_pay as $u){
					$nuevo_pass = $this->random(8);
					if(!$this->users_model->check_email_sent($u->email)){
						$this->force_newpass($u->id, $nuevo_pass);
						$data = array(
							'email'		=>	$u->email,
							'enviado'	=>	1,
							'cambiado'	=>	0
						);
						$this->users_model->add_user_forced($data);
						$this->send_forced_change_pass_email($u->email, $nuevo_pass);
						$i++;
						echo '<strong style="color: gree">'.$i.')'.$u->email.': ENVIADO</strong><br>';
					}else{
						echo '<strong style="color: red">'.$u->email.': ESTE EMAIL YA FUE ENVIADO</strong><br>';
					}
				}
			}
		}
	}

	public function send_forced_change_pass_email($email, $password){

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

		$this->email->to($email);

		$this->email->subject('NUEVA CONTRASEÑA DE ACCESO A DALEMASBAJO.COM');

		$data['password']=$password;
		$data['email']=$email;

		$mail = $this->load->view('emails/forced_change_pass_email', $data, TRUE);
		$this->email->message($mail);

		$this->email->send();
		return; 
	}

	public function force_newpass($user_id, $pass){
		$encriptedpass =  password_hash($pass, PASSWORD_BCRYPT);
		$data = array(
			'password' => $encriptedpass,
		);
		$this->users_model->update_user($user_id, $data);
		return true;
	}

	public function encrypt_all_users(){
		ini_set('max_execution_time', 600);
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$users = $this->users_model->get_all_users();
				foreach($users as $user){
					if($user->id > 516){
						$password = $user->password;
						$id = $user->id;
						$encriptedpass =  password_hash($password, PASSWORD_BCRYPT);
						$data = array(
							'id'=>$id,
							'password'=>$encriptedpass
						);
						$this->users_model->update_user($id, $data);
					}
				}
			}
		}
	}

	public function editar_perfil(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$data['title']="Editar Perfil";
				$data['description']="Aquí podrás editar la información de tu perfil";
				$user_info = $this->users_model->load_user_info($this->session->id_usuario);
				$data['user_info']=$user_info;
				$data['token']=$this->token();
				$data['paises']=$this->get_countries();
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/editar_perfil');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function cambiar_pass(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$data['title']="Cambiar Contraseña";
				$data['description']="Aquí podrás editar tu contraseña";
				$user_info = $this->users_model->load_user_info($this->session->id_usuario);
				$data['user_info']=$user_info;
				$data['token']=$this->token();
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/cambiar_pass');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function listar_usuarios(){
		if($this->user_has_admin_access()){
			$accion = $this->input->get('action');
			$user_id = $this->input->get('user_id');
			$user_role= $this->session->userdata('role');
			switch($accion){
				case 'delete':
					$user = $this->users_model->load_user_info($user_id);
					if(!$user){
						$mensaje='Este Usuario no existe';
					}else{
						if($user_role=='is_admin'|| $user_role=='is_subadmin'){
							$this->users_model->delete_user($user_id);
						}
					}
				break;
			}
			$where=array();
			if(isset($_GET['s'])){
				$where['email']=urldecode($_GET['s']);
				$data['where'] = $_GET['s'];
			}else{
				$data['where'] = '';
			}
			$this->load->model('users_model');
			if($this->session->userdata('is_logued_in')){
				$data['title']="Usuarios";
				$data['description']="Administra a todos los usuarios dentro del sistema";
				$data['aditional_scripts']="<script>
			      $(function(){
			        'use strict';
			        $('#datatable1').DataTable({
			          responsive: true,
			          rowReorder:false,
			          paging: false,
			          info: false, 
			          ordering: false
			          language: {
			            searchPlaceholder: 'Buscar...',
			            sSearch: '',
			            lengthMenu: '_MENU_ items/pagina',
			            paginate: {
			            	next: 'Siguiente',
			            	previous: 'Anterior',
			            },
			            emptyTable: 'No hay registros para esta vista',
			            info:           'Mostrando _START_ a _END_ de _TOTAL_ registros',
	    				infoEmpty:      'Mostrando 0 a 0 de 0 registros',
			          }
			          //'scrollX': true,
			        });
			        // Select2
			        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

			      });
			    </script>";
			    $data['aditional_stylesheets']='
			    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
			    $data['users']=$this->users_model->get_users($where);
			    $data['roles']=$this->users_model->get_roles();
			    $data['paises']=$this->get_countries();
			   	if(isset($mensaje)){
			    	$data['mensaje']=$mensaje;
				}
				
				$data['accion'] = 'admin/mostrar_usuarios/';
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/usuarios');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url().'admin/login/');
			}
		}else{
			redirect(base_url());
		}
	}

	public function mostrar_usuarios(){
		$numeropagina = $this->input->post("nropagina");
		$cantidad = $this->input->post("cantidad");
		$where['email'] = $this->input->post("where");

		$inicio = ($numeropagina -1)*$cantidad;
		$data["total_registros"] =	count($this->users_model->get_users($where));
		$users = $this->users_model->get_users($where, $inicio, $cantidad);
		$roles = $this->users_model->get_roles();
		$data['roles'] = $roles;
		$html = '';
		foreach ($users as $key => $user) {
			$html .= '<tr>
				<td class="align-middle">'. $user->username .'</td>
				<td class="align-middle">'. $user->ip_registro .'</td>
				<td class="align-middle">'. $user->email .'</td>
				<td class="align-middle">'. date('m-d-Y', strtotime($user->registered_on)) .'</td>
				
				<td class="align-middle">'. $roles[array_search($user->role_id, array_column($roles, 'id'))]->name .'</td>
				<td class="align-middle">
					<a href="'. base_url() .'admin/ver_descargar/?user_id='. $user->id .'" class="btn btn-info">Descargas</a>
					<a href="'. base_url() .'admin/editar_usuario/?user_id='. $user->id .'" class="btn btn-danger">Editar</a>
					<a href="'. base_url() .'admin/listar_usuarios/?action=delete&user_id='. $user->id .'" class="btn btn-danger">Delete</a>
				</td>
			</tr>';
		  }
		$data['users'] = $users;
		$data['html'] = $html;
		echo json_encode($data);
	}

	public function listar_djs(){
		$accion = $this->input->get('action');
		$user_id = $this->input->get('user_id');
		$user_role= $this->session->userdata('role');
		$this->load->model('users_model');
		if($accion=='delete'){
			
			$user = $this->users_model->load_user_info($user_id);
			if(!$user){
				$mensaje='Este Usuario no existe';
			}else{

				if($user_role=='is_admin'|| $user_role=='is_editor'){
					$this->users_model->delete_user($user_id);
				}else{
					$mensaje= "No tienes permisos para realizar esta acción";
				}
			}
		}
		if($this->session->userdata('is_logued_in')){
			$data['title']="Usuarios";
			$data['description']="Administra a todos los usuarios dentro del sistema";
			$data['aditional_scripts']="<script>
		      $(function(){
		        'use strict';
		        $('#datatable1').DataTable({
		          responsive: true,
		          paging: false,
		          ordering: false,
		          info: false, 
		          language: {
		            searchPlaceholder: 'Buscar...',
		            sSearch: '',
		            lengthMenu: '_MENU_ items/pagina',
		            paginate: {
		            	next: 'Siguiente',
		            	previous: 'Anterior',
		            },
		            emptyTable: 'No hay registros para esta vista',
		            info:           'Mostrando _START_ a _END_ de _TOTAL_ registros',
    				infoEmpty:      'Mostrando 0 a 0 de 0 registros',
		          }
		          //'scrollX': true,
		        });
		        // Select2
		        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

		      });
		    </script>";
		    $data['aditional_stylesheets']='
		    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
		    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
		    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
		    $data['users']=$this->users_model->get_djs();
		    $data['roles']=$this->users_model->get_roles();
		    $data['paises']=$this->get_countries();
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/djs');
			$this->load->view('admin/footer');
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function editar_usuario(){
		$this->load->model('users_model');
		if($this->session->userdata('is_logued_in')){
			$user_id = $this->input->get('user_id');
			$user_role= $this->session->userdata('role');
			if(isset($user_id)){
				$usuario = $this->users_model->load_user_info($user_id);
				if(!$usuario){
					$mensaje='Este producto no existe';
					echo $mensaje;
				}else{
					if($user_role=='is_admin'|| $user_role=='is_editor'){
						$this->print_editar_usuario($usuario);
					}else{
						$mensaje='No tienes permisos suficientes para esta acción';
						echo $mensaje;
					}
				}
			}else{
				$mensaje="Ups! parece que estas haciendo algo mal";
				echo $mensaje;
			}

		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function print_editar_usuario($user_data){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$data['title']="Editar Usuario";
				$data['description']="Editar usuario";
				$data['generos']=$this->genero_model->get_generos();
				$data['usuario']=$user_data;
				$data['roles']=$this->users_model->get_roles();
				$data['paises']=$this->get_countries();
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/editar_usuario');
				$this->load->view('admin/footer');
			}
		}
	}

	//START FORMAT
	// public function name(){
	// 	if($this->session->userdata('is_logued_in')){
		
	// 	}else{
	// 		redirect(base_url().'admin/login/');
	// 	}
	// }

	public function nuevo_usuario(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
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
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function nuevo_dj(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
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
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function get_countries(){
		$countries = $this->location_model->get_countries(); 
		return $countries;
	}

}
