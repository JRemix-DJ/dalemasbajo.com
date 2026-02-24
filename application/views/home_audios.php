<div class="bg-slate-50 min-h-screen font-sans">

    <section class="py-10 md:py-14">
        <div class="container mx-auto px-4">
            <div id="heroBanner"
                 class="relative w-full overflow-hidden rounded-[28px] border border-slate-200 bg-slate-900 shadow-xl"
                 data-base="<?php echo base_url('assets/banners/'); ?>"
                 data-banners='<?php echo json_encode($banners ?? [], JSON_UNESCAPED_SLASHES); ?>'>

                <!-- VIDEO LAYER (JS inyecta el <video> aquí) -->
                <div class="absolute inset-0" data-video-layer></div>

                <!-- overlays -->
                <div class="absolute inset-0 bg-slate-900/50 pointer-events-none"></div>
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(255,255,255,0.06),rgba(0,0,0,0.65))] pointer-events-none"></div>

                <!-- CONTENIDO -->
                <div class="relative z-10 flex min-h-[420px] md:min-h-[520px] items-center justify-center px-6 py-12">
                    <div class="w-full max-w-3xl rounded-2xl bg-white/10 backdrop-blur-xl shadow-2xl px-6 py-10 md:px-12 md:py-12 text-center">
                        <h1 class="text-3xl md:text-6xl font-extrabold tracking-tight text-white drop-shadow-sm">
                            Premium Monthly Subscription
                        </h1>

                        <p class="mt-3 text-sm md:text-lg text-white/80 font-medium">
                            Unlimited access to exclusive DJ remixes
                        </p>

                        <a href="<?php echo base_url('planes'); ?>"
                           class="mt-8 inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-primary text-white font-bold transition-all duration-200 hover:scale-[1.03] hover:bg-blue-600 shadow-lg shadow-blue-500/30">
                            JOIN NOW <i class="fa fa-arrow-right text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- DOTS -->
                <div class="absolute bottom-4 left-0 right-0 z-20 flex items-center justify-center gap-2" data-dots></div>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 pb-20">

        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                    <span class="bg-blue-100 p-2 rounded-full flex items-center justify-center w-8 h-8">
                        <i class="fa fa-arrow-trend-up text-primary text-sm"></i>
                    </span> Trending Now
                </h2>
                <a href="<? echo base_url('/search/?sname=&sgenero=&sremixers='); ?>" class="text-sm text-primary font-medium hover:underline">See all</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <?
                $loop_trending = isset($trending_audios) ? $trending_audios : (isset($products) ? array_slice($products, 0, 5) : []);

                if(!empty($loop_trending)) {
                    foreach($loop_trending as $audio) {
                        // Imagen desde cover_mp3
                        $img = base_url('audios/cover_mp3/' . $audio->id);

                        $title = isset($audio->name) ? $audio->name : (isset($audio->title) ? $audio->title : 'Unknown');
                        $artist = isset($audio->artist) ? $audio->artist : 'Unknown Artist';
                        $preview = isset($audio->demo) ? $audio->demo : (isset($audio->preview) ? $audio->preview : '');
                        ?>
                        <div class="bg-white rounded-2xl p-3 shadow-sm hover:shadow-xl transition-all border border-slate-100 group">
                            <div class="relative aspect-square rounded-xl overflow-hidden mb-3 bg-gray-100">
                                <img src="<? echo $img; ?>"
                                     alt="<? echo $title; ?>"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     onerror="this.onerror=null;this.src='<? echo base_url(); ?>images/default_cover.jpg';">

                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                                    <a href="javascript:;" class="play_btn w-12 h-12 bg-white rounded-full flex items-center justify-center text-primary hover:scale-110 transition-transform"
                                       data-id="<? echo $audio->id; ?>"
                                       data-demo="<? echo base_url().'assets/products/demos/'.$preview; ?>"
                                       data-cover="<? echo $img; ?>"
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

        <div class="flex items-center justify-between mb-4 mt-8">
            <h2 class="text-2xl font-bold text-slate-900">Latest Remixes</h2>
            <div id="table-loader" class="hidden text-primary">
                <i class="fa fa-circle-o-notch fa-spin"></i> Cargando...
            </div>
        </div>

        <form action="<? echo base_url('search/'); ?>" method="GET" class="mb-6">
            <div class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-grow group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fa fa-search text-slate-400 group-focus-within:text-primary transition-colors"></i>
                    </div>
                    <input type="text" name="sname" id="sname"
                           class="block w-full p-3 pl-10 text-sm text-slate-900 border border-slate-200 rounded-lg bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                           placeholder="Search for remix, artist or title..." autocomplete="off">
                </div>

                <div class="w-full md:w-48">
                    <div class="relative">
                        <select name="sgenero" id="sgenero" class="block w-full p-3 text-sm text-slate-700 border border-slate-200 rounded-lg bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none appearance-none cursor-pointer">
                            <option value="">Genre</option>
                            <? if(isset($generos)){ foreach($generos as $g) { ?>
                                <option value="<? echo $g->id; ?>"><? echo $g->name; ?></option>
                            <? }} ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="fa fa-angle-down text-slate-400"></i>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-48">
                    <div class="relative">
                        <select name="sremixers" id="sremixers" class="block w-full p-3 text-sm text-slate-700 border border-slate-200 rounded-lg bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none appearance-none cursor-pointer">
                            <option value="">Remixer</option>
                            <? if(isset($djs)){ foreach($djs as $dj) { ?>
                                <option value="<? echo $dj->id; ?>"><? echo $dj->username; ?></option>
                            <? }} ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="fa fa-angle-down text-slate-400"></i>
                        </div>
                    </div>
                </div>

                <button type="submit" class="p-3 px-6 text-white bg-primary hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm text-center transition-all shadow-md shadow-blue-500/20">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden relative">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                        <th class="p-4 font-semibold w-24">Date</th>
                        <th class="p-4 font-semibold w-16 text-center">Play</th>
                        <th class="p-4 font-semibold">Song Title</th>
                        <th class="p-4 font-semibold">Version</th>
                        <th class="p-4 font-semibold">Artist</th>
                        <th class="p-4 font-semibold">Remixer</th>
                        <th class="p-4 font-semibold w-20">BPM</th>
                        <th class="p-4 font-semibold w-32">Genre</th>
                        <th class="p-4 font-semibold w-24 text-center">Download</th>
                    </tr>
                    </thead>

                    <tbody id="table-body-content" class="divide-y divide-slate-100 text-sm text-slate-700 transition-opacity duration-200">
                    <?
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
    /* Estilo base para quitar apariencia por defecto */
    #volume-slider {
        -webkit-appearance: none;
        background: linear-gradient(to right, #2563EB 0%, #2563EB 100%, #e2e8f0 100%, #e2e8f0 100%);
    }
    /* El puntito del slider */
    #volume-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        height: 12px;
        width: 12px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #2563EB;
        box-shadow: 0 1px 3px rgba(0,0,0,0.3);
        margin-top: -4px; /* Centrar verticalmente si es necesario */
    }
    /* Firefox */
    #volume-slider::-moz-range-thumb {
        height: 12px;
        width: 12px;
        border: none;
        border-radius: 50%;
        background: #2563EB;
    }

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
    (function () {
        const root = document.getElementById('heroBanner');
        if (!root) return;

        const basePath = (root.dataset.base || '').replace(/\/?$/, '/');
        let banners = [];
        try {
            banners = JSON.parse(root.dataset.banners || '[]') || [];
        } catch (e) {
            banners = [];
        }

        const videoLayer = root.querySelector('[data-video-layer]');
        const dotsWrap = root.querySelector('[data-dots]');
        let idx = 0;
        let currentVideo = null;

        function makeDot(active) {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'h-2.5 w-2.5 rounded-full transition-all ' + (active ? 'bg-white w-6' : 'bg-white/40 hover:bg-white/70');
            return b;
        }

        function renderDots() {
            if (!dotsWrap) return;
            dotsWrap.innerHTML = '';
            if (banners.length <= 1) return;

            banners.forEach((_, i) => {
                const dot = makeDot(i === idx);
                dot.addEventListener('click', () => go(i));
                dotsWrap.appendChild(dot);
            });
        }

        function mountVideo() {
            if (!videoLayer) return;

            videoLayer.innerHTML = '';
            const b = banners[idx];

            // fallback si no hay banners
            const src = b && b.image ? (basePath + b.image) : "<?php echo base_url('assets/new_video.mp4'); ?>";

            const v = document.createElement('video');
            v.className = 'h-full w-full object-cover';
            v.autoplay = true;
            v.muted = true;
            v.playsInline = true;
            v.loop = (banners.length <= 1);

            const s = document.createElement('source');
            s.src = src;
            s.type = 'video/mp4';

            v.appendChild(s);

            v.addEventListener('ended', () => next());

            v.addEventListener('canplay', () => {
                v.play().catch(() => {});
            });

            videoLayer.appendChild(v);
            currentVideo = v;
        }

        function next() {
            if (!banners.length) return;
            idx = (idx + 1) % banners.length;
            mountVideo();
            renderDots();
        }

        function go(i) {
            if (!banners.length) return;
            idx = i;
            mountVideo();
            renderDots();
        }

        // init
        mountVideo();
        renderDots();
    })();
</script>