<div class="sl-pagebody">
        <div class="sl-page-title">
          <h5><? echo $title; ?></h5>
          <p><? echo $description; ?></p>
        </div><!-- sl-page-title -->
<div class="top_btn"><a href="http://localhost/dalemasbajo.com/admin/nuevo_faq" class="btn btn-success">Añadir Nuevo</a></div>
        <div class="card pd-20 pd-sm-40">
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap text-center">
              <thead>
                <tr>
                  <th>Titulo</th>
                  <th>Contenido</th>
                  <th>URL</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <? foreach($faqs as $faq) { ?>
                  <tr>
                    <td class="align-middle"><? echo $faq->title; ?></td>
                    <td class="align-middle"><? echo $faq->content; ?></td>
                    <td class="align-middle"><? echo $faq->slug; ?></td>
                    <td class="align-middle">
                      <a href="<? echo base_url(); ?>admin/editar_faq/?faq_id=<? echo $faq->id; ?>" class="btn btn-danger">Editar</a>
                      <a href="<? echo base_url(); ?>admin/listar_faq/?action=delete&faq_id=<? echo $faq->id; ?>" class="btn btn-danger">Delete</a>
                    </td>
                  </tr>
                <? } ?>
              </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->

      </div><!-- sl-pagebody -->