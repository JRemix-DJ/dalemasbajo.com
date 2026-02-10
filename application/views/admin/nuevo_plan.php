

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->
        
        <div class="card pd-20 pd-sm-40">
          <? if(isset($plan)){
              $name = $plan->name;
              $price = $plan->price;
              $description = $plan->description;
              $duration = $plan->duration;
              $activo = $plan->activated;
              $tokens = $plan->tokens;
              $tokens_video = $plan->tokens_video;
              $ilimitado_activo = $plan->ilimitado_activo;
              $ilimitado_dias = $plan->ilimitado_dias;
              $url_pago = !is_null($plan->url_pago) ? $plan->url_pago : '';
           }else{ 
              $name = "";
              $price = "";
              $description = "";
              $duration = "";
              $tokens = "";
              $tokens_video = "";
              $ilimitado_activo = 0;
              $ilimitado_dias = 0;
              $url_pago = "";
          } ?>
          <div class="form-layout">
          <? if(!isset($plan)){ ?>
            <? echo form_open_multipart(base_url().'admin/add_plan/'); ?>
          <? }else{ ?>
            <? echo form_open_multipart(base_url().'admin/update_plan/'); ?>
          <? } ?>
            <div class="row mg-b-25">
              <div class="col-lg-8">
                <div class="form-group">
                  <label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="name" value="<? echo $name; ?>" placeholder="Ingrese Nombre del plan">
                </div>
              </div><!-- col-4 -->
              <div class="col-md-2">
                <div class="form-group">
                  <label class="form-control-label">Precio: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="price" value="<? echo $price; ?>" placeholder="99.99">
                </div>
              </div>
             
             
            </div><!-- row -->
            <div class="row mg-b-25">
                <div class="col-lg-8">
                  <div class="form-group">
                    <label class="form-control-label">URL PAGO: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="url_pago" value="<? echo $url_pago; ?>" placeholder="Ingrese URL de pago">
                  </div>
                </div><!-- col-4 -->
              </div>
             <div class="row mg-b-25">
              <div class="col-lg-8">
                <div class="form-group">
                  <label class="form-control-label">Descripción: <span class="tx-danger">*</span></label>
                  <textarea name="description" class="form-control" id="" cols="30" rows="10"><? echo $description; ?></textarea>
                </div>
              </div><!-- col-4 -->
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-control-label">Duración (en días): <span class="tx-danger">*</span></label>
                  <input class="form-control" type="number" name="duration" value="<? echo $duration;  ?>" placeholder="30">
                </div>
                <div class="form-group">
                  <label class="form-control-label">Tokens: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="number" name="tokens" value="<? echo $tokens;  ?>" placeholder="30">
                </div>
                <div class="form-group">
                  <label class="form-control-label">Tokens Video: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="number" name="tokens_video" value="<? echo $tokens_video;  ?>" placeholder="30">
                </div>
                <? if(isset($plan)){ ?>
                  <input type="hidden" name="id" value="<? echo $plan->id; ?>">
                <? } ?>
                <? if(isset($plan)){ ?>
                  <label class="form-control-label">Activado <span class="tx-danger">*</span></label>
                  <select name="activated" id="" class="form-control">
                    <option value="1" <?php echo ($activo==1 ? 'selected': ''); ?>>Yes</option>
                    <option value="0" <?php echo ($activo==0 ? 'selected': ''); ?>>No</option>
                  </select>
                <? } ?>
              </div>
              <div class="row">
                  <div class="col-md-6">
                  <label for="" class="form-control-label">Activar Ilimitado</label>
                    <select name="ilimitado_activo" id="" class="form-control">
                      <option value="0" <?php echo ($ilimitado_activo==0 ? 'selected': ''); ?>>No</option>
                      <option value="1" <?php echo ($ilimitado_activo==1 ? 'selected': ''); ?>>Yes</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-control-label">Por cuantos días: <span class="tx-danger">*</span></label>
                    <input class="form-control" type="number" name="ilimitado_dias" value="<? echo $ilimitado_dias;  ?>" placeholder="30">
                  </div>
              </div>
            </div><!-- row -->
            <div class="form-layout-footer">
            <? if(isset($plan)){ ?>
              <button class="btn btn-info mg-r-5">Editar</button>
            <? }else{ ?>
              <button class="btn btn-info mg-r-5">Añadir</button>
            <? } ?>
              <a class="btn btn-secondary" href="<? echo base_url('admin/listar_planes/'); ?>">Cancelar</a>
            </div><!-- form-layout-footer -->
            
            <? echo form_close(); ?>
            <?php echo validation_errors(); ?>
            <? if(isset($mensaje)){ ?>
              <div class="alert alert-success" role="alert"><? echo $mensaje; ?></div>
            <? } ?>
          </div><!-- form-layout -->
        </div><!-- card -->


      </div><!-- sl-pagebody -->