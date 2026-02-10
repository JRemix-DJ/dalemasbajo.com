<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model'));
		$this->load->library(array('session','form_validation', 'pagination','dmbfunctions'));
		$this->dmbfunctions->loadGets(); 
		$this->load->database('default');
	}

	public function index()
	{
		if($this->input->get('sname')!=''){
			$sname = $this->input->get('sname');
			$data['sname']=$sname;
		}else{
			$sname=NULL;
		}
		if($this->input->get('sgenero')!=''){
			$sgenero = $this->input->get('sgenero');
			$data['sgenero']=$sgenero;
		}else{
			$sgenero=NULL;
		}
		if($this->input->get('sremixers')!=''){
			$sremixers = $this->input->get('sremixers');
			$data['sremixers']=$sremixers;
		}else{
			$sremixers=NULL;
		}

				$data['title']="Buscar - Dale Más Bajo";
				$data['description']="Compra los mejores remixes para djs del continente";
				
				$params = array();
				if($this->session->userdata('content_type')=='videos'){
					$params['product_type_id']=3;
				}else{
					$params['product_type_id']=1;
				}
				$total_records = $this->products_model->get_total_products_searched($sgenero, $sremixers, $sname, $params);
		        $limit_per_page = 20;
		        $start_index = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			    if($total_records > 0)
		        {
		        	$data["products"] = $this->products_model->get_current_page_records_searched($limit_per_page, $start_index, $sgenero, $sremixers, $sname, $params);
	             	$config['reuse_query_string']=TRUE;

		            $config['base_url'] = base_url().'search/';
		            $config['total_rows'] = $total_records;
		            $config['per_page'] = $limit_per_page;
		            $config['page_query_string'] = FALSE;
		            $config["uri_segment"] = 2;
		            $total_pages =  ceil($total_records/$limit_per_page);
		            $config['full_tag_open'] = '<nav><ul class="pagination">';
	            	$config['full_tag_close'] = '</ul></nav>';

					$config['prev_link'] = '«';
					$config['next_link'] = '»';

					$config['first_tag_open'] = '<li class="numlink">';
					$config['fisrt_tag_close'] = '<li>';
					$config['first_link'] = '1';
					$config['last_tag_open'] = '<li class="numlink">';
					$config['last_tag_close'] = '<li>';
					$config['last_link'] = $total_pages;

					$config['cur_tag_open'] = '<li class="curlink"><a href="#">';
		            $config['cur_tag_close'] = '</a></li>';
		 
		            $config['num_tag_open'] = '<li class="numlink">';
		            $config['num_tag_close'] = '</li>';

		             $config['next_tag_open'] = '<li class="nextlink">';
            		$config['next_tag_close'] = '</li>';

            		$config['prev_tag_open'] = '<li class="prevlink">';
            		$config['prev_tag_close'] = '</li>';

		            $this->pagination->initialize($config);
		             
		            // build paging links
		            $data["links"] = $this->pagination->create_links();
		        }
				$data['generos']=$this->genero_model->get_generos();
				$data['users']=$this->users_model->get_all_users();
				$data['djs']=$this->users_model->get_djs();

				$this->load->view('templates/header', $data);
				$this->load->view('search');
				$this->load->view('templates/footer', $data);
	}
}
?>