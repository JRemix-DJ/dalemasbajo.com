<div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->
        <div class="top_btn"><a href="http://localhost/dalemasbajo.com/admin/nuevo_usuario/" class="btn btn-success">Añadir Nuevo</a></div>
        <div class="card pd-20 pd-sm-40">
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap text-center">
              <thead>
                <tr>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Fecha de Registro</th>
                  <th>Rol</th>
                  <th>Porcentaje</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <? foreach($users as $user) { ?>
                  <tr>
                    <td class="align-middle"><? echo $user->username; ?></td>
                    <td class="align-middle"><? echo $user->email; ?></td>
                    <td class="align-middle"><? $fecha=strtotime($user->registered_on); echo date('d-m-Y', $fecha); ?></td>
                   
                    <td class="align-middle">
                      <? //echo $user->role_id; ?>
                        <? 

                        $key = array_search($user->role_id, array_column($roles, 'id'));

                        echo $roles[$key]->name;
                    ?>
                      </td>
                      <td>
                        <? echo $user->percentage; ?>
                      </td>
                    <td class="align-middle">
                    <a href="<? echo base_url(); ?>admin/ver_descargar/?user_id=<? echo $user->id; ?>" class="btn btn-info">Descargas</a>
                      <a href="<? echo base_url(); ?>admin/editar_usuario/?user_id=<? echo $user->id; ?>" class="btn btn-danger">Editar</a>
                      <a href="<? echo base_url(); ?>admin/listar_djs/?action=delete&user_id=<? echo $user->id; ?>" class="btn btn-danger">Delete</a>
                    </td>
                  </tr>
                <? } ?>
              </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->

      </div><!-- sl-pagebody -->