<? echo form_open_multipart(base_url().'admin/add_banner/'); ?>

    <div class="row mg-b-25">
        <div class="col-lg-8">
            <div class="form-group">
                <label class="form-control-label">Nombre: <span class="tx-danger">*</span></label>
                <input class="form-control" type="text" name="name" placeholder="Nombre del banner" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-control-label">Video del banner (MP4): <span class="tx-danger">*</span></label>
                <input type="file" name="video" class="form-control" accept="video/mp4,video/webm,video/ogg" required>
                <small class="text-muted">Se mostrará en loop y sin sonido.</small>
            </div>
        </div>
    </div>

    <div class="form-layout-footer">
        <button class="btn btn-info mg-r-5">Añadir</button>
        <a class="btn btn-secondary" href="<? echo base_url('admin/listar_banner/'); ?>">Cancelar</a>
    </div>

<? echo form_close(); ?>