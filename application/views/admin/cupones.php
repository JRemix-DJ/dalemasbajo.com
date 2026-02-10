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
                  <th class="wd-25p">Codigo</th>
                  <th class="wd-25p">Descripción</th>
                  <th>Descuento</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <? //$generos=(array) $generos; ?>
                <? foreach($cupones as $cupon) { ?>
                  <tr>
                    <td class="align-middle"><? echo $cupon->code; ?></td>
                    <td class="align-middle"><? echo $cupon->description; ?></td>
                    <td class="align-middle"><? echo $cupon->discount; ?>%  </td>
                    <td class="align-middle">
                    <a href="<? echo base_url('admin/editar_cupon/').$cupon->id;; ?>" class="btn btn-warning">Editar</a>
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
      
