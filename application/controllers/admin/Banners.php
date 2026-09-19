<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banners extends Admin_Controller {

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
		    <link href="'.base_url().'assets/admin/vendor/highlightjs/github.css" rel="stylesheet">
		    <link href="'.base_url().'assets/admin/vendor/datatables/jquery.dataTables.css" rel="stylesheet">
		    <link href="'.base_url().'assets/admin/vendor/select2/css/select2.min.css" rel="stylesheet">';
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
        if(!$this->session->userdata('is_logued_in')){
            redirect(base_url().'admin/login/');
            return;
        }

        $name = $this->input->post('name');

        // validar nombre
        if(empty($name)){
            show_error('Nombre requerido', 400);
            return;
        }

        // validar archivo
        if(!isset($_FILES['video']) || $_FILES['video']['error'] !== UPLOAD_ERR_OK){
            show_error('Debes subir un video', 400);
            return;
        }

        $video_folder = FCPATH.'assets/uploads/video_banners/';
        if(!is_dir($video_folder)) mkdir($video_folder, 0755, true);

        $temp = explode(".", $_FILES["video"]["name"]);
        $ext = strtolower(end($temp));
        $allowed = ['mp4','webm','ogg'];

        if(!in_array($ext, $allowed)){
            show_error('Formato no permitido. Usa MP4/WEBM/OGG', 400);
            return;
        }

        $newfilename = round(microtime(true)) . '.' . $ext;

        if(move_uploaded_file($_FILES['video']['tmp_name'], $video_folder.$newfilename)){
            $data = [
                'name'  => $name,
                // reutilizamos "image" para el nombre del video
                'image' => $newfilename,
                // si existe url, lo dejamos vacío
                'url'   => null
            ];

            $id = $this->banners_model->create_banner($data);
            $banner = $this->banners_model->load_banner_info($id);
            $this->print_edit_banner($id, $banner, 'Banner creado');
            return;
        }

        show_error('No se pudo subir el video', 500);
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
        if(!$this->session->userdata('is_logued_in')){
            redirect(base_url().'admin/login/');
            return;
        }

        $name = $this->input->post('name');
        $id   = (int)$this->input->post('id');

        if(empty($name) || !$id){
            show_error('Datos inválidos', 400);
            return;
        }

        $data = [
            'name' => $name,
            'url'  => null
        ];

        // si sube video, reemplazamos
        if(isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK){

            $video_folder = FCPATH.'assets/uploads/video_banners/';
            if(!is_dir($video_folder)) mkdir($video_folder, 0755, true);

            $temp = explode(".", $_FILES["video"]["name"]);
            $ext = strtolower(end($temp));
            $allowed = ['mp4','webm','ogg'];

            if(!in_array($ext, $allowed)){
                show_error('Formato no permitido. Usa MP4/WEBM/OGG', 400);
                return;
            }

            $newfilename = round(microtime(true)) . '.' . $ext;

            if(move_uploaded_file($_FILES['video']['tmp_name'], $video_folder.$newfilename)){
                $data['image'] = $newfilename;
            } else {
                show_error('No se pudo subir el video', 500);
                return;
            }
        }

        $this->banners_model->update_banner($id, $data);

        $banner = $this->banners_model->load_banner_info($id);
        $this->print_edit_banner($id, $banner, 'Banner actualizado');
    }

}
