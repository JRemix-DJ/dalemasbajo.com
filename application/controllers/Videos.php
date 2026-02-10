<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class __Videos extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model', 'plan_model'));
		$this->load->library(array('session','form_validation','cart', 'pagination', 'dmbfunctions'));
		$this->load->database('default');
		$this->users_model->check_payment();
		$this->dmbfunctions->loadGets(); 
		$this->session->set_userdata('content_type','videos');
	}

	public function index()
	{
		$data['title']="Dale Más Bajo";
		$data['description']="Música para Djs y Vjs, los mejores remixes en un solo lugar";
		//$data['products']=$this->products_model->get_products();
		$data['generos']=$this->genero_model->get_generos();
		//print_r($data['generos']);
		$data['is_video_section']=1;
		$data['banners']=$this->banners_model->get_banners();
		$data['djs']=$this->users_model->get_djs_videos();
        $data['users']=$this->users_model->get_all_users();
        $where_video = array();
        $where_video['product_type_id']=3;
		$total_records = $this->products_model->get_total_products_approved($where_video);
		//echo $total_records;
		$params = array();
        $limit_per_page = 20;
        $where = array();
		$not_in = array(45);
		
		$where['approved'] = 1;
		
        $where['product_type_id']=3;
		$start_index = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		//echo 'total records'.$total_records;
	    if($total_records > 0)
        {
        	$data["products"] = $this->products_model->get_current_page_records($limit_per_page, $start_index, $where, 'gender_id', $not_in);
         
            $config['base_url'] = base_url('videos');
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config['page_query_string'] = FALSE;
            $config["uri_segment"] = 2;

            $config['full_tag_open'] = '<nav><ul class="pagination">';
        	$config['full_tag_close'] = '</ul></nav>';
        	$total_pages =  ceil($total_records/$limit_per_page);
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
		$data['plans']=$this->plan_model->get_plans();
		$this->load->view('templates/header', $data);
		$this->load->view('home_videos');
		$this->load->view('templates/footer', $data);
	}

	public function comingsoon()
	{
		$this->load->view('comingsoon');
	}

}
