<div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->
        <div class="top_btn"><a href="https://dalemasbajo.com/admin/nuevo_genero/" class="btn btn-success">Añadir Nuevo</a></div>
        <div class="card pd-20 pd-sm-40">
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap text-center">
              <thead>
                <tr>
                  <th class="wd-25p">Nombre</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <? //$generos=(array) $generos; ?>
                <? foreach($generos as $genero) { ?>
                  <tr>
                    <td class="align-middle"><? echo $genero->name; ?></td>
                    <td>
                      <a href="<? echo base_url(); ?>admin/editar_genero/?gender_id=<? echo $genero->id; ?>" class="btn btn-danger">Editar</a>
                      <a href="<? echo base_url(); ?>admin/listar_generos/?action=delete&gender_id=<? echo $genero->id; ?>" class="btn btn-danger">Delete</a>
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