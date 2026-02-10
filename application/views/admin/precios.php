<? $this->load->helper('url'); ?>
<? $role = $this->session->userdata('role'); ?>

    <!-- ########## END: LEFT PANEL ########## -->

    

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->
        <div class="top_btn"><a href="https://dalemasbajo.com/admin/nuevo_precio/" class="btn btn-success">Añadir Nuevo</a></div>
        <div class="card pd-20 pd-sm-40">
          <div class="table-wrapper">
            <table id="datatable1" class="table display nowrap text-center">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Precio</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <? if($precios){ ?>
                  <? foreach($precios as $precio) { ?>
                    <tr>
                      <td class="align-middle" style="max-width: 300px"><? echo $precio->name; ?></td>
                      <td class="align-middle">$<? echo $precio->price; ?></td>
                      <td>
                        <a href="<? echo base_url(); ?>admin/editar_precio/?precio_id=<? echo $precio->id; ?>" class="btn btn-danger">Editar</a>

                        <a href="<? echo base_url(); ?>admin/precios/?action=delete&precio_id=<? echo $precio->id; ?>" class="btn btn-danger">Delete</a>
                      </td>
                    </tr>
                  <? } ?>
                <? } ?>
              </tbody>
            </table>
            <? if(isset($mensaje)){ ?>
              <div class="alert alert-danger" role="alert"><? echo $mensaje; ?></div>
            <? } ?>
            <?php if (isset($links)) { ?>
              <?php echo $links ?>
            <?php } ?>
          </div><!-- table-wrapper -->
        </div><!-- card -->

      </div><!-- sl-pagebody -->
      
