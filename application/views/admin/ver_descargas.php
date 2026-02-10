<div class="sl-pagebody">
    <div class="sl-page-title">
        <h5><? echo $title; ?></h5>
        <p><? echo $description; ?></p>
    </div><!-- sl-page-title -->
    <div class="card pd-20 pd-sm-40">
        <div class="table-wrapper">
        <input type="hidden" id="where" value="">
        <input type="hidden" id="user_id" value="<?= $user_id ?>">
        <input type="hidden" id="accion" value="<?= $accion ?>">
            <table id="datatable1" class="table display responsive nowrap text-center">
                <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Artista</th>
                        <th>Fecha de compra</th>
                    </tr>
                </thead>
                <tbody id="total_descargas">
                </tbody>
            </table>
            
        </div><!-- table-wrapper --><div class="paginacion"></div>
    </div><!-- card -->
</div><!-- sl-pagebody -->