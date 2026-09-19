<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupons extends Admin_Controller {

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
			    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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

}
