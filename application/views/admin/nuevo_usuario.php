

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <div class="form-layout">
            <? echo form_open_multipart(base_url().'users/new_user'); ?>
            <div class="row mg-b-25">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Username: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="username" value="<? ?>" placeholder="Ingrese Username">
                </div>
              </div><!-- col-4 -->
            </div><!-- row -->
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label class="form-control-label">Email: <span class="tx-danger">*</span></label>
                  <input type="text" name="email" class="form-control" placeholder="Ingrese un correo">
                </div>
                <div class="form-group">
                  <label class="form-control-label">Porcentaje: <span class="tx-danger">*</span></label>
                  <input type="number" name="percentage" class="form-control" step="5" placeholder="Porcentaje del 0 a 100 si es un dj.">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-control-label">País: <span class="tx-danger">*</span></label>
                  <select  name="country_id" id="country_id" class="form-control">
                    <option>Seleccione una opción</option>
                    <? foreach($paises as $pais){ ?>
                      <option value="<? echo $pais->code; ?>"><? echo $pais->name; ?></option>
                    <? } ?>
                  </select>
                </div>
                
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Rol: <span class="tx-danger">*</span></label>
                  <select class="form-control" name="role_id">
                    <option>Seleccione una opción</option>
                    <? foreach($roles as $rol){ ?>
                      <option value="<? echo $rol->id; ?>"><? echo $rol->name; ?></option>
                    <? } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Password: <span class="tx-danger">*</span></label>
                  <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                  <label class="form-control-label">Repetir Password: <span class="tx-danger">*</span></label>
                  <input type="password" class="form-control" name="passwordrepeat">
                </div>
              </div>
            </div>
            <div class="form-layout-footer">
              <button class="btn btn-info mg-r-5">Añadir</button>
              <a class="btn btn-secondary" href="<? echo base_url('admin/listar_usuarios/'); ?>">Cancelar</a>
            </div><!-- form-layout-footer -->
            
            <? echo form_close(); ?>
            <?php echo validation_errors(); ?>
            <? if(isset($mensaje)){ ?>
              <div class="alert alert-success" role="alert"><? echo $mensaje; ?></div>
            <? } ?>
          </div><!-- form-layout -->
        </div><!-- card -->


      </div><!-- sl-pagebody -->