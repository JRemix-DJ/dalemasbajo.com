<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends Admin_Controller {

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
		    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
		    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
		    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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

}
