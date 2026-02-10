<? $this->load->helper('url'); ?>

    <!-- ########## END: LEFT PANEL ########## -->

    

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->
        <a href="<? 
        if(isset($_GET['section_realizado'])){
            echo base_url('admin/pagos_realizados_tokens/'); 
          }else{
            echo base_url('admin/pagos_tokens/'); 
          }
        ?>" class="btn btn-danger"><i class="fa fa-left-row"></i> Regresar</a>
        <div class="card pd-20 pd-sm-40">
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap text-center">
              <thead>
                <tr>
                <th>Fecha</th>
                  <th class="wd-25p">Dj</th>
                  <th class="wd-25p">Producto</th>
                  <? if($this->session->userdata('role')=='is_admin'){ ?>
                  <th>Comprado por</th>
                  <? } ?>
                  <th>Pago</th>
                </tr>
              </thead>
              <tbody>
                <? //print_r($pagos); ?>
                <? foreach($pagos as $pago) { ?>
                  <tr>
                  	<td class="align-middle"><? $fecha = date_format(date_create($pago->fecha), 'd/m/Y');
                                echo $fecha;  ?></td>
                    <td class="align-middle"><? echo $pago->name; ?></td>
                    <td class="align-middle"><? echo $pago->product_name.' - '.$pago->artista.' - '.$pago->version; ?></td>
                    <? if($this->session->userdata('role')=='is_admin'){ ?>
                    <td class="align-middle">
                    	<? $user = $this->users_model->load_user_info($pago->who_paid); 
                    		echo $user->username;
                    	?>
              		
                    </td>
                    <? } ?>
                    <td class="align-middle">$<? echo $pago->monto; ?></td>
                    
                  </tr>
                <? } ?>
              </tbody>
            </table>
            <? if(isset($mensaje)){ ?>
              <div class="alert alert-danger" role="alert"><? echo $mensaje; ?></div>
            <? } ?>
          </div><!-- table-wrapper -->
        </div><!-- card -->

      </div><!-- sl-pagebody -->
      
