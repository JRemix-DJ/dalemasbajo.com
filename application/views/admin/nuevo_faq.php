

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <div class="form-layout">
            <? echo form_open_multipart(base_url().'admin/add_faq'); ?>
            <div class="row mg-b-25">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Titulo: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="title" value="<? ?>" placeholder="Ingrese Titulo">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Contenido: <span class="tx-danger">*</span></label>
                  <textarea name="content" id="" cols="30" rows="10" class="form-control"></textarea>
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">URL: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="slug" step="any" value="<?   ?>" placeholder="Ingrese Slug de URL">
                </div>
              </div><!-- col-4 -->
            </div><!-- row -->
            
            <div class="form-layout-footer">
              <button class="btn btn-info mg-r-5">Añadir</button>
              <a class="btn btn-secondary" href="<? echo base_url('admin/listar_faq/'); ?>">Cancelar</a>
            </div><!-- form-layout-footer -->
            
            <? echo form_close(); ?>
            <?php echo validation_errors(); ?>
            <? if(isset($mensaje)){ ?>
              <div class="alert alert-success" role="alert"><? echo $mensaje; ?></div>
            <? } ?>
          </div><!-- form-layout -->
        </div><!-- card -->


      </div><!-- sl-pagebody -->