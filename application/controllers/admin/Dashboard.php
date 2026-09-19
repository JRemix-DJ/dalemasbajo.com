<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function index() {
        if (!$this->session->userdata('is_logued_in')) {
            redirect(base_url('admin/login/'));
            exit;
        }

        $data['title'] = "Dale Más Bajo";
        $data['description'] = "Música para Djs y Vjs, los mejores remixes en un solo lugar";
        $data['scripts'] = ['admin_assets/js/dashboard.js'];

        $this->load->view('admin/head', $data);
        $this->load->view('admin/side', $data);
        $this->load->view('admin/top', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('admin/footer', $data);
    }

    public function login() {
        if ($this->session->userdata('is_logued_in') && $this->user_has_admin_access()) {
            redirect(base_url('admin'));
            exit;
        }

        $data['title'] = "Panel Administrativo - Dale Más Bajo";
        $data['description'] = "Panel Administrativo - Dale Más Bajo";
        $data['token'] = $this->token();
        $this->load->view('admin/login', $data);
    }
}
