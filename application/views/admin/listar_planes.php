<div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->
        <div class="top_btn"><a href="<? echo base_url(); ?>admin/nuevo_plan/" class="btn btn-success">Añadir Nuevo</a></div>
        <div class="card pd-20 pd-sm-40">
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap text-center">
              <thead>
                <tr>
                  <th class="wd-25p">Nombre</th>
                  <th>Precio</th>
                  <th>Duración (dias)</th>
                  <th>Tokens Audio</th>
                  <th>Tokens Video</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <? //$generos=(array) $generos; ?>
                <? foreach($plans as $plan) { ?>
                  <tr>
                    <td class="align-middle"><? echo $plan->name; ?></td>
                    <td class="align-middle"><? echo $plan->price; ?></td>
                    <td class="align-middle"><? echo $plan->duration; ?></td>
                    <td class="align-middle"><? echo $plan->tokens; ?></td>
                    <td class="align-middle"><? echo $plan->tokens_video; ?></td>
                    <td>
                      <? if($plan->activated){ ?>
                        <a href="<? echo base_url(); ?>admin/listar_planes/?action=desactivar&plan_id=<? echo $plan->id; ?>" class="btn btn-danger">Desactivar</a>
                      <? }else{ ?>
                        <a href="<? echo base_url(); ?>admin/listar_planes/?action=activar&plan_id=<? echo $plan->id; ?>" class="btn btn-success">Activar</a>
                      <? } ?>
                      <a href="<? echo base_url(); ?>admin/editar_plan/?plan_id=<? echo $plan->id; ?>" class="btn btn-danger">Editar</a>
                      <a href="<? echo base_url(); ?>admin/listar_planes/?action=delete&plan_id=<? echo $plan->id; ?>" class="btn btn-danger">Delete</a>
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