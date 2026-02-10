<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Faq_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function load_faq_info($id){
		$this->db->where('id',$id);
		$query = $this->db->get('faq');
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
	}

	public function get_faq(){
		$query = $this->db->get('faq');
		$data = $query->result();
		return $data;
	}
	public function update_faq($id, $data){
		$this->db->where('id', $id);
		$this->db->update('faq', $data);
	}

	public function create_faq($data){
		$this->db->insert('faq',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function delete_faq($id){
		$this->db->where('id',$id);
		$this->db->delete('faq');
		return true;
	}

}