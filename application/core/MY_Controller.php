<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
        $this->load->database('default');

        if ($this->session->userdata('is_logued_in')) {
            $existing = $this->session->userdata('user_products');
            if (empty($existing)) {
                $user_id = $this->session->userdata('id_usuario') ?: $this->session->userdata('user_id');
                if ($user_id) {
                    if (!isset($this->users_model)) {
                        $this->load->model('users_model');
                    }
                    $downloaded = $this->users_model->get_user_products($user_id);
                    $downloaded_ids = [];
                    foreach ($downloaded as $item) {
                        $downloaded_ids[] = (string)(is_object($item) && isset($item->product_id) ? $item->product_id : $item);
                    }
                    $this->session->set_userdata('user_products', $downloaded_ids);
                }
            } elseif (is_array($existing)) {
                $normalized = array_map('strval', $existing);
                if ($normalized !== $existing) {
                    $this->session->set_userdata('user_products', $normalized);
                }
            }
        }

    }

    public function token() {
        $token = md5(uniqid(rand(), true));
        $this->session->set_userdata('token', $token);
        return $token;
    }

    public function random($length = 8) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
}

class Admin_Controller extends Base_Controller {

    protected $user_rol;

    public function __construct() {
        parent::__construct();
        $this->load->library(['form_validation', 'pagination', 'email']);
        $this->load->model([
            'users_model',
            'cupons_model',
            'plan_model',
            'genero_model',
            'products_model',
            'banners_model',
            'precios_model',
            'faq_model',
            'orders_model',
            'location_model'
        ]);

        $this->user_rol = $this->session->userdata('role');

        $method = $this->router->fetch_method();
        if ($method !== 'login' && !$this->user_has_admin_access()) {
            redirect(base_url());
            exit;
        }
    }

    public function user_has_admin_access() {
        $role = $this->session->userdata('role');
        return ($role == 1 || $role == 2 || $role === 'is_admin' || $role === 'is_editor');
    }
}
