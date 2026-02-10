<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audios extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model'));
		$this->load->library(array('session','form_validation','cart', 'pagination','dmbfunctions'));
		$this->dmbfunctions->loadGets(); 
		$this->load->database('default');
		$this->users_model->check_payment();
		$this->session->set_userdata('content_type','audios');
	}

	public function index()
	{
		$data['title']="Dale Más Bajo";
		$data['description']="Música para Djs y Vjs, los mejores remixes en un solo lugar";
		//$data['products']=$this->products_model->get_products();
		$data['generos']=$this->genero_model->get_generos();
		$data['banners']=$this->banners_model->get_banners();
		$data['djs']=$this->users_model->get_djs_audios();
		$data['users']=$this->users_model->get_all_users();
		$where_audio = array();
        $where_audio['product_type_id']=1;
		$total_records = $this->products_model->get_total_products_approved($where_audio);
		//echo $total_records;
		$params = array();
        $limit_per_page = 20;
        $where = array();
        $not_in = array(45);
		$where['approved'] = 1;
		$where['product_type_id']=1;
        $start_index = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        //echo $start_index;
	    if($total_records > 0)
        {
        	$data["products"] = $this->products_model->get_current_page_records($limit_per_page, $start_index, $where, 'gender_id', $not_in);
         
            $config['base_url'] = base_url('audios');
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

		$this->load->view('templates/header', $data);
		$this->load->view('home_audios');
		$this->load->view('templates/footer', $data);
	}

	public function comingsoon()
	{
		$this->load->view('comingsoon');
	}

}
