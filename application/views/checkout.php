 <div id="ajaxArea"> 
      <section class="album-header">
            <figure class="album-cover-wrap">
                <div class="album-cover_overlay"></div>
            </figure>
            <div class="container">
                <div class="cover-content">
                   <hr>
                    <div class="clearfix text-uppercase">
                        <h1 style="padding-top: 30px">Checkout</h1>
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
                                    <? foreach($_SESSION['cart']['items'] as $item){ ?>
                                        <tr>
                                            <td>
                                               <? echo $item['name'].' - '.$item['artist'].' - '.$item['artist']. ' - '.$item['bpm'].'bpm'; ?>
                                            </td>
                                            <td>
                                                $<? echo $item['price']; ?>
                                            </td>
                                        </tr>
                                    <? } ?>
                                    <? if(isset($_SESSION['cart']['cupon'])){ ?>
                                        <tr class="cart_discount">
                                            <td>
                                            Cupon de Descuento Aplicado
                                            </td>
                                            <td>
                                                <? echo '-$'.number_format($_SESSION['cart']['cupon']['descuento_total'], 2, '.', ''); ?>
                                        </tr>
                                    <? } ?>
                                    <tr class="total">
                                        <td>Total de la Orden</td>
                                        <td>
                                            
                                            <strong>$<? echo $cart_total; ?></strong>
                                            
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </section>
                        <section>
                            <div class="title">
                                <h3>REALIZAR PAGO</h3>
                            </div>
                            <div class="content">
                                <div class="payment_options">
                                    <div class="item">
                                        <input type="radio" name="paypal" checked> <img src="/images/paypal.png" alt=""><br>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section>
                            <br>
                            <form name="frm_customer_detail" id="pagarpaypal" action="https://www.paypal.com/cgi-bin/webscr" method="POST">
                                <input type='hidden' name='business' value='<? echo PAYPAL_MAIL; ?>'>
                                <input type='hidden' name='item_name' value='<? echo 'Dale Mas Bajo'; ?>'> 
                                <input type='hidden' name='amount' id="amount" value='<? echo $cart_total; ?>'>
                                <input type="hidden" name="lc" value="US">
                                <input type='hidden' name='currency_code' value='USD'> 
                                <input type='hidden' name='notify_url' value='http://localhost/dalemasbajo.com/payment/realizado/'>
                                <input type='hidden' name='return' value='http://localhost/dalemasbajo.com/payment/finalizado/'>
                                <input type="hidden" name="button_subtype" value="services">
                                <input type="hidden" name="cancel_return" value="http://localhost/dalemasbajo.com/payment/cancelar/">
                                <input type="hidden" name="cmd" value="_xclick"> 
                                <input type="hidden" name="order" value="<? echo $order_id; ?>">
                                <input type="hidden" name="custom" id="custom" value="<? echo $order_id; ?>">
                                <div> <input type="submit" class="btn-action btn btn-default btn-orange" name="continue_payment" id="paynow" value="Pagar Ahora"> </div>
                            </form>
                        </section>

                    </div>
                <? }else{
                    ?>
                    Necesitas estar registrado y logueado para finalizar la compra.
                    <?
                } ?>
                </div>
            </div>
        </section>
  
    </div>