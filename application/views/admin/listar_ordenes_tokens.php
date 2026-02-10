<div class="sl-pagebody">
	<div class="sl-page-title">
		<h5><? echo $title; ?></h5>
		<p><? echo $description; ?></p>
	</div><!-- sl-page-title -->
	<a href="<? echo base_url('admin/listar_ordenes_tokens/?time=semana'); ?>" class="btn btn-primary">7 DIAS</a>
	<a href="<? echo base_url('admin/listar_ordenes_tokens/?time=mes'); ?>" class="btn btn-primary">30 DIAS</a>
	<div class="card pd-20 pd-sm-40">
		<div class="table-wrapper">
			<table id="datatable1" class="table display nowrap text-center">
				<thead>
					<tr>
						<th>ID</th>
						<th>Fecha</th>
						<th>Usuario</th>
						<th>Email</th>
						<th>Total</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<? if ($ordenes) { ?>
						<? foreach ($ordenes as $orden) { ?>
							<tr class="<? if ($orden->txn_id == "MANUAL") {
											echo "bg-success text-white";
										} else {
											echo "";
										} ?>">
								<td><? echo $orden->id; ?></td>
								<td>
									<?

									$fecha = date_format(date_create($orden->date_order), 'm/d/Y');
									echo $fecha;

									?>

								</td>
								<td><? $user = $this->users_model->load_user_info($orden->user_id);
									if ($user != NULL) {
										echo $user->username;
									} else {
										echo 'usuario no existe';
									}
									?></td>
								<td>
									<? $user = $this->users_model->load_user_info($orden->user_id);
									if ($user != NULL) {
										echo $user->email;
									} else {
										echo 'usuario no existe';
									}  ?>
								</td>
								<td>$<? echo $orden->total_price; ?></td>
								<td>
									<? if ($orden->txn_id != "MANUAL") { ?>
										<a href="<? echo base_url('payment/aplicar_orden/?order_id=') . $orden->id; ?>" class="btn btn-success">Aplicar Plan</a>
									<? } else { ?>
										<a href="<? echo base_url('payment/aplicar_orden/?renovacion=1&order_id=') . $orden->id; ?>" class="btn btn-danger">Renovar Plan</a>
									<? } ?>
								</td>
							</tr>

						<? } ?>
					<? } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>