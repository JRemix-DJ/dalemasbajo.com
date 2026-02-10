<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Banners_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function load_banner_info($id){
		$this->db->where('id',$id);
		$query = $this->db->get('banners');
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
	}

	public function get_banners(){
		$query = $this->db->get('banners');
		$data = $query->result();
		return $data;
	}

	public function update_banner($id, $data){
		$this->db->where('id', $id);
		$this->db->update('banners', $data);
	}

	public function create_banner($data){
		$this->db->insert('banners',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	function delete_banner($id){
		$this->db->where('id',$id);
		$this->db->delete('banners');
		return true;
	}

}