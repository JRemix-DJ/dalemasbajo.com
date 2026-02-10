<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Login_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function login_user($email,$password, $ip)
	{
		//$email = $this->db->escape($email);
		//$password=$this->db->escape($password);

		$this->db->where('email',$email);
		//$this->db->where('password',$password);
		$query = $this->db->get('users');
		$data_log = array(
			'value' 	=> 	$email,
			'value2'	=>	$password,
			'ip'		=>	$ip
		);
		$this->db->insert('log_table',$data_log );
		if($query->num_rows() == 1)
		{
			$user = $query->row();
			if(password_verify($password, $user->password)){
				return $query->row();
			}else{
				return false;
			}
		}else{
			$this->session->set_flashdata('usuario_incorrecto','Los datos introducidos son incorrectos');
			redirect(base_url().'login','refresh');
		}
	}

	public function login_front($email,$password, $ip)
	{
		//$email = $this->db->escape($email);
		//$password=$this->db->escape($password);
		$this->db->where('email',$email);
		//$this->db->where('password',$password);
		$query = $this->db->get('users');
		$data_log = array(
			'value' 	=> 	$email,
			'value2'	=>	$password,
			'ip'		=>	$ip
		);

		$this->db->insert('log_table',$data_log);
		
		if($query->num_rows() == 1)
		{
			$user = $query->row();
			if(password_verify($password, $user->password)){
				return $query->row();
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}