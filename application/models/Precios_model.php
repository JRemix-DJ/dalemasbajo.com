<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Precios_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function load_precio_info($id){
		$this->db->where('id',$id);
		$query = $this->db->get('precios');
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
	}

	public function get_precios(){
		$this->db->order_by('price', 'ASC');
		$query = $this->db->get('precios');
		$data = $query->result();
		return $data;
	}
	public function update_precio($id, $data){
		$this->db->where('id', $id);
		$this->db->update('precios', $data);
	}

	public function create_precio($data){
		$this->db->insert('precios',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function delete_precio($id){
		$this->db->where('id',$id);
		$this->db->delete('precios');
		return true;
	}

}