<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Plan_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function load_plan_info($id){
		$this->db->where('id',$id);
		$query = $this->db->get('plans');
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
	}

	public function load_plan_info_by_amount($amount){
		$this->db->where('price',$amount);
		$query = $this->db->get('plans');
		if($query->num_rows() == 1)
		{
			return $query->row();
		}else{
			return false;
		}
	}

	public function get_plans_admin(){
		//$this->db->where('activated', 1);
		$this->db->order_by('price', 'ASC');
		$query = $this->db->get('plans');
		$data = $query->result();
		return $data;
	}

	public function get_plans(){
		$this->db->where('activated', 1);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('plans');
		$data = $query->result();
		return $data;
	}

	public function update_plan($id, $data){
		$this->db->where('id', $id);
		$this->db->update('plans', $data);
	}

	public function create_plan($data){
		$this->db->insert('plans',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	function delete_plan($id){
		$this->db->where('id',$id);
		$this->db->delete('plans');
		return true;
	}

}