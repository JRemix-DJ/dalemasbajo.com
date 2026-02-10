<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	private $path_preview='assets/products/demos/';
	private $path_preview_videos='assets/products/demos/videos/';
	private $path_cover='images/products/featured_image/';
	private $path_download='assets/products/descargables/';
	private $path_download_videos='assets/products/descargables/videos/';
	private $file_name=''; //SE OBTIENE POR POST
	private $user_rol = '';
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'cupons_model', 'plan_model', 'genero_model', 'products_model', 'banners_model','precios_model', 'faq_model', 'orders_model'));
		$this->load->library(array('session','form_validation', 'pagination', 'email'));
		$this->load->database('default');
		$this->load->model('location_model');
		$this->user_rol= $this->session->userdata("role");
		$user_role= $this->session->userdata('role');
		if($this->user_has_admin_access()){
		}else{
			redirect(base_url());
		}
	}


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

	public function random($x){
		$token = base64_encode(random_bytes($x));
		$token = strtr($token, '+/=', 'dmb');
		return $token;
	}


	public function index()
	{
		if($this->session->userdata('is_logued_in')){
			if($this-> user_has_admin_access()){
				$data['title']="Dale Más Bajo";
				$data['description']="Música para Djs y Vjs, los mejores remixes en un solo lugar";
				$data['aditional_scripts']='<script src="'.site_url().'admin_assets/js/dashboard.js"></script>';
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/index');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function cupones(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$data['title']="Cupones";
				$data['description']="Ver cupones";
				
				$cupones = $this->products_model->get_cupons();
				$data['cupones']=$cupones;
				$data['aditional_scripts']="<script>
			      $(function(){
			        'use strict';
			        $('#datatable1').DataTable({
			          responsive: true,
			          paging: false,
			          order: false,
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
			        });
			        // Select2
			        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

			      });
			    </script>";
			    $data['aditional_stylesheets']='
			    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/cupones');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
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

	public function editar_cupon(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$id = $this->uri->segment(3);
				$data['title']="Editar Precio";
				$data['description']="Edita los precios";
				$data['cupon']=$this->products_model->get_cupon_by_id($id);
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/editar_cupon');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function edit_cupon(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$id = $this->input->post('id');
				$code = $this->input->post('code');
				$description = $this->input->post('description');
				$discount = $this->input->post('discount');
				$parameter = $this->input->post('parameter');
				$type = $this->input->post('type');
				$data = array(
					'code'			=> $code,
					'description'	=> $description,
					'discount'		=> $discount,
					'type'			=> $type,
					'parameter'		=> $parameter
				);
				$this->cupons_model->update_cupon($id, $data);
				redirect(base_url('/admin/editar_cupon/'.$id));
			}
		}else{
			redirect(base_url('admin/login/'));
		}
	}

	public function user_has_admin_access(){
		switch($this->session->userdata('role')){
			case "is_admin":
				return true;
				break;
			case "is_subadmin":
				return true;
				break;
			case "is_editor":
				return true;
				break;
			case "is_normal":
				return false;
				break;
		}
		return false;
	}
	public function add_precio(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$name = $this->input->post('name');
				$price = $this->input->post('price');
				//$id = $this->input->post('id');
					
				$data = array(
					'name'=>$name,
					'price'=>$price,
					//'description'=>$description,
					//'img'=>$newfilename,
				);
				$id=$this->precios_model->create_precio($data);
				$precio = $this->precios_model->load_precio_info($id);
				$mensaje = "Precio Creado";
				$this->print_edit_precio($id, $precio, $mensaje);
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}
	public function print_edit_precio($id,$precio, $mensaje ){
		if($this->user_has_admin_access()){
			$data['title']="Editar Precio";
			$data['description']="Editar los Precios";
			$data['mensaje']=$mensaje;
		    $data['precios']=$this->precios_model->get_precios();
		    $data['precio']=$this->precios_model->load_precio_info($id);

			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/nuevo_precio');
			$this->load->view('admin/footer');
		}else{
			redirect(base_url());
		}
	}
	function editar_precio(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$id = $this->input->get('precio_id');
				$data['title']="Editar Precio";
				$data['description']="Edita los precios";
				$data['precio']=$this->precios_model->load_precio_info($id);
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/nuevo_precio');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}
	public function precios(){
		if($this->session->userdata('is_logued_in')){
			if($this->session->userdata('role')=='is_admin'){
				$user_role= $this->session->userdata('role');
				$precio_id = $this->input->get('precio_id');
				$accion = $this->input->get('action');
				switch($accion){
					case 'delete':
						$precio = $this->precios_model->load_precio_info($precio_id);
						if(!$precio){
							$mensaje='Este precio no existe';
						}else{
							if($user_role=='is_admin'|| $user_role=='is_subadmin'){
								$this->precios_model->delete_precio($precio_id);
								$mensaje='Precio eliminado';
							}
						}
					break;
				}
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
			        });
			        // Select2
			        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

			      });
			    </script>";
			    $data['aditional_stylesheets']='
			    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
				$data['title']="Precios";
				$data['description']="A continuación podrás ver el listado de precios que tienes disponibles en tu sitio web";
				$data['aditional_scripts']='<script src="'.site_url().'admin_assets/js/dashboard.js"></script>';
				$data['precios']=$this->precios_model->get_precios(); 
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/precios');
				$this->load->view('admin/footer');
			}else{
				$data['title']="Dale Más Bajo";
				$data['description']="Música para Djs y Vjs, los mejores remixes en un solo lugar";
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/permisos');
				$this->load->view('admin/footer');
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function login(){
		$data['title']="Dale Más Bajo";
		$data['description']="Música para Djs y Vjs, los mejores remixes en un solo lugar";
		$data['token']=$this->token(); 
		$this->load->view('admin/login', $data);
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

	public function listar_productos(){
		if($this->user_has_admin_access()){
			$accion = $this->input->get('action');
			$product_id = $this->input->get('product_id');
			$user_role= $this->session->userdata('role');
			switch($accion){
				case 'delete':
					$producto = $this->products_model->load_product_info($product_id);
					if(!$producto){
						$mensaje='Este producto no existe';
					}else{

						if($user_role=='is_admin'|| $user_role=='is_subadmin'){
							$this->products_model->delete_product($product_id);
						}else{
							if($producto->owner_id==$this->session->userdata('id_usuario')){
								$this->products_model->delete_product($product_id);
							}
						}
					}
				break;
				case 'approve':
					$producto = $this->products_model->load_product_info($product_id);
					if(!$producto){
						$mensaje='Este producto no existe';
					}else{
						if($user_role=='is_admin'|| $user_role=='is_subadmin'){
							$fecha = date("Y-m-d H:i:s");
							$data = array(
								'approved'=>1,
								'time_approved'=> $fecha
							);
							$this->products_model->update_product($product_id, $data);
						}else{
							if($producto->owner_id==$this->session->userdata('id_usuario')){
								$data = array(
									'approved'=>1
								);
								$this->products_model->update_product($product_id, $data);
							}
						}
					}
				break;
				case 'disapprove':
					$producto = $this->products_model->load_product_info($product_id);
					if(!$producto){
						$mensaje='Este producto no existe';
					}else{
						if($user_role=='is_admin'|| $user_role=='is_subadmin'){
							$data = array(
								'approved'=>0
							);
							$this->products_model->update_product($product_id, $data);
						}else{
							if($producto->owner_id==$this->session->userdata('id_usuario')){
								$data = array(
									'approved'=>0
								);
								$this->products_model->update_product($product_id, $data);
							}
						}
					}
				break;
			}
		
			$where = array();
			//$this->load->model('products_model');
			if($this->session->userdata('is_logued_in')){
				$data['title']="Productos";
				$data['description']="Audios, Packs, y todos los productos dentro del sistema";
				$data['aditional_scripts']="<script>
			      $(function(){
			        'use strict';
			        $('#datatable1').DataTable({
			          responsive: false,
			          paging: false,
			          searching: false,
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
			        });
			        // Select2
			        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

			      });
			    </script>";
			    $data['aditional_stylesheets']='
			    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
			    $data['generos']=$this->genero_model->get_generos();
			    $data['users']=$this->users_model->get_all_users();
				$data['product_types']=$this->products_model->get_product_types();
				
				//definimos que sean audios
				$where['product_type_id']=1;

				if(isset($_GET['genero_filter'])){
					if ($_GET['genero_filter'] != '') {
						$where['gender_id']=$_GET['genero_filter'];
					}
				}
				if(isset($_GET['search'])){
					$search=$_GET['search'];
				}else{
					$search=NULL;
				}
				if(isset($_GET['aprobacion'])){
					if($user_role!='is_admin' && $user_role!="is_subadmin"){
						$where['owner_id']=$this->session->userdata('id_usuario');
		        		$total_records = $this->products_model->get_total_products_por_aprobar($where, $search);
		        	}else{
						$total_records = $this->products_model->get_total_products_por_aprobar(null, $search);
		        	}
				}else{
					if($user_role!='is_admin' && $user_role!="is_subadmin"){
						$where['owner_id']=$this->session->userdata('id_usuario');
						$where['approved']=1;
		        		$total_records = $this->products_model->get_total_products($where, $search);
		        	}else{
		        		$where['approved']=1;
						$total_records = $this->products_model->get_total_products($where, $search);
		        	}
					
				}

			    //$data['products']=$this->products_model->get_products();
			    //$config['base_url']= base_url().'admin/listar_productos';

				$params = array();
		        $limit_per_page = 20;
		        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			    if($total_records > 0)
		        {
		            // get current page records
		        	$where['approved'] = 1;
		        	
		        	if($this->input->get('aprobacion')==1){
		        		$where['approved'] = 0;
		        	}
		        		//print_r($user_role);
		        	if($user_role!='is_admin' && $user_role!="is_subadmin"){
		        		$where['owner_id']=$this->session->userdata('id_usuario');
					}
					
		        	if(isset($_GET['aprobacion'])){
		            	$data["products"] = $this->products_model->get_current_page_records_order_created($limit_per_page, $start_index, $where, null, null, $search);
		        	}else{
		            	$data["products"] = $this->products_model->get_current_page_records($limit_per_page, $start_index, $where, null, null, $search);

		        	}
		             
		            $config['base_url'] = base_url() . 'admin/listar_productos';
		            $config['total_rows'] = $total_records;
		            $config['reuse_query_string']=TRUE;
		            $config['per_page'] = $limit_per_page;
		            $config["uri_segment"] = 3;

		            $config['full_tag_open'] = '<div class="pagination">';
	            	$config['full_tag_close'] = '</div>';

					$config['prev_link'] = 'Anterior';
					$config['next_link'] = 'Siguiente';

		            $this->pagination->initialize($config);
		             
		            // build paging links
		            $data["links"] = $this->pagination->create_links();
		        }


			    if(isset($mensaje)){
			    	$data['mensaje']=$mensaje;
			    }
			    $data['paginationnumber']=$start_index;
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/productos');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url().'admin/login/');
			}
		}else{
			redirect(base_url());
		}
	}

	public function listar_videos(){
		if($this->user_has_admin_access()){
			$accion = $this->input->get('action');
			$product_id = $this->input->get('product_id');
			$user_role= $this->session->userdata('role');
			switch($accion){
				case 'delete':
					$producto = $this->products_model->load_product_info($product_id);
					if(!$producto){
						$mensaje='Este producto no existe';
					}else{

						if($user_role=='is_admin'|| $user_role=='is_subadmin'){
							$this->products_model->delete_product($product_id);
						}else{
							if($producto->owner_id==$this->session->userdata('id_usuario')){
								$this->products_model->delete_product($product_id);
							}
						}
					}
				break;
				case 'approve':
					$producto = $this->products_model->load_product_info($product_id);
					if(!$producto){
						$mensaje='Este producto no existe';
					}else{
						if($user_role=='is_admin'|| $user_role=='is_subadmin'){
							$fecha = date("Y-m-d H:i:s");
							$data = array(
								'approved'=>1,
								'time_approved'=> $fecha
							);
							$this->products_model->update_product($product_id, $data);
						}else{
							if($producto->owner_id==$this->session->userdata('id_usuario')){
								$data = array(
									'approved'=>1
								);
								$this->products_model->update_product($product_id, $data);
							}
						}
					}
				break;
				case 'disapprove':
					$producto = $this->products_model->load_product_info($product_id);
					if(!$producto){
						$mensaje='Este producto no existe';
					}else{
						if($user_role=='is_admin'|| $user_role=='is_subadmin'){
							$data = array(
								'approved'=>0
							);
							$this->products_model->update_product($product_id, $data);
						}else{
							if($producto->owner_id==$this->session->userdata('id_usuario')){
								$data = array(
									'approved'=>0
								);
								$this->products_model->update_product($product_id, $data);
							}
						}
					}
				break;
			}
		
			$where = array();
			//$this->load->model('products_model');
			if($this->session->userdata('is_logued_in')){
				$data['title']="Productos";
				$data['description']="Audios, Packs, y todos los productos dentro del sistema";
				$data['aditional_scripts']="<script>
			      $(function(){
			        'use strict';
			        $('#datatable1').DataTable({
			          responsive: false,
			          paging: false,
			          searching: false,
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
			        });
			        // Select2
			        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

			      });
			    </script>";
			    $data['aditional_stylesheets']='
			    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
			    $data['generos']=$this->genero_model->get_generos();
			    $data['users']=$this->users_model->get_all_users();
				$data['product_types']=$this->products_model->get_product_types();
				//definimos que sean videos
				$where['product_type_id']=3;
				if(isset($_GET['genero_filter'])){
					$where['gender_id']=$_GET['genero_filter'];
				}
				if(isset($_GET['search'])){
					$search=$_GET['search'];
				}else{
					$search=NULL;
				}
				if(isset($_GET['aprobacion'])){
					if($user_role!='is_admin' && $user_role!="is_subadmin"){
						$where['owner_id']=$this->session->userdata('id_usuario');
		        		$total_records = $this->products_model->get_total_products_por_aprobar($where, $search);
		        	}else{
						$total_records = $this->products_model->get_total_products_por_aprobar(null, $search);
		        	}
				}else{
					if($user_role!='is_admin' && $user_role!="is_subadmin"){
						$where['owner_id']=$this->session->userdata('id_usuario');
						$where['approved']=1;
		        		$total_records = $this->products_model->get_total_products($where, $search);
		        	}else{
		        		$where['approved']=1;
						$total_records = $this->products_model->get_total_products($where, $search);
		        	}
					
				}

			    //$data['products']=$this->products_model->get_products();
			    //$config['base_url']= base_url().'admin/listar_productos';

				$params = array();
		        $limit_per_page = 20;
		        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			    if($total_records > 0)
		        {
		            // get current page records
		        	$where['approved'] = 1;
		        	
		        	if($this->input->get('aprobacion')==1){
		        		$where['approved'] = 0;
		        	}
		        		//print_r($user_role);
		        	if($user_role!='is_admin' && $user_role!="is_subadmin"){
		        		$where['owner_id']=$this->session->userdata('id_usuario');
		        	}
		        	if(isset($_GET['aprobacion'])){
		            	$data["products"] = $this->products_model->get_current_page_records_order_created($limit_per_page, $start_index, $where, null, null, $search);
		        	}else{
		            	$data["products"] = $this->products_model->get_current_page_records($limit_per_page, $start_index, $where, null, null, $search);

		        	}
		             
		            $config['base_url'] = base_url() . 'admin/listar_videos';
		            $config['total_rows'] = $total_records;
		            $config['reuse_query_string']=TRUE;
		            $config['per_page'] = $limit_per_page;
		            $config["uri_segment"] = 3;

		            $config['full_tag_open'] = '<div class="pagination">';
	            	$config['full_tag_close'] = '</div>';

					$config['prev_link'] = 'Anterior';
					$config['next_link'] = 'Siguiente';

		            $this->pagination->initialize($config);
		             
		            // build paging links
		            $data["links"] = $this->pagination->create_links();
		        }


			    if(isset($mensaje)){
			    	$data['mensaje']=$mensaje;
			    }
			    $data['paginationnumber']=$start_index;
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/videos');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url().'admin/login/');
			}
		}else{
			redirect(base_url());
		}
	}

	public function listar_drops(){
		if($this-> user_has_admin_access()){
			$accion = $this->input->get('action');
			$product_id = $this->input->get('product_id');
			$user_role= $this->session->userdata('role');
			switch($accion){
				case 'delete':
					$producto = $this->products_model->load_product_info($product_id);
					if(!$producto){
						$mensaje='Este producto no existe';
					}else{

						if($user_role=='is_admin'|| $user_role=='is_subadmin'){
							$this->products_model->delete_product($product_id);
						}else{
							if($producto->owner_id==$this->session->userdata('id_usuario')){
								$this->products_model->delete_product($product_id);
							}
						}
					}
				break;
				case 'approve':
					$producto = $this->products_model->load_product_info($product_id);
					if(!$producto){
						$mensaje='Este producto no existe';
					}else{
						if($user_role=='is_admin'|| $user_role=='is_subadmin'){
							$fecha = date("Y-m-d H:i:s");
							$data = array(
								'approved'=>1,
								'time_approved'=> $fecha
							);
							$this->products_model->update_product($product_id, $data);
						}else{
							if($producto->owner_id==$this->session->userdata('id_usuario')){
								$data = array(
									'approved'=>1
								);
								$this->products_model->update_product($product_id, $data);
							}
						}
					}
				break;
				case 'disapprove':
					$producto = $this->products_model->load_product_info($product_id);
					if(!$producto){
						$mensaje='Este producto no existe';
					}else{
						if($user_role=='is_admin'|| $user_role=='is_subadmin'){
							$data = array(
								'approved'=>0
							);
							$this->products_model->update_product($product_id, $data);
						}else{
							if($producto->owner_id==$this->session->userdata('id_usuario')){
								$data = array(
									'approved'=>0
								);
								$this->products_model->update_product($product_id, $data);
							}
						}
					}
				break;
			}
		
			$where = array();
			//$this->load->model('products_model');
			if($this->session->userdata('is_logued_in')){
				$data['title']="Productos";
				$data['description']="Audios, Packs, y todos los productos dentro del sistema";
				$data['aditional_scripts']="<script>
			      $(function(){
			        'use strict';
			        $('#datatable1').DataTable({
			          responsive: false,
			          paging: false,
			          searching: false,
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
			        });
			        // Select2
			        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

			      });
			    </script>";
			    $data['aditional_stylesheets']='
			    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
			    $data['generos']=$this->genero_model->get_generos();
			    $data['users']=$this->users_model->get_all_users();
				$data['product_types']=$this->products_model->get_product_types();
				//definimos que sean videos
				$where['product_type_id']=5;
				if(isset($_GET['genero_filter'])){
					$where['gender_id']=$_GET['genero_filter'];
				}
				if(isset($_GET['search'])){
					$search=$_GET['search'];
				}else{
					$search=NULL;
				}
				if(isset($_GET['aprobacion'])){
					if($user_role!='is_admin' && $user_role!="is_subadmin"){
						$where['owner_id']=$this->session->userdata('id_usuario');
		        		$total_records = $this->products_model->get_total_products_por_aprobar($where, $search);
		        	}else{
						$total_records = $this->products_model->get_total_products_por_aprobar(null, $search);
		        	}
				}else{
					if($user_role!='is_admin' && $user_role!="is_subadmin"){
						$where['owner_id']=$this->session->userdata('id_usuario');
						$where['approved']=1;
		        		$total_records = $this->products_model->get_total_products($where, $search);
		        	}else{
		        		$where['approved']=1;
						$total_records = $this->products_model->get_total_products($where, $search);
		        	}
					
				}

			    //$data['products']=$this->products_model->get_products();
			    //$config['base_url']= base_url().'admin/listar_productos';

				$params = array();
		        $limit_per_page = 20;
		        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			    if($total_records > 0)
		        {
		            // get current page records
		        	$where['approved'] = 1;
		        	
		        	if($this->input->get('aprobacion')==1){
		        		$where['approved'] = 0;
		        	}
		        		//print_r($user_role);
		        	if($user_role!='is_admin' && $user_role!="is_subadmin"){
		        		$where['owner_id']=$this->session->userdata('id_usuario');
		        	}
		        	if(isset($_GET['aprobacion'])){
		            	$data["products"] = $this->products_model->get_current_page_records_order_created($limit_per_page, $start_index, $where, null, null, $search);
		        	}else{
		            	$data["products"] = $this->products_model->get_current_page_records($limit_per_page, $start_index, $where, null, null, $search);

		        	}
		             
		            $config['base_url'] = base_url() . 'admin/listar_drops/';
		            $config['total_rows'] = $total_records;
		            $config['reuse_query_string']=TRUE;
		            $config['per_page'] = $limit_per_page;
		            $config["uri_segment"] = 3;

		            $config['full_tag_open'] = '<div class="pagination">';
	            	$config['full_tag_close'] = '</div>';

					$config['prev_link'] = 'Anterior';
					$config['next_link'] = 'Siguiente';

		            $this->pagination->initialize($config);
		             
		            // build paging links
		            $data["links"] = $this->pagination->create_links();
		        }


			    if(isset($mensaje)){
			    	$data['mensaje']=$mensaje;
			    }
			    $data['paginationnumber']=$start_index;
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/productos');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url().'admin/login/');
			}
		}else{
			redirect(base_url());
		}
	}

	public function pagos(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$data['title']="Pagos";
				$data['description']="Ver pagos pendientes";
				if($this->session->userdata('role')=='is_editor'){
					$where = 'AND user_id='.$this->session->userdata('id_usuario');
				}else{
					$where = '';
				}
				$pagos = $this->orders_model->get_pagos($where);
				$data['pagos']=$pagos;
				$data['aditional_scripts']="<script>
			      $(function(){
			        'use strict';
			        $('#datatable1').DataTable({
			          responsive: true,
			          paging: false,
			          order: false,
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
			        });
			        // Select2
			        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

			      });
			    </script>";
			    $data['aditional_stylesheets']='
			    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/pagos');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function pagos_tokens(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$data['title']="Pagos de Tokens";
				$data['description']="Ver pagos pendientes";
				if($this->session->userdata('role')=='is_editor'){
					$where = 'AND owner_id='.$this->session->userdata('id_usuario');
				}else{
					$where = '';
				}
				$pagos = $this->orders_model->get_pagos_tokens($where);
				$data['pagos']=$pagos;
				$data['aditional_scripts']="<script>
			      $(function(){
			        'use strict';
			        $('#datatable1').DataTable({
			          responsive: true,
			          paging: false,
			          order: false,
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
			        });
			        // Select2
			        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

			      });
			    </script>";
			    $data['aditional_stylesheets']='
			    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/pagos_tokens');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}
	public function pagos_realizados(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$data['title']="Pagos Realizados";
				$data['description']="Ver pagos realizados";
				if($this->session->userdata('role')=='is_editor'){
					$where = 'AND user_id='.$this->session->userdata('id_usuario');
				}else{
					$where = '';
				}
				$pagos = $this->orders_model->get_pagos_realizados($where);
				$data['pagos']=$pagos;
				$data['aditional_scripts']="<script>
			      $(function(){
			        'use strict';
			        $('#datatable1').DataTable({
			          responsive: true,
			          paging: false,
			          info: false, 
			          rowReorder:false,
			          ordering: false,
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
			        });
			        // Select2
			        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

			      });
			    </script>";
			    $data['aditional_stylesheets']='
			    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/pagos_realizados');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function pagos_realizados_tokens(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$data['title']="Pagos Realizados";
				$data['description']="Ver pagos realizados";
				if($this->session->userdata('role')=='is_editor'){
					$where = 'WHERE dj_id='.$this->session->userdata('id_usuario');
				}else{
					$where = '';
				}
				$pagos = $this->orders_model->get_pagos_realizados_tokens($where);
				$data['pagos']=$pagos;
				$data['aditional_scripts']="<script>
			      $(function(){
			        'use strict';
			        $('#datatable1').DataTable({
			          responsive: true,
			          paging: false,
			          info: false, 
			          rowReorder:false,
			          ordering: false,
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
			        });
			        // Select2
			        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

			      });
			    </script>";
			    $data['aditional_stylesheets']='
			    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/pagos_realizados_tokens');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function detalles_pago(){
		$dj_id=$this->uri->segment(3);
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$data['title']="Pagos";
				$data['description']="Ver pagos pendientes";
				if(isset($_GET['section_realizado'])){
					$pagos = $this->orders_model->get_pagos_details_pagado($dj_id);
				}else{
					$pagos = $this->orders_model->get_pagos_details($dj_id);
				}
				$data['pagos']=$pagos;
				$data['aditional_scripts']="<script>
			      $(function(){
			        'use strict';
			        $('#datatable1').DataTable({
			          responsive: true,
			          paging: false,
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
			        });
			        // Select2
			        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

			      });
			    </script>";
			    $data['aditional_stylesheets']='
			    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/details_pagos');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function detalles_pago_token(){
		$payment_id=$this->uri->segment(3);
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$data['title']="Pagos";
				$data['description']="Ver pagos pendientes";
				if(isset($_GET['section_realizado'])){
					$pagos = $this->orders_model->get_pagos_details_pagado_tokens($payment_id);
				}else{
					$pagos = $this->orders_model->get_pagos_details_tokens($payment_id);
				}
				$data['pagos']=$pagos;
				$data['aditional_scripts']="<script>
			      $(function(){
			        'use strict';
			        $('#datatable1').DataTable({
			          responsive: true,
			          paging: false,
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
			        });
			        // Select2
			        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

			      });
			    </script>";
			    $data['aditional_stylesheets']='
			    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/details_pagos_tokens');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function pago_a_dj(){
		$dj_id=$this->uri->segment(3);
		$this->orders_model->update_pagos($dj_id);
		$this->pagos();
	}

	public function pago_a_dj_token(){
		$dj_id=$this->uri->segment(3);
		$this->orders_model->update_pagos_tokens($dj_id);
		$this->pagos_tokens();
	}

	public function listar_generos(){
		$accion = $this->input->get('action');
		$gender_id = $this->input->get('gender_id');
		$user_role= $this->session->userdata('role');
		
		if($accion=='delete'){
			
			$genero = $this->genero_model->load_genero_info($gender_id);
			if(!$genero){
				$mensaje='Este Género no existe';
			}else{

				if($user_role=='is_admin'|| $user_role=='is_editor'){
					$this->genero_model->delete_genero($gender_id);
				}else{
					$mensaje= "No tienes permisos para realizar esta acción";
				}
			}
		}
		$this->load->model('products_model');
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$data['title']="Generos";
				$data['description']="Generos para audios del sitio web";
				$data['aditional_scripts']="<script>
			      $(function(){
			        'use strict';
			        $('#datatable1').DataTable({
			          responsive: true,
			          searching: false,
			          paging: false,
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
			        });
			        // Select2
			        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

			      });
			    </script>";
			    $data['aditional_stylesheets']='
			    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
			    $data['generos']=$this->genero_model->get_generos();
			    if(isset($mensaje)){
			    	$data['mensaje']=$mensaje;
			    }
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/generos');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}


	public function nuevo_genero(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$data['title']="Añadir Genero";
				$data['description']="Sube nuevos generos a la tienda";

				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/nuevo_genero');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function orden_detail(){
		$orden_id=$this->uri->segment(3);
		if($this->session->userdata('is_logued_in')){
			$data['title']="Listar Ordenes";
			$data['description']="Lista de ordenes en el sitio web";
			$data['order_items']=$this->orders_model->get_order_detail($orden_id);
			$data['usuarios']=$this->users_model->get_all_users();
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/orden_detail');
			$this->load->view('admin/footer');
		}else{
			redirect(base_url('admin/login/'));
		}
	}

	public function nuevo_precio(){
		if($this->session->userdata('is_logued_in')){
			$user_role= $this->session->userdata('role');
			if($this->session->userdata('role')=='is_admin'){
				$data['title']="Añadir Precio";
				$data['description']="Sube nuevos precios a la tienda";

				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/nuevo_precio');
				$this->load->view('admin/footer');
			}else{
				$data['title']="Dale Más Bajo";
				$data['description']="Música para Djs y Vjs, los mejores remixes en un solo lugar";
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/permisos');
				$this->load->view('admin/footer');
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function editar_genero(){
		if($this->session->userdata('is_logued_in')){

			$gender_id = $this->input->get('gender_id');
			$user_role= $this->session->userdata('role');
			if(isset($gender_id)){
				$genero = $this->genero_model->load_genero_info($gender_id);
				if(!$genero){
					$mensaje='Este genero no existe';
					echo $mensaje;
				}else{
					if($user_role=='is_admin'|| $user_role=='is_editor'){
						$this->print_edit_gender($gender_id, $genero);
					}else{
						if($producto->owner_id==$this->session->userdata('id_usuario')){
							$mensaje = 'Banner Actualizado';
							$this->print_edit_gender($gender_id, $genero, $mensaje);
						}else{
							$mensaje='No tienes permisos suficientes para esta acción';
							echo $mensaje;
						}
					}
				}
			}

		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function print_edit_gender($gender_id, $genero_info, $mensaje=null){

			$data['title']="Añadir Genero";
			$data['description']="Sube nuevos generos a la tienda";
			$data['genero']=$genero_info;
			if($mensaje!=null){
				$data['mensaje']=$mensaje;
			}
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/editar_genero');
			$this->load->view('admin/footer');

	}


	public function add_genero(){
		if($this->session->userdata('is_logued_in')){
			$name = $this->input->post('name');
			//$description = $this->input->post('description');
			//$id = $this->input->post('id');
				
			$data = array(
				'name'=>$name,
				//'description'=>$description,
				//'img'=>$newfilename,
			);
			$id=$this->genero_model->create_genero($data);
			$genero = $this->genero_model->load_genero_info($id);
			$mensaje = "Genero Creado";
			$this->print_edit_gender($id, $genero, $mensaje);
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function update_genero(){
		if($this->session->userdata('is_logued_in')){
			$name = $this->input->post('name');
			$id = $this->input->post('id');
			$data = array(
				'name'=>$name,
				
			);
			$this->genero_model->update_genero($id, $data);
			$genero = $this->genero_model->load_genero_info($id);
			$mensaje = "Genero Actualizado";
			redirect(base_url().'admin/listar_generos/');
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function editar_producto(){
		$this->load->model('users_model');
		if($this->session->userdata('is_logued_in')){
			$product_id = $this->input->get('product_id');
			$user_role= $this->session->userdata('role');
			
			if(isset($product_id)){
				$producto = $this->products_model->load_product_info($product_id);
				if(!$producto){
					$mensaje='Este producto no existe';
					echo $mensaje;
				}else{
					if($user_role=='is_admin'|| $user_role=='is_subadmin'){
						$this->print_edit_product($product_id);
					}else{
						if($producto->owner_id==$this->session->userdata('id_usuario')){
							$this->print_edit_product($product_id);
						}else{
							$mensaje='No tienes permisos suficientes para esta acción';
							echo $mensaje;
						}
					}
				}
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function print_edit_product($product_id){
		
		$product_id = $this->input->get('product_id');
		$data['title']="Editar Producto";
		$data['description']="Editar los Productos";
	    $data['generos']=$this->genero_model->get_generos();
	    $data['product_types']=$this->products_model->get_product_types();
	    $data['producto']=$this->products_model->load_product_info($product_id);
	    $data['precios']=$this->precios_model->get_precios();
		$this->load->view('admin/head', $data);
		$this->load->view('admin/side');
		$this->load->view('admin/top');
		$this->load->view('admin/editar_producto');
		$this->load->view('admin/footer');
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
			    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
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

	public function ver_descargar(){
		$user_id = $this->input->get('user_id');
		$user_role= $this->session->userdata('role');
		
		if($this->session->userdata('is_logued_in')){
			$data['title']="Ver descargas";
			$data['description']="Descargas";
		    $data['aditional_stylesheets']='
		    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
		    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
		    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
			$data['descargas'] = $this->users_model->load_user_descargas($user_id);
			$data['user_id'] = $user_id;
			$data['accion'] = 'admin/mostrar_descarga/';
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/ver_descargas');
			$this->load->view('admin/footer');
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function mostrar_descarga(){
		$numeropagina = $this->input->post("nropagina");
		$cantidad = $this->input->post("cantidad");
		$user_id = $this->input->post("user_id");

		$inicio = ($numeropagina -1)*$cantidad;
		$data["total_registros"] =	count($this->users_model->load_user_descargas($user_id));
		$data["descargas"] =	$this->users_model->load_user_descargas($user_id, $inicio, $cantidad);
		$html = '';
		foreach ($data["descargas"] as $key => $value) {
        $html .='<tr>
          <td class="align-middle">'.$value->product_name.'</td>
          <td class="align-middle">'.$value->artist.'</td>
          <td class="align-middle">'.$value->since.'</td>
        </tr>';
		  }
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
		    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
		    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
		    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
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

	public function update_precio(){
		if($this->session->userdata('is_logued_in')){
			$name = $this->input->post('name');
			$id = $this->input->post('id');
			$price = $this->input->post('price');
			$data = array(
				'name'=>$name,
				'price'=>$price,
				
			);
			$this->precios_model->update_precio($id, $data);
			$data['title']="Editar Precio";
			$data['description']="Edita los precios";
			$data['precio'] = $this->precios_model->load_precio_info($id);
			$data['mensaje'] = "Precio Actualizado";
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/nuevo_precio');
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

	public function nuevo_producto(){
		if($this->session->userdata('is_logued_in')){
			$data['stylesheets'] = array();
			$data['title']="Añadir Producto";
			$data['description']="Sube nuevos productos a la tienda";
		    $data['generos']=$this->genero_model->get_generos();
		    $data['precios']=$this->precios_model->get_precios();
		    array_push($data['stylesheets'],site_url().'admin_assets/css/uploadfile.min.css');
		    array_push($data['stylesheets'],'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css');
		    $data['product_types']=$this->products_model->get_product_types();
		    $data['scripts']= array();
		    $data['uploader']=true;
		    array_push($data['scripts'], site_url() .'admin_assets/js/jquery.uploadfile.min.js');
		    array_push($data['scripts'], 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js');
		    $data['subnivel']=preg_match('/localhost/i',$_SERVER['HTTP_HOST'])?'../../':'../../';
		    $data['upload_preview']=true; //Upload preview or not
		    $data['image_'] = '';//$con->Select(array('Foto'),'djs','WHERE CodDj='.$_SESSION['dj']);
		    $data['image']= site_url()."images/products/featured_image/default-image.jpg";//$image_['Foto'][0];
		    $data['image_name']  = "";//$image_['Foto'][0];
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/nuevo_producto');
			$this->load->view('admin/footer');
		}else{
			redirect(base_url().'admin/login/');
		}
	}



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

	public function listar_faq(){
		$accion = $this->input->get('action');
		$faq_id = $this->input->get('faq_id');
		$user_role= $this->session->userdata('role');
		
		if($accion=='delete'){
			
			$faq = $this->faq_model->load_faq_info($faq_id);
			if(!$faq){
				$mensaje='Este Banner no existe';
			}else{

				if($user_role=='is_admin'|| $user_role=='is_editor'){
					$this->faq_model->delete_faq($faq_id);
				}else{
					$mensaje= "No tienes permisos para realizar esta acción";
				}
			}
		}	
		$this->load->model('faq_model');
		if($this->session->userdata('is_logued_in')){
			$data['title']="FAQ";
			$data['description']="Lista de Preguntas Frecuentes";
			$data['aditional_scripts']="<script>
		      $(function(){
		        'use strict';
		        $('#datatable1').DataTable({
		          responsive: true,
		          paging: false,
		          info: false, 
		          searching: false,
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
		        });
		        // Select2
		        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

		      });
		    </script>";
		    $data['aditional_stylesheets']='
		    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
		    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
		    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
		    $data['faqs']=$this->faq_model->get_faq();
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/faq');
			$this->load->view('admin/footer');
		}else{
			redirect(base_url().'admin/login/');
		}
	}


	public function subir(){
		if($this->session->userdata('is_logued_in')){
			if(isset($_POST['action'])){
				$this->file_name=(isset($_POST['file'])?$_POST['file']:(isset($_POST['replace'])?$_POST['replace']:false));
				switch($_POST['action']){
					case 'file_upload':
						$extension=strtolower(pathinfo($_FILES['files']['name'],PATHINFO_EXTENSION));
						$file=$this->file_name.'.'.$extension;
						switch($extension){
							case 'mp3':
								@unlink(($_POST['demo']=='1'?$this->path_preview:$this->path_download).$file);
								if(copy($_FILES['files']['tmp_name'],($_POST['demo']=='1'?$this->path_preview:$this->path_download).($_POST['demo']==1?$file:$file))){
									// this scope only runs when demo: 1
									if($_POST['demo']==1){
										//Is not necessarily convert previews
										// $filePreview = $this->sox($this->path_preview.'Audio/'.$file);
										// unlink($this->path_preview.'/Audio/'.$file);
										// rename($this->path_preview.'/Audio/'.$filePreview,	$this->path_preview.'/Audio/'.$file);
									}
									// Only run for main file upload. If a demo were uploaded, avoid to replace preview.
									if($_POST['preview']=='true')
									{
										//CREAR PREVIEW A PARTIR DEL ARCHIVO COPIADO
										if(	!is_file($this->path_preview.$file)	):
											$filePreview = $this->sox($this->path_download.$file);
											rename($this->path_preview.$filePreview,	$this->path_preview.$file);
										endif;
									}
									echo 'true';
								}else{
									echo 'false';
								}
							break;
							case 'zip':
								$pack	=	isset($_POST['pack'])? $_POST['pack']:'video';
								@unlink(($_POST['demo']=='1'?$this->path_preview:$this->path_download).$file);
								if(copy($_FILES['files']['tmp_name'],($_POST['demo']=='1'?$this->path_preview:$this->path_download).$file)){
									echo 'true';
								}else{
									echo 'false';
								}
							break;
							case 'rar':
								$pack				=	isset($_POST['pack'])? $_POST['pack']:'video';
								@unlink(($_POST['demo']=='1'?$this->path_preview:$this->path_download).($pack=='video'?'Video/':'Audio/').$file);
								if(copy($_FILES['files']['tmp_name'],($_POST['demo']=='1'?$this->path_preview:$this->path_download).($pack=='video'?'Video/':'Audio/').$file)){
									echo 'true';
								}else{
									echo 'false';
								}
							break;
							case 'mp4':
								//Antes de crear el archivo borro cualquier otro con el mismo nombre por si se ha equivocado o esta reemplazando.
								@unlink(($_POST['demo']==1?$this->path_preview_videos:$this->path_download_videos).$file);
								//echo ($_POST['demo']==1?$this->path_preview:$this->path_download).'/Video/'.$file;
								if(copy($_FILES['files']['tmp_name'],($_POST['demo']=='1'?$this->path_preview_videos:$this->path_download_videos).($_POST['demo']==1?$file:$file))){
								//creo preview
									if($_POST['demo']==1){
										$this->ffmpeg($this->path_preview_videos.$file,$file);
										unlink($this->path_preview_videos.$file);
									}
									if($_POST['preview']=='true'){
										/*Copy file from Download/Video/. to Preview/Video/. and convert */
											$this->ffmpeg($this->path_download_videos.$file,$file);
											//unlink($this->path_preview.'/Video/convert_'.$file);
									}
									echo 'true';
								}else{
									echo 'false';
								}
							break;
							//imagen
							default:
								if(copy($_FILES['files']['tmp_name'],$this->path_cover.$file)){
									if($this->image($this->path_cover.$file,$this->path_cover.$file,200,200)){
										echo 'true';
									}else{
										echo 'library';
									}
								}else{
									echo 'false';
								}
							break;
						}
					break;
					case 'file_add':
						if(!isset($_POST['real_file_name'])){
							echo 'false'; 
							return false;
						}
						$extension	=	strtolower(pathinfo($_POST['real_file_name'],PATHINFO_EXTENSION));
						$extensionPreview	=	strtolower(pathinfo($_POST['file_preview'],PATHINFO_EXTENSION));
						if(	$extension=='mp3' || $extensionPreview	==	'mp3'	){
							//VERIFICO SI ES PARA ACTUALIZAR O CREAR NUEVO
							if(isset($_POST['id_file']) && $_POST['id_file'] <>''){
								//UPDATE
								return $this->audio('update');
							}else{
								//INSERT
								return $this->audio('insert');
							}
						}else{
							if(isset($_POST['id_file']) && $_POST['id_file'] <>''){
								//UPDATE
								return $this->video('update');
							}else{
								//INSERT
								return $this->video('insert');
							}
						}
					break;
				}
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function showme(){
		print_r($_SESSION);
	}

	function video($action){
		//var_dump($_POST);
		$duration = $this->getVideoDuration($_POST['descargable']);
		$demo = $_POST['descargable'];
		$productos_data=array(
			'created_on'		=>	date('Y-m-d H:i:s'),
			'name'				=>	$_POST['video_name'],
			'artist'			=>	$_POST['video_artist'],
			'price'				=>	$_POST['price'],
			'version'			=>	$_POST['version'],
			'owner_id'			=>	$this->session->userdata('id_usuario'),
			'gender_id'			=>	$_POST['gender_id'],
			'product_type_id'	=>	$_POST['type'],
			'description'		=>	$_POST['description'],
			'bpm'				=>	$_POST['bpm'],
			'demo'				=>	$demo,
			'descargable'		=>	$_POST['descargable'],
			'format'			=>	'video',
			'duration'			=>	$duration
		);
		if($this->session->userdata('role')=='is_admin'||$this->session->userdata('role')=='is_subadmin'){
			$productos_data['approved']=1;
			$productos_data['time_approved']=date("Y-m-d H:i:s");
		}
		if($action=='update'){
			if(!isset($_POST['id_file'])){ 
				return false; 
			}
			unset($productos_data['created_on']);
			if($this->products_model->update_product($product_id, $productos_data)){
				echo 'true';
			}else{
				echo 'false';
			}
		}else{
			$product_inserted = $this->products_model->create_product($productos_data);
			//echo $product_inserted;
			if($product_inserted){
				echo 'true';
			}else{
				echo 'false';
			}
		}
	}

	function updateDurations(){
		$products = $this->products_model->get_products();
		foreach($products as $product){
			if($product->format=='video'){
				$duration = $this->getVideoDuration($product->descargable);
				$data = array(
					'duration'=>$duration,
				);
				$this->products_model->update_product($product->id, $data);
			}
		}
	}

	public function getAudioDuration($filename){
		$file = $this->path_download.$filename;
		$get_file= exec("mp3info -p \"%m:%s\" ".$file."  2>&1", $output);
		$value = explode(':',$get_file);
		$mins = $value[0];
		$formatted_mins = sprintf("%02d", $mins);
		$secs = $value[1];
		$formatted_secs = sprintf("%02d", $secs);
		return $formatted_mins.":".$formatted_secs;
	}

	public function getVideoDuration($filename){
		$file = $this->path_download_videos.$filename;
		$get_file = exec("ffmpeg -i ".$file." 2>&1 | grep \"Duration\" | cut -d ' ' -f 4 | sed s/,//", $output);
		$value = explode(':', $get_file);
		$mins=$value[1];
		$value2 = explode('.',$value[2]);
		$secs=$value2[0];
		return $mins.':'.$secs;
	}



	public function sox(	$file,	$start	=	array(0,60),	$end	=	array(90,120)	){
		$tmp_name='_'.date('YmdHis');
		$final_name=date('YmdHis').intval(microtime(true)).'.mp3';
			$fade_cut=$end[1]-$end[0];
			$break1=exec("sox '".addslashes($file)."' ".$this->path_preview."Audio/part1_".$tmp_name.".mp3 trim ".$start[0]." ".($start[1])." fade t 3 ".($start[1]-$start[0])." 2 pad 0 1");
			$break2=exec("sox '".addslashes($file)."' ".$this->path_preview."Audio/part2_".$tmp_name.".mp3 trim ".$end[0]." ".$end[1]." fade t 3 ".$fade_cut." 5");
			$merge=exec("sox ".$this->path_preview."Audio/part1_".$tmp_name.".mp3 ".$this->path_preview."Audio/part2_".$tmp_name.".mp3 '".$this->path_preview.'Audio/'.$final_name."'");
			unlink($this->path_preview."Audio/part2_".$tmp_name.".mp3");
			unlink($this->path_preview."Audio/part1_".$tmp_name.".mp3");
			//unlink($file);
		return $final_name; //RETORNO NOMBRE NUEVO DEL PREVIEW CON DATE
	}

	public function ffmpeg($file,$final_name,$resolution='500x250',$duration='00:00:55'){
		/* NOTE: $file = TMP_NAME, NOT DOWNLOAD URL */
		if($duration<>''){
			 $long='-ss 00:00:00.01 -t '.$duration;
		}else{
			$long='';
		}
		//$final_name=date('YmdHis').'.mp4'; //return name
		//CODEC AUDIO CHANGED TO AAC FOR AVOID SERVER ERRORS
		//CONVERT TO MP4 . WORKING BUT DEACTIVATED FOR AVOID DUPLICATE
		$convert2=exec("ffmpeg -i ".$file." ".$long." -s ".$resolution." -strict -2 -c:v libx264 -crf 20 -maxrate 800k -bufsize 800k -c:a aac -b:a 50k '".$this->path_preview_videos.$final_name."'");

		//$convert3=exec("ffmpeg -i ".$file." ".$long." -s ".$resolution." -codec:v libvpx -quality realtime -cpu-used 4 -b:v 800k -qmin 30 -qmax 52 -bufsize 800k -threads 4 -codec:a libvorbis -b:a 50k '".$this->path_preview.preg_replace('/\.mp4/','.webm',$final_name)."'");
		/*$MP4Box=exec("MP4Box -add '".$mp4_date."' '".$uploadFileMp4."'");
		unlink($mp4_date);*/
		//$this->demoname = preg_replace('/\.mp4/','.webm',$final_name);
		return $final_name;
	}

	public function image($file,$thumb,$width,$height){
		try{
			@$image = new Imagick($file);
			$image->cropThumbnailImage($width,$height);

			if($image->writeImage($thumb)){
				return true;
			}else{
				return false;
			}
		}catch(ImagickException $e){
			return false;
		}
	}

	function audio($action){
		$duration = $this->getAudioDuration($_POST['descargable']);

		$productos_data=array(
			'created_on'		=>	date('Y-m-d H:i:s'),
			'name'				=>	$_POST['video_name'],
			'artist'			=>	$_POST['video_artist'],
			'price'				=>	$_POST['price'],
			'version'			=>	$_POST['version'],
			'gender_id'			=>	$_POST['gender_id'],
			'owner_id'			=>	$this->session->userdata('id_usuario'),
			'product_type_id'	=>	$_POST['type'],
			'description'		=>	$_POST['description'],
			'bpm'				=>	$_POST['bpm'],
			'demo'				=>	$_POST['demo'],
			'descargable'		=>	$_POST['descargable'],
			'format'			=> 'audio',
			'duration'			=> $duration
		);
		if($this->session->userdata('role')=='is_admin'||$this->session->userdata('role')=='is_subadmin'){
			$productos_data['approved']=1;
			$productos_data['time_approved']=date("Y-m-d H:i:s");
		}
		if($action=='update'){
			if(!isset($_POST['id_file'])){ 
				return false; 
			}
			unset($productos_data['created_on']);
			if($this->products_model->update_product($product_id, $productos_data)){
				echo 'true';
			}else{
				echo 'false';
			}
		}else{
			if($this->products_model->create_product($productos_data)){
				echo 'true';
			}else{
				echo 'false';
			}
		}

	}

	public function nuevo_faq(){
		if($this->session->userdata('is_logued_in')){
			$data['title']="Añadir FAQ";
			$data['description']="Añade preguntas frecuentes a tu sitio web.";
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/nuevo_faq');
			$this->load->view('admin/footer');
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function add_faq(){
		if($this->session->userdata('is_logued_in')){
			$title = $this->input->post('title');
			$content = $this->input->post('content');
			$url = $this->input->post('slug');
			//$id = $this->input->post('id');
			$data = array(
				'title'=>$title,
				'content'=>$content,
				'slug'=>$url,
			);
			$id=$this->faq_model->create_faq($data);

			$faq = $this->faq_model->load_faq_info($id);
			//print gender updated
			$this->print_edit_faq($id, $faq);
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function editar_faq(){
		$this->load->model('users_model');
		if($this->session->userdata('is_logued_in')){
			$faq_id = $this->input->get('faq_id');
			$user_role= $this->session->userdata('role');
			
			if(isset($faq_id)){
				$faq = $this->faq_model->load_faq_info($faq_id);
				if(!$faq){
					$mensaje='Este producto no existe';
					echo $mensaje;
				}else{
					if($user_role=='is_admin'|| $user_role=='is_editor'){
						$this->print_edit_faq($faq_id, $faq);
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

	public function print_edit_faq($id, $faq){
		$data['title']="Editar Faq";
		$data['description']="Editar faq";
	    $data['faq']=$faq;
		$this->load->view('admin/head', $data);
		$this->load->view('admin/side');
		$this->load->view('admin/top');
		$this->load->view('admin/editar_faq');
		$this->load->view('admin/footer');
	}


	public function update_faq(){
		if($this->session->userdata('is_logued_in')){
			$title = $this->input->post('title');
			$slug = $this->input->post('slug');
			$content = $this->input->post('content');
			$id = $this->input->post('id');
			$data = array(
				'title'=>$title,
				'slug'=>$slug,
				'content'=>$content,
			);
			$this->faq_model->update_faq($id, $data);
			$faq = $this->faq_model->load_faq_info($id);
			//print faq updated
			$this->print_edit_faq($id, $faq);
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function token()
	{
		$token = md5(uniqid(rand(),true));
		$this->session->set_userdata('token',$token);
		return $token;
	}

	public function get_countries(){
		$countries = $this->location_model->get_countries(); 
		return $countries;
	}

	public function listar_banner(){

		$accion = $this->input->get('action');
		$banner_id = $this->input->get('banner_id');
		$user_role= $this->session->userdata('role');
		
		if($accion=='delete'){
			
			$banner = $this->banners_model->load_banner_info($banner_id);
			if(!$banner){
				$mensaje='Este Banner no existe';
			}else{
				if($user_role=='is_admin'|| $user_role=='is_editor'){
					$this->banners_model->delete_banner($banner_id);
				}else{
					$mensaje= "No tienes permisos para realizar esta acción";
				}
			}
		}	

		$this->load->model('users_model');
		$this->load->model('banners_model');
		if($this->session->userdata('is_logued_in')){
			$data['title']="Banners";
			$data['description']="Administra a todos los banners dentro del sistema";
			$data['aditional_scripts']="<script>
		      $(function(){
		        'use strict';
		        $('#datatable1').DataTable({
		          responsive: true,
		          paging: false,
		          searching: false,
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
		    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
		    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
		    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
		    $data['banners']=$this->banners_model->get_banners();
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/banners');
			$this->load->view('admin/footer');
		}else{
			redirect(base_url().'admin/login/');
		}
	}
	
	public function nuevo_banner(){
		if($this->session->userdata('is_logued_in')){
			$data['title']="Añadir Banner";
			$data['description']="Sube nuevos banners a la tienda";

			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/nuevo_banner');
			$this->load->view('admin/footer');
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function add_banner(){
		if($this->session->userdata('is_logued_in')){
			$name = $this->input->post('name');
			$url = $this->input->post('url');
			//$id = $this->input->post('id');
			if(!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
				$data = array(
					'name'=>$name,
					'url'=>$url,
				);
				$id=$this->banners_model->create_banner($data);

				$banner = $this->banners_model->load_banner_info($id);
				//print gender updated
				$this->print_edit_banner($id, $banner);
			}else{
				$image_folder='images/banners/';
				$temp = explode(".", $_FILES["image"]["name"]);
				$newfilename = round(microtime(true)) . '.' . end($temp);
				$image_file=$image_folder.basename($_FILES['image']['name']);

				if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
					die("Upload failed with error code " . $_FILES['image']['error']);
				}

				$info = getimagesize($_FILES['image']['tmp_name']);
				if ($info === FALSE) {
					die("Unable to determine image type of uploaded file");
				}

				if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
					die("Not a gif/jpeg/png");
				}
				if(move_uploaded_file($_FILES['image']['tmp_name'], $image_folder.$newfilename)){
					$data = array(
						'name'=>$name,
						'url'=>$url,
						'image'=>$newfilename,
					);
					$id=$this->banners_model->create_banner($data);
					$banner = $this->banners_model->load_banner_info($id);
					$this->print_edit_banner($id, $banner);
				}
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function print_edit_banner($id, $banner, $mensaje=null){
		$data['title']="Editar Banner";
		$data['description']="edita banners de la tienda";
		$data['banner']=$banner;
		$this->load->view('admin/head', $data);
		$this->load->view('admin/side');
		$this->load->view('admin/top');
		$this->load->view('admin/editar_banner');
		$this->load->view('admin/footer');
	}

	public function editar_banner(){
		if($this->session->userdata('is_logued_in')){
			$banner_id = $this->input->get('banner_id');
			$user_role= $this->session->userdata('role');
			if(isset($banner_id)){
				$banner = $this->banners_model->load_banner_info($banner_id);
				if(!$banner){
					$mensaje='Este banner no existe';
					echo $mensaje;
				}else{
					if($user_role=='is_admin'|| $user_role=='is_editor'){
						$this->print_edit_banner($banner_id, $banner);
					}else{
							$this->print_edit_banner($banner_id, $banner);
					}
				}
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function update_banner(){
		if($this->session->userdata('is_logued_in')){
			$name = $this->input->post('name');
			$url = $this->input->post('url');
			$id = $this->input->post('id');
			if(!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
				$data = array(
					'name'=>$name,
					'url'=>$url,
				);
				$this->banners_model->update_banner($id, $data);

				$banner = $this->banners_model->load_banner_info($id);
				//print gender updated
				$this->print_edit_banner($id, $banner);

			}else{
				$image_folder='images/generos/';
				$temp = explode(".", $_FILES["image"]["name"]);
				$newfilename = round(microtime(true)) . '.' . end($temp);
				$image_file=$image_folder.basename($_FILES['image']['name']);

				if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
					die("Upload failed with error code " . $_FILES['image']['error']);
				}

				$info = getimagesize($_FILES['image']['tmp_name']);
				if ($info === FALSE) {
					die("Unable to determine image type of uploaded file");
				}

				if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
					die("Not a gif/jpeg/png");
				}
				if(move_uploaded_file($_FILES['image']['tmp_name'], $image_folder.$newfilename)){

					$data = array(
						'name'=>$name,
						'url'=>$url,
						'image'=>$newfilename,
					);
					$this->banners_model->update_banner($id, $data);
					$banner = $this->banners_model->load_banner_info($id);
					$mensaje = 'Banner Actualizado';
					$this->print_edit_banner($id, $banner, $mensaje);
				}
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function listar_ordenes(){
		if($this->session->userdata('is_logued_in')){
			$where = ' AND is_plan=0 ';
			if(isset($_GET['time'])){
				if($_GET['time']!=""){
					$tiempo = $this->input->get('time');
					$data['ordenes']=$this->orders_model->get_orders_time($tiempo, $where);
				}else{
					$where2['is_plan']=0;
					$data['ordenes']=$this->orders_model->get_orders($where2);
				}
			}else{
				$where2['is_plan']=0;
				$data['ordenes']=$this->orders_model->get_orders($where2);
			}

			$data['title']="Listar Ordenes";
			$data['description']="Lista de ordenes en el sitio web";
			$data['usuarios']=$this->users_model->get_all_users();
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/listar_ordenes');
			$this->load->view('admin/footer');
		}
	}

	public function listar_ordenes_tokens(){
		if($this->session->userdata('is_logued_in')){
			$where = ' AND is_plan=1 ';
			if(isset($_GET['time'])){
				if($_GET['time']!=""){
					$tiempo = $this->input->get('time');
					$data['ordenes']=$this->orders_model->get_orders_time($tiempo, $where);
				}else{
					$where2['is_plan']=1;
					$data['ordenes']=$this->orders_model->get_orders($where2);
				}
			}else{
				$where2['is_plan']=1;
				$data['ordenes']=$this->orders_model->get_orders($where2);
			}

			$data['title']="Listar Ordenes";
			$data['description']="Lista de ordenes en el sitio web";
			$data['usuarios']=$this->users_model->get_all_users();
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/listar_ordenes_tokens');
			$this->load->view('admin/footer');
		}
	}
	

	public function nuevo_plan(){
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$data['title']="Añadir Plan";
				$data['description']="Sube nuevos planes a la tienda";

				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/nuevo_plan');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}

	public function add_plan(){
		if($this->session->userdata('is_logued_in')){
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$price = $this->input->post('price');
			$tokens = $this->input->post('tokens');
			$tokens_video = $this->input->post('tokens_video');
			$duration = $this->input->post('duration');
			$ilimitado_activo = $this->input->post('ilimitado_activo');
			$ilimitado_dias = $this->input->post('ilimitado_dias');
			$url_pago = $this->input->post('url_pago');
				
			$data = array(
				'name'			=>	$name,
				'description'	=>	$description,
				'price'			=>	$price,
				'duration'		=>	$duration,
				'tokens'		=>	$tokens,
				'tokens_video'		=>	$tokens_video,
				'activated'		=>	1,
				'ilimitado_activo' => $ilimitado_activo,
				'ilimitado_dias'	=> $ilimitado_dias,
				'url_pago'		=> $url_pago
			);
			$id=$this->plan_model->create_plan($data);
			$plan = $this->plan_model->load_plan_info($id);
			$mensaje = "Plan Creado";
			$this->print_edit_plan($id, $plan, $mensaje);
		}else{
			redirect(base_url().'admin/login/');
		}
	}
	public function editar_plan(){
		$plan_id = $_GET['plan_id'];
		$plan = $this->plan_model->load_plan_info($plan_id);
		$mensaje = null;
		$this->print_edit_plan($plan_id, $plan, $mensaje);
	}
	public function update_plan(){
		if($this->session->userdata('is_logued_in')){
			$name = $this->input->post('name');
			$description = $this->input->post('description');
			$price = $this->input->post('price');
			$id = $this->input->post('id');
			$duration = $this->input->post('duration');
			$tokens = $this->input->post('tokens');
			$tokens_video = $this->input->post('tokens_video');
			$activated = $this->input->post('activated');
			$ilimitado_activo = $this->input->post('ilimitado_activo');
			$ilimitado_dias = $this->input->post('ilimitado_dias');
			$url_pago = $this->input->post('url_pago');
			$data = array(
				'name'			=>	$name,
				'description'	=>	$description,
				'price'			=>	$price,
				'duration'		=>	$duration,
				'activated'		=>	$activated,
				'tokens'		=> 	$tokens,
				'tokens_video'		=> 	$tokens_video,
				'ilimitado_activo' => $ilimitado_activo,
				'ilimitado_dias'	=> $ilimitado_dias,
				'url_pago'		=> $url_pago
			);
			$this->plan_model->update_plan($id, $data);
			$plan = $this->plan_model->load_plan_info($id);
			$mensaje = "Plan Actualizado";
			$this->print_edit_plan($id, $plan, $mensaje);
		}else{
			redirect(base_url().'admin/login/');
		}
	}
	public function print_edit_plan($id, $plan, $mensaje){
			$data['title']="Editar Plan";
			$data['description']="Edita el plan de la tienda";
			$data['plan']=$plan;
			if($mensaje!=null){
				$data['mensaje']=$mensaje;
			}
			$this->load->view('admin/head', $data);
			$this->load->view('admin/side');
			$this->load->view('admin/top');
			$this->load->view('admin/nuevo_plan');
			$this->load->view('admin/footer');
	}

	public function listar_planes(){
		$accion = $this->input->get('action');
		$plan_id = $this->input->get('plan_id');
		$user_role= $this->session->userdata('role');
		
		if($accion=='delete'){
			
			$plan = $this->plan_model->load_plan_info($plan_id);
			if(!$plan){
				$mensaje='Este Plan no existe';
			}else{

				if($user_role=='is_admin'|| $user_role=='is_editor'){
					$this->plan_model->delete_plan($plan_id);
				}else{
					$mensaje= "No tienes permisos para realizar esta acción";
				}
			}
		}
		if($accion=='activar'){
			$plan = $this->plan_model->load_plan_info($plan_id);
			if(!$plan){
				$mensaje='Este Plan no existe';
			}else{

				if($user_role=='is_admin'|| $user_role=='is_editor'){
					$data = array(
						'activated' => 1
					);
					$this->plan_model->update_plan($plan_id, $data);
				}else{
					$mensaje= "No tienes permisos para realizar esta acción";
				}
			}
		}
		if($accion=='desactivar'){
			$plan = $this->plan_model->load_plan_info($plan_id);
			if(!$plan){
				$mensaje='Este Plan no existe';
			}else{

				if($user_role=='is_admin'|| $user_role=='is_editor'){
					$data = array(
						'activated' => 0
					);
					$this->plan_model->update_plan($plan_id, $data);
				}else{
					$mensaje= "No tienes permisos para realizar esta acción";
				}
			}
		}
		$this->load->model('products_model');
		if($this->session->userdata('is_logued_in')){
			if($this->user_has_admin_access()){
				$data['title']="Planes";
				$data['description']="Planes para los productos del sitio web";
				$data['aditional_scripts']="<script>
			      $(function(){
			        'use strict';
			        $('#datatable1').DataTable({
			          responsive: true,
			          searching: false,
			          paging: false,
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
			        });
			        // Select2
			        $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

			      });
			    </script>";
			    $data['aditional_stylesheets']='
			    <link href="'.base_url().'admin_assets/lib/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'admin_assets/lib/select2/css/select2.min.css" rel="stylesheet">';
			    $data['plans']=$this->plan_model->get_plans_admin();
			    if(isset($mensaje)){
			    	$data['mensaje']=$mensaje;
			    }
				$this->load->view('admin/head', $data);
				$this->load->view('admin/side');
				$this->load->view('admin/top');
				$this->load->view('admin/listar_planes');
				$this->load->view('admin/footer');
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url().'admin/login/');
		}
	}


}