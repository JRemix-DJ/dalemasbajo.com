

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->
        
        <div class="card pd-20 pd-sm-40">
          <div class="form-layout">
            <? 
              if(isset($precio)){
                echo form_open_multipart(base_url().'admin/update_precio/'); 
              }else{
                echo form_open_multipart(base_url().'admin/add_precio/'); 
              }

            ?>
            <div class="row mg-b-25">
              <div class="col-lg-8">
                <? if(isset($precio)){ ?>
                  <input type="hidden" name="id" value="<? echo $precio->id; ?>">
                <? } ?>
                <div class="form-group">
                  <label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="name" value="<? if(isset($precio)) echo $precio->name; ?>" placeholder="Ingrese Nombre del producto">
                </div>
                <div class="form-group">
                  <label class="form-control-label">Precio: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="number" step="any" name="price" value="<? if(isset($precio)) echo $precio->price; ?>" placeholder="Precio. Centavos dividos con un punto">
                </div>
              </div><!-- col-4 -->
            </div><!-- row -->
            <div class="form-layout-footer">
              <? if(isset($precio)){ ?>
                <button class="btn btn-info mg-r-5">Actualizar</button>
              <? }else{ ?>
                <button class="btn btn-info mg-r-5">Añadir</button>
              <? } ?>
             <a class="btn btn-secondary" href="<? echo base_url('admin/precios/'); ?>">Cancelar</a>
            </div><!-- form-layout-footer -->
            
            <? echo form_close(); ?>
            <?php echo validation_errors(); ?>
            <? if(isset($mensaje)){ ?>
              <div class="alert alert-success" role="alert"><? echo $mensaje; ?></div>
            <? } ?>
          </div><!-- form-layout -->
        </div><!-- card -->


      </div><!-- sl-pagebody -->