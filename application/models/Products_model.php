<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products_model extends CI_Model {

    public function load_product_info($id){
        $this->db->where('id', $id);
        $query = $this->db->get('products');
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        return false;
    }

    public function get_cupons(){
        $query = $this->db->get('cupons');
        return $query->result();
    }

    public function get_cupon_by_code($code){
        $this->db->where('code', $code);
        $this->db->from('cupons');
        return $this->db->count_all_results();
    }

    public function get_cupon($code){
        $this->db->where('code', $code);
        $query = $this->db->get('cupons');
        return $query->row();
    }

    public function get_cupon_by_id($cupon_id){
        $this->db->where('id', $cupon_id);
        $query = $this->db->get('cupons');
        return $query->row();
    }

    public function get_total_products_approved($where_parameter = NULL)
    {
        if(!is_null($where_parameter)){
            foreach($where_parameter as $clave => $valor){
                $this->db->where($clave, $valor);
            }
        }
        $this->db->where('approved', 1);
        $this->db->where_not_in('gender_id', 45);
        $this->db->from('products');
        return $this->db->count_all_results();
    }

    public function get_total_products_por_aprobar($where_parameter = NULL, $search = NULL)
    {
        if(!is_null($where_parameter)){
            foreach($where_parameter as $clave => $valor){
                $this->db->where($clave, $valor);
            }
        }
        if(!is_null($search)){
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->group_end();
        }

        $this->db->where('approved', 0);
        $this->db->where_not_in('gender_id', 45);
        $this->db->from('products');
        return $this->db->count_all_results();
    }

    public function get_total_products($where_parameter = NULL, $search = NULL)
    {
        if(!is_null($where_parameter)){
            foreach($where_parameter as $clave => $valor){
                $this->db->where($clave, $valor);
            }
        }
        if(!is_null($search)){
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->group_end();
        }
        $this->db->from("products");
        return $this->db->count_all_results();
    }

    public function get_total_products_by_gender($gender_id, $where_parameter = NULL)
    {
        if(!is_null($where_parameter)){
            foreach($where_parameter as $clave => $valor){
                $this->db->where($clave, $valor);
            }
        }
        $this->db->where('gender_id', $gender_id);
        $this->db->where('approved', 1);
        $this->db->from("products");
        return $this->db->count_all_results();
    }

    public function get_total_products_searched($gender_id = NULL, $dj_id = NULL, $name = NULL, $where_parameter = NULL)
    {
        if($gender_id != NULL){
            $this->db->where('gender_id', $gender_id);
        }
        if($dj_id != NULL){
            $this->db->where('owner_id', $dj_id);
        }
        if($name != NULL){
            $this->db->like('name', $name);
            $this->db->or_like('artist', $name);
        }
        if(!is_null($where_parameter)){
            foreach($where_parameter as $clave => $valor){
                $this->db->where($clave, $valor);
            }
        }
        $this->db->where('approved', 1);
        $this->db->from("products");
        return $this->db->count_all_results();
    }

    public function get_current_page_records_searched($limit, $start, $gender_id = NULL, $dj_id = NULL, $name = NULL, $where_parameter = NULL)
    {
        $this->db->limit($limit, $start);
        if($gender_id != NULL || $dj_id != NULL || $name != NULL){
            $this->db->group_start();
            if($gender_id != NULL){
                $this->db->where('gender_id', $gender_id);
            }
            if($dj_id != NULL){
                $this->db->where('owner_id', $dj_id);
            }
            if($name != NULL){
                $this->db->like('name', $name);
                $this->db->or_like('artist', $name);
            }
            $this->db->group_end();
        }
        if(!is_null($where_parameter)){
            foreach($where_parameter as $clave => $valor){
                $this->db->where($clave, $valor);
            }
        }
        $this->db->where('approved', 1);
        $this->db->order_by('time_approved', 'desc');
        $query = $this->db->get("products");

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return false;
    }

    public function get_total_products_by_dj($dj_id, $where_parameter = NULL)
    {
        if(!is_null($where_parameter)){
            foreach($where_parameter as $clave => $valor){
                $this->db->where($clave, $valor);
            }
        }
        $this->db->where('owner_id', $dj_id);
        $this->db->where('approved', 1);
        $this->db->from("products");
        return $this->db->count_all_results();
    }

    public function get_current_page_records($limit, $start, $where_parameter = NULL, $no_parameter = NULL, $not_in = NULL, $search = NULL)
    {
        if(!is_null($where_parameter)){
            foreach($where_parameter as $clave => $valor){
                $this->db->where($clave, $valor);
            }
        }
        if(!is_null($not_in) && !is_null($no_parameter)){
            $this->db->where_not_in($no_parameter, $not_in);
        }
        if(!is_null($search)){
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->group_end();
        }
        $this->db->order_by('time_approved', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get("products");

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return false;
    }

    public function get_current_page_records_order_created($limit, $start, $where_parameter = NULL, $no_parameter = NULL, $not_in = NULL, $search = NULL)
    {
        if(!is_null($where_parameter)){
            foreach($where_parameter as $clave => $valor){
                $this->db->where($clave, $valor);
            }
        }
        if(!is_null($search)){
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->group_end();
        }
        if(!is_null($not_in) && !is_null($no_parameter)){
            $this->db->where_not_in($no_parameter, $not_in);
        }
        $this->db->order_by('created_on', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get("products");

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return false;
    }

    public function get_current_page_records_by_gender($limit, $start, $gender_id, $where_parameter = NULL)
    {
        if(!is_null($where_parameter)){
            foreach($where_parameter as $clave => $valor){
                $this->db->where($clave, $valor);
            }
        }
        $this->db->limit($limit, $start);
        $this->db->where('gender_id', $gender_id);
        $this->db->where('approved', 1);
        $this->db->order_by('time_approved', 'DESC');
        $query = $this->db->get("products");

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return false;
    }

    public function get_current_page_records_by_dj($limit, $start, $dj_id, $where_parameter = NULL)
    {
        if(!is_null($where_parameter)){
            foreach($where_parameter as $clave => $valor){
                $this->db->where($clave, $valor);
            }
        }
        $this->db->limit($limit, $start);
        $this->db->where('owner_id', $dj_id);
        $this->db->where('approved', 1);
        $this->db->order_by('time_approved', 'DESC');
        $query = $this->db->get("products");

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return false;
    }

    public function get_products(){
        $query = $this->db->get('products');
        return $query->result();
    }

    public function get_product_types(){
        $query = $this->db->get('product_types');
        return $query->result();
    }

    public function get_products_by_gender($gender_id){
        $this->db->where('gender_id', $gender_id);
        $query = $this->db->get('products');
        return $query->result();
    }

    public function update_product($id, $data){
        $this->db->where('id', $id);
        $this->db->update('products', $data);
    }

    public function create_product($data){
        $this->db->insert('products', $data);
        return (int)$this->db->insert_id();
    }

    public function delete_product($id){
        $this->db->where('id', $id);
        $this->db->delete('products');
        return true;
    }

    public function add_download($data){
        $this->db->insert('product_downloads', $data);
        return true;
    }

    public function clear_trending_slot($slot, $exclude_product_id = null)
    {
        $this->db->set('trending_slot', null);
        $this->db->where('trending_slot', (int)$slot);
        if ($exclude_product_id) {
            $this->db->where('id !=', (int)$exclude_product_id);
        }
        $this->db->update('products');
    }

    public function set_trending_slot($product_id, $slot)
    {
        $slot = (int)$slot;
        if ($slot < 1 || $slot > 5) {
            $slot = 0;
        }

        $this->db->trans_start();
        if ($slot > 0) {
            $this->clear_trending_slot($slot, (int)$product_id);
            $this->db->where('id', (int)$product_id);
            $this->db->update('products', ['trending_slot' => $slot]);
        } else {
            $this->db->where('id', (int)$product_id);
            $this->db->update('products', ['trending_slot' => null]);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_trending_now($limit = 5)
    {
        $this->db->from('products');
        $this->db->where('approved', 1);
        $this->db->where('product_type_id', 1);
        $this->db->where('trending_slot IS NOT NULL', null, false);
        $this->db->order_by('trending_slot', 'ASC');
        $this->db->limit((int)$limit);
        return $this->db->get()->result();
    }
}