 <div id="ajaxArea">
 	<section>
 		<header>
 			<div class="container">
 				<div class="row">
 					<div class="col-md-12">
 						<h1>Hola <? echo $this->session->userdata('username'); ?></h1>
 						<p>Para accesar a los edits comprados haz click en el id de cada orden. Dentro encontrarás los archivos para descargar.</p>
						 <? //print_r($_SESSION); ?>
 					</div>
 				</div>
				<div class="row">
					<div class="col-md-6">
						<h3>MIS ULTIMAS COMPRAS</h3>
						<table class="table">
							<tr>
								<th>Fecha</th>
								<th>Orden ID</th>
								<th>Precio Total</th>
							</tr>
							<? foreach($orders as $orden){ ?>
							<tr>
								<td>
									
									<? 
										$fecha = date_format(date_create($orden->date_order), 'd/m/Y');
                                		echo $fecha; 
									?>
								</td>
								<td>
									<a href="<? echo base_url('micuenta/compra/').$orden->id;?>">
										<? echo $orden->id; ?>
									</a>
									</td>
								<td>
									
										$<? echo $orden->total_price; ?>
	
								</td>
							</tr>
							<? } ?>
						</table>
					</div>
				</div>
 			</div>
 		</header>
 	</section>
 </div>