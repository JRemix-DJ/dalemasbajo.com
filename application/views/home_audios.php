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

<div id="music-player-bar" class="fixed bottom-0 left-0 w-full bg-white/95 backdrop-blur-md border-t border-slate-200 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] z-50 transform translate-y-full transition-transform duration-500 ease-in-out">

    <div class="container mx-auto px-4 py-3 h-24 md:h-20 flex items-center justify-between gap-4">

        <div class="flex items-center gap-4 w-1/4 min-w-[140px] md:min-w-[200px]">
            <div class="relative w-12 h-12 md:w-14 md:h-14 rounded-lg overflow-hidden shadow-sm flex-shrink-0 bg-slate-100">
                <img id="player-cover" src="" alt="Cover" class="w-full h-full object-cover">
            </div>
            <div class="overflow-hidden hidden sm:block">
                <h4 id="player-title" class="font-bold text-slate-900 text-sm truncate leading-tight">Selecciona canción</h4>
                <p id="player-artist" class="text-xs text-slate-500 truncate mt-0.5">DALE MAS BAJO</p>
            </div>
        </div>

        <div class="flex flex-col items-center justify-center flex-1 max-w-2xl w-full">

            <div class="flex items-center gap-6 mb-1">
                <button id="skip-back-btn" class="text-slate-400 hover:text-slate-600 transition-colors" title="-10 segundos">
                    <i class="fa-solid fa-rotate-left text-lg"></i>
                </button>

                <button id="player-play-btn" class="w-10 h-10 bg-primary hover:bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg shadow-blue-500/30 transition-all transform hover:scale-105 active:scale-95">
                    <i class="fa fa-play pl-1"></i>
                </button>

                <button id="skip-fwd-btn" class="text-slate-400 hover:text-slate-600 transition-colors" title="+10 segundos">
                    <i class="fa-solid fa-rotate-right text-lg"></i>
                </button>
            </div>

            <div class="w-full flex items-center gap-3 text-[10px] md:text-xs font-mono text-slate-400 font-medium select-none">
                <span id="current-time">0:00</span>

                <div class="relative w-full h-1.5 group cursor-pointer py-1" id="progress-container">
                    <div class="absolute top-1/2 -translate-y-1/2 left-0 w-full h-1 bg-slate-200 rounded-full overflow-hidden">
                        <div id="progress-bar" class="h-full bg-primary w-0 rounded-full relative"></div>
                    </div>
                    <div id="progress-thumb" class="absolute top-1/2 -translate-y-1/2 w-3 h-3 bg-white border-2 border-primary rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity transform -translate-x-1.5 pointer-events-none" style="left: 0%"></div>
                </div>

                <span id="total-time">0:00</span>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 md:gap-6 w-1/4 min-w-[140px] md:min-w-[200px]">

            <div class="hidden md:flex items-center gap-2 group relative">
                <button id="mute-btn" class="text-slate-400 hover:text-slate-600 w-6 text-center">
                    <i class="fa fa-volume-high"></i>
                </button>
                <input type="range" id="volume-slider" min="0" max="1" step="0.05" value="1"
                       class="w-20 lg:w-24 h-1 rounded-lg appearance-none cursor-pointer">
            </div>

            <div class="h-8 w-px bg-slate-200 hidden md:block"></div>

            <button id="player-download-btn"
                    class="btn-smart-download w-10 h-10 rounded-full flex items-center justify-center bg-slate-100 hover:bg-primary hover:text-white text-slate-600 transition-all shadow-sm border border-slate-200"
                    data-id="" data-logged="" data-access="" title="Descargar Remix">
                <i class="fa fa-download"></i>
            </button>
        </div>
    </div>

    <audio id="main-audio-element" preload="none"></audio>
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
</script>