

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <div class="form-layout">
            <? echo form_open_multipart(base_url().'/users/editar_perfil'); ?>
            <div class="row mg-b-25">
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="firstname" value="<? echo $user_info->first_name;?>" placeholder="Ingrese Nombre">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Apellido: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="lastname" value="<? echo $user_info->last_name;?>" placeholder="Ingrese Apellido">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Email: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="email" name="email" value="<? echo $user_info->email;?>" placeholder="Ingrese Correo electrónico">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Username: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="username" value="<? echo $user_info->username;?>" placeholder="Ingrese Nombre de Usuario">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-8">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Dirección: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="address" value="<? echo $user_info->address; ?>" placeholder="Ingrese Dirección">
                </div>
              </div><!-- col-8 -->
              <div class="col-lg-8">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">Ciudad: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="city" value="<? echo $user_info->city; ?>" placeholder="Ingrese Ciudad">
                </div>
              </div><!-- col-8 -->
              <div class="col-lg-4">
                <div class="form-group mg-b-10-force">
                  <label class="form-control-label">País: <span class="tx-danger">*</span></label>
                  <select class="form-control select2" name="country" data-placeholder="Choose country">
                    <option>Seleccione una opción</option>
                    <? foreach($paises as $pais){ ?>
                      <option value="<? echo $pais->code; ?>" <? if($user_info->country_id==$pais->code){ echo 'selected'; } ?>><? echo $pais->name; ?></option>
                    <? } ?>
                  </select>
                </div>
              </div><!-- col-4 -->
            </div><!-- row -->
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Teléfono</label>
                  <input type="text" class="form-control" name="phone" value="<? echo $user_info->phone; ?>" placeholder="Ingrese teléfono">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-3 justify-content-center align-items-center align-self-center text-center align-content-center">
                    <img src="<? echo base_url().'images/users/profile_img/'.$user_info->profile_img; ?>" alt="">
                  </div>
                  <div class="col-md-9">  
                    <div class="form-group">
                      <label class="form-label">Imagen de Perfil</label>
                      <input type="file" class="form-control" name="profile_img" value="<? echo $user_info->profile_img; ?>" placeholder="Ingrese teléfono">
                      <small id="fileHelp" class="form-text text-muted">Actualmente: <? echo $user_info->profile_img; ?></small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php echo validation_errors(); ?>
           
            <? if(isset($mensaje)){ ?>
              <div class="alert alert-success" role="alert"><? echo $mensaje; ?></div>
            <? } ?>
            <div class="form-layout-footer">
              <button class="btn btn-info mg-r-5">Actualizar</button>
              <button class="btn btn-secondary">Cancelar</button>
            </div><!-- form-layout-footer -->
            <? echo form_close(); ?>
          </div><!-- form-layout -->
        </div><!-- card -->


      </div><!-- sl-pagebody -->