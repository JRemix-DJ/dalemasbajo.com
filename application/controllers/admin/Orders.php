<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Admin_Controller {

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
			    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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
			    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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
			    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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
			    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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
			    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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
			    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
			    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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

}
