

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <div class="form-layout">
            <? echo form_open_multipart(base_url().'admin/add_banner/'); ?>
            <div class="row mg-b-25">
              <div class="col-lg-8">
                <div class="form-group">
                  <label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="name" value="<? ?>" placeholder="Ingrese Nombre del producto">
                </div>
              </div><!-- col-4 -->
            </div><!-- row -->
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label class="form-control-label">URL: <span class="tx-danger">*</span></label>
                  <input name="url" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Imagen del banner: <span class="tx-danger">*</span></label>
                  <input type="file" name="image" class="form-control">
                </div>
              </div>
            </div>
            <div class="form-layout-footer">
              <button class="btn btn-info mg-r-5">Añadir</button>
              <a class="btn btn-secondary" href="<? base_url('admin/listar_banner/'); ?>">Cancelar</a>
            </div><!-- form-layout-footer -->
            
            <? echo form_close(); ?>
            <?php echo validation_errors(); ?>
            <? if(isset($mensaje)){ ?>
              <div class="alert alert-success" role="alert"><? echo $mensaje; ?></div>
            <? } ?>
          </div><!-- form-layout -->
        </div><!-- card -->


      </div><!-- sl-pagebody -->