<div id="ajaxArea" class="bg-slate-50 min-h-screen">

    <section class="album-header relative h-[250px] w-full overflow-hidden flex items-center justify-center text-center bg-gradient-to-r from-slate-900 to-[#0066FF]">

        <figure class="album-cover-wrap absolute inset-0 z-0 opacity-20 mix-blend-multiply bg-[url('<? echo base_url(); ?>images/default_cover.jpg')] bg-cover bg-center"></figure>

        <div class="container relative z-10 flex flex-col items-center">
            <div class="clearfix text-uppercase">
                <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight mb-2 drop-shadow-md font-heading">
                    DROPS EXCLUSIVOS
                </h1>
                <p class="text-blue-100 font-medium text-sm tracking-wide">VOCES, INTROS Y EFECTOS PARA DJS</p>
            </div>
        </div>
    </section>

    <section class="py-12">

        <div class="container mx-auto px-4 pb-24">

            <div class="mb-8">
                <? $this->load->view('search_box'); ?>
            </div>

            <div id="table-body-content" class="flex flex-col gap-2 transition-opacity duration-200">

                <? if(isset($products) && !empty($products)) {
                    foreach($products as $producto) {

                        // Lógica de acceso (Ilimitado / Tokens)
                        $tiene_acceso = false;
                        if($this->session->userdata('is_logued_in')) {
                            if($this->session->userdata('is_user_unlimited') || $this->session->userdata('role') == 1) {
                                $tiene_acceso = true;
                            } elseif($this->session->userdata('tokens') > 0) {
                                $tiene_acceso = true;
                            }

                            // Verificar si ya lo tiene comprado (usamos helper si existe, o lógica inline)
                            // Para la vista rápida asumimos lógica en el botón JS
                        }

                        // Formato de fecha
                        $fecha = date('d M, Y', strtotime($producto->time_approved));
                        ?>

                        <div class="group relative bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-primary/30 transition-all duration-200 p-3 md:p-4 flex items-center gap-3 md:gap-6">

                            <div class="hidden md:block w-24 text-right flex-shrink-0">
                                <span class="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-wider"><? echo $fecha; ?></span>
                            </div>

                            <div class="flex-shrink-0">
                                <button class="play_btn w-10 h-10 md:w-12 md:h-12 rounded-full bg-slate-50 text-primary group-hover:bg-primary group-hover:text-white flex items-center justify-center transition-all shadow-sm border border-slate-100 group-hover:border-primary group-hover:scale-105 active:scale-95"
                                        data-demo="<? echo base_url(); ?>assets/products/demos/<? echo $producto->demo; ?>"
                                        data-title="<? echo $producto->name; ?>"
                                        data-artist="DROP EXCLUSIVO"
                                        data-cover="<? echo base_url(); ?>images/icons/favicon.ico"
                                        data-id="<? echo $producto->id; ?>">
                                    <i class="fa fa-play pl-1 text-sm md:text-base"></i>
                                </button>
                            </div>

                            <div class="flex-grow min-w-0 flex flex-col justify-center">
                                <h3 class="text-sm md:text-base font-bold text-slate-800 truncate leading-tight group-hover:text-primary transition-colors">
                                    <? echo $producto->name; ?>
                                </h3>

                                <div class="flex items-center gap-2 mt-1">
                                    <? if(!empty($producto->version)){ ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    <? echo $producto->version; ?>
                                </span>
                                    <? } ?>

                                    <span class="md:hidden text-[10px] text-slate-400">• <? echo $fecha; ?></span>
                                </div>
                            </div>

                            <div class="flex-shrink-0 pl-2 border-l border-slate-100">
                                <? if($this->session->userdata('is_logued_in')){ ?>
                                    <button class="btn-smart-download w-10 h-10 rounded-lg flex items-center justify-center bg-white text-slate-600 border border-slate-200 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm"
                                            data-id="<? echo $producto->id; ?>"
                                            data-logged="1"
                                            data-access="<? echo $tiene_acceso ? 1 : 0; ?>"
                                            title="Descargar Drop">
                                        <i class="fa fa-download"></i>
                                    </button>
                                <? } else { ?>
                                    <button class="btn-smart-download w-10 h-10 rounded-lg flex items-center justify-center bg-slate-50 text-slate-400 border border-slate-200 hover:bg-primary hover:text-white hover:border-primary transition-all"
                                            data-id="<? echo $producto->id; ?>"
                                            data-logged="0"
                                            data-access="0"
                                            title="Ingresa para descargar">
                                        <i class="fa fa-lock"></i>
                                    </button>
                                <? } ?>
                            </div>

                        </div>
                    <? }} else { ?>
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4 text-slate-300">
                            <i class="fa-solid fa-music text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-700">No hay drops disponibles</h3>
                        <p class="text-sm text-slate-500 max-w-xs mx-auto">Intenta buscar con otros términos o regresa más tarde.</p>
                    </div>
                <? } ?>

            </div>

            <div class="mt-10 flex justify-center">
                <div class="pagination-modern" id="pagination-container">
                    <?php if (isset($links)) { ?>
                        <?php echo $links ?>
                    <?php } ?>
                </div>
            </div>
        </div>

    </section>
</div>

<script>
    window.addEventListener('load', function() {
        $(document).ready(function() {
            $(document).on('click', '#pagination-container a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                if(!url || url === '#' || url === '') return;

                $('#table-body-content').addClass('opacity-50 pointer-events-none');

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if(response.status === 'success') {
                            // Inyectamos el HTML de las filas sin tabla
                            $('#table-body-content').html(response.html_table);
                            $('#pagination-container').html(response.html_pagination);

                            window.history.pushState({path: url}, '', url);
                            $('html, body').animate({ scrollTop: $("#table-body-content").offset().top - 150 }, 500);
                        }
                    },
                    complete: function() {
                        $('#table-body-content').removeClass('opacity-50 pointer-events-none');
                    }
                });
            });
        });
    });
</script>