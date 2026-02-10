<? $this->load->helper('url'); ?>

    <!-- ########## END: LEFT PANEL ########## -->

    

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->
        <div class="card pd-20 pd-sm-40">
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap text-center">
              <thead>
                <tr>
                  <th class="wd-25p">Nombre</th>
                  <th class="wd-25p">Paypal</th>
                  <th>Adeudado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <? //$generos=(array) $generos; ?>
                <? foreach($pagos as $pago) { ?>
                  <tr>
                    <td class="align-middle"><? echo $pago->name; ?></td>
                    <td class="align-middle"><? echo $pago->paypal; ?></td>
                    <td class="align-middle">$<? echo $pago->apagar; ?></td>
                    <td class="align-middle">
                    <a href="<? echo base_url('admin/detalles_pago_token/').$pago->uid;; ?>" class="btn btn-warning">Ver Detalles</a>
                    <? if($this->session->userdata('role')=='is_admin') { ?>
                    <a href="<? echo base_url('admin/pago_a_dj_token/').$pago->uid.'?amount='.$pago->apagar; ?>" class="btn btn-success">Pagar</a>
                    <? } ?>
                    </td>
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
      
