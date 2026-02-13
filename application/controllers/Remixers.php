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
        // Importante setear esto para que las vistas sepan qué mostrar
        $this->session->set_userdata('content_type','audios');
    }

    public function index(){
        // Obtenemos ID del Remixer desde la URL: remixers/ID
        $dj_id = $this->uri->segment(2);

        if($this->is_dj($dj_id)){

            // 1. Datos Globales (Arriba para que el AJAX los tenga)
            $data['generos'] = $this->genero_model->get_generos();
            $data['users'] = $this->users_model->get_all_users();
            $data['djs'] = $this->users_model->get_djs();
            $data['user'] = $this->users_model->load_user_info($dj_id); // Info del DJ actual

            $data['title'] = $data['user']->username . " - Remixes";
            $data['description'] = "Remixes exclusivos de " . $data['user']->username;

            // 2. Configuración Filtros
            $where = array();
            if($this->session->userdata('content_type')=='videos'){
                $where['product_type_id']=3;
            }else{
                $where['product_type_id']=1;
            }

            // 3. Paginación
            $total_records = $this->products_model->get_total_products_by_dj($dj_id, $where);
            $limit_per_page = 20;
            $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            if($total_records > 0)
            {
                $data["products"] = $this->products_model->get_current_page_records_by_dj($limit_per_page, $start_index, $dj_id, $where);

                // Config Paginación
                $config['base_url'] = base_url('remixers/'.$dj_id.'/'); // Slash final importante
                $config['total_rows'] = $total_records;
                $config['per_page'] = $limit_per_page;
                $config['uri_segment'] = 3; // Segmento 3 es el número de página

                // Estilos HTML Modernos (Blue Active)
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

                $config['first_url'] = base_url('remixers/'.$dj_id);

                $this->pagination->initialize($config);
                $data["links"] = $this->pagination->create_links();
            } else {
                $data["products"] = [];
                $data["links"] = "";
            }

            // 4. RESPUESTA AJAX (Para navegación sin recarga)
            if ($this->input->is_ajax_request()) {
                $html_rows = $this->load->view('table_products', $data, TRUE);
                echo json_encode([
                    'status' => 'success',
                    'html_table' => $html_rows,
                    'html_pagination' => $data['links']
                ]);
                exit;
            }

            // 5. Carga Normal
            $this->load->view('templates/header', $data);
            $this->load->view('remixer', $data); // Vista principal
            $this->load->view('templates/footer', $data);

        }else{
            redirect('audios'); // Si el DJ no existe, redirigir
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
?>