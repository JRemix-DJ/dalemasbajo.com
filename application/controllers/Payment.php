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

    public function done_tukuy()
    {
        header('Content-Type: application/json; charset=utf-8');

        $post = file_get_contents('php://input');
        $payload = json_decode($post);

        $state   = isset($payload->state) ? trim((string)$payload->state) : '';
        $email   = isset($payload->customer->email) ? trim((string)$payload->customer->email) : '';
        $amount  = isset($payload->amount) ? (float)$payload->amount : 0;
        $tukuyId = isset($payload->id) ? (int)$payload->id : 0;
        $txnId   = 'TUKUY-' . $tukuyId;

        if ($state !== 'done' || empty($email) || $amount <= 0 || $tukuyId <= 0) {
            echo json_encode(['status' => 'bad_payload']);
            return;
        }

        if ($this->orders_model->get_by_txn_id($txnId)) {
            echo json_encode(['status' => 'already_processed_local']);
            return;
        }

        $user = $this->users_model->get_user_where_array(['email' => $email]);

        if ($user) {
            $order = $this->orders_model->find_pending_drop_order_by_user_amount($user->id, $amount);
            $is_drop = true;

            if (!$order) {
                $order = $this->orders_model->find_pending_plan_order_by_user_amount($user->id, $amount);
                $is_drop = false;
            }

            if ($order) {
                $claimed = $this->orders_model->consume_paid_order((int)$order->id, $txnId);

                if ($claimed) {
                    if ($is_drop) {
                        $this->add_payment_to_owner((int)$order->id);
                        $this->add_items_to_user((int)$order->id);
                        $this->send_notification_mail((int)$order->id, 0);
                        $this->notify_admin_drop_paid((int)$order->id);
                    } else {
                        $this->add_tokens_to_user((int)$order->id, null);
                        $this->send_notification_mail((int)$order->id, 0);
                    }

                    echo json_encode([
                        'status'   => 'applied_local',
                        'site'     => 'dalemasbajo',
                        'order_id' => (int)$order->id
                    ]);
                    return;
                }
            }
        }

        $relay = $this->relay_to_vrp($post);

        if (is_array($relay) && in_array($relay['status'] ?? '', [
                'applied',
                'already_processed',
                'already_processed_local',
                'renewal_applied'
            ], true)) {
            echo json_encode($relay);
            return;
        }

        $renewal = $this->try_apply_plan_renewal_local($email, $amount, $txnId);
        if ($renewal) {
            echo json_encode($renewal);
            return;
        }

        $relayRenewal = $this->relay_to_vrp($post, true);
        echo json_encode($relayRenewal ?: ['status' => 'no_match']);
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
        $orden = $this->orders_model->load_order_info($order_id);
        if (!$orden) {
            log_message('error', "send_notification_mail: orden no encontrada. order_id={$order_id}");
            return false;
        }

        $user = $this->users_model->load_user_info($orden->user_id);
        if (!$user || empty($user->email)) {
            log_message('error', "send_notification_mail: usuario no encontrado o sin email. order_id={$order_id}");
            return false;
        }

        $cupon = null;
        if (!empty($orden->cupon_id)) {
            $cupon = $this->products_model->get_cupon_by_id($orden->cupon_id);
        }

        $items = [];
        if (!empty($orden->is_plan)) {
            $plan = $this->plan_model->load_plan_info($orden->plan_id);
            if ($plan) {
                $items[] = (object)[
                    'name'             => $plan->name,
                    'tokens'           => $plan->tokens,
                    'tokens_video'     => $plan->tokens_video,
                    'duration'         => $plan->duration,
                    'description'      => $plan->description,
                    'ilimitado_activo' => $plan->ilimitado_activo
                ];
            }
        } else {
            $items = $this->orders_model->load_order_items($order_id);
            if (!is_array($items)) $items = [];
        }

        $data = [
            'items'      => $items,
            'renovacion' => (int)$renovacion,
            'user'       => $user,
            'is_plan'    => !empty($orden->is_plan),
            'orden'      => $orden
        ];
        if ($cupon) $data['cupon'] = $cupon;

        $subject = ((int)$renovacion === 1)
            ? 'Gracias por renovar tu plan - Dale Más Bajo'
            : 'Confirmación de Compra - Dale Más Bajo';

        $html = $this->load->view('emails/payment', $data, true);

        // --- EMAIL ---
        $this->email->clear(true);

        $this->load->config('email', true);
        $email_cfg = $this->config->item('email');
        if (is_array($email_cfg)) {
            $this->email->initialize($email_cfg);
        } else {
            $this->email->initialize();
        }

        $this->email->from('dalemasbajo@gmail.com', 'DALE MÁS BAJO');
        $this->email->to($user->email);
        $this->email->bcc(['dalemasbajo@gmail.com']);

        $this->email->subject($subject);
        $this->email->message($html);

        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");

        $ok = $this->email->send(false);

        log_message('error',
            "GMAIL SMTP send=" . ($ok ? 'OK' : 'FAIL') .
            " order_id={$order_id} to={$user->email} :: " .
            $this->email->print_debugger(['headers','subject'])
        );

        if (!$ok) {
            log_message('error', $this->email->print_debugger(['headers','subject','body']));
        }

        return (bool)$ok;
    }
    public function test_gmail()
    {
        $this->email->clear(true);

        $this->load->config('email', true);
        $email_cfg = $this->config->item('email');
        if (is_array($email_cfg)) {
            $this->email->initialize($email_cfg);
        } else {
            $this->email->initialize();
        }

        $this->email->from('dalemasbajo@gmail.com', 'DALE MÁS BAJO');
        $this->email->to('dalemasbajo@gmail.com');
        $this->email->subject('TEST SMTP GMAIL desde VPS');
        $this->email->message('<h1>Hola</h1><p>Si llegó, SMTP Gmail OK.</p>');

        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");

        $ok = $this->email->send(false);

        echo $ok ? "OK<br>" : "FAIL<br>";
        echo "<pre>".$this->email->print_debugger(['headers','subject'])."</pre>";
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

        $mail_ok = $this->send_notification_mail($order_id, $renovacion);

        if (!$mail_ok) {
            echo '<div style="max-width:700px;margin:10px auto;padding:12px;border:1px solid #fecaca;background:#fef2f2;color:#991b1b;border-radius:10px;font-family:Arial,sans-serif;">
        ERROR: no se pudo enviar el correo. Revisa el log del servidor (application/logs).
    </div>';
        }

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
        $this->email->clear(true);

        $this->load->config('email', true);
        $email_cfg = $this->config->item('email');
        if (is_array($email_cfg)) {
            $this->email->initialize($email_cfg);
        } else {
            $this->email->initialize();
        }

        $this->email->from('dalemasbajo@gmail.com', 'DALE MÁS BAJO');
        $this->email->to('dalemasbajo@gmail.com');

        $this->email->subject($title);
        $this->email->message($data);

        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");

        $ok = $this->email->send(false);

        log_message('error', "send_received_message=" . ($ok ? 'OK' : 'FAIL') . " :: " . $this->email->print_debugger(['headers','subject']));

        return (bool)$ok;
    }

    private function notify_admin_drop_paid($order_id)
    {
        $orden = $this->orders_model->load_order_info($order_id);
        if(!$orden){
            log_message('error', 'notify_admin_drop_paid: orden no encontrada. order_id=' . $order_id);
            return false;
        }

        $user = $this->users_model->load_user_info($orden->user_id);
        $producto = $this->products_model->load_product_info($orden->drop_id);

        $this->email->clear(true);

        $this->load->config('email', true);
        $email_cfg = $this->config->item('email');
        if (is_array($email_cfg)) {
            $this->email->initialize($email_cfg);
        } else {
            $this->email->initialize();
        }

        $fromEmail = isset($email_cfg['smtp_user']) ? $email_cfg['smtp_user'] : 'dalemasbajo@gmail.com';

        $userName  = $user ? $user->username : '';
        $userEmail = $user ? $user->email : '';
        $dropName  = $producto ? $producto->name : '';
        $msg = !empty($orden->dj_message) ? trim($orden->dj_message) : '(sin mensaje)';

        $subject = 'DROP PAGADO #' . (int)$orden->id;

        $body = '
        <div style="font-family:Arial,sans-serif;line-height:1.6;color:#111;">
            <h2 style="margin:0 0 12px;">Se pagó un drop correctamente ✅</h2>

            <table style="border-collapse:collapse;width:100%;max-width:700px;">
                <tr>
                    <td style="padding:6px 0;width:160px;"><strong>Order ID:</strong></td>
                    <td style="padding:6px 0;">'.(int)$orden->id.'</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;"><strong>Usuario:</strong></td>
                    <td style="padding:6px 0;">'.htmlspecialchars($userName, ENT_QUOTES, 'UTF-8').'</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;"><strong>Email:</strong></td>
                    <td style="padding:6px 0;">'.htmlspecialchars($userEmail, ENT_QUOTES, 'UTF-8').'</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;"><strong>Drop ID:</strong></td>
                    <td style="padding:6px 0;">'.(int)$orden->drop_id.'</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;"><strong>Drop:</strong></td>
                    <td style="padding:6px 0;">'.htmlspecialchars($dropName, ENT_QUOTES, 'UTF-8').'</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;vertical-align:top;"><strong>Mensaje solicitado:</strong></td>
                    <td style="padding:6px 0;">'.nl2br(htmlspecialchars($msg, ENT_QUOTES, 'UTF-8')).'</td>
                </tr>
            </table>

            <p style="margin-top:16px;font-size:12px;color:#666;">
                Dale Más Bajo • Notificación automática
            </p>
        </div>
    ';

        $this->email->from($fromEmail, 'DALE MÁS BAJO');
        $this->email->to('dalemasbajo@gmail.com');
        $this->email->bcc('sevelasquezro@gmail.com');
        $this->email->subject($subject);
        $this->email->message($body);
        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");

        $ok = $this->email->send(false);

        if(!$ok){
            log_message('error', 'notify_admin_drop_paid FAIL order_id='.$order_id.' :: '.$this->email->print_debugger(['headers','subject']));
        }

        return (bool)$ok;
    }

    private function relay_to_vrp($rawJson, $renewal = false)
    {
        $url = $renewal
            ? 'https://videoremixpool.com/payment/process_tukuy_renewal_relay'
            : 'https://videoremixpool.com/payment/process_tukuy_relay';

        $ch = curl_init($url);

        curl_setopt_array($ch, array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $rawJson,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'X-Relay-Secret: ' . TUKUY_RELAY_SECRET
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
        ));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($curlErr) {
            log_message('error', 'relay_to_vrp CURL ERROR: ' . $curlErr);
            return ['status' => 'relay_error'];
        }

        $json = json_decode($response, true);

        if ($httpCode !== 200 || !is_array($json)) {
            log_message('error', 'relay_to_vrp BAD RESPONSE: ' . $response);
            return ['status' => 'relay_bad_response'];
        }

        return $json;
    }

    private function try_apply_plan_renewal_local($email, $amount, $txnId)
    {
        $user = $this->users_model->get_user_where_array(['email' => $email]);
        if (!$user) {
            return false;
        }

        $plan = $this->plan_model->load_plan_info_by_amount($amount);
        if (!$plan) {
            return false;
        }

        if ($this->orders_model->get_by_txn_id($txnId)) {
            return [
                'status' => 'already_processed_local',
                'site'   => 'dalemasbajo'
            ];
        }

        $data_order = [
            'user_id'     => (int)$user->id,
            'date_order'  => date("Y-m-d H:i:s"),
            'total_price' => (float)$plan->price,
            'status'      => 1,
            'is_plan'     => 1,
            'plan_id'     => (int)$plan->id,
            'txn_id'      => $txnId
        ];

        $order_id = $this->orders_model->create_order_plan($data_order);

        if (!$order_id) {
            return false;
        }

        $this->add_tokens_to_user($order_id, 1);
        $this->send_notification_mail($order_id, 1);

        return [
            'status'   => 'renewal_applied_local',
            'site'     => 'dalemasbajo',
            'order_id' => (int)$order_id
        ];
    }
}
