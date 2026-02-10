<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Remixers extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model'));
		$this->load->library(array('session','form_validation', 'pagination','dmbfunctions'));
		$this->load->database('default');
		$this->dmbfunctions->loadGets(); 
	}

	public function index(){
		$dj_id = $this->uri->segment(2);
		//echo $dj_id;
		if($this->is_dj($dj_id)){
			$data['title']="Remixers - Dale Más Bajo";
			$data['description']="Remixers en Dale Más Bajo";
			$data['djs']=$this->users_model->get_djs();
			$where = array();
			if($this->session->userdata('content_type')=='videos'){
				$where['product_type_id']=3;
			}else{
				$where['product_type_id']=1;
			}
			// echo $this->uri->segment(4);
			$total_records = $this->products_model->get_total_products_by_dj($dj_id, $where);
			//echo $total_records;
			$params = array();
	        $limit_per_page = 20;
	        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		    if($total_records > 0)
	        {
	        	$data["products"] = $this->products_model->get_current_page_records_by_dj($limit_per_page, $start_index, $dj_id, $where);
             
	            $config['base_url'] = base_url().'remixers/'.$dj_id.'/';
	            $config['total_rows'] = $total_records;
	            $config['per_page'] = $limit_per_page;
	            $config['page_query_string'] = FALSE;
	            $config["uri_segment"] = 3;
	            $total_pages =  ceil($total_records/$limit_per_page);
	            $config['full_tag_open'] = '<nav><ul class="pagination">';
            	$config['full_tag_close'] = '</ul></nav>';
            	$config['first_tag_open'] = '<li class="numlink">';
				$config['fisrt_tag_close'] = '<li>';
				$config['first_link'] = '1';
				$config['last_tag_open'] = '<li class="numlink">';
				$config['last_tag_close'] = '<li>';
				$config['last_link'] = $total_pages;
				$config['prev_link'] = '«';
				$config['next_link'] = '»';

				$config['cur_tag_open'] = '<li class="curlink"><a href="#">';
	            $config['cur_tag_close'] = '</a></li>';
	 
	            $config['num_tag_open'] = '<li class="numlink">';
	            $config['num_tag_close'] = '</li>';

	             $config['next_tag_open'] = '<li class="nextlink">';
        		$config['next_tag_close'] = '</li>';

        		$config['prev_tag_open'] = '<li class="prevlink">';
        		$config['prev_tag_close'] = '</li>';

	            $this->pagination->initialize($config);
	             
	            $data["links"] = $this->pagination->create_links();
	        }



			$data['generos']=$this->genero_model->get_generos();
			$data['users']=$this->users_model->get_all_users();
			$data['user']=$this->users_model->load_user_info($dj_id);
			$this->load->view('templates/header', $data);
			$this->load->view('remixer');
			$this->load->view('templates/footer', $data);
		}else{
			echo 'error';
		}
	}
	private function is_dj($id){
		if($this->users_model->load_user_info($id)){
			return true;
		}else{
			return false;
		}
	}
}