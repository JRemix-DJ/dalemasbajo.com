<div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->
        <input type="hidden" id="where" value="<?= $where ?>">
        <input type="hidden" id="user_id" value="">
        <input type="hidden" id="accion" value="<?= $accion ?>">
        <div class="top_btn"><a href="http://localhost/dalemasbajo.com/admin/nuevo_usuario/" class="btn btn-success">Añadir Nuevo</a></div>
          <div class="card pd-20">
            <form action="<?php echo base_url('admin/listar_usuarios/'); ?>" class="form-inline">
            <input type="text" name="s" class="form-control" placeholder="buscar por email" <?if(isset($_GET['s'])){ ?> value="<? echo $_GET['s']; ?>" <? } ?>>
              <input type="submit" value="Buscar" class="btn btn-primary">
            </form>
          </div>
        <div class="card pd-20 pd-sm-40">
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap text-center">
              <thead>
                <tr>
                  <th>Username</th>
                  <th>IP</th>
                  <th>Email</th>
                  <th>Fecha de Registro</th>
                  <th>Rol</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody id="total_descargas">
              </tbody>
            </table>
            <? if(isset($mensaje)){ ?>
              <div class="alert alert-danger" role="alert"><? echo $mensaje; ?></div>
            <? } ?>
          </div><!-- table-wrapper --><div class="paginacion"></div>
        </div><!-- card -->

      </div><!-- sl-pagebody -->