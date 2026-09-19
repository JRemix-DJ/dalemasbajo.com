<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Admin_Controller {

    private $path_preview = 'assets/uploads/demos/';
    private $path_preview_videos = 'assets/uploads/demos/videos/';
    private $path_cover = 'assets/uploads/covers/';
    private $path_download = 'assets/uploads/descargables/';
    private $path_download_videos = 'assets/uploads/descargables/videos/';
    private $file_name = '';

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
			    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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
			    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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
			    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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
		$data['scripts'] = ['assets/admin/js/pages/editar_producto.js'];
		$this->load->view('admin/head', $data);
		$this->load->view('admin/side');
		$this->load->view('admin/top');
		$this->load->view('admin/editar_producto');
		$this->load->view('admin/footer');
	}

	public function ver_descargar(){
		$user_id = $this->input->get('user_id');
		$user_role= $this->session->userdata('role');
		
		if($this->session->userdata('is_logued_in')){
			$data['title']="Ver descargas";
			$data['description']="Descargas";
		    $data['aditional_stylesheets']='
		    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
		    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
		    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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

	public function nuevo_producto(){
		if($this->session->userdata('is_logued_in')){
			$data['stylesheets'] = array();
			$data['title']="Añadir Producto";
			$data['description']="Sube nuevos productos a la tienda";
		    $data['generos']=$this->genero_model->get_generos();
		    $data['precios']=$this->precios_model->get_precios();
		    array_push($data['stylesheets'],site_url().'assets/admin/css/uploadfile.min.css');
		    array_push($data['stylesheets'],'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css');
		    $data['product_types']=$this->products_model->get_product_types();
		    $data['scripts']= array();
		    $data['uploader']=true;
		    array_push($data['scripts'], site_url() .'assets/admin/js/jquery.uploadfile.min.js');
		    array_push($data['scripts'], 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js');
		    array_push($data['scripts'], 'assets/admin/js/pages/nuevo_producto.js');
		    $data['subnivel']=preg_match('/localhost/i',$_SERVER['HTTP_HOST'])?'../../':'../../';
		    $data['upload_preview']=true; //Upload preview or not
		    $data['image_'] = '';//$con->Select(array('Foto'),'djs','WHERE CodDj='.$_SESSION['dj']);
		    $data['image']= site_url()."assets/uploads/covers/default-image.jpg";//$image_['Foto'][0];
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

    public function subir(){
        if($this->session->userdata('is_logued_in')){

            if(isset($_POST['action'])){

                $this->file_name = (isset($_POST['file']) ? $_POST['file'] : (isset($_POST['replace']) ? $_POST['replace'] : false));

                switch($_POST['action']){
                    case 'cover_upload':

                        if(!isset($_FILES['files']) || empty($_FILES['files']['name'])){
                            echo 'false';
                            return;
                        }

                        $extension = strtolower(pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION));
                        if(!in_array($extension, ['jpg','jpeg','png','webp'])){
                            echo 'false';
                            return;
                        }

                        // Nombre final
                        $file = $this->file_name . '.' . $extension;

                        $public_dir = FCPATH . 'assets/uploads/covers/';
                        if(!is_dir($public_dir)){
                            @mkdir($public_dir, 0755, true);
                        }

                        @unlink($public_dir . $file);

                        if(!copy($_FILES['files']['tmp_name'], $public_dir . $file)){
                            echo 'false';
                            return;
                        }

                        try {
                            $this->load->library('image_lib');

                            $config = [
                                'image_library'  => 'gd2',
                                'source_image'   => $public_dir . $file,
                                'maintain_ratio' => TRUE,
                                'width'          => 1400,
                                'height'         => 1400,
                                'quality'        => '85%',
                            ];

                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                            $this->image_lib->clear();
                        } catch (\Throwable $e) {}

                        echo 'assets/uploads/covers/' . $file;
                        return;

                        break;

                    case 'file_upload':
                        $extension = strtolower(pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION));
                        $file = $this->file_name . '.' . $extension;

                        switch($extension){
                            case 'mp3':
                                @unlink(($_POST['demo']=='1'?$this->path_preview:$this->path_download).$file);
                                if(copy($_FILES['files']['tmp_name'], ($_POST['demo']=='1'?$this->path_preview:$this->path_download).($_POST['demo']==1?$file:$file))){
                                    if($_POST['demo']==1){
                                    }
                                    if($_POST['preview']=='true'){
                                        if(!is_file($this->path_preview.$file)){
                                            $filePreview = $this->sox($this->path_download.$file);
                                            rename($this->path_preview.$filePreview, $this->path_preview.$file);
                                        }
                                    }
                                    echo 'true';
                                }else{
                                    echo 'false';
                                }
                                break;
                            case 'zip':
                                $pack = isset($_POST['pack']) ? $_POST['pack'] : 'video';
                                @unlink(($_POST['demo']=='1'?$this->path_preview:$this->path_download).$file);
                                if(copy($_FILES['files']['tmp_name'], ($_POST['demo']=='1'?$this->path_preview:$this->path_download).$file)){
                                    echo 'true';
                                }else{
                                    echo 'false';
                                }
                                break;
                            case 'rar':

                                $pack = isset($_POST['pack']) ? $_POST['pack'] : 'video';
                                @unlink(($_POST['demo']=='1'?$this->path_preview:$this->path_download).($pack=='video'?'Video/':'Audio/').$file);

                                if(copy($_FILES['files']['tmp_name'], ($_POST['demo']=='1'?$this->path_preview:$this->path_download).($pack=='video'?'Video/':'Audio/').$file)){
                                    echo 'true';
                                }else{
                                    echo 'false';
                                }
                                break;
                            case 'mp4':
                                @unlink(($_POST['demo']==1?$this->path_preview_videos:$this->path_download_videos).$file);
                                if(copy($_FILES['files']['tmp_name'], ($_POST['demo']=='1'?$this->path_preview_videos:$this->path_download_videos).($_POST['demo']==1?$file:$file))){
                                    if($_POST['demo']==1){
                                        $this->ffmpeg($this->path_preview_videos.$file, $file);
                                        unlink($this->path_preview_videos.$file);
                                    }

                                    if($_POST['preview']=='true'){
                                        $this->ffmpeg($this->path_download_videos.$file, $file);
                                    }

                                    echo 'true';

                                }else{
                                    echo 'false';
                                }
                                break;
                            default:
                                if(copy($_FILES['files']['tmp_name'], $this->path_cover.$file)){
                                    if($this->image($this->path_cover.$file, $this->path_cover.$file, 200, 200)){
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
                        if(!isset($_POST['cover'])){
                            $_POST['cover'] = ''; // por si llega vacío
                        }
                        $extension = strtolower(pathinfo($_POST['real_file_name'], PATHINFO_EXTENSION));
                        $extensionPreview = strtolower(pathinfo($_POST['file_preview'], PATHINFO_EXTENSION));

                        if($extension=='mp3' || $extensionPreview=='mp3'){
                            if(isset($_POST['id_file']) && $_POST['id_file'] <> ''){
                                return $this->audio('update');
                            }else{
                                return $this->audio('insert');
                            }
                        }else{
                            if(isset($_POST['id_file']) && $_POST['id_file'] <> ''){
                                return $this->video('update');
                            }else{
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
			'duration'			=>	$duration,
            'featured_image' => isset($_POST['cover']) ? $_POST['cover'] : null,
            'payment_link' => isset($_POST['payment_link']) ? $_POST['payment_link'] : null
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
			'duration'			=> $duration,
            'featured_image' => isset($_POST['cover']) ? $_POST['cover'] : null,
            'payment_link' => isset($_POST['payment_link']) ? $_POST['payment_link'] : null
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

}
