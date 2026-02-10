<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Cupons_model extends CI_Model {
    public function get_cupons(){
		$query = $this->db->get('cupons');
		$data = $query->result();
		return $data;
	}

    public function get_cupon_by_code($code){
        $this->db->where('code', $code);
        $this->db->from('cupons');
        return $this->db->count_all_results();
    }

    public function get_cupon($code){
        $this->db->where('code', $code);
        $query = $this->db->get('cupons');
        $data = $query->row();
		return $data;
    }

    public function get_cupon_by_id($cupon_id){
        $this->db->where('id', $cupon_id);
        $query = $this->db->get('cupons');
        $data = $query->row();
		return $data;
    }

    public function update_cupon($id, $data){
		$this->db->where('id', $id);
		$this->db->update('cupons', $data);
	}

}