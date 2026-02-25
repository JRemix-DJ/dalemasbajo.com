<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drops extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model', 'plan_model', 'orders_model'));
		$this->load->library(array('session','form_validation','cart', 'pagination', 'dmbfunctions'));
		$this->load->database('default');
		$this->users_model->check_payment();
		$this->dmbfunctions->loadGets(); 
		$this->session->set_userdata('content_type','videos');
	}

	public function index()
	{
		$data['title']="Drops - Dale Mas Bajo";
		$data['description']="Música para Djs y Vjs, los mejores remixes en un solo lugar";
		$data['generos']=$this->genero_model->get_generos();
		$data['genero'] = $this->genero_model->load_genero_info(45);
		$data['banners']=$this->banners_model->get_banners();
		$data['djs']=$this->users_model->get_djs_videos();
        $data['users']=$this->users_model->get_all_users();
		$where_video = array();
		$where_video['approved'] = 1;
        $where_video['product_type_id']=5;
		$total_records = $this->products_model->get_total_products($where_video);
		$params = array();

		$limit_per_page = 20;

        $where = array();
		$not_in = null;
		
		$where['approved'] = 1;
		
        $where['product_type_id']=5;
		$start_index = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
	    if($total_records > 0)
        {
        	$data["products"] = $this->products_model->get_current_page_records($limit_per_page, $start_index, $where, 'gender_id', $not_in);
            $config['base_url'] = base_url('drops');
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config['page_query_string'] = FALSE;
            $config["uri_segment"] = 2;
			$config['reuse_query_string'] = true;
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
             
            $data["links"] = $this->pagination->create_links();
		}
		$data['product_type_id'] = $where['product_type_id'];
		$data['plans']=$this->plan_model->get_plans();
		$this->load->view('templates/header', $data);
		$this->load->view('drops');
		$this->load->view('templates/footer', $data);
	}

	public function drop_text(){
		$drop_text = $this->input->post('drop_text');
		$order_id = $this->input->post('order_id');
		$data['drop_text']=$drop_text;
		$this->orders_model->update_order($order_id, $data);
		$jsondata['respuesta'] = "ok";
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata);
	}

	public function get_drop(){
		if($this->session->userdata('is_logued_in')){

			$drop_id = $this->input->get('drop_id');
			$producto = $this->products_model->load_product_info($drop_id);
			$data['title']="Checkout - LAMEGAMEZCLADJS.COM";
			$data['description']="Finaliza tu pago";
			$data['generos']=$this->genero_model->get_generos();
			$data['djs']=$this->users_model->get_djs();
			$data['producto']=$producto;
			$data_order = array(
				'user_id'		=>	$this->session->userdata('id_usuario'),
				'date_order'	=> 	date("Y-m-d H:i:s"),
				'total_price'	=> 	$producto->price,
				'status'		=> 	0,
				'is_plan'		=>	0,
				'plan_id'		=>	0,
				'is_drop'		=>	1,
				'drop_id'		=> 	$producto->id
			);
			$order_id = $this->orders_model->create_order_drop($data_order);
			$data_items = array(
				'product_id' => $producto->id,
				'quantity'	=> 1,
				'order_id'	=> $order_id
			);
			$this->orders_model->add_items_to_order_drop($data_items);
			$data['order_id'] = $order_id;
			
			$this->load->view('templates/header', $data);
			$this->load->view('get_drop');
			$this->load->view('templates/footer', $data);
		}else{
			$data['title']="Checkout - LAMEGAMEZCLADJS.COM";
			$data['description']="Finaliza tu pago";
			$data['generos']=$this->genero_model->get_generos();
			$data['djs']=$this->users_model->get_djs();
			$this->load->view('templates/header', $data);
			$this->load->view('get_drop.php');
			$this->load->view('templates/footer', $data);
		}
	}

    public function checkout_drop(){
        $data['title'] = "Checkout - Dale Mas Bajo";
        $data['description'] = "Finalize your drop purchase";
        $data['generos'] = $this->genero_model->get_generos();
        $data['djs'] = $this->users_model->get_djs();
        $data['plans'] = $this->plan_model->get_plans();

        if(!$this->session->userdata('is_logued_in')){
            redirect(base_url('drops'));
            return;
        }

        $drop_id = (int)$this->input->get('drop_id');
        if(!$drop_id){
            redirect(base_url('drops'));
            return;
        }

        $producto = $this->products_model->load_product_info($drop_id);
        if(!$producto || (int)$producto->product_type_id !== 5){
            redirect(base_url('drops'));
            return;
        }

        if(empty($producto->payment_link)){
            $data['error'] = "This drop does not have a payment link configured.";
            $data['producto'] = $producto;
            $this->load->view('templates/header', $data);
            $this->load->view('checkout', $data);
            $this->load->view('templates/footer', $data);
            return;
        }

        $user_id = (int)$this->session->userdata('id_usuario');

        $order = $this->orders_model->find_pending_drop_order_by_drop($user_id, $drop_id);
        if(!$order){
            $data_order = array(
                'user_id'      => $user_id,
                'date_order'   => date("Y-m-d H:i:s"),
                'total_price'  => $producto->price,
                'status'       => 0,
                'is_plan'      => 0,
                'plan_id'      => 0,
                'is_drop'      => 1,
                'drop_id'      => $producto->id,
                'txn_id'       => null
            );

            $order_id = $this->orders_model->create_order_drop($data_order);

            $data_items = array(
                'product_id' => $producto->id,
                'quantity'   => 1,
                'order_id'   => $order_id
            );

            $this->orders_model->add_items_to_order_drop($data_items);

            $order = $this->orders_model->load_order_info($order_id);
        }

        $data['producto'] = $producto;
        $data['orden'] = $order;

        $this->load->view('templates/header', $data);
        $this->load->view('checkout', $data);
        $this->load->view('templates/footer', $data);
    }

	public function test()
	{
		$this->load->view('comingsoon');
	}

}
