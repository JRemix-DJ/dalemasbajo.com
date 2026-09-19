<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plans extends Admin_Controller {

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
			    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
				$data['title']="Precios";
				$data['description']="A continuación podrás ver el listado de precios que tienes disponibles en tu sitio web";
				$data['aditional_scripts']='<script src="'.site_url().'assets/admin/js/dashboard.js"></script>';
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
			    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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
