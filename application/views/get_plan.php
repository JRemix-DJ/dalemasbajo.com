<div id="ajaxArea"> 
      <section class="album-header">
            <figure class="album-cover-wrap">
                <div class="album-cover_overlay"></div>
            </figure>
            <div class="container">
                <div class="cover-content">
                   <hr>
                    <div class="clearfix text-uppercase">
                        <h1 style="padding-top: 30px">Checkout Plan</h1>
                        <cite class="album-author mb-20">DALE MAS BAJO</cite>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                <? if($this->session->userdata('is_logued_in')){ ?>
                    <div class="col-md-6">
                        <div class="title">
                            <h3>INFORMACIÓN DE FACTURACIÓN</h3>
                        </div>
                        <table class="table user_info">
                            <tr>
                               <td>CODIGO DE CLIENTE: </td><td><? echo $this->session->userdata('id_usuario'); ?></td>
                           </tr>
                           <tr>
                               <td>Nombre: </td><td><? echo $this->session->userdata('first_name'); echo ' '; echo $this->session->userdata('last_name'); ?></td>
                           </tr>
                           <tr>
                               <td>E-mail: </td>
                               <td><? echo $this->session->userdata('email'); ?></td>
                           </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <section>
                            <div class="title"><h3>ORDEN</h3><a class="pull-right" href="<? echo base_url(); ?>cart">Editar Carrito</a></div>
                            <div class="content">
                                <table class="table checkout">
                                    <? if(isset($plan)){ ?>
                                        <tr>
                                            <td>
                                               <? echo $plan->name; 
                                               if ($plan->ilimitado_activo == 1) { ?>
                                                  - Descargas Ilimitadas de Audio
                                               <? }else{ if($plan->tokens!=NULL||$plan->tokens!=0){ ?>
                                                - <? echo $plan->tokens; ?> Descargas de Audio 
                                                <? } } ?>
                                               - Duración <? echo $plan->duration; ?> días
                                            </td>
                                            <td>
                                                    $<? echo $plan->price; ?> USD
                                               
                                            </td>
                                        </tr>
                                    <tr class="total">
                                        <td>Total de la Orden</td>

                                            <td><strong>$<? echo $plan->price; ?> USD</strong></td>
                                        

                                    </tr>
                                    <? } ?>
                                </table>
                            </div>
                        </section>
                        <section class="mb-5" style="margin-bottom: 50px;">
                            <div class="title">
                                <h3>SELECCIONA TU METODO PAGO</h3>
                            </div>
                            <div class="content">
                                <div class="payment_options">
                                    <? 
                                    $metodos_pago=0;
                                    if(PAYPAL_ACTIVE){ 
                                    $metodos_pago++;
                                    ?>
                                    <div class="item">
                                        <input type="radio" value="paypal" name="pago" id="checkpaypal" checked> <img src="<? echo base_url(); ?>/images/paypal.png" alt="" style="max-width: 200px; margin-bottom: 20px"><br>
                                    </div>
                                    <?  } ?>
                                    <? if(PAGOLINK_ACTIVE && !is_null($plan->url_pago)){ 
                                        $metodos_pago++;
                                        ?>
                                    <div class="item">
                                        <a href="<? echo $plan->url_pago?>" class="button btn btn-default" id="pagar_tarjeta" data-user_id="<? echo $this->session->userdata('id_usuario'); ?>" data-plan_id="<? echo $plan->id; ?>" data-email="<? echo $this->session->userdata('email'); ?>" data-monto="<? echo $plan->price; ?>">PAGAR CON TARJETA DE CRÉDITO / DÉBITO</a>
                                        <div class="item-icons-card">
                                            <i class="fa fa-brands fa-cc-visa"></i>
                                            <i class="fa fa-brands fa-cc-mastercard"></i>
                                            <i class="fa fa-brands fa-cc-amex"></i>
                                            <i class="fa fa-brands fa-cc-diners-club"></i>
                                        </div>
                                    </div>
                                    <? } ?>
                                    <? if(!$metodos_pago){ ?>
                                    <div class="item">
                                        NO HAY METODOS DE PAGO DISPONIBLES PARA ESTE PLAN
                                    </div>
                                    <? } ?>
                                </div>
                            </div>
                        </section>
                        <? if(PAYPAL_ACTIVE){ ?>
                        <section>
                            <form name="frm_customer_detail" id="pagarpaypal" action="https://www.paypal.com/cgi-bin/webscr" method="POST">
                           
                                <input type='hidden' name='business' value='<? echo PAYPAL_MAIL; ?>'>
                                <input type='hidden' name='item_name' value='<? echo $plan->name; ?>'> 
                                
                                <input type='hidden' name='a3' id="amount" value='<? echo $plan->price; ?>'>
                                <input type='hidden' name='p3' id="period" value='<? echo $plan->duration; ?>'>
                                <input type='hidden' name='t3' id="type_period" value='D'>
                                <input type='hidden' name='currency_code' value='USD'> 


                                
                                <input type="hidden" name="lc" value="US">
                                <input type="hidden" name="src" value="1">
                                
                                
                                <input type='hidden' name='notify_url' value='<? echo base_url(); ?>payment/plan_realizado/'>
                                <input type='hidden' name='return' value='<? echo base_url(); ?>payment/plan_finalizado/'>
                                <input type="hidden" name="button_subtype" value="services">
                                <input type="hidden" name="cancel_return" value="<? echo base_url(); ?>payment/plan_cancelar/">
                                <input type="hidden" name="cmd" value="_xclick-subscriptions"> 
                                <input type="hidden" name="order" value="">
                                <input type="hidden" name="plan" id="plan" value="<?php echo $_GET['plan_id'];?>">
                                <input type="hidden" name="custom" id="custom" value="">
                                <input type="submit" class="btn-action btn btn-default btn-orange" name="continue_payment" id="paynow" value="Pagar Ahora con Paypal">
                            </form>
                        </section>
                        <? } ?>
                    </div>
                <? }else{
                    ?>
                    <div class="col-md-12" style="padding-top: 40px;padding-bottom: 40px">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Necesitas estar    registrado y logueado para finalizar la compra.
                    </div>
                    <?
                } ?>
                </div>
            </div>
        </section>
  
    </div>