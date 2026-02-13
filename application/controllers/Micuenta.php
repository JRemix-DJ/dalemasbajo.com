<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Micuenta extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        // Cargamos todos los modelos necesarios
        $this->load->model(array('users_model', 'genero_model', 'products_model', 'banners_model', 'faq_model', 'orders_model'));
        $this->load->library(array('session','form_validation'));
        $this->load->database('default');
    }

    public function show_session(){
        echo '<pre>';
        print_r($_SESSION);
        echo '<br>';
        print_r($this->session->userdata('id_usuario'));
        echo '<br>';
        print_r($this->users_model->isUnlimited($this->session->userdata('id_usuario')));
        echo '<br>';
        $ilimitado = $this->users_model->isUnlimited($this->session->userdata('id_usuario'));
        echo $ilimitado;
        echo '</pre>';
    }

    public function index()
    {
        if($this->session->userdata('is_logued_in')){
            $data['title']="Mi Cuenta - Dale Más Bajo";
            $data['description']="Detalles de tu cuenta";
            $data['products']=$this->products_model->get_products();
            $data['generos']=$this->genero_model->get_generos();
            $data['users']=$this->users_model->get_all_users();
            $data['orders']=$this->orders_model->get_orders_by_user($this->session->userdata('id_usuario'));
            $data['djs']=$this->users_model->get_djs();
            $data['descargas']=$this->orders_model->load_descargas($this->session->userdata('id_usuario'));

            $this->load->view('templates/header', $data);
            $this->load->view('micuenta');
            $this->load->view('templates/footer', $data);
        }
    }

    public function compra(){
        if($this->session->userdata('is_logued_in')){
            $order_id=$this->uri->segment(3);
            $data['title']="Mi Cuenta - Dale Más Bajo";
            $data['description']="Detalles de tu cuenta";
            $data['products']=$this->products_model->get_products();
            $data['generos']=$this->genero_model->get_generos();
            $data['users']=$this->users_model->get_all_users();
            $data['orders']=$this->orders_model->get_orders_by_user($this->session->userdata('id_usuario'));
            $data['djs']=$this->users_model->get_djs();
            $data['descargas']=$this->orders_model->load_descargas_id($this->session->userdata('id_usuario'), $order_id);

            $this->load->view('templates/header', $data);
            $this->load->view('compra');
            $this->load->view('templates/footer', $data);
        }
    }

    public function hasTokensPost(){
        if($this->session->userdata('is_logued_in')){
            $user_id=$this->session->userdata('id_usuario');
            $tokens = $this->users_model->hasTokens($user_id);
            if($this->session->userdata('is_user_unlimited')){
                $jsondata['success']=true;
                $jsondata['is_unlimited']=true;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
                return;
            }else{
                if($tokens==false){
                    $tokens = 0;
                }else{
                    $tokens = $tokens[0]->total;
                }

                // Actualizamos la sesión para asegurar sincronización
                $this->session->set_userdata('tokens', $tokens);

                if($tokens!==false){
                    $jsondata['success']=true;
                    $jsondata['tokens']=$tokens;
                    header('Content-type: application/json; charset=utf-8');
                    echo json_encode($jsondata);
                }else{
                    $jsondata['tokens']=0;
                    $jsondata['success']=true;
                    header('Content-type: application/json; charset=utf-8');
                    echo json_encode($jsondata);
                }
            }
        }else{
            $jsondata['success']=false;
            $jsondata['message']="NOTLOGGEDIN";
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
        }
    }

    public function hasTokensPostVideo(){
        $user_id=$this->session->userdata('id_usuario');
        $tokens = $this->users_model->hasTokensVideo($user_id);
        if($this->session->userdata('is_user_unlimited')){
            $jsondata['is_unlimited']=true;
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
            return;
        }else{
            if($tokens==false){
                $tokens = 0;
            }else{
                $tokens = $tokens[0]->total;
            }
            if($tokens!==false){
                $jsondata['tokens_video']=$tokens;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
            }else{
                $jsondata['tokens_video']=0;
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
            }
        }
    }

    // ==========================================
    // FUNCIÓN PRINCIPAL DE DESCARGA (CORREGIDA)
    // ==========================================
    public function descargar_producto(){
        // Prevenimos salida de errores HTML que rompen el JSON
        error_reporting(0);

        if(isset($_POST['product_id'])){
            if($this->session->userdata('is_logued_in')){
                $user_id = $this->session->userdata('id_usuario');
                $product_id = $_POST['product_id'];

                // Obtener información del producto
                $product = $this->products_model->load_product_info($product_id);

                // 1. Verificar Tokens Actuales
                $tokens_data = $this->users_model->hasTokens($user_id);
                // Validación extra por si devuelve false o array vacío
                $tokenstotal = ($tokens_data && isset($tokens_data[0]->total)) ? (int)$tokens_data[0]->total : 0;

                // 2. Verificar si es Ilimitado
                $is_unlimited = ($this->session->userdata('is_user_unlimited') == true || $this->session->userdata('role') == 1);

                // 3. VERIFICACIÓN DOBLE: ¿Ya lo tiene por tokens o por compra directa?
                $tiene_archivo = $this->users_model->isUserFile($user_id, $product_id);
                $tiene_orden   = $this->orders_model->user_files($user_id, $product_id);

                $ya_comprado = ($tiene_archivo || $tiene_orden);

                if($tokenstotal > 0 || $ya_comprado || $is_unlimited){

                    $new_total = $tokenstotal;

                    // --- LÓGICA DE COBRO ---
                    // Solo cobramos si NO lo tiene Y NO es ilimitado
                    if(!$ya_comprado && !$is_unlimited){

                        // A. Restar Token en BD
                        $this->users_model->update_tokens($user_id);
                        $new_total = max(0, $tokenstotal - 1); // Evitar negativos

                        // B. Registrar propiedad del archivo en BD
                        $today = date('Y-m-d');
                        $data_file = array(
                            'user_id' 	        => 	$user_id,
                            'product_id'	    =>  $product_id,
                            'downloads_left'	=>	3,
                            'since'		        =>  $today
                        );
                        $this->users_model->add_file_to_user($data_file);

                        // C. Registrar en historial de descargas generales
                        $data_download = array(
                            'product_id'	=>	$product_id,
                            'user_id'		=>	$user_id,
                            'date'			=>	$today
                        );
                        $this->products_model->add_download($data_download);

                        // D. Pagar al dueño del remix (Protegido contra fallos)
                        if($product && isset($product->owner_id)){
                            $this->add_payment_to_owner_tokens($product_id, $product->owner_id, $user_id);
                        }
                    }

                    // 4. Actualizar Sesión CodeIgniter
                    $this->session->set_userdata('tokens', $new_total);

                    // Actualizar array de productos en sesión
                    if(!isset($_SESSION['user_products']) || !is_array($_SESSION['user_products'])){
                        $_SESSION['user_products'] = array();
                    }
                    if (!in_array($product_id, $_SESSION['user_products'])){
                        $_SESSION['user_products'][] = $product_id;
                    }

                    // 5. Enviar Respuesta JSON
                    $jsondata['success'] = true;
                    $jsondata['total_tokens'] = $new_total;
                    $jsondata['is_unlimited'] = $is_unlimited;
                    $jsondata['message'] = 'DESCARGANDO';

                    header('Content-type: application/json; charset=utf-8');
                    echo json_encode($jsondata);

                } else {
                    $jsondata['success'] = false;
                    $jsondata['message'] = 'NOTOKENS';
                    header('Content-type: application/json; charset=utf-8');
                    echo json_encode($jsondata);
                }
            } else {
                $jsondata['success'] = false;
                $jsondata['message'] = 'NOLOGGUEDIN';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
            }
        } else {
            // Si acceden directamente a la URL sin POST
            header("Location: ".base_url());
        }
    }

    // Función auxiliar para registrar pago al DJ
    private function add_payment_to_owner_tokens($product_id, $owner_id, $user_id){
        $amount = 0.05;
        $date = date("Y-m-d");
        $data = array(
            'date'			=>	$date,
            'user_id'		=>	$user_id,
            'amount'		=>	$amount,
            'product_id'	=>	$product_id,
            'owner_id'		=>	$owner_id
        );
        // Verificar que el modelo esté cargado por si acaso
        if(isset($this->orders_model)){
            $this->orders_model->insert_payment_tokens($data);
        }
    }

    public function descargar_producto_video(){
        if(isset($_POST['product_id'])){
            if($this->session->userdata('is_logued_in')){
                $user_id = $this->session->userdata('id_usuario');
                $product_id=$_POST['product_id'];

                // Corrección similar para videos
                $tokens_data = $this->users_model->hasTokensVideo($user_id);
                $tokenstotal = ($tokens_data && isset($tokens_data[0]->total)) ? (int)$tokens_data[0]->total : 0;

                $ya_comprado = $this->orders_model->user_files($user_id, $product_id);
                $is_unlimited = ($this->session->userdata('is_user_unlimited') == 1);

                if($tokenstotal > 0 || $ya_comprado || $is_unlimited){

                    $product = $this->products_model->load_product_info($product_id);
                    $new_total = $tokenstotal;

                    if(!$ya_comprado && !$is_unlimited){
                        // Restar token video
                        $this->users_model->update_tokens_video($user_id);
                        $new_total = max(0, $tokenstotal - 1);

                        // Registrar
                        $today = date('Y-m-d');
                        $data_file = array(
                            'user_id' 	        => 	$user_id,
                            'product_id'	    =>  $product_id,
                            'downloads_left'	=>	3,
                            'since'		        =>  $today
                        );
                        $this->users_model->add_file_to_user($data_file);

                        $data_dw = array(
                            'product_id'	=>	$product_id,
                            'user_id'		=>	$user_id,
                            'date'			=>	$today
                        );
                        $this->products_model->add_download($data_dw);

                        if($product && isset($product->owner_id)){
                            $this->add_payment_to_owner_tokens($product_id, $product->owner_id, $user_id);
                        }
                    }

                    $this->session->set_userdata('tokens_video', $new_total);

                    if (!isset($_SESSION['user_products']) || !in_array($product_id, $_SESSION['user_products'])){
                        $_SESSION['user_products'][] = $product_id;
                    }

                    $jsondata['success'] = true;
                    $jsondata['total_tokens'] = $new_total;
                    $jsondata['is_unlimited'] = $is_unlimited;
                    $jsondata['message'] = 'DESCARGANDO';

                    header('Content-type: application/json; charset=utf-8');
                    echo json_encode($jsondata);

                } else {
                    $jsondata['success'] = false;
                    $jsondata['message'] = 'NOTOKENS';
                    header('Content-type: application/json; charset=utf-8');
                    echo json_encode($jsondata);
                }
            } else {
                $jsondata['success'] = false;
                $jsondata['message'] = 'NOLOGGUEDIN';
                header('Content-type: application/json; charset=utf-8');
                echo json_encode($jsondata);
            }
        } else {
            header( "Location: ".base_url() );
        }
    }
}
?>