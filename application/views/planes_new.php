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
                        <cite class="bg-success"><i class="fa fa-exclamation-triangle"></i> Hemos mejorado nuestro sistema de pagos, hazlo con confianza!</cite>
                    </div>
                </div>
            </div>
        </section>
    	<section id="cuerpo" class="planespage">
                    
    		<header class="style4 confirmacion">
		    	<div class="container">
		    		<div class="row">
		    			<div class="col-xs-12">
                            
                        <div class="contenedor" >
                        <? if(isset($plans)){  ?>
                            <? foreach($plans as $plan){ ?>
                                <div class="tabla tabla hover ">
                                    <div class="section_plan">
                                        <h2><?= $plan->name; ?></h2>
                                    </div>
                                    <div class="section_plan">
                                        <p><? echo $plan->description;  ?></p>
                                    </div>
                                  
                                    <div class="section_plan">
                                    <span class="precio">$ <? echo $plan->price; ?></span>
                                    </div>
                                 
                                    <div class="section_plan">
                                    <span class=""><? echo $plan->duration; ?></span>
                                    <p> &nbsp; días</p>
                                    </div>
                                    <? if ($plan->ilimitado_activo == 1) { ?>
                                        <div class="section_plan">
                                            <h6>Descargas Ilimitadas de Audio.</h6>
                                        </div>
                                    <? }else{ ?>
                                    <div class="section_plan">
                                    <span class="table-tokens-audio"><? if($plan->tokens!=0 && $plan->tokens!=NULL){ echo $plan->tokens; }else{ echo '0'; } ?></span>
                                    <p> &nbsp; Descargas Audio </p>
                                    </div>
                                    <? } ?>
                                    <div class="section_plan">
                                    <p> Renovacion Automatica </p>
                                    </div>
                                    
                                    <div class="section_plan">
                                    <p>Busqueda Avanzada </p>
                                    </div>
                                    <div class="section_plan">
                                    <p>Nueva Música Diariamente </p>
                                    </div>
                                    
                                    <div class="section_plan">
                                    <p> Descargas con 1 Click </p>
                                    </div>
                                   
                                    <div class="section_plan">
                                    <p>HQ Audio</p>
                                    </div>
                                    
                                
                                    
                                    

                                    <a class="btn btn-default" href="<? echo base_url(); ?>getplan/?plan_id=<? echo $plan->id; ?>&currency=USD"><b>Comprar</b></a>   
                                    
                                </div>
                                
                                
                                <??>
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