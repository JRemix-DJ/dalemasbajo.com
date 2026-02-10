

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <div class="form-layout">

            <? echo form_open_multipart(base_url().'products/edit_product'); ?>
            <div class="row mg-b-25">
              <div class="col-lg-8">
                <div class="form-group">
                  <label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="name" value="<? echo $producto->name; ?>" placeholder="Ingrese Nombre del producto">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-4">
                <div class="form-group">
                  <label class="form-control-label">Precio: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                      <select class="form-control" name="price" id="precio">
                        <option>Seleccione un precio</option>
                        <? foreach($precios as $precio){ ?>
                          <option value="<? echo $precio->price; ?>" <? if($producto->price==$precio->price){ echo 'selected'; } ?>><? echo $precio->price; ?></option>
                        <? } ?>
                      </select>
                </div>
              </div><!-- col-4 -->
            </div><!-- row -->
            <div class="row">
              <div class="col-md-8 hidden">
                <div class="form-group">
                  <label class="form-control-label">Descripción del producto: <span class="tx-danger">*</span></label>
                  <textarea name="description" id="" cols="30" rows="14" class="form-control"><? echo $producto->description; ?></textarea>
                </div>
              </div>
              <input type="hidden" name="paginationnumber" value="<? echo $_GET['paginationnumber']; ?>">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-control-label">ARTIST: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="artist" placeholder="Artista para el producto" value="<? echo $producto->artist; ?>">
                </div>
              </div>
              <div class="col-md-4">
                 <div class="form-group">
                  <label class="form-control-label">VERSION: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="version" placeholder="Version para el producto" value="<? echo $producto->version; ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-control-label">BPM: <span class="tx-danger">*</span></label>
                  <input type="text" class="form-control" name="bpm" placeholder="BPM para el producto" value="<? echo $producto->bpm; ?>">
                </div>
                
              </div>
              <div class="col-md-4"> 
                <div class="form-group">
                  <label class="form-control-label">Género: <span class="tx-danger">*</span></label>
                  <select name="gender_id" id="gender_id" class="form-control">
                    <option>Seleccione una Opción</option>
                     <? foreach($generos as $genero){ ?>
                      <option value="<? echo $genero->id; ?>" <? if($genero->id==$producto->gender_id){ echo "selected"; } ?>><? echo $genero->name; ?></option>
                    <? } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-control-label">Tipo de Producto: <span class="tx-danger">*</span></label>
                  <select name="product_type_id" id="product_type_id" class="form-control">
                    <option>Seleccione una Opción</option>
                    <? foreach($product_types as $product_type){ ?>
                      <option value="<? echo $product_type->id; ?>" <? if($product_type->id==$producto->product_type_id){ echo "selected"; } ?>><? echo $product_type->name; ?></option>
                    <? } ?>
                  </select>
                </div>
              </div>
              </div>
            </div>
            <? echo form_hidden('user_id', $producto->owner_id);?>
            <? echo form_hidden('product_id', $producto->id);?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Descargable: <span class="tx-danger">*</span></label>
                  <input type="file" name="descargable" class="form-control">
                  <div class="row">
                    <div class="col-md-4">
                       Subido Previamente
                    </div>
                    <? if($producto->product_type_id==3){ ?>
                      <video class="col-md-8" src="<? echo base_url().'assets/products/descargables/videos/'.$producto->descargable; ?>" controls></video>
                    <? }else{ ?>
                      <audio class="col-md-8" src="<? echo base_url().'assets/products/descargables/'.$producto->descargable; ?>" controls></audio>
                    <? } ?>
                  </div>
                </div>
              </div>
            
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Demo: <span class="tx-danger">*</span></label>
                  <input type="file" name="demo" class="form-control">
                  <div class="row">
                    <div class="col-md-4">
                        Subido Previamente
                    </div>
                    <? if($producto->product_type_id==3){ ?>
                      <video class="col-md-8" src="<? echo base_url().'assets/products/demos/videos/'.$producto->descargable; ?>" controls></video>
                    <? }else{ ?>
                    <audio class="col-md-8" src="<? echo base_url().'assets/products/demos/'.$producto->demo; ?>" controls></audio>
                    <? } ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-layout-footer">
              <button class="btn btn-info mg-r-5">Actualizar</button>
              <? if($producto->approved==0){ $aprobacion = "?aprobacion=1"; }else{ $aprobacion="";}?>
              <a class="btn btn-secondary" href="<? echo base_url('admin/listar_productos/').$aprobacion; ?>">Cancelar</a>
            </div><!-- form-layout-footer -->
            
            <? echo form_close(); ?>
            <?php echo validation_errors(); ?>
            <? if(isset($mensaje)){ ?>
              <div class="alert alert-success" role="alert"><? echo $mensaje; ?></div>
            <? } ?>
          </div><!-- form-layout -->
        </div><!-- card -->


      </div><!-- sl-pagebody -->