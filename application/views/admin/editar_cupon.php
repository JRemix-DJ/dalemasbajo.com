

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <div class="form-layout">
            <? echo form_open_multipart(base_url().'admin/edit_cupon'); ?>
            <div class="row mg-b-25">
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Descripción: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="description" value="<? echo $cupon->description; ?>" placeholder="Description">
                </div>
              </div><!-- col-4 -->
              <div class="col-lg-12">
                <div class="form-group">
                  <label class="form-control-label">Código: <span class="tx-danger">*</span></label>
                  <input name="code" id="" cols="30" rows="10" class="form-control" value="<? echo $cupon->code; ?>">
                </div>
              </div><!-- col-4 -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-control-label">Descuento: <span class="tx-danger">*</span></label>
                  <input class="form-control" type="text" name="discount" step="any" value="<?  echo $cupon->discount; ?>" placeholder="Descuento en numeros ejemplo 15 (para 15%)">
                </div>
              </div><!-- col-4 -->

              <div class="col-md-6">
                <div class="form-group row  ">
                    <div class="col-md-6">
                        <label class="form-control-label">Tipo: <span class="tx-danger">*</span></label>
                        <select name="type" class="form-control" id="tipo">
                            <option value="1" <? if($cupon->type==1){ echo 'selected'; } ?>>Simple</option>
                            <option value="2" <? if($cupon->type==2){ echo 'selected'; } ?>>Venta Mayor a</option>
                        </select>
                    </div>
                    <div class="col-md-6" id="pagominimo" <? if($cupon->type!=2){ ?> style="display: none"<? } ?>>
                    <label id="label-number" style="">Pago Mínimo</label>
                    <input type="number" name="parameter" id="number" class="form-control" value="<? echo $cupon->parameter; ?>" style="">
                    </div>
                </div>
              </div><!-- col-4 -->
            </div><!-- row -->
            <? echo form_hidden('id', $cupon->id);?>
            <div class="form-layout-footer">
              <button class="btn btn-info mg-r-5">Actualizar</button>
              <a class="btn btn-secondary" href="<? echo base_url('admin/cupones'); ?>">Cancelar</a>
            </div><!-- form-layout-footer -->
            
            <? echo form_close(); ?>
            <?php echo validation_errors(); ?>
            <? if(isset($mensaje)){ ?>
              <div class="alert alert-success" role="alert"><? echo $mensaje; ?></div>
            <? } ?>
          </div><!-- form-layout -->
        </div><!-- card -->


      </div><!-- sl-pagebody -->