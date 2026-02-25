<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url', 'form')); 
		$this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model', 'orders_model', 'plan_model'));
		$this->load->library(array('session','form_validation', 'email'));
		$this->load->database('default');
	}

	public function index()
	{
		$data['title']="Payment - Dale Más Bajo";
		$data['description']="Detalles de tu pago";
		$data['products']=$this->products_model->get_products();
		$data['generos']=$this->genero_model->get_generos();
		$data['users']=$this->users_model->get_all_users();
		$data['djs']=$this->users_model->get_djs();
		$this->load->view('templates/header', $data);
		$this->load->view('payment');
		$this->load->view('templates/footer', $data);
	}

	public function cancelar(){
		$data['title']="Pago Cancelado - Dale Más Bajo";
		$data['description']="Detalles de tu pago";
		$data['products']=$this->products_model->get_products();
		$data['generos']=$this->genero_model->get_generos();
		$data['users']=$this->users_model->get_all_users();
		$data['djs']=$this->users_model->get_djs();
		$this->load->view('templates/header', $data);
		$this->load->view('cancelado');
		$this->load->view('templates/footer', $data);
	}

	public function plan_cancelar(){
		$data['title']="Pago Cancelado - Dale Más Bajo";
		$data['description']="Detalles de tu pago";
		$data['products']=$this->products_model->get_products();
		$data['generos']=$this->genero_model->get_generos();
		$data['users']=$this->users_model->get_all_users();
		$data['djs']=$this->users_model->get_djs();
		$this->load->view('templates/header', $data);
		$this->load->view('cancelado');
		$this->load->view('templates/footer', $data);
	}


	public function finalizado(){
		$this->session->unset_userdata('cart');
		$data['title']="Pago Finalizado - Dale Más Bajo";
		$data['description']="Detalles de tu pago";
		$data['products']=$this->products_model->get_products();
		$data['generos']=$this->genero_model->get_generos();
		$data['users']=$this->users_model->get_all_users();
		$data['djs']=$this->users_model->get_djs();
		$this->load->view('templates/header', $data);
		$this->load->view('finalizado');
		$this->load->view('templates/footer', $data);
	}

	public function plan_finalizado(){
		//$this->session->unset_userdata('cart');
		$data['title']="Pago Finalizado - Dale Más Bajo";
		$data['description']="Detalles de tu pago";
		$data['products']=$this->products_model->get_products();
		$data['generos']=$this->genero_model->get_generos();
		$data['users']=$this->users_model->get_all_users();
		$data['djs']=$this->users_model->get_djs();
		$this->load->view('templates/header', $data);
		$this->load->view('finalizado');
		$this->load->view('templates/footer', $data);
	}

    public function done_tukuy(){
        $post = file_get_contents('php://input');
        $data = json_decode($post);

        if(!isset($data->success) || $data->success != true){
            http_response_code(200);
            echo json_encode(['status' => 'ignored']);
            return;
        }

        $client_email = isset($data->client_email) ? trim($data->client_email) : '';
        $amount = isset($data->amount) ? (float)$data->amount : 0;
        $txn = isset($data->transaction_details) ? trim($data->transaction_details) : '';

        if($client_email === '' || $amount <= 0 || $txn === ''){
            $title = "DMB - ERROR PAGO TUKUY - Datos incompletos";
            $mensaje = "JSON Completo: ".$post;
            $this->send_received_message($title, $mensaje);
            http_response_code(200);
            echo json_encode(['status' => 'bad_payload']);
            return;
        }

        $user = $this->users_model->get_user_where_array(['email' => $client_email]);

        if(!$user){
            $title = "DMB - ERROR PAGO TUKUY - Usuario no encontrado";
            $mensaje = "
            Datos recibidos:<br>
            Email Cliente: {$client_email}<br>
            Monto: {$amount}<br>
            Txn: {$txn}<br>
            JSON Completo: {$post}
        ";
            $this->send_received_message($title, $mensaje);
            http_response_code(200);
            echo json_encode(['status' => 'user_not_found']);
            return;
        }

        $existing_order = $this->orders_model->get_by_txn_id($txn);
        if($existing_order){
            http_response_code(200);
            echo json_encode(['status' => 'already_processed']);
            return;
        }

        $plan = $this->plan_model->load_plan_info_by_amount($amount);

        if($plan){
            $data_order = array(
                'user_id'      => $user->id,
                'date_order'   => date("Y-m-d H:i:s"),
                'total_price'  => $plan->price,
                'status'       => 1,
                'is_plan'      => 1,
                'plan_id'      => $plan->id,
                'txn_id'       => $txn
            );

            $order_id = $this->orders_model->create_order_plan($data_order);

            $this->add_tokens_to_user($order_id, 1);
            $this->send_notification_mail($order_id, 0);

            http_response_code(200);
            echo json_encode(['status' => 'success_plan']);
            return;
        }

        $drop_order = $this->orders_model->find_pending_drop_order_by_email_amount($user->id, $amount);

        if(!$drop_order){
            $title = "DMB - ERROR PAGO TUKUY - Orden Drop no encontrada";
            $mensaje = "
            Datos recibidos:<br>
            Email Cliente: {$client_email}<br>
            Monto: {$amount}<br>
            Txn: {$txn}<br>
            Detalle Error: No se encontró una orden DROP pendiente (status=0) con ese monto.<br>
            JSON Completo: {$post}
        ";
            $this->send_received_message($title, $mensaje);
            http_response_code(200);
            echo json_encode(['status' => 'drop_order_not_found']);
            return;
        }

        $this->orders_model->update_order($drop_order->id, [
            'status' => 1,
            'txn_id' => $txn
        ]);

        $this->send_notification_mail($drop_order->id, 0);

        http_response_code(200);
        echo json_encode(['status' => 'success_drop']);
    }

    private function build_payment_view_data($order_id, $renovacion = 0){
        $orden = $this->orders_model->load_order_info($order_id);
        if(!$orden) return false;

        $cupon = null;
        if (!empty($orden->cupon_id)) {
            $cupon = $this->products_model->get_cupon_by_id($orden->cupon_id);
        }

        $user = $this->users_model->load_user_info($orden->user_id);

        if($orden->is_plan){
            $plan = $this->plan_model->load_plan_info($orden->plan_id);
            $items = [
                (object)[
                    'name'            => $plan->name,
                    'tokens'          => $plan->tokens,
                    'tokens_video'    => $plan->tokens_video,
                    'duration'        => $plan->duration,
                    'description'     => $plan->description,
                    'ilimitado_activo'=> $plan->ilimitado_activo
                ]
            ];
        } else {
            $items = $this->orders_model->load_order_items($order_id);
        }

        $data = [
            'items'      => $items,
            'renovacion' => (int)$renovacion,
            'user'       => $user,
            'is_plan'    => (int)$orden->is_plan,
            'orden'      => $orden
        ];

        if($cupon){
            $data['cupon'] = $cupon;
        }

        return $data;
    }

    public function send_notification_mail($order_id, $renovacion)
    {
        $config['protocol']     = 'smtp';
        $config['smtp_host']    = SMTP_URL;
        $config['smtp_port']    = SMTP_PORT;
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = SMTP_USER;
        $config['smtp_pass']    = SMTP_KEY;
        $config['charset']      = 'utf-8';
        $config['newline']      = "\r\n";
        $config['mailtype']     = 'html';
        $config['validation']   = TRUE;

        $this->email->initialize($config);
        $this->email->from('admin@dalemasbajo.com', 'DALE MÁS BAJO');

        $orden = $this->orders_model->load_order_info($order_id);
        if (!$orden) {
            return false;
        }

        $cupon = null;
        if (!empty($orden->cupon_id)) {
            $cupon = $this->products_model->get_cupon_by_id($orden->cupon_id);
        }

        $user = $this->users_model->load_user_info($orden->user_id);
        if (!$user) {
            return false;
        }

        $items = array();
        if (!empty($orden->is_plan)) {
            $plan = $this->plan_model->load_plan_info($orden->plan_id);
            if ($plan) {
                $items[] = (object) array(
                    'name'            => $plan->name,
                    'tokens'          => $plan->tokens,
                    'tokens_video'    => $plan->tokens_video,
                    'duration'        => $plan->duration,
                    'description'     => $plan->description,
                    'ilimitado_activo'=> $plan->ilimitado_activo
                );
            }
        } else {
            $items = $this->orders_model->load_order_items($order_id);
            if (!is_array($items)) {
                $items = array();
            }
        }

        $this->email->to($user->email);

        $admin_emails = array('dalemasbajo@gmail.com', 'sevelasquezro@gmail.com');
        $this->email->bcc($admin_emails);

        $mensaje_asunto = ((int)$renovacion === 1)
            ? 'Gracias por renovar tu plan - Dale Más Bajo'
            : 'Confirmación de Compra - Dale Más Bajo';

        $this->email->subject($mensaje_asunto);

        $data = array(
            'items'     => $items,
            'renovacion'=> (int)$renovacion,
            'user'      => $user,
            'is_plan'   => !empty($orden->is_plan),
            'orden'     => $orden,
            'cupon'     => $cupon
        );

        $mail = $this->load->view('emails/payment', $data, TRUE);
        $this->email->message($mail);

        return (bool) $this->email->send();
    }

	public function realizado(){
		$this->session->unset_userdata('cart');
		$req = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
			$req .= "&$key=$value";
		}
		if(isset($_POST['custom'])){
			$order_id= $_POST['custom'];
		}
		$order = $this->orders_model->load_order_info($order_id);


		if($order->status==0){
			$data['status']=1;
			$data['txn_id'] = $_POST['txn_id'];
			// $data['payment_method'] = "Paypal";

			$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
			
			
			$this->orders_model->update_order($order_id, $data);
			$this->add_payment_to_owner($order_id);
			$this->add_items_to_user($order_id);
			$this->send_notification_mail($order_id, $renovacion = 0);
		}else{

		}	
	}

    public function aplicar_orden()
    {
        if (!$this->session->userdata('is_logued_in') || !$this->user_has_admin_access()) {
            show_error('No autorizado', 403);
            return;
        }

        $order_id  = (int) $this->input->get('order_id', true);
        $renovacion = (int) $this->input->get('renovacion', true);

        if (empty($order_id)) {
            show_error('order_id inválido', 400);
            return;
        }

        $order = $this->orders_model->load_order_info($order_id);
        if (!$order) {
            show_error('Orden no encontrada', 404);
            return;
        }

        $mensaje = null;

        if ($renovacion === 1) {
            $this->add_payment_to_owner($order_id);
            $this->add_tokens_to_user($order_id);
            $this->send_notification_mail($order_id, 1);
            $mensaje = "La orden {$order_id} fue renovada correctamente";
        } else if ($order->txn_id != "MANUAL") {
            $data_update = array(
                'txn_id'  => 'MANUAL',
                'status'  => 1
            );

            $this->orders_model->update_order($order_id, $data_update);

            $this->add_payment_to_owner($order_id);
            $this->add_tokens_to_user($order_id);
            $this->send_notification_mail($order_id, 0);

            $mensaje = "La orden {$order_id} fue aplicada correctamente";
        } else {
            $mensaje = "La orden {$order_id} ya estaba aplicada (MANUAL).";
        }

        $orden = $this->orders_model->load_order_info($order_id);

        $cupon = null;
        if (!empty($orden->cupon_id)) {
            $cupon = $this->products_model->get_cupon_by_id($orden->cupon_id);
        }

        $user = $this->users_model->load_user_info($orden->user_id);

        $items = array();
        if (!empty($orden->is_plan)) {
            $plan = $this->plan_model->load_plan_info($orden->plan_id);
            if ($plan) {
                $items[] = (object) array(
                    'name'            => $plan->name,
                    'tokens'          => $plan->tokens,
                    'tokens_video'    => $plan->tokens_video,
                    'duration'        => $plan->duration,
                    'description'     => $plan->description,
                    'ilimitado_activo'=> $plan->ilimitado_activo
                );
            }
        } else {
            $items = $this->orders_model->load_order_items($order_id);
            if (!is_array($items)) {
                $items = array();
            }
        }

        echo '<div style="max-width:700px;margin:20px auto;padding:14px 16px;border:1px solid #d1fae5;background:#ecfdf5;color:#065f46;border-radius:10px;font-family:Arial,sans-serif;">'
            . htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8')
            . '</div>';

        $data = array(
            'items'      => $items,
            'renovacion' => $renovacion,
            'user'       => $user,
            'is_plan'    => !empty($orden->is_plan),
            'orden'      => $orden,
            'cupon'      => $cupon
        );

        $this->load->view('emails/payment', $data);
    }

	public function user_has_admin_access(){
		switch($this->session->userdata('role')){
			case "is_admin":
				return true;
				break;
			case "is_subadmin":
				return true;
				break;
		}
		return false;
	}

	public function plan_realizado(){
		

		if ( ! count($_POST)) {
            throw new Exception("Missing POST Data");
        }
		$req = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
			$req .= "&$key=$value";
		}
		if(isset($_POST['custom'])){
			$order_id= $_POST['custom'];
		}
		$order = $this->orders_model->load_order_info($order_id);

		// $config['protocol']    = 'smtp';
		// $config['smtp_host']    = 'ssl://smtp.mailgun.org';
		// $config['smtp_port']    = '465';
		// $config['smtp_timeout'] = '7';
		// $config['smtp_user']    = 'admin@remixmp4.com';
		// $config['smtp_pass']    = 'asdK33AA';
		// $config['charset']    = 'utf-8';
		// $config['newline']    = "\r\n";
		// $config['mailtype'] = 'text'; // or html
		// $config['validation'] = TRUE; // bool whether to validate email or not      

		// $this->email->initialize($config);

		// $this->email->from('web@dalemasbajo.com', 'DMB');
		// $this->email->to('o.reyes@shiftandcontrol.com');
		// $text = file_get_contents("php://input");
		// $this->email->subject('INFO IPN');
		// $this->email->message($text);
		// $this->email->send();

		//print_r($order);
		if($order->status==0 && $_POST['payment_status']=='Completed'){
			$data['status']=1;
			$data['txn_id']=$_POST['txn_id'];

			$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
			
			
			$this->orders_model->update_order($order_id, $data);
			$this->add_tokens_to_user($order_id);
			$this->send_notification_mail($order_id, $renovacion = 0);
		}else{
			$ipnsentbefore = $this->orders_model->get_by_txn_id($_POST['txn_id']);
			if(!$ipnsentbefore && $_POST['payment_status']=='Completed'){
				$plan_id=$order->plan_id;
				$plan=$this->plan_model->load_plan_info($plan_id);
				$data_order = array(
					'user_id'		=>	$order->user_id,
					'date_order'	=> 	date("Y-m-d H:i:s"),
					'total_price'	=> 	$plan->price,
					'status'		=> 	1,
					'is_plan'		=>	1,
					'plan_id'		=>	$plan->id,
					'txn_id'		=> 	$_POST['txn_id']
				);
				$order_id = $this->orders_model->create_order_plan($data_order);
				$renovacion=1;
				$this->add_tokens_to_user($order_id, $renovacion);
				$this->send_notification_mail($order_id, $renovacion = 0);
			}
		}	
	}


	function test_admin($txn_id='oscareyes071313'){
		$order = $this->orders_model->load_order_info(967);
		$ipnsentbefore = $this->orders_model->get_by_txn_id($txn_id);
		$txn_id2 = $txn_id.'new';
		if(!$ipnsentbefore){
			$plan_id=$order->plan_id;
			$plan=$this->plan_model->load_plan_info($plan_id);
			$data_order = array(
				'user_id'		=>	$order->user_id,
				'date_order'	=> 	date("Y-m-d H:i:s"),
				'total_price'	=> 	$plan->price,
				'status'		=> 	1,
				'is_plan'		=>	1,
				'plan_id'		=>	$plan->id,
				'txn_id'		=> 	$txn_id2
			);
			$order_id = $this->orders_model->create_order_plan($data_order);
			$renovacion=1;
			$this->add_tokens_to_user($order_id, $renovacion);
			$this->send_notification_mail($order_id, $renovacion = 0);
		}else{
			echo 'error';
		}
	}

	function add_tokens_to_user_admin($order_id=967, $renovacion=1){
		$order = $this->orders_model->load_order_info($order_id);
		$plan = $this->plan_model->load_plan_info($order->plan_id);
		$plus_days_string = "+".$plan->duration." days";
		//echo $plus_days_string;
		$expiration = date("Y-m-d", strtotime($plus_days_string));
		
		if($plan->tokens!=NULL && $plan->tokens!=0){
			$data = array(
				'tokens'		=>	$plan->tokens,
				'order_id'		=>	$order->id,
				'user_id'		=>	$order->user_id,
				'expiration'	=> 	$expiration
			);
			$this->orders_model->insert_tokens_to_user($data);
		}

		if($plan->tokens_video!=NULL && $plan->tokens_video!=0){
			$data = array(
				'tokens_video'		=>	$plan->tokens_video,
				'order_id'		=>	$order->id,
				'user_id'		=>	$order->user_id,
				'expiration'	=> 	$expiration
			);
			$this->orders_model->insert_tokens_video_to_user($data);
		}

		$plus_days_string_ilimitado = "+".$plan->ilimitado_dias." days";

		$expiration_ilimitado = date("Y-m-d", strtotime($plus_days_string_ilimitado));
		
		if($renovacion==null){
			$plus_days_string_ilimitado = "+".$plan->ilimitado_dias." days";
			$expiration_ilimitado = date("Y-m-d", strtotime($plus_days_string_ilimitado));
			if($plan->ilimitado_activo==1){
				$data_ilimitado = array(
					'end_date' => $expiration_ilimitado,
					'user_id'		=> $order->user_id,
					'order_id'		=>	$order->id
				);
				$this->orders_model->add_unlimited($data_ilimitado);
			}
		}
	}

	function add_tokens_to_user($order_id, $renovacion=NULL){
		$order = $this->orders_model->load_order_info($order_id);
		$plan = $this->plan_model->load_plan_info($order->plan_id);
		$plus_days_string = "+".$plan->duration." days";
		//echo $plus_days_string;
		$expiration = date("Y-m-d", strtotime($plus_days_string));
		if($plan->tokens!=NULL && $plan->tokens!=0){
			$data = array(
				'tokens'		=>	$plan->tokens,
				'order_id'		=>	$order->id,
				'user_id'		=>	$order->user_id,
				'expiration'	=> 	$expiration
			);
			$this->orders_model->insert_tokens_to_user($data);
		}

		if($plan->tokens_video!=NULL && $plan->tokens_video!=0){
			$data = array(
				'tokens_video'		=>	$plan->tokens_video,
				'order_id'		=>	$order->id,
				'user_id'		=>	$order->user_id,
				'expiration'	=> 	$expiration
			);
			$this->orders_model->insert_tokens_video_to_user($data);
		}

		if($renovacion==NULL){
			$plus_days_string_ilimitado = "+".$plan->ilimitado_dias." days";
			$expiration_ilimitado = date("Y-m-d", strtotime($plus_days_string_ilimitado));
			if($plan->ilimitado_activo==1){
				$data_ilimitado = array(
					'end_date' => $expiration_ilimitado,
					'user_id'		=> $order->user_id,
					'order_id'		=>	$order->id
				);
				$this->orders_model->add_unlimited($data_ilimitado);
			}
		}
		
	}


	function add_payment_to_owner($order_id){
	// function add_payment_to_owner(){
	// 	$order_id=$this->input->get('order_id');
		$items = $this->orders_model->load_items($order_id);
		$orden = $this->orders_model->load_order_info($order_id);
		$porcentaje_descuento = null;
		if($orden->cupon_id!=null){
			$cupon = $this->products_model->get_cupon_by_id($orden->cupon_id);
			$porcentaje_descuento = $cupon->discount/100;
		}
		//print_r($items);
		foreach($items as $item){
			$producto=$this->products_model->load_product_info($item->product_id);
			//echo $producto->name.' '.$producto->price.'<br>';
			$propietario = $producto->owner_id;
			$user = $this->users_model->load_user_info($propietario);
			$porcentaje = $user->percentage;
			$precio = $producto->price;
			//porcentaje de cobro paypal;
			$precio_menos_comision_paypal = $precio-(($precio*0.056)+0.30);
			if($porcentaje_descuento!=null){
				$precio_menos_comision_paypal = $precio_menos_comision_paypal - ($precio_menos_comision_paypal*$porcentaje_descuento);
			}
			$pago = $precio_menos_comision_paypal*($porcentaje/100);
			$data = array(
				'order_item'	=>	$item->id,
				'user_id'		=>	$propietario,
				'amount'		=>	$pago,
				'order_id'		=>	$orden->id
			);
			$this->orders_model->insert_payment($data);
		}
	}

	function add_items_to_user($order_id){
	// function add_payment_to_owner(){
	// 	$order_id=$this->input->get('order_id');
		$order = $this->orders_model->load_order_info($order_id);
		$items = $this->orders_model->load_items($order_id);
		
		foreach($items as $item){
			
			$data = array(
				'product_id'		=>	$item->product_id,
				'downloads_left'	=>	3,
				'order_id'			=>	$order_id,
				'user_id'			=> $order->user_id
			);
			$this->orders_model->insert_files_to_user($data);
		}
	}

	public function postdata(){
		var_dump($_POST);
	}


	public function send_received_message($title, $data)
	{
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = SMTP_URL;
		$config['smtp_port']    = SMTP_PORT;
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    =  SMTP_USER;
		$config['smtp_pass']    = SMTP_KEY;
		$config['charset']    = 'utf-8';
		$config['newline']    = "\r\n";
		$config['mailtype'] = 'html'; // or html
		$config['validation'] = TRUE; // bool whether to validate email or not      
		$this->email->initialize($config);
		$this->email->from('dalemasbajo@gmail.com', 'DALE MÁS BAJO');
		$this->email->to('dalemasbajo@gmail.com');
		//$this->email->cc('o.reyes@shiftandcontrol.com');
		$this->email->subject($title);
		$this->email->message($data);
		$this->email->send();
	}

	public function send_test(){
		$order_id=$_GET['orden'];
		$config['protocol']    = 'smtp';

		$config['smtp_host']    = SMTP_URL;

		$config['smtp_port']    = SMTP_PORT;

		$config['smtp_timeout'] = '7';

		$config['smtp_user']    = SMTP_USER;

		$config['smtp_pass']    = SMTP_KEY;

		$config['charset']    = 'utf-8';

		$config['newline']    = "\r\n";

		$config['mailtype'] = 'html'; // or html

		$config['validation'] = TRUE; // bool whether to validate email or not      

		$this->email->initialize($config);

		$this->email->from('dalemasbajo@gmail.com', 'DALE MÁS BAJO');

		$orden = $this->orders_model->load_order_info($order_id);

		$user= $this->users_model->load_user_info($orden->user_id);

		$items = $this->orders_model->load_order_items($order_id);
		print_r($items);
		$this->email->to($user->email);

		$this->email->bcc('dalemasbajo@gmail.com');

		$this->email->subject('Pago Recibido');

		$data['items']=$items;
		$data['user']=$user;
		$data['orden']=$orden;

		$mail = $this->load->view('emails/payment', $data, TRUE);
		$this->email->message($mail);

		$this->email->send();
	}

}
