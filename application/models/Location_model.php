<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Location_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function get_countries(){
		$query = $this->db->get('countries');
		$data = $query->result();
		return $data;
	}
}