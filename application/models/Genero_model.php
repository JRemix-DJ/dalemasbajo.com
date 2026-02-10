<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Genero_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function load_genero_info($id){
		$this->db->where('id',$id);
		$query = $this->db->get('generos');
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
	}

	public function get_generos(){
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get('generos');
		$data = $query->result();
		return $data;
	}

	public function update_genero($id, $data){
		$this->db->where('id', $id);
		$this->db->update('generos', $data);
	}

	public function create_genero($data){
		$this->db->insert('generos',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function delete_genero($id){
		$this->db->where('id',$id);
		$this->db->delete('generos');
		return true;
	}

}