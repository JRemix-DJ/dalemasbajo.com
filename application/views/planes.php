    <div id="ajaxArea"> 
    <div class="pageArea">
    <section class="album-header">
            <figure class="album-cover-wrap">
                <div class="album-cover_overlay"></div>
            </figure>
            <div class="container">
                <div class="cover-content">
                   <hr>
                    <div class="clearfix text-uppercase">
                        <h1 style="padding-top: 30px">PLANES</h1>
                        <cite class="album-author mb-20">DALE MAS BAJO</cite>
                    </div>
                </div>
            </div>
        </section>
    	<section>
            <div class="row">
                <div class="container">
                    <div class="col-md-12 ">
                    <p class="text-success">
                        <i class="fa fa-exclamation-triangle"></i> Hemos mejorado nuestro sistema de pagos, hazlo con confianza!
                    </p>
                    </div>
                </div>
            </div>
    		<header class="style4 confirmacion">
		    	<div class="container">
		    		<div class="row">
		    			<div class="col-xs-12">
                        <div class="pricing-table">
                        <? if(isset($plans)){ ?>
                            <? foreach($plans as $plan){ ?>

                                <div class="pricing-box">
                                    <h2><? echo $plan->name; ?></h2>
                                    <span class="price">$<? echo $plan->price; ?></span>
                                    <p class="description"><? echo $plan->description; ?></p>
                                    <span class="pricing-table-divider"></span>
                                    <a class="btn btn-default" href="<? echo base_url(); ?>getplan/?plan_id=<? echo $plan->id; ?>&currency=USD"><b>Comprar</b></a>
                                    <span class="pricing-table-divider"></span>
                                    <ul>
                                    <? if($plan->tokens!=0||$plan->tokens!=NULL){ ?>
                                        <li><? echo $plan->tokens; ?> DESCARGAS DE AUDIO</li>
                                    <? } ?>
                                        <li><? echo $plan->duration; ?> DIAS</li>
                                    </ul>
                                    <small>*Cada plan se renueva via paypal hasta su cancelación</small>
                                </div>
                            <? } ?>
                        <? } ?>
                        </div>
		    			</div>
		    		</div>
		    	</div> 
    		</header>
    	</section>
    </div>
</div>