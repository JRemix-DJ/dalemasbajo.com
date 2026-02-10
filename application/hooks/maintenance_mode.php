<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class maintenance_mode{
	// protected $CI;

	// public function __construct(){
	// 	$this->CI =& get_instance();
	// }		 
	// public function is_on(){
	// 	if(file_exists(APPPATH.'config/config.php'))
	// 	{
	// 		include(APPPATH.'config/config.php');
	// 		if($this->CI->router->fetch_class() == 'admin'||$this->CI->router->fetch_class() == 'login' || $this->CI->session->userdata('role')=="is_admin"){
	// 			return;
	// 		}else{
	// 			if(isset($config['maintenance_mode']) && $config['maintenance_mode']===TRUE)
	// 			{
	// 				$this->show_site_offline();
	// 				exit;
	// 			}
	// 		}
	// 	}
	// }

	// public function show_site_offline(){
	// 	exit($this->CI->load->view('comingsoon', null, true)); 
	// }


}