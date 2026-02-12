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

    public function index(){
        $where_audio = array('product_type_id' => 1, 'approved' => 1);
        $total_records = $this->products_model->get_total_products_approved($where_audio);
        $limit_per_page = 20;
        $start_index = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $where = array('approved' => 1, 'product_type_id' => 1);
        $not_in = array(45);

        if($total_records > 0) {
            $data["products"] = $this->products_model->get_current_page_records($limit_per_page, $start_index, $where, 'gender_id', $not_in);
        } else {
            $data["products"] = [];
        }

        $config['base_url'] = base_url('audios/');
        $config['first_url'] = base_url('audios');
        $config['total_rows'] = $total_records;
        $config['per_page'] = $limit_per_page;
        $config['uri_segment'] = 2;

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><span>';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['prev_link'] = '<i class="fa fa-chevron-left"></i>';
        $config['prev_tag_open'] = '<li class="prevlink">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '<i class="fa fa-chevron-right"></i>';
        $config['next_tag_open'] = '<li class="nextlink">';
        $config['next_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="numlink">';
        $config['fisrt_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="numlink">';
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $data['generos'] = $this->genero_model->get_generos();
        $data['banners'] = $this->banners_model->get_banners();
        $data['djs'] = $this->users_model->get_djs_audios();
        $data['users'] = $this->users_model->get_all_users();

        // Trending
        $data['trending_audios'] = array_slice($data['products'], 0, 5);

        if ($this->input->is_ajax_request()) {
            // Ahora 'table_products' recibe $data que incluye 'generos'
            $html_rows = $this->load->view('table_products', $data, TRUE);

            echo json_encode([
                'status' => 'success',
                'html_table' => $html_rows,
                'html_pagination' => $data['links']
            ]);
            exit;
        }

        $data['title']="Dale Más Bajo";
        $data['description']="Música para Djs y Vjs";

        $this->load->view('templates/header', $data);
        $this->load->view('home_audios', $data);
        $this->load->view('templates/footer', $data);
    }

    public function comingsoon() {
        $this->load->view('comingsoon');
    }
}