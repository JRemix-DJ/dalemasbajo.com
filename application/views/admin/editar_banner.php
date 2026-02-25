<? echo form_open_multipart(base_url() . 'admin/update_banner/'); ?>

    <div class="row mg-b-25">
        <div class="col-lg-8">
            <div class="form-group">
                <label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="name" value="<? echo $banner->name; ?>" required>
            </div>
        </div>
    </div>

<? echo form_hidden('id', $banner->id);?>

    <div class="row">
        <div class="col-md-4">
            <? if(!empty($banner->image)){ ?>
                <video style="max-width:100%;border-radius:12px" muted autoplay loop playsinline>
                    <source src="<? echo base_url('assets/banners/'.$banner->image); ?>" type="video/mp4">
                </video>
            <? } ?>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="form-control-label">Reemplazar video (MP4)</label>
                <input type="file" name="video" class="form-control" accept="video/mp4,video/webm,video/ogg">
                <small class="text-muted">Si no subes nada, se mantiene el video actual.</small>
            </div>
        </div>
    </div>

    <div class="form-layout-footer">
        <button class="btn btn-info mg-r-5">Actualizar</button>
        <a class="btn btn-secondary" href="<? echo base_url('admin/listar_banner/'); ?>">Cancelar</a>
    </div>

<? echo form_close(); ?>