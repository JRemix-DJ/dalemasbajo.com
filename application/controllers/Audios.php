<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audios extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper(array('url', 'form', 'download'));
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

        $data['trending_audios'] = array_slice($data['products'], 0, 5);

        if ($this->input->is_ajax_request()) {
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

    public function download($id = null){
        if (!$this->session->userdata('is_logued_in')) {
            redirect('login');
        }

        if ($id == null) {
            show_404();
        }

        $product = $this->products_model->get_product_by_id($id);

        if (empty($product)) {
            show_404();
        }

        $file_name = isset($product->descargable) ? $product->descargable : '';

        if($file_name == ''){
            show_error('Error: El producto no tiene archivo asignado en la base de datos.');
            return;
        }

        $path = FCPATH . 'assets/products/descargables/' . $file_name;

        if (file_exists($path)) {
            $this->load->helper('download');

            $remixer_obj = $this->users_model->load_user_info($product->owner_id);
            $remixer_name = ($remixer_obj) ? $remixer_obj->username : 'DMB';

            $genre_obj = $this->genero_model->load_genero_info($product->gender_id);
            $genre_name = ($genre_obj) ? $genre_obj->name : 'General';

            $clean_title   = str_replace(array('/', '\\', ':'), '-', $product->name);
            $clean_artist  = str_replace(array('/', '\\', ':'), '-', $product->artist);
            $clean_remixer = str_replace(array('/', '\\', ':'), '-', $remixer_name);
            $clean_genre   = str_replace(array('/', '\\', ':'), '-', $genre_name);
            $clean_version = str_replace(array('/', '\\', ':'), '-', $product->version);

            if(empty($clean_version)) $clean_version = "Original";

            $new_name_string = $clean_title . ' - ' .
                $clean_artist . ' - ' .
                $clean_remixer . ' - ' .
                $clean_genre . ' - ' .
                $clean_version . ' - ' .
                $product->bpm . 'bpm - DMB';

            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $final_name = $new_name_string . '.' . $extension;

            force_download($final_name, file_get_contents($path));

        } else {
            show_error('El archivo físico no existe en la ruta: ' . $path);
        }
    }
}