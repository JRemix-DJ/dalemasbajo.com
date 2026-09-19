<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Genres extends Admin_Controller {

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
			    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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

}
