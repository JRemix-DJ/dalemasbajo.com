<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tienda extends CI_Controller {
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
				$data['title']="Tienda - Dale Más Bajo";
				$data['description']="Compra los mejores remixes para djs del continente";

				$total_records = $this->products_model->get_total_products();
				$params = array();
		        $limit_per_page = 1;
		        $start_index = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			    if($total_records > 0)
		        {
		        	$data["products"] = $this->products_model->get_current_page_records($limit_per_page, $start_index);
	             
		            $config['base_url'] = base_url().'tienda/';
		            $config['total_rows'] = $total_records;
		            $config['per_page'] = $limit_per_page;
		            $config['page_query_string'] = FALSE;
		            $config["uri_segment"] = 2;

		            $config['full_tag_open'] = '<nav><ul class="pagination">';
	            	$config['full_tag_close'] = '</ul></nav>';

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
		             
		            // build paging links
		            $data["links"] = $this->pagination->create_links();
		        }
				$data['generos']=$this->genero_model->get_generos();
				$data['users']=$this->users_model->get_all_users();

				$this->load->view('templates/header', $data);
				$this->load->view('tienda');
				$this->load->view('templates/footer', $data);
	}
}
?>