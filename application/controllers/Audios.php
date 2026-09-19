<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audios extends Base_Controller {

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

    public function index($start_index = 0)
    {
        $data['user_products'] = $this->session->userdata('user_products') ?: [];

        if($this->session->userdata('is_logued_in') && empty($data['user_products'])){
            $user_id = (int)$this->session->userdata('id_usuario');
            $user_products = $this->users_model->get_user_products($user_id);
            $ids = [];
            if(!empty($user_products)){
                foreach($user_products as $up){
                    $ids[] = (string)(is_object($up) && isset($up->product_id) ? $up->product_id : $up);
                }
            }
            $this->session->set_userdata('user_products', $ids);
            $data['user_products'] = $ids;
        }

        session_write_close();

        $data['downloaded_ids'] = $data['user_products'];

        if ($start_index === 0 && $this->uri->segment(2) && is_numeric($this->uri->segment(2))) {
            $start_index = (int) $this->uri->segment(2);
        } else {
            $start_index = (int) $start_index;
        }

        $where_audio = array('product_type_id' => 1, 'approved' => 1);
        $total_records = $this->products_model->get_total_products_approved($where_audio);
        $limit_per_page = 20;

        $where = array('approved' => 1, 'product_type_id' => 1);
        $not_in = array(45);

        if($total_records > 0) {
            $data["products"] = $this->products_model->get_current_page_records($limit_per_page, $start_index, $where, 'gender_id', $not_in);
        } else {
            $data["products"] = [];
        }

        $config['base_url']          = base_url('audios/');
        $config['first_url']         = base_url('audios');
        $config['total_rows']        = $total_records;
        $config['per_page']          = $limit_per_page;
        $config['uri_segment']       = 2;
        $config['cur_page']          = $start_index;
        $config['use_page_numbers']  = FALSE;
        $config['reuse_query_string'] = TRUE;

        $config['full_tag_open']  = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open']   = '<li class="active"><span class="bg-primary text-white">';
        $config['cur_tag_close']  = '</span></li>';
        $config['num_tag_open']   = '<li>';
        $config['num_tag_close']  = '</li>';
        $config['prev_link']      = '<i class="fa fa-chevron-left"></i>';
        $config['prev_tag_open']  = '<li class="prevlink">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link']      = '<i class="fa fa-chevron-right"></i>';
        $config['next_tag_open']  = '<li class="nextlink">';
        $config['next_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="numlink">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open']  = '<li class="numlink">';
        $config['last_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $data['generos'] = $this->genero_model->get_generos();
        $data['banners'] = $this->banners_model->get_banners();
        $data['djs']     = $this->users_model->get_djs_audios();
        $data['trending_audios'] = $this->products_model->get_trending_now(5);

        if ($this->input->is_ajax_request()) {
            $html_rows = $this->load->view('table_products', $data, TRUE);
            echo json_encode([
                'status'          => 'success',
                'html_table'      => $html_rows,
                'html_pagination' => $data['links']
            ]);
            exit;
        }

        $data['title']       = "Dale Más Bajo";
        $data['description'] = "Música para Djs y Vjs";
        $data['styles']      = ['assets/front/css/pages/audios.css'];
        $data['scripts']     = ['assets/front/js/pages/audios.js'];

        $this->load->view('layouts/header', $data);
        $this->load->view('home_audios', $data);
        $this->load->view('layouts/footer', $data);
    }

    public function download($id = null){
        if (!$this->session->userdata('is_logued_in')) {
            redirect('login');
        }

        if ($id == null) {
            show_404();
        }

        $product = $this->products_model->load_product_info($id);

        if (empty($product)) {
            show_404();
        }

        $user_id      = (int) $this->session->userdata('id_usuario');
        $is_unlimited = (bool) $this->session->userdata('is_user_unlimited');
        $tokens       = (int) $this->session->userdata('tokens');

        $user_products = $this->users_model->get_user_products($user_id);
        $downloaded_ids = [];
        if (!empty($user_products)) {
            foreach ($user_products as $up) {
                $downloaded_ids[] = (int) $up->product_id;
            }
        }

        $already_owned = in_array((int)$id, $downloaded_ids, true);

        if (!$already_owned && !$is_unlimited && $tokens <= 0) {
            redirect('planes');
            return;
        }

        $file_name = isset($product->descargable) ? $product->descargable : '';

        if($file_name == ''){
            show_error('Error: El producto no tiene archivo asignado en la base de datos.');
            return;
        }

        $path = FCPATH . 'assets/uploads/descargables/' . $file_name;
        if (!file_exists($path) && file_exists(FCPATH . 'assets/products/descargables/' . $file_name)) {
            $path = FCPATH . 'assets/products/descargables/' . $file_name;
        }

        if (file_exists($path)) {
            if (!$already_owned) {
                if (!$is_unlimited) {
                    $this->users_model->update_tokens($user_id);
                    $this->session->set_userdata('tokens', max(0, $tokens - 1));
                }

                $today = date('Y-m-d');
                $this->users_model->add_file_to_user([
                    'user_id'        => $user_id,
                    'product_id'     => (int) $id,
                    'downloads_left' => 3,
                    'since'          => $today
                ]);

                $this->products_model->add_download([
                    'product_id' => (int) $id,
                    'user_id'    => $user_id,
                    'date'       => $today
                ]);

                $curr_prods = $this->session->userdata('user_products') ?: [];
                $curr_prods[] = (string)$id;
                $this->session->set_userdata('user_products', array_values(array_unique(array_map('strval', $curr_prods))));

                if (!empty($product->owner_id)) {
                    $this->load->model('orders_model');
                    $this->orders_model->insert_payment_tokens([
                        'date'       => $today,
                        'user_id'    => $user_id,
                        'amount'     => 0.05,
                        'product_id' => (int) $id,
                        'owner_id'   => (int) $product->owner_id
                    ]);
                }
            }

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

    public function cover_mp3($id = null){
        session_write_close();

        if ($id == null) {
            $this->_output_default_image();
            return;
        }

        $cache_folder = FCPATH . 'assets/uploads/covers/';

        if (!is_dir($cache_folder)) {
            @mkdir($cache_folder, 0777, true);
        }

        $cached_cover_path = $cache_folder . 'mp3_art_' . $id . '.jpg';

        if (file_exists($cached_cover_path)) {
            $this->_output_image_file($cached_cover_path);
            return;
        }

        $product = $this->products_model->load_product_info($id);
        if (empty($product)) {
            $this->_output_default_image(); return;
        }

        $file_name = isset($product->descargable) ? $product->descargable : '';
        $mp3_path = FCPATH . 'assets/uploads/descargables/' . $file_name;
        if (!file_exists($mp3_path) && file_exists(FCPATH . 'assets/products/descargables/' . $file_name)) {
            $mp3_path = FCPATH . 'assets/products/descargables/' . $file_name;
        }

        if (!file_exists($mp3_path) || empty($file_name)) {
            $this->_output_default_image(); return;
        }

        if (!class_exists('getID3')) {
            if (file_exists(FCPATH . 'vendor/autoload.php')) {
                require_once FCPATH . 'vendor/autoload.php';
            } elseif (file_exists(APPPATH . 'libraries/getid3/getid3.php')) {
                require_once(APPPATH . 'libraries/getid3/getid3.php');
            } else {
                $this->_output_default_image(); return;
            }
        }

        try {
            $getID3 = new getID3;
            $getID3->option_tag_id3v2 = true;
            $getID3->option_tag_apic  = true;

            $file_info = $getID3->analyze($mp3_path);
            $image_data = null;
            $image_mime = 'image/jpeg';

            if (isset($file_info['comments']['picture'][0]['data'])) {
                $image_data = $file_info['comments']['picture'][0]['data'];
                $image_mime = isset($file_info['comments']['picture'][0]['image_mime']) ? $file_info['comments']['picture'][0]['image_mime'] : 'image/jpeg';
            } elseif (isset($file_info['id3v2']['APIC'][0]['data'])) {
                $image_data = $file_info['id3v2']['APIC'][0]['data'];
                $image_mime = isset($file_info['id3v2']['APIC'][0]['mime']) ? $file_info['id3v2']['APIC'][0]['mime'] : 'image/jpeg';
            }

            if ($image_data) {
                @file_put_contents($cached_cover_path, $image_data);
                header('Content-Type: ' . $image_mime);
                echo $image_data;
                return;
            }
        } catch (Exception $e) {}

        $this->_output_default_image();
    }

    private function _output_image_file($path) {
        $mime = mime_content_type($path);
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($path));
        readfile($path);
    }

    private function _output_default_image() {
        $path = FCPATH . 'images/default_cover.jpg';
        if (file_exists($path)) {
            $this->_output_image_file($path);
        } else {
            header('Content-Type: image/jpeg');
            echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');
        }
    }
}