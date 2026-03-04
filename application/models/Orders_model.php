<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Orders_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}
	public function user_files($user_id, $product_id){
		$this->db->where('user_id', $user_id);
		$this->db->where('product_id', $product_id);
		$this->db->where('downloads_left >', 0);
		$query = $this->db->get('user_files');
		$data = $query->result();
		return $data;
	}
	public function load_order_info($id){
		$this->db->where('id',$id);
		$query = $this->db->get('orders');
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
	}


	public function get_by_txn_id($txn_id){
		$this->db->where('txn_id',$txn_id);
		$query = $this->db->get('orders');
		if($query->num_rows() == 1)
		{
			return true;
		}else{
			return false;
		}
	}

	public function get_orders($where_parameter=null){
		$this->db->where('status', 1);
		$this->db->order_by('date_order', 'DESC');
		$parametros = is_null($where_parameter)? 'nulo': $where_parameter;
        if($parametros!= 'nulo'){
            // while(list($clave, $valor) = each($parametros)){
            //     $this->db->where($clave, $valor);
            // }
            foreach($parametros as $clave => $valor){
                $this->db->where($clave, $valor);
            }

        }
		$query = $this->db->get('orders');
		$data = $query->result();
		return $data;
	}

	public function get_orders_time($time, $where=null){
		switch($time){
			case 'semana':
			$fecha = 7;
			break;
			case 'mes':
			$fecha = 30;
			break;
		}
		$query = $this->db->query("SELECT * FROM orders WHERE status=1 $where AND date_order >= DATE(NOW()) - INTERVAL $fecha DAY ORDER BY date_order DESC");
		$data = $query->result();
		return $data;
	}

	public function get_orders_by_user($user_id){
		$this->db->where('user_id', $user_id);
		$this->db->where('status', 1);
		$this->db->where('txn_id IS NOT NULL');
		$query = $this->db->get('orders');
		$data = $query->result();
		return $data;
	}

	public function update_order($id, $data){
		$this->db->where('id', $id);
		$this->db->update('orders', $data);
	}

	public function update_user_files_item($id, $data){
		$this->db->where('id', $id);
		$this->db->update('user_files', $data);
	}

	public function create_order($data){
		$this->db->insert('orders',$data);
		$insert_id = $this->db->insert_id();
		$this->create_order_items($insert_id);
		return $insert_id;
	}

	public function add_unlimited($data){
		$this->db->insert('unlimited_users',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function create_order_plan($data){
		$this->db->insert('orders',$data);
		$insert_id = $this->db->insert_id();	
		//$this->create_order_items($insert_id);
		return $insert_id;
	}


	public function insert_tokens_to_user($data){
		$this->db->insert('user_tokens',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function insert_tokens_video_to_user($data){
		$this->db->insert('user_tokens_video',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function get_pagos($where){
		$query = $this->db->query("SELECT pagos.user_id AS uid, Sum(pagos.amount) AS apagar, users.username AS name, users.paypal AS paypal FROM pagos INNER JOIN users ON users.id=pagos.user_id WHERE payed=0 $where GROUP BY user_id");
		$data = $query->result();
		return $data;
	}

	public function get_pagos_tokens($where){
		$query = $this->db->query("SELECT pagos_tokens.owner_id AS uid, Sum(pagos_tokens.amount) AS apagar, users.username AS name, users.paypal AS paypal FROM pagos_tokens INNER JOIN users ON users.id=pagos_tokens.owner_id WHERE payed=0 $where GROUP BY owner_id");
		$data = $query->result();
		return $data;
	}

	public function get_pagos_realizados($where){
		$query = $this->db->query("SELECT pagos.payment_date as fecha_de_pago, pagos.user_id AS uid, Sum(pagos.amount) AS apagar, users.username AS name, users.paypal AS paypal FROM pagos INNER JOIN users ON users.id=pagos.user_id WHERE payed=1 $where GROUP BY user_id ORDER BY fecha_de_pago DESC");
		$data = $query->result();
		return $data;
	}

	public function get_pagos_realizados_tokens($where){
		$query = $this->db->query("SELECT payments.id as id, payments.date as fecha_de_pago, payments.dj_id AS uid, payments.amount AS apagar FROM payments $where  ORDER BY fecha_de_pago DESC");
		$data = $query->result();
		return $data;
	}

	public function get_order_detail($order_id){
		$query = $this->db->query("SELECT products.name as product_name, products.artist as artista, products.version as version,  products.price as product_price, products.owner_id as owner FROM order_items INNER JOIN products ON order_items.product_id=products.id WHERE order_items.order_id=$order_id");
		$data = $query->result();
		return $data;
	}

	public function get_pagos_details($user_id){
		$query = $this->db->query("SELECT pagos.user_id AS uid, orders.date_order as fecha, orders.user_id as who_paid, pagos.amount as monto, order_items.product_id AS product_id, products.name as product_name, products.artist as artista, products.version as version, users.username AS name, users.paypal AS paypal FROM pagos INNER JOIN users ON users.id=pagos.user_id INNER JOIN order_items ON pagos.order_Item=order_items.id INNER JOIN products ON order_items.product_id=products.id INNER JOIN orders ON order_items.order_id=orders.id  WHERE pagos.payed=0 AND pagos.user_id=$user_id");
		$data = $query->result();
		return $data;
	}
	public function get_pagos_details_pagado($user_id){
		$query = $this->db->query("SELECT pagos.user_id AS uid, orders.date_order as fecha, orders.user_id as who_paid, pagos.amount as monto, order_items.product_id AS product_id, products.name as product_name, products.artist as artista, products.version as version, users.username AS name, users.paypal AS paypal FROM pagos INNER JOIN users ON users.id=pagos.user_id INNER JOIN order_items ON pagos.order_Item=order_items.id INNER JOIN products ON order_items.product_id=products.id INNER JOIN orders ON order_items.order_id=orders.id  WHERE pagos.payed=1 AND pagos.user_id=$user_id");
		$data = $query->result();
		return $data;
	}

	public function get_pagos_details_tokens($user_id){
		$query = $this->db->query("SELECT pagos_tokens.user_id AS uid, pagos_tokens.date as fecha, pagos_tokens.user_id as who_paid, pagos_tokens.amount as monto, pagos_tokens.product_id AS product_id, products.name as product_name, products.artist as artista, products.version as version, users.username AS name, users.paypal AS paypal FROM pagos_tokens INNER JOIN users ON users.id=pagos_tokens.owner_id INNER JOIN products ON pagos_tokens.product_id=products.id   WHERE pagos_tokens.payed=0 AND pagos_tokens.owner_id=$user_id");
		$data = $query->result();
		return $data;
	}
	public function get_pagos_details_pagado_tokens($payment_id){
		$query = $this->db->query("SELECT payments.id AS payment_id, pagos_tokens.owner_id AS uid, pagos_tokens.date as fecha, pagos_tokens.user_id as who_paid, pagos_tokens.amount as monto, pagos_tokens.product_id AS product_id, products.name as product_name, products.artist as artista, products.version as version, users.username AS name, users.paypal AS paypal FROM payments INNER JOIN pagos_tokens ON pagos_tokens.payment_id=payments.id INNER JOIN users ON users.id=pagos_tokens.owner_id INNER JOIN products ON pagos_tokens.product_id=products.id   WHERE pagos_tokens.payed=1 AND payments.id=$payment_id");
		$data = $query->result();
		return $data;
	}

	public function update_pagos($user_id){
		$hoy = date("Y-m-d H:i:s");
		$data=array(
			'payed'=>1,
			'payment_date'=>$hoy
		);
		$this->db->where('user_id', $user_id);
		$this->db->where('payed', 0);
		$this->db->update('pagos', $data);
	}

	public function update_pagos_tokens($user_id){
		$amount = $_GET['amount'];
		$hoy = date("Y-m-d");
		$data_payment = array(
			'amount'	=>	$amount,
			'date'		=>	$hoy, 
			'dj_id'		=>	$user_id
		);
		$this->db->insert('payments', $data_payment);
		$payment_id = $this->db->insert_id();
		$data=array(
			'payment_id'	=>	$payment_id,
			'payed'			=>	1,
			'payment_date'	=>	$hoy
		);
		$this->db->where('owner_id', $user_id);
		$this->db->where('payed', 0);
		$this->db->update('pagos_tokens', $data);
	}

	public function create_order_items($order_id){
		foreach($_SESSION['cart']['items'] as $item){
			$data = array(
				'product_id'=>$item['id'],
				'quantity'=>1,
				'order_id'=>$order_id
			);
			$this->db->insert('order_items',$data);
		}
		//$insert_id = $this->db->insert_id();
		return true;
	}

	

	public function insert_payment($data){
		$this->db->insert('pagos',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	public function insert_payment_tokens($data){
		$this->db->insert('pagos_tokens',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function insert_files_to_user($data){
		$this->db->insert('user_files',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function load_items($order_id){
		$this->db->where('order_id', $order_id);
		$query=$this->db->get('order_items');
		$data = $query->result();
		return $data;
	}
	public function load_order_items($order_id){
		$this->db->where('order_id', $order_id);
		$query=$this->db->get('order_items');
		$data = $query->result();
		$products = [];
		foreach($data as $item){
			$this->db->where('id', $item->product_id);
			$query=$this->db->get('products');
			$product = $query->result();
			array_push($products, $product[0]);
		}
		return $products;
	}

	public function load_descargas($user_id){
		$this->db->select('user_files.id, user_files.product_id, user_files.order_id, user_files.downloads_left as downloads_left, products.id as product_id, products.name as product_name, products.gender_id as gender, products.bpm as bpm');
		$this->db->from('user_files');
		$this->db->join('products', 'user_files.product_id = products.id');
		$this->db->where('user_files.user_id', $user_id);
		$query=$this->db->get();
		$data = $query->result();
		return $data;
	}

	public function load_descargas_id($user_id, $order_id){
		$this->db->select('user_files.id, user_files.product_id, user_files.order_id, user_files.downloads_left as downloads_left, products.id as product_id, products.name as product_name, products.artist as artista, products.gender_id as gender, products.bpm as bpm, products.version as version, products.owner_id as owner_id');
		$this->db->from('user_files');
		$this->db->join('products', 'user_files.product_id = products.id');
		$this->db->where('user_files.user_id', $user_id);
		$this->db->where('user_files.order_id', $order_id);
		$query=$this->db->get();
		$data = $query->result();
		return $data;
	}

	function delete_order($id){
		$this->db->where('id',$id);
		$this->db->delete('orders');
		return true;
	}

    public function create_order_drop($data){
        $this->db->insert('orders', $data);
        return $this->db->insert_id();
    }

    public function add_items_to_order_drop($data){
        $this->db->insert('order_items', $data);
        return $this->db->insert_id();
    }

    public function find_pending_drop_order_by_drop($user_id, $drop_id){
        $this->db->where('user_id', (int)$user_id);
        $this->db->where('status', 0);
        $this->db->where('is_drop', 1);
        $this->db->where('drop_id', (int)$drop_id);
        $this->db->order_by('date_order', 'DESC');
        $this->db->limit(1);
        $q = $this->db->get('orders');
        if($q->num_rows() === 1) return $q->row();
        return false;
    }

    public function find_pending_drop_order_by_email_amount($user_id, $amount){
        $this->db->where('user_id', (int)$user_id);
        $this->db->where('status', 0);
        $this->db->where('is_drop', 1);
        $this->db->where('total_price', (float)$amount);
        $this->db->group_start();
        $this->db->where('txn_id IS NULL', null, false);
        $this->db->or_where('txn_id', '');
        $this->db->group_end();
        $this->db->order_by('date_order', 'DESC');
        $this->db->limit(1);
        $q = $this->db->get('orders');
        if($q->num_rows() === 1) return $q->row();
        return false;
    }
    public function find_pending_plan_order_by_user_amount($user_id, $amount)
    {
        $amount = (float)$amount;

        $this->db->select('*');
        $this->db->from('orders');
        $this->db->where('user_id', (int)$user_id);
        $this->db->where('status', 1);
        $this->db->where('is_plan', 1);
        $this->db->where('total_price >=', $amount - 0.01);
        $this->db->where('total_price <=', $amount + 0.01);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        return $this->db->get()->row();
    }

    public function consume_paid_order(int $order_id): bool
    {
        $this->db->set('status', 0);
        $this->db->where('id', $order_id);
        $this->db->where('status', 1);
        $this->db->update('orders');

        return ($this->db->affected_rows() === 1);
    }
}