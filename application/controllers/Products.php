<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->library(array('session','form_validation', 'pagination'));
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->load->model(array('products_model', 'genero_model', 'orders_model', 'users_model'));
		$this->load->database('default');
	}

	// public function get_all_products(){
	// 	$data['products']=$this->products_model->get_products();
	// }

	public function edit_product(){
		$this->load->model('users_model');
		$user_role= $this->session->userdata('role');
		if($this->session->userdata('is_logued_in')){
			$name = $this->input->post('name');
			$price = $this->input->post('price');
			$description = $this->input->post('description');
			$bpm = $this->input->post('bpm');
			$version = $this->input->post('version');
			$artist = $this->input->post('artist');
			$gender_id = $this->input->post('gender_id');
			$product_type_id = $this->input->post('product_type_id');
			$owner_id = $this->input->post('user_id');
			$product_id = $this->input->post('product_id');
			$paginationnumber = $this->input->post('paginationnumber');
			$data=[];
			$where = array();

			$data = array(
				'name'=>$name,
				'artist'=>$artist,
				'price'=>$price,
				'version'=>$version,
				'description'=>$description,
				'gender_id'=>$gender_id,
				'product_type_id'=>$product_type_id,
				'owner_id'=>$owner_id,
				'bpm'=>$bpm,
			);

			if(($_FILES["demo"]["name"]!="")){
				$demo_folder = 'assets/products/demos/';
				$temp = explode(".", $_FILES["demo"]["name"]);
				$newdemoname = round(microtime(true)) . '.' . end($temp);
				$demo_file=$demo_folder.basename($_FILES['demo']['name']);
				move_uploaded_file($_FILES['demo']['tmp_name'], $demo_folder.$newdemoname);
				$data['demo']=$newdemoname;
			}
			if(($_FILES["descargable"]["name"]!="")){
				$file_folder = 'assets/products/descargables/';
				$temp = explode(".", $_FILES["descargable"]["name"]);
				$newdescargablename = round(microtime(true)) . '.' . end($temp);
				$descagable=$file_folder.basename($_FILES['descargable']['name']);
				move_uploaded_file($_FILES['descargable']['tmp_name'], $file_folder.$newdescargablename);
				$data['descargable']=$newdescargablename;
			}
			
			$this->products_model->update_product($product_id, $data);
			$producto = $this->products_model->load_product_info($product_id);
			if($producto->approved==0){
				$aprobacion="?aprobacion=1";
			}else{
				$aprobacion="";
			}
			if($producto->product_type_id==3){
				redirect(base_url().'admin/listar_videos/'.$paginationnumber.$aprobacion);
			}else{
				redirect(base_url().'admin/listar_productos/'.$paginationnumber.$aprobacion);
			}

		}else{
			redirect(base_url().'admin/login/');
		}

	}
	public function user_pay_for_it($user_id, $product_id){
		if($this->orders_model->user_files($user_id, $product_id)){
			return true;
		}else{
			return false;
		}
	}

    public function descargar(){
        if($this->session->userdata('is_logued_in')){
            $product_id = $this->uri->segment(3);
            $user_id = $this->session->userdata('id_usuario');

            // 1. VERIFICACIÓN DOBLE (Igual que en Micuenta)
            // Verificamos en tabla de asignaciones (Tokens) O en tabla de ordenes (Compras)
            $tiene_archivo = $this->users_model->isUserFile($user_id, $product_id);
            $tiene_orden   = $this->orders_model->user_files($user_id, $product_id);

            $has_file = ($tiene_archivo || $tiene_orden);

            // 2. Verificar Ilimitado
            $is_unlimited = ($this->session->userdata('is_user_unlimited') == true || $this->session->userdata('role') == 1);

            if($has_file || $is_unlimited){

                $product = $this->products_model->load_product_info($product_id);
                $genero = $this->genero_model->load_genero_info($product->gender_id);
                $dj = $this->users_model->load_user_info($product->owner_id);

                $djusername = ($dj) ? $dj->username : 'Unavailable';

                if($product->product_type_id==1){
                    $ext = pathinfo($product->descargable, PATHINFO_EXTENSION);
                    $file=preg_replace('/[^a-zA-Z0-9]/', ' ',$product->name).' - '.$product->artist.' - '.$djusername.' - '.$genero->name.' - '.$product->version.' - '.$product->bpm.'bpm - DMB.mp3';
                }else{
                    $ext = pathinfo($product->descargable, PATHINFO_EXTENSION);
                    $file=$product->name.' - '.$product->artist.' - '.$djusername.' - '.$genero->name.' - '.$product->version.' - '.$product->bpm.'bpm - DMB .'.$ext;
                }

                if($product->product_type_id==3){
                    $file_url='/var/www/dalemasbajo.com/assets/products/descargables/videos/'.$product->descargable;
                }else{
                    $file_url='/var/www/dalemasbajo.com/assets/products/descargables/'.$product->descargable;
                }

                if(!file_exists($file_url)){
                    echo "File Not Found!!";
                    return;
                }

                $tamano=@filesize($file_url);

                if(file_exists($file_url)) {
                    header("Pragma: no-cache");
                    header('Expires: 0');
                    header('Access-Control-Allow-Origin: *');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header("Last-Modified: " . gmdate("D, d M Y H:i:s T", filemtime($file_url)));
                    header('Cache-Control: private',false);
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="'.$file.'"');
                    header('Content-Transfer-Encoding: binary');
                    header('Content-Length: '.$tamano);

                    $chunksize = 1 * (1024 * 1024);
                    $fp = fopen($file_url,'rb');
                    $buffer = '';
                    while (!feof($fp)) {
                        $buffer = fread($fp, $chunksize);
                        echo $buffer;
                        ob_flush();
                        flush();
                    }
                    fclose($fp);
                    exit();
                }
            }else{
                echo 'No tienes permiso para descargar este archivo. Por favor recarga la página.';
            }
        }else{
            redirect(base_url());
        }
    }

	public function descargar_admin(){
		if($this->session->userdata('is_logued_in')&&$this->session->userdata('role')=='is_admin'){
			$user_id = $this->session->userdata('id_usuario');
			$product_id=$this->uri->segment(3);
			$product = $this->products_model->load_product_info($product_id);
			print_r($product);
			$genero = $this->genero_model->load_genero_info($product->gender_id);
			$dj = $this->users_model->load_user_info($product->owner_id);
			if($dj){
				$djusername = $dj->username;
			}else{
				$djusername = 'Unavailable';
			}
			$file='DMB.mp3';
			if($product->product_type_id==1){
				$ext = pathinfo($product->descargable, PATHINFO_EXTENSION);
				$file=preg_replace('/[^a-zA-Z0-9]/', ' ', $product->name).' - '.$product->artist.' - '.$djusername.' - '.$genero->name.' - '.$product->version.' - '.$product->bpm.'bpm - DMB.mp3';
			}else{
				$ext = pathinfo($product->descargable, PATHINFO_EXTENSION);
				$file=$product->name.' - '.$product->artist.' - '.$djusername.' - '.$genero->name.' - '.$product->version.' - '.$product->bpm.'bpm - DMB .'.$ext;
			}
			if($product->product_type_id==3){
				$tamano=@filesize('/var/www/dalemasbajo.com/assets/products/descargables/videos/'.$product->descargable);
				$file_url='/var/www/dalemasbajo.com/assets/products/descargables/videos/'.$product->descargable;
			}else{
				$tamano=@filesize('/var/www/dalemasbajo.com/assets/products/descargables/'.$product->descargable);
				$file_url='/var/www/dalemasbajo.com/assets/products/descargables/'.$product->descargable;
			}
			$tamano=@filesize($file_url);
			$today = date('Y-m-d');
			$data = array(
				'product_id'	=>	$product->id,
				'user_id'		=>	$user_id,
				'date'			=>	$today
			);
			$this->products_model->add_download($data);
			if(file_exists($file_url)) {
				header("Pragma: no-cache");
				header('Expires: 0');
				header('Access-Control-Allow-Origin: *');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header("Last-Modified: " . gmdate("D, d M Y H:i:s T", filemtime($file_url))); 
				header('Cache-Control: private',false);
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'.$file.'"');
				header('Content-Transfer-Encoding: binary');
				header('Content-Length: '.$tamano);
				// reason: it's unreliable to download whole file at once
				ob_clean();
				flush();
				readfile($file_url);
				exit;
				header("Connection: close");
				exit();
			}else{
				echo "File Not Found!!";	
			}
		}else{
			redirect(base_url());
		}
	}

	public function add_product(){
		$user_role= $this->session->userdata('role');
		$where = array();
		$this->load->model('users_model');
		if($this->session->userdata('is_logued_in')){
			$name = $this->input->post('name');
			$artist = $this->input->post('artist');
			$price = $this->input->post('price');
			$description = $this->input->post('description');
			$bpm = $this->input->post('bpm');
			$gender_id = $this->input->post('gender_id');
			$product_type_id = $this->input->post('product_type_id');
			$owner_id = $this->input->post('user_id');

			$image_folder='images/products/featured_image/';
			
			$temp = explode(".", $_FILES["image"]["name"]);
			$newfilename = round(microtime(true)) . '.' . end($temp);
			$image_file=$image_folder.basename($_FILES['image']['name']);

			if(move_uploaded_file($_FILES['image']['tmp_name'], $image_folder.$newfilename)){
				
				$demo_folder = 'assets/products/demos/';

				$temp = explode(".", $_FILES["demo"]["name"]);
				$newdemoname = round(microtime(true)) . '.' . end($temp);
				$demo_file=$demo_folder.basename($_FILES['demo']['name']);
				
				if(move_uploaded_file($_FILES['demo']['tmp_name'], $demo_folder.$newdemoname)){

					$file_folder = 'assets/products/descargables/';

					$temp = explode(".", $_FILES["descargable"]["name"]);


					$newdescargablename = round(microtime(true)) . '.' . end($temp);

					$descagable=$file_folder.basename($_FILES['descargable']['name']);

					if(move_uploaded_file($_FILES['descargable']['tmp_name'], $file_folder.$newdescargablename)){

						$data = array(
							'name'=>$name,
							'artist'=>$artist,
							'price'=>$price,
							'description'=>$description,
							'gender_id'=>$gender_id,
							'product_type_id'=>$product_type_id,
							'owner_id'=>$owner_id,
							'bpm'=>$bpm,
							'featured_image'=>$newfilename,
							'demo'=>$newdemoname,
							'descargable'=>$newdescargablename,
						);
						
						$this->products_model->create_product($data);

						$data['title']="Productos";
						$data['description']="Audios, Packs, y todos los productos dentro del sistema";
						$data['aditional_scripts']="<script>
					      $(function(){
					        'use strict';
					        $('#datatable1').DataTable({
					          responsive: true,
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
					    $data['product_types']=$this->products_model->get_product_types();
					   

					    $total_records = $this->products_model->get_total_products();

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
				            $data["products"] = $this->products_model->get_current_page_records($limit_per_page, $start_index, $where);
				             
				            $config['base_url'] = base_url() . 'admin/listar_productos';
				            $config['total_rows'] = $total_records;
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
						$this->load->view('admin/head', $data);
						$this->load->view('admin/side');
						$this->load->view('admin/top');
						$this->load->view('admin/productos');
					}
				
				}

			}
		}else{
			redirect(base_url().'admin/login/');
		}

	}


	public function descargar_producto(){
		
		if($this->session->userdata('is_logued_in')){
			$user_id = $this->session->userdata('id_usuario');
			$tokens= $this->users_model->hasTokens($user_id);
			$product_id=$this->uri->segment(3);
			if($tokens==false){
				$tokenstotal=0;
			}else{
				$tokenstotal=$tokens[0]->total;
			}
			if($tokenstotal>0||$this->users_model->isUserFile($user_id, $product_id)||$this->session->userdata('is_user_unlimited')==true){
				$product = $this->products_model->load_product_info($product_id);
				$genero = $this->genero_model->load_genero_info($product->gender_id);
				$dj = $this->users_model->load_user_info($product->owner_id);
				
				if($product->product_type_id==1){
					$ext = pathinfo($product->descargable, PATHINFO_EXTENSION);
						$file=$product->name.' - '.$product->artist.' - '.$dj->username.' - '.$genero->name.' - '.$product->version.' - '.$product->bpm.'bpm - DMB.mp3';
				}else{
					$ext = pathinfo($product->descargable, PATHINFO_EXTENSION);
					$file=$product->name.' - '.$product->artist.' - '.$dj->username.' - '.$genero->name.' - '.$product->version.' - '.$product->bpm.'bpm - DMB .'.$ext;
				}
				
				$tamano=@filesize('/var/www/dalemasbajo.com/assets/products/descargables/'.$product->descargable);
				$file_url='/var/www/dalemasbajo.com/assets/products/descargables/'.$product->descargable;
				$tamano=@filesize($file_url);
				$today = date('Y-m-d');
				$user_products = $this->users_model->get_user_products($user_id);
				$user_product_ids = array();
				foreach($user_products as $user_product){
					$user_product_ids[] = $user_product->product_id;
				}
				//print_r($user_product_ids);
				//echo $product_id;
				if(!in_array($product_id, $user_product_ids)&& !$this->session->userdata('is_user_unlimited')){
					$this->reduce_tokens($user_id);
				}

				$data = array(
					'user_id' 	=> 	$user_id,
					'product_id'	=> $product_id,
					'downloads_left'	=>	3,
					'since'		=> $today
				);
				$this->users_model->add_file_to_user($data);
				$data = array(
					'product_id'	=>	$product_id,
					'user_id'		=>	$user_id,
					'date'			=>	$today
				);
				$this->products_model->add_download($data);
				$owner_id = $product->owner_id;
				$this->add_payment_to_owner_tokens($product_id, $owner_id, $user_id); 
				if(file_exists($file_url)) {
					session_write_close();
					header("Pragma: no-cache");
					header('Expires: 0');
					header('Access-Control-Allow-Origin: *');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header("Last-Modified: " . gmdate("D, d M Y H:i:s T", filemtime($file_url))); 
					header('Cache-Control: private',false);
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="'.$file.'"');
					header('Content-Transfer-Encoding: binary');
					header('Content-Length: '.$tamano);
					ob_clean();
					flush();
					readfile($file_url);
					exit;
					header("Connection: close");
					exit();  
				}else{
					echo "File Not Found!!";	
				}
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url());
		}
	}

	public function descargar_producto_video(){
		if($this->session->userdata('is_logued_in')){
			$user_id = $this->session->userdata('id_usuario');
			$tokens= $this->users_model->hasTokensVideo($user_id);
			$product_id=$this->uri->segment(3);
			if($tokens==false){
				$tokenstotal=0;
			}else{
				$tokenstotal=$tokens[0]->total;
			}
			if($tokenstotal>0||$this->users_model->isUserFile($user_id, $product_id)||$this->session->userdata('is_user_unlimited')==true){
				$product = $this->products_model->load_product_info($product_id);
				$genero = $this->genero_model->load_genero_info($product->gender_id);
				$dj = $this->users_model->load_user_info($product->owner_id);
				
				if($product->product_type_id==1){
					$ext = pathinfo($product->descargable, PATHINFO_EXTENSION);
						$file=$product->name.' - '.$product->artist.' - '.$dj->username.' - '.$genero->name.' - '.$product->version.' - '.$product->bpm.'bpm - DMB.'.$ext;
				}else{
					$ext = pathinfo($product->descargable, PATHINFO_EXTENSION);
					$file=$product->name.' - '.$product->artist.' - '.$dj->username.' - '.$genero->name.' - '.$product->version.' - '.$product->bpm.'bpm - DMB .'.$ext;
				}
				
				$tamano=@filesize('/var/www/dalemasbajo.com/assets/products/descargables/videos/'.$product->descargable);
				$file_url='/var/www/dalemasbajo.com/assets/products/descargables/videos/'.$product->descargable;
				$tamano=@filesize($file_url);
				$today = date('Y-m-d');
				$user_products = $this->users_model->get_user_products($user_id);
				$user_product_ids = array();
				foreach($user_products as $user_product){
					$user_product_ids[] = $user_product->product_id;
				}
				//print_r($user_product_ids);
				//echo $product_id;
				if(!in_array($product_id, $user_product_ids)&& !$this->session->userdata('is_user_unlimited')){
					$this->reduce_tokens_video($user_id);
				}

				$data = array(
					'user_id' 	=> 	$user_id,
					'product_id'	=> $product_id,
					'downloads_left'	=>	3,
					'since'		=> $today
				);
				$this->users_model->add_file_to_user($data);
				$data = array(
					'product_id'	=>	$product_id,
					'user_id'		=>	$user_id,
					'date'			=>	$today
				);
				$this->products_model->add_download($data);
				$owner_id = $product->owner_id;
				$this->add_payment_to_owner_tokens($product_id, $owner_id, $user_id); 
				if(file_exists($file_url)) {
					session_write_close();
					header("Pragma: no-cache");
					header('Expires: 0');
					header('Access-Control-Allow-Origin: *');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header("Last-Modified: " . gmdate("D, d M Y H:i:s T", filemtime($file_url))); 
					header('Cache-Control: private',false);
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename="'.$file.'"');
					header('Content-Transfer-Encoding: binary');
					header('Content-Length: '.$tamano);
				// 	// reason: it's unreliable to download whole file at once
				// 	// $chunksize = 1 * (1024 * 1024);
				// 	// $fp = fopen($file_url,'rb'); 
				// 	// $buffer = ''; 
				// 	// while (!feof($fp)) 
				// 	// 	{ 
				// 	// 	$buffer = fread($fp, $chunksize); 
				// 	// 	echo $buffer; 
				// 	// 	ob_flush(); 
				// 	// 	flush(); 
				// 	// 	} 
				// 	// fclose($fp); 
				// 	// // resume original code here:
				// 	// if ( !$fp ) {
				// 	//     echo "File Not Found";
				// 	//     exit();
				// 	// }
				// 	// if ( !fpassthru($fp) ) {
				// 	//     echo "There was an error!";
				// 	//     exit();
				// 	// }
					ob_clean();
					flush();
					readfile($file_url);
					exit;
					header("Connection: close");
					exit();  
				}else{
					echo "File Not Found!!";	
				}
			}else{
				redirect(base_url());
			}
		}else{
			redirect(base_url());
		}
	}

	public function reduce_tokens($user_id){
		$this->users_model->update_tokens($user_id); 
	}

	public function reduce_tokens_video($user_id){
		$this->users_model->update_tokens_video($user_id); 
	}

	function add_payment_to_owner_tokens($product_id, $owner_id, $user_id){
		$amount = 0.05;
		$date = date("Y-m-d"); 
		$data = array(
			'date'			=>	$date,
			'user_id'		=>	$user_id,
			'amount'		=>	$amount,
			'product_id'	=>	$product_id,
			'owner_id'		=>	$owner_id
		);
		$this->orders_model->insert_payment_tokens($data);
	}


}