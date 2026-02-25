<table id="datatable1" class="table display responsive nowrap text-center">
    <thead>
    <tr>
        <th>Name</th>
        <th>Video</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <? foreach($banners as $banner) { ?>
        <tr>
            <td class="align-middle"><? echo $banner->name; ?></td>

            <td class="align-middle" style="width:260px">
                <? if(!empty($banner->image)){ ?>
                    <video style="max-width:240px;border-radius:10px" muted autoplay loop playsinline>
                        <source src="<? echo base_url('assets/banners/'.$banner->image); ?>" type="video/mp4">
                    </video>
                <? } else { ?>
                    <span class="text-muted">Sin video</span>
                <? } ?>
            </td>

            <td class="align-middle">
                <a href="<? echo base_url(); ?>admin/editar_banner/?banner_id=<? echo $banner->id; ?>" class="btn btn-danger">Editar</a>
                <a href="<? echo base_url(); ?>admin/listar_banner/?action=delete&banner_id=<? echo $banner->id; ?>" class="btn btn-danger">Delete</a>
            </td>
        </tr>
    <? } ?>
    </tbody>
</table>