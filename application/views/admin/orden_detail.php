<div class="sl-pagebody">
				<div class="sl-page-title">
					<h5><? echo $title; ?></h5>
					<p><? echo $description; ?></p>
				</div><!-- sl-page-title -->

					<a href="<? echo base_url('admin/listar_ordenes/'); ?>" class="btn btn-danger"><i class="fa fa-left-row"></i> Regresar</a>
				<div class="card pd-20 pd-sm-40">
					<div class="table-wrapper">
						<table id="datatable1" class="table display responsive nowrap text-center">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>DJ</th>
									<th>Precio</th>
								</tr>
							</thead>
							<tbody>
								<? if($order_items){ ?>
									<? foreach($order_items as $order_item){ ?>
										<tr>
											<td><? echo $order_item->product_name.' - '.$order_item->artista.' - '.$order_item->version; ?></td>
											<td><? 
											 $user = $this->users_model->load_user_info($order_item->owner);
											 echo $user->username;
											 ?></td>
											<td><? echo $order_item->product_price; ?></td>
										</tr>

									<? } ?>
								<? } ?>
							</tbody>
						</table>
					</div>
				</div>
</div>