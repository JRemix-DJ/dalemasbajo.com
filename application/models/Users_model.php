<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Users_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function get_user_where_array($where){
		//print_r($where);
		$this->db->where($where);
		$query=$this->db->get('users');
		//print_r($query);
		if($query->num_rows() >= 1){
			return $query->row();
		}else{
			return false;
		}
	}

	public function check_payment(){
		if(!is_null($this->session->userdata('id_usuario'))){
			$tokens = $this->hasTokens($this->session->userdata('id_usuario'));	
			$tokens_video = $this->hasTokensVideo($this->session->userdata('id_usuario'));
			$ilimitado = $this->isUnlimited($this->session->userdata('id_usuario'));	
			//var_dump($tokens);
			if($tokens==false && $tokens_video==false){
				$user_has_tokens=false;
				$tokens = 0;
				$tokens_video = 0;
				$user_is_unlimited=$ilimitado;
			}else{
				$user_has_tokens=true;
				if($tokens!=false){
					$tokens = $tokens[0]->total;
				}
				if($tokens_video!=false){
					$tokens_video = $tokens_video[0]->total;
				}else{
					$tokens_video=0;
				}
				if($ilimitado!=false){
					$user_is_unlimited=true;
				}else{
					$user_is_unlimited=false;
				}
			}
			//'is_user_unlimited'=>	$user_is_unlimited,
			//'tokens'		=>		$tokens,
			$newuserdata = array(
				'is_user_tokens'	=>	$user_has_tokens,
				'is_user_unlimited' => 	$user_is_unlimited,
				'tokens'			=> 	$tokens,
				'tokens_video'		=>	$tokens_video
			);
			
			$this->session->set_userdata($newuserdata);
		}
	}

	public function isUserFile($user_id, $product_id){
		$this->db->where('user_id', $user_id);
		$this->db->where('product_id', $product_id);
		$query = $this->db->get('user_files');
		if($query->num_rows()>=1){
			return true;
		}else{
			return false;
		}
	}

	public function get_user_products($user_id){
		$this->db->select('user_id, product_id');
		$this->db->where('user_id', $user_id);
		$this->db->group_by('product_id');
		$query = $this->db->get('user_files');
		$data = $query->result();
		return $data;
	}

	public function add_file_to_user($data){
		if($this->db->insert('user_files',$data)){
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}else{
			echo 'error';
		}

	}

	public function get_user_where($where){
		//list($clave, $valor) = each($where);
		if($where!= 'nulo'){
		    foreach($where as $clave => $valor){
                $this->db->where($clave, $valor);
            }
        }
		//$this->db->where($clave, $valor);
		$this->db->order_by('registered_on', 'DESC');
		$query=$this->db->get('users');
		if($query->num_rows() == 1){
			return true;
		}else{
			return false;
		}
	}

	public function load_user_info($id){
		$this->db->where('id',$id);
		$query = $this->db->get('users');
		if($query->num_rows() == 1)
		{
			return $query->row();
		}else{
			return false;
		}
	}

	public function add_user_forced($data){
		if($this->db->insert('password_change',$data)){
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}else{
			echo 'error';
		}

	}

	public function get_users_who_pay(){
		$this->db->select('u.id, u.email, o.id order_id');
		$this->db->from('orders o');
		$this->db->join('users u', 'o.user_id=u.id');
		$this->db->where('o.status', 1);
		$this->db->where('o.date_order >', '2020-08-01 00:00:00');
		

		$query = $this->db->get();
 
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) 
            {
                $data[] = $row;
            }
             
            return $data;
        }
 
        return false;
	}

	public function check_email_sent($email){
		$this->db->where('email', $email);
		$query = $this->db->get('password_change');
		if($query->num_rows() >= 1)
		{
			return $query->row();
		}else{
			return false;
		}
	}

	public function load_user_descargas($id, $inicio = false, $cantidadregistro = false){

		$this->db->select('users.id, users.username, user_files.since, user_files.id, user_files.product_id, user_files.order_id, user_files.downloads_left as downloads_left, 
		products.id as product_id, products.artist, products.name as product_name, products.gender_id as gender, products.bpm as bpm');
		$this->db->from('user_files');
		$this->db->join('products', 'user_files.product_id = products.id');
		$this->db->join('users', 'users.id = user_files.user_id');
		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro,$inicio);
        }
		$this->db->where('user_id',$id);
		$this->db->order_by('user_files.since', 'DESC');
		$query = $this->db->get();
		$data = $query->result();
		return $data;
	}

	public function get_all_users(){
		$query = $this->db->get('users');
		$data = $query->result();
		return $data;
	}

	public function get_users($where, $inicio = false, $cantidadregistro = false){
		if($where!= 'nulo'){
		    foreach($where as $clave => $valor){
                $this->db->like($clave, $valor);
            }
		}
		if ($inicio !== FALSE && $cantidadregistro !== FALSE) {
			$this->db->limit($cantidadregistro,$inicio);
        }
		$this->db->where('role_id', 4);
		$this->db->order_by('registered_on', 'DESC');
		$query = $this->db->get('users');
		$data = $query->result();
		return $data;
	}

	public function get_djs(){
		$this->db->where('role_id', 3);
		//$this->db->or_where('role_id', 1);
		$this->db->order_by('username', 'ASC');
		$query = $this->db->get('users');
		$data = $query->result();
		return $data;
	}

	public function get_djs_videos(){
		$this->db->select('users.id, users.username, products.product_type_id, users.role_id');
		$this->db->from('users');
		$this->db->where('users.role_id', 3);
		$this->db->where('products.product_type_id', 3);
		$this->db->join('products', 'users.id = products.owner_id');
		$this->db->group_by('users.id');
		$this->db->order_by('users.username', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_djs_audios(){
		$this->db->select('users.id, users.username, products.product_type_id, users.role_id');
		$this->db->from('users');
		$this->db->where('users.role_id', 3);
		$this->db->where('products.product_type_id', 1);
		$this->db->join('products', 'users.id = products.owner_id');
		$this->db->group_by('users.id');
		$this->db->order_by('users.username', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_roles(){
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('roles');
		$data = $query->result();
		return $data;
	}

	public function update_user($id, $data){
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		return true;
	}

	public function create_user($data){
		$this->db->insert('users',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	function delete_user($id){
		$this->db->where('id',$id);
		$this->db->delete('users');
		return true;
	}

	//tokens change

	public function hasTokens($user_id){
		$today = date('Y-m-d');
		$query = $this->db->query("SELECT total FROM (SELECT SUM(tokens) AS total, MAX( expiration ) as final_date FROM user_tokens WHERE user_id=$user_id AND expiration>='$today' AND tokens >= 1) AS tokens_table WHERE total is not null");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	public function hasTokensVideo($user_id){
		$today = date('Y-m-d');
		$query = $this->db->query("SELECT total FROM (SELECT SUM(tokens_video) AS total, MAX( expiration ) as final_date FROM user_tokens_video WHERE user_id=$user_id AND expiration>='$today' AND tokens_video >= 1) AS tokens_table WHERE total is not null");
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}

	public function isUnlimited($user_id){
		$today = date('Y-m-d');
		$query = $this->db->query("SELECT * FROM unlimited_users WHERE end_date>='$today' AND user_id='$user_id'");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function update_tokens($user_id){
		$today = date('Y-m-d');
		$this->db->where('user_id', $user_id);
		$this->db->where('expiration >=', $today);
		$this->db->where('tokens >=', 1);
		
		//$this->db->where('expiration <', '$today');
		$this->db->set('tokens', '`tokens`-1', FALSE);
		$this->db->limit(1);
		$this->db->update('user_tokens');
		$this->db->order_by('expiration', 'ASC');
	}

	public function update_tokens_video($user_id){
		$today = date('Y-m-d');
		$this->db->where('user_id', $user_id);
		$this->db->where('expiration >=', $today);
		$this->db->where('tokens_video >=', 1);
		
		//$this->db->where('expiration <', '$today');
		$this->db->set('tokens_video', '`tokens_video`-1', FALSE);
		$this->db->limit(1);
		$this->db->update('user_tokens_video');
		$this->db->order_by('expiration', 'ASC');
	}

	public function get_available_tokens($user_id){
		$today = date('Y-m-d');

		$query = $this->db->query("SELECT * FROM user_tokens WHERE user_id=$user_id AND expiration>='$today' AND tokens >= 1 ORDER BY expiration ASC");
		// $where = array(
		// 	'user_id' 		=> 	$user_id,
		// 	'expiration>'	=> 	$today
		// );
		//$this->db->where($where);
		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	public function get_available_tokens_video($user_id){
		$today = date('Y-m-d');

		$query = $this->db->query("SELECT * FROM user_tokens_video WHERE user_id=$user_id AND expiration>='$today' AND tokens_video >= 1 ORDER BY expiration ASC");
		// $where = array(
		// 	'user_id' 		=> 	$user_id,
		// 	'expiration>'	=> 	$today
		// );
		//$this->db->where($where);
		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

    public function get_active_plan($user_id){
        $today = date('Y-m-d');

        $sql = "
        SELECT p.*, ut.expiration, o.date_order, o.status, o.is_plan
        FROM user_tokens ut
        INNER JOIN orders o ON o.id = ut.order_id
        INNER JOIN plans p ON p.id = o.plan_id
        WHERE ut.user_id = ?
          AND (ut.expiration IS NULL OR DATE(ut.expiration) >= ?)
          AND o.plan_id IS NOT NULL
        ORDER BY 
          (CASE WHEN ut.expiration IS NULL THEN 1 ELSE 0 END) DESC,
          ut.expiration DESC,
          o.date_order DESC
        LIMIT 1
    ";

        $q = $this->db->query($sql, [(int)$user_id, $today]);
        return ($q->num_rows() > 0) ? $q->row() : false;
    }

    /**
     * Standard o superior:
     * - unlimited => OK
     * - plan name contiene Standard o Premium => OK
     */
    public function has_standard_or_higher_plan($user_id){
        // Unlimited => OK
        if($this->isUnlimited($user_id)){
            return true;
        }

        $plan = $this->get_active_plan($user_id);
        if(!$plan) return false;

        $name = strtolower(trim($plan->name));

        // Standard o Premium => OK
        if(strpos($name, 'standard') !== false) return true;
        if(strpos($name, 'premium') !== false) return true;
        if(strpos($name, '3 months') !== false) return true;
        if(strpos($name, '6 months') !== false) return true;

        // Si tus planes se llaman distinto, agrega aquí
        return false;
    }
    public function get_user_by_email($email){
        $this->db->where('email', $email);
        $q = $this->db->get('users');
        return ($q->num_rows() === 1) ? $q->row() : false;
    }

    public function upsert_password_reset($user_id, $email, $token_hash){
        // si ya existe un registro, lo actualizamos
        $this->db->where('email', $email);
        $q = $this->db->get('password_change');

        $data = [
            'user_id'    => (int)$user_id,
            'email'      => $email,
            'token_hash' => $token_hash,
            'enviado'    => 1,
            'cambiado'   => 0,
            'used'       => 0
        ];

        if($q->num_rows() >= 1){
            $row = $q->row();
            $this->db->where('id', (int)$row->id);
            return $this->db->update('password_change', $data);
        }

        return $this->db->insert('password_change', $data);
    }

    public function validate_password_reset_token($email, $token_hash){
        $this->db->where('email', $email);
        $this->db->where('token_hash', $token_hash);
        $this->db->where('used', 0);
        $q = $this->db->get('password_change');
        return ($q->num_rows() >= 1) ? $q->row() : false;
    }

    public function mark_password_reset_used($id){
        $this->db->where('id', (int)$id);
        return $this->db->update('password_change', [
            'used'     => 1,
            'cambiado' => 1
        ]);
    }
}