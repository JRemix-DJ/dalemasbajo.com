<? $role = $this->session->userdata('role'); ?>
<div class="sl-pagebody">
				<div class="sl-page-title">
					<h5><? echo $title; ?></h5>
					<p><? echo $description; ?></p>
				</div><!-- sl-page-title -->
				<div class="top_btn"><a href="https://dalemasbajo.com/admin/nuevo_producto/" class="btn btn-success">Añadir Nuevo</a></div>
				<div class="card pd-20 pd-sm-40">
					<div class="table-wrapper">
						<div class="row">
							<div class="col-md-4 form-group">
								<label for="">Generos</label>
								<select name="genero-productos" id="genero-videos" class="form-control">
									<option value="">Selecciona una opción</option>
									<? foreach($generos as $genero){ ?>
										<option value="<? echo $genero->id; ?>" <? if(isset($_GET['genero_filter'])){ if($_GET['genero_filter']==$genero->id){?> selected <? } } ?>><? echo $genero->name; ?></option>
									<? } ?>
								</select>
							</div>
							<div class="col-md-4"></div>
							<div class="col-md-4">
								<form action="<? echo base_url('admin/listar_productos/'); ?>">
									<? if(isset($_GET['aprobacion'])){ ?> 
										<input type="hidden" name="aprobacion" value="1">
									<? } ?>
									<div class="form-grup">
										<label for="">Buscar</label>
										<input type="text" name="search" class="form-control" placeholder="Buscar..." value="<? if(isset($_GET['search'])){ echo $_GET['search']; } ?>">
									</div>
								</form>
							</div>
						</div>
						<? if(isset($mensaje)){ ?>
							<div class="alert alert-danger" role="alert"><? echo $mensaje; ?></div>
						<? } ?>
						<table id="datatable1" class="table display wrap text-center">
							<thead>
								<tr>
									<th>Fecha Aprobación</th>
									<th>Nombre</th>
									<th>Precio</th>
									<th>Género</th>
									<th>BPM</th>
									<th>Artista</th>
									<th>Tipo</th>
									<th>Editor</th>
									<th>Ver</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								<? if(isset($products)){ ?>
									<? if($products){ ?>
									<? $i = 0; 
									foreach($products as $producto) { 
										$i++;
										?>
										<tr class="video_product" id="producto<? echo $i; ?>">
											<td class="align-middle">
												<? 
												$fecha = date_format(date_create($producto->time_approved), 'm/d/Y');
                                				echo $fecha; 
												?>
													
												</td>
											<td class="align-middle" style="max-width: 300px"><? echo $producto->name; ?></td>
											<td class="align-middle">$<? echo $producto->price; ?></td>
											
											<td class="align-middle">
												<? 

													$key = array_search($producto->gender_id, array_column($generos, 'id'));

													echo $generos[$key]->name;
											?>
												
											</td>
											<td class="align-middle"><? echo $producto->bpm; ?></td>
											<td class="align-middle"><? echo $producto->artist; ?></td>
											<td class="align-middle">
												<? 
												$key = array_search($producto->product_type_id, array_column($product_types, 'id'));
												echo  $product_types[$key]->name; 
												?>
											</td>
											<td class="align-middle">
												<? 
												$key = array_search($producto->owner_id, array_column($users, 'id'));
												echo  $users[$key]->username; 
												?>
												</td>
												<td class="align-middle">
													<div class="video_demo" data-mp4="<? echo base_url().'assets/products/demos/videos/'.$producto->demo; ?>" id="player<? echo $i; ?>"></div>
												<div class="playit controls jp-controls-holder">
				                                    <i class=" fa fa-play-circle-o jp-play pc-play"></i> 
				                                    <i class=" fa fa-pause-circle-o jp-pause pc-pause"></i>
				                                </div>
												</td>
											<td class="actions align-middle">
												<? if(($role=='is_admin' || $role=='is_subadmin')||($this->input->get('aprobacion')==1)){ ?>
													<a href="<? echo base_url(); ?>admin/editar_producto/?product_id=<? echo $producto->id.'&paginationnumber='.$paginationnumber; ?>" class="btn btn-danger btn-sm">Editar</a>
												<? } ?>
												<? 	
													//usamos la misma vista para mostrar los productos
													//aquí validamos que sea un administrador o sub administrador
													//y que la variable de productos esperando aprobación este lista
												?>
												<? if(($role=='is_admin' || $role=='is_subadmin')&&($this->input->get('aprobacion')!==null)){ ?>
													<a href="<? echo base_url(); ?>admin/listar_videos/?aprobacion=1&action=approve&product_id=<? echo $producto->id; ?>" class="btn btn-success btn-sm">Aprobar</a>
												<? } ?>
												<? if(($role=='is_admin' || $role=='is_subadmin')&&($this->input->get('aprobacion')==null)){ ?>
													<a href="<? echo base_url(); ?>admin/listar_videos/?action=disapprove&product_id=<? echo $producto->id; ?>" class="btn btn-warning btn-sm">Desaprobar</a>
												<? } ?>
												<? if(($role=='is_admin' || $role=='is_subadmin')){ ?>
													<a href="<? echo base_url(); ?>products/descargar_admin/<? echo $producto->id; ?>" class="btn btn-primary btn-sm">Descargar</a>
												<? } ?>
												<? if(($role=='is_admin' || $role=='is_subadmin')||($this->input->get('aprobacion')==1)){ ?>
												<a href="<? echo base_url(); ?>admin/listar_videos/?<? if($this->input->get('aprobacion')!=null){ echo 'aprobacion=1&';} ?>action=delete&product_id=<? echo $producto->id; ?>" class="btn btn-danger btn-sm">Delete</a>
											<? } ?>

											</td>
										</tr>
									<? } ?>
									<? } ?>
								<? } ?>
							</tbody>
						</table>
						
						<?php if (isset($links)) { ?>
							<?php echo $links ?>
						<?php } ?>
					</div><!-- table-wrapper -->
				</div><!-- card -->

			</div><!-- sl-pagebody -->