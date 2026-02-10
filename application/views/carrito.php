    <div id="ajaxArea"> 
        <section class="album-header">
            <figure class="album-cover-wrap">
                <div class="album-cover_overlay"></div>
            </figure>
            <div class="container">
                <div class="cover-content">
                   <hr>
                    <div class="clearfix text-uppercase">
                        <h1 style="padding-top: 30px">MI CARRITO</h1>
                        <cite class="album-author mb-20">Tus productos añadidos</cite>
                    </div>
                </div>
            </div>
        </section>
        <section class="contenido">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p>A continuación te mostramos todos los productos que haz añadido a tu carrito de compras</p>
                        <? if(isset($cart_items)){ ?>

                            <? if(count($cart_items)==0){  ?>
                                <p class="alert alert-warning">Aún no haz añadido nada a tu carrito, por favor revisa nuestra tienda para ver todos nuestros productos. <a href="<? echo base_url(); ?>" class="btn btn-default">Ir y Comprar</a></p>
                            <? }else{ ?>
                            <table class="table carrito">
                                <thead>
                                    <tr>
                                        <th>
                                            Nombre del Producto
                                        </th>
                                        <th>
                                            Precio
                                        </th>
                                        <th>
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?
                                    
                                        foreach($cart_items as $item){
                                            ?>
                                            <tr>
                                                <td>
                                                   <? echo $item['name'].' - '.$item['artist'].' - '.$item['artist']. ' - '.$item['bpm'].'bpm'; ?>
                                                </td>
                                                <td>
                                                    $<? echo  $item['price']; ?>
                                                </td>
                                                <td>
                                                    <button class="deleteFromCart btn btn-danger" data-id="<? echo $item['id']; ?>">Borrar</button>
                                                </td>
                                            </tr>
                                            <?
                                        }
                                    
                                    ?>
                                    <? if(isset($_SESSION['cart']['cupon'])){ ?>
                                        <tr class="cart_discount">
                                            <td>
                                                <table class="table-no-table">
                                                    <tr>
                                                        <td>
                                                            <i class="fa fa-close" id="removeCupon"></i>
                                                        </td>
                                                        <td>
                                                            Cupon de Descuento Aplicado<br>
                                                            <small><? echo $_SESSION['cart']['cupon']['description']; ?></small>
                                                        </td>
                                                    </tr>
                                                </table>
                                               
                                            </td>
                                            <td colspan="2">
                                                <? echo '-$'.number_format($_SESSION['cart']['cupon']['descuento_total'], 2, '.',''); ?>
                                            </td>
                                        </tr>
                                    <? } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Total:</td>
                                        <td colspan="1">
                                            
                                                $<? echo $cart_total; ?>
                                           
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">
                                            <? if(!isset($_SESSION['cart']['cupon'])){ ?>
                                                <div class="grid3">
                                                    ¿Tienes un cupón de descuento?
                                                    <input type="text" name="cuponcode" id="cuponcode" class="form-control">
                                                    <a href="#" class="btn btn-default" id="aplicarDescuento">Aplicar</a>
                                                </div>
                                            <? }else{ ?>
                                                <em>Cupon Aplicado <strong><? echo $_SESSION['cart']['cupon']['code']; ?></strong></em>
                                            <? } ?>
                                        </td>
                                        <td></td>
                                        <td colspan="1"><a href="<? echo base_url(); ?>checkout" class="btn btn-success" id="gotoCheckout">Continuar</a></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <? } ?>
                        <? }else{ ?>
                             <p class="alert alert-warning">Aún no haz añadido nada a tu carrito, por favor revisa nuestra tienda para ver todos nuestros productos. <a href="<? echo base_url(); ?>" class="btn btn-default">Ir y Comprar</a></p>
                        <? } ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <? 
       
    ?>