<div class="bg-slate-50 min-h-screen font-sans">

    <section class="relative h-[500px] w-full overflow-hidden mb-12 group">
        <div class="absolute inset-0 z-0">
            <video class="w-full h-full object-cover" autoplay muted loop playsinline>
                <source src="<? echo base_url('assets/new_video.mp4'); ?>" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-slate-900/60 mix-blend-multiply"></div>
        </div>

        <div class="relative z-10 container mx-auto px-4 h-full flex flex-col justify-center items-center text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white tracking-tight mb-4 drop-shadow-lg">
                Premium Monthly<br>
                <span class="text-primary text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">
                    Subscription
                </span>
            </h1>
            <p class="text-lg text-slate-200 mb-8 max-w-2xl font-light">
                Unlimited access to exclusive DJ Remixes
            </p>
            <a href="<? echo base_url('planes'); ?>" class="px-8 py-4 bg-primary hover:bg-blue-600 text-white font-bold rounded-full transition-all transform hover:scale-105 shadow-[0_0_20px_rgba(37,99,235,0.5)] flex items-center gap-2">
                JOIN NOW <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <div class="container mx-auto px-4 pb-20">

        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                    <span class="bg-blue-100 p-2 rounded-full flex items-center justify-center w-8 h-8">
                        <i class="fa fa-arrow-up text-primary text-sm"></i>
                    </span> Trending Now
                </h2>
                <a href="<? echo base_url('audios/trending'); ?>" class="text-sm text-primary font-medium hover:underline">See all</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <?
                $loop_trending = isset($trending_audios) ? $trending_audios : (isset($products) ? array_slice($products, 0, 5) : []);
                if(!empty($loop_trending)) {
                    foreach($loop_trending as $audio) {
                        $img = base_url().'images/default_cover.jpg';
                        if(isset($audio->featured_image) && $audio->featured_image != '') $img = base_url().'uploads/covers/'.$audio->featured_image;
                        elseif(isset($audio->cover) && $audio->cover != '') $img = base_url().'uploads/covers/'.$audio->cover;

                        $title = isset($audio->name) ? $audio->name : (isset($audio->title) ? $audio->title : 'Unknown');
                        $artist = isset($audio->artist) ? $audio->artist : 'Unknown Artist';
                        $preview = isset($audio->demo) ? $audio->demo : (isset($audio->preview) ? $audio->preview : '');
                        ?>
                        <div class="bg-white rounded-2xl p-3 shadow-sm hover:shadow-xl transition-all border border-slate-100 group">
                            <div class="relative aspect-square rounded-xl overflow-hidden mb-3">
                                <img src="<? echo $img; ?>" alt="<? echo $title; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                                    <a href="javascript:;" class="play_btn w-12 h-12 bg-white rounded-full flex items-center justify-center text-primary hover:scale-110 transition-transform"
                                       data-id="<? echo $audio->id; ?>"
                                       data-preview="<? echo base_url().'uploads/previews/'.$preview; ?>"
                                       data-title="<? echo $title; ?>"
                                       data-artist="<? echo $artist; ?>">
                                        <i class="fa fa-play pl-1"></i>
                                    </a>
                                </div>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm truncate"><? echo $title; ?></h3>
                            <p class="text-xs text-slate-500 truncate"><? echo $artist; ?></p>
                        </div>
                    <?  }
                } else { echo '<p class="col-span-full text-center text-gray-400">No trendings now</p>'; } ?>
            </div>
        </div>

        <div class="flex items-center justify-between mb-6 mt-8">
            <h2 class="text-2xl font-bold text-slate-900">Latest Remixes</h2>
            <div id="table-loader" class="hidden text-primary">
                <i class="fa fa-circle-o-notch fa-spin"></i> Cargando...
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden relative">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                        <th class="p-4 font-semibold w-24">Date</th>
                        <th class="p-4 font-semibold w-16 text-center">Play</th>
                        <th class="p-4 font-semibold">Song Title</th>
                        <th class="p-4 font-semibold">Version</th>
                        <th class="p-4 font-semibold">Remixer</th>
                        <th class="p-4 font-semibold w-20">BPM</th>
                        <th class="p-4 font-semibold w-32">Genre</th>
                        <th class="p-4 font-semibold w-24 text-center">Download</th>
                    </tr>
                    </thead>

                    <tbody id="table-body-content" class="divide-y divide-slate-100 text-sm text-slate-700 transition-opacity duration-200">
                    <?
                    // Carga inicial normal
                    $this->load->view('table_products', ['products' => $products]);
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            <div class="pagination-modern" id="pagination-container">
                <? echo $this->pagination->create_links(); ?>
            </div>
        </div>

    </div>
</div>

<style>
    /* Estilos de paginación */
    .pagination-modern ul.pagination {
        display: flex !important; flex-direction: row !important; gap: 8px; list-style: none; padding: 0; margin: 0; flex-wrap: wrap; justify-content: center;
    }
    .pagination-modern ul.pagination li { display: inline-block; margin: 0; }
    .pagination-modern ul.pagination li a,
    .pagination-modern ul.pagination li span {
        display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 8px;
        background: white; border: 1px solid #e2e8f0; color: #64748b; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 0.2s; cursor: pointer;
    }
    .pagination-modern ul.pagination li a:hover { background: #f1f5f9; color: #007bff; border-color: #007bff; }

    /* ESTILO PÁGINA ACTIVA */
    .pagination-modern ul.pagination li.active span {
        background: #007bff !important; color: white !important; border-color: #007bff !important; pointer-events: none; box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3);
    }
</style>

<script>
    window.addEventListener('load', function() {
        $(document).ready(function() {
            $(document).on('click', '#pagination-container a', function(e) {
                e.preventDefault();

                var url = $(this).attr('href');

                if(!url || url === '#' || url === '') return;

                $('#table-loader').removeClass('hidden');
                $('#table-body-content').addClass('opacity-50');

                // Llamada AJAX
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if(response.status === 'success') {
                            $('#table-body-content').html(response.html_table);

                            $('#pagination-container').html(response.html_pagination);

                            window.history.pushState({path: url}, '', url);

                            $('html, body').animate({
                                scrollTop: $("#table-body-content").offset().top - 150
                            }, 500);
                        }
                    },
                    error: function() {
                        console.error('Error en carga AJAX');
                        window.location.href = url;
                    },
                    complete: function() {
                        $('#table-loader').addClass('hidden');
                        $('#table-body-content').removeClass('opacity-50');
                    }
                });
            });
        });
    });
</script>