<div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->
        <div class="top_btn"><a href="https://dalemasbajo.com/admin/nuevo_banner" class="btn btn-success">Añadir Nuevo</a></div>
        <div class="card pd-20 pd-sm-40">
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap text-center">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Image</th>
                  <th>Url</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <? foreach($banners as $banner) { ?>
                  <tr>
                    <td class="align-middle"><? echo $banner->name; ?></td>
                    <td class="align-middle"><img src="<? echo base_url(); ?>images/banners/<? echo $banner->image; ?>" alt=""></td>
                   
                    <td class="align-middle"><? echo $banner->url; ?></td>
                   
                    <td class="align-middle">
                      <a href="<? echo base_url(); ?>admin/editar_banner/?banner_id=<? echo $banner->id; ?>" class="btn btn-danger">Editar</a>
                      <a href="<? echo base_url(); ?>admin/listar_banner/?action=delete&banner_id=<? echo $banner->id; ?>" class="btn btn-danger">Delete</a>
                    </td>
                  </tr>
                <? } ?>
              </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->

      </div><!-- sl-pagebody -->