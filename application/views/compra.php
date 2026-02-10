 <div id="ajaxArea">
 	<section>
 		<header>
 			<div class="container">
 				<div class="row">
 					<div class="col-md-12">
 						<h1>Hola <? echo $this->session->userdata('username'); ?></h1>
 						<p>Aquí podrás ver tu compra  y los items en DaleMasBajo.com</p>
 					</div>
 				</div>
				<div class="row">
					<div class="col-md-9">
						<h3>Mis Descargas</h3>
						<table class="table">
							<tr>
								<th>ID</th>
								<th>Descargas Restantes</th>
								<th>Nombre</th>
								<th>Descargar</th>
							</tr>
							<? foreach($descargas as $descarga){ ?>
							<tr>
								<td><? echo $descarga->product_id; ?></td>
								<td><? echo $descarga->downloads_left; ?></td>
								<td><? 
										$dj = $this->users_model->load_user_info($descarga->owner_id);
										if($dj){
											echo $descarga->product_name.' - '. $descarga->artista. ' - '.$descarga->bpm.'bpm - '.$descarga->version.' - '.$dj->username;
										}else{
											echo $descarga->product_name.' - '. $descarga->artista. ' - '.$descarga->bpm.'bpm - '.$descarga->version;
										}
											?></td>
								<td>
									<? if($descarga->gender!=45){ ?>
									<a href="<? echo base_url('products/descargar/').$descarga->product_id; ?>" class="btn btn-default"><i class="fa fa-download"></i></a>
									<? }else{ ?>
										<button  class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Envía un e-mail a dalemasbajo@gmail.com, nuestro equipo enviará tu audio en cuanto este listo. Tiempo estimado 24 / 48 horas. Excepto en feriados."><i class="fa fa-info"></i></button>
								<? } ?>
								</td>
							</tr>
							<? } ?>
						</table>
					</div>
					<div class="col-md-3">
						<a href="<? echo base_url('micuenta/'); ?>" class="btn btn-orange"><i class="fa fa-arrow-left"></i> Regresar</a>
					</div>
				</div>
 			</div>
 		</header>
 	</section>
 </div>