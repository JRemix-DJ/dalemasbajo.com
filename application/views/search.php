<div id="ajaxArea" class="bg-slate-50 min-h-screen">

    <section class="album-header relative h-[250px] w-full overflow-hidden flex items-center justify-center text-center bg-gradient-to-r from-slate-900 to-slate-800">

        <figure class="album-cover-wrap absolute inset-0 z-0 opacity-20 mix-blend-multiply bg-[url('<? echo base_url(); ?>images/default_cover.jpg')] bg-cover bg-center"></figure>

        <div class="container relative z-10 flex flex-col items-center">
            <div class="clearfix text-uppercase">
                <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight mb-2 drop-shadow-md">
                    Searcher
                </h1>
                <cite class="text-blue-200 font-medium not-italic">DALE MAS BAJO</cite>

                <? if(isset($_GET['sname']) && !empty($_GET['sname'])) { ?>
                    <div class="mt-4 bg-white/10 backdrop-blur-sm px-4 py-1 rounded-full border border-white/20">
                        <span class="text-white text-sm">Results for: <b class="text-primary-300">"<? echo $_GET['sname']; ?>"</b></span>
                    </div>
                <? } ?>
            </div>
        </div>
    </section>

    <section class="py-12" <? if($this->session->userdata('content_type') == 'videos'){ ?>id="cuerpo"<? } ?>>

        <div class="container mx-auto px-4 pb-24">
            <div class="mb-8">
                <? $this->load->view('search_box'); ?>
            </div>

            <? if($this->session->userdata('content_type') == 'videos'){ ?>

                <? $this->load->view('table_videos'); ?>

            <? } else { ?>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden relative mt-8">
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
                            if(isset($products) && !empty($products)) {
                                $this->load->view('table_products');
                            } else {
                                ?>
                                <tr>
                                    <td colspan="9" class="p-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-solid fa-magnifying-glass text-3xl mb-2 opacity-30"></i>
                                            <p>No se encontraron resultados para tu búsqueda.</p>
                                        </div>
                                    </td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <? } ?>

            <div class="mt-8 flex justify-center">
                <div class="pagination-modern" id="pagination-container">
                    <?php if (isset($links)) { ?>
                        <?php echo $links ?>
                    <?php } ?>
                </div>
            </div>
        </div>

    </section>
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
    #volume-slider {
        -webkit-appearance: none;
        background: linear-gradient(to right, #2563EB 0%, #2563EB 100%, #e2e8f0 100%, #e2e8f0 100%);
    }
    #volume-slider::-webkit-slider-thumb {
        -webkit-appearance: none; height: 12px; width: 12px; border-radius: 50%; background: #fff; border: 2px solid #2563EB; box-shadow: 0 1px 3px rgba(0,0,0,0.3); margin-top: -4px;
    }
    #volume-slider::-moz-range-thumb {
        height: 12px; width: 12px; border: none; border-radius: 50%; background: #2563EB;
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
    $(function() {
        console.log("--- INICIANDO SISTEMA DE AUDIO DEBUG ---");

        var audio = document.getElementById('main-audio-element');
        var playBtn = $('#player-play-btn');
        var icon = playBtn.find('i');

        var progressBar = $('#progress-bar');
        var progressThumb = $('#progress-thumb');
        var progressContainer = $('#progress-container');
        var currentTimeEl = $('#current-time');
        var totalTimeEl = $('#total-time');

        // Controles de volumen
        var volumeSlider = $('#volume-slider');
        var muteBtn = $('#mute-btn');

        // Helper para formatear tiempo
        function formatTime(seconds) {
            if(isNaN(seconds)) return "0:00";
            var min = Math.floor(seconds / 60);
            var sec = Math.floor(seconds % 60);
            return min + ":" + (sec < 10 ? "0" + sec : sec);
        }

        audio.addEventListener('play', function() {
            console.log("EVENTO: El audio comenzó a sonar -> Cambiando icono a PAUSE");
            icon.removeClass('fa-play pl-1').addClass('fa-pause');
        });

        audio.addEventListener('pause', function() {
            console.log("EVENTO: El audio se pausó -> Cambiando icono a PLAY");
            icon.removeClass('fa-pause').addClass('fa-play pl-1');
        });

        audio.addEventListener('ended', function() {
            console.log("EVENTO: Canción terminada");
            progressBar.css('width', '0%');
            progressThumb.css('left', '0%');
            currentTimeEl.text("0:00");
        });

        audio.addEventListener('timeupdate', function() {
            if (!isNaN(audio.duration)) {
                var percent = (audio.currentTime / audio.duration) * 100;
                progressBar.css('width', percent + '%');
                progressThumb.css('left', percent + '%');
                currentTimeEl.text(formatTime(audio.currentTime));
            }
        });

        audio.addEventListener('loadedmetadata', function() {
            console.log("METADATA: Duración cargada -> " + audio.duration);
            totalTimeEl.text(formatTime(audio.duration));
        });

        audio.addEventListener('error', function(e) {
            console.error("ERROR DE AUDIO:", e);
        });

        playBtn.off('click').on('click', function(e) {
            e.preventDefault();
            console.log("CLICK: Botón flotante presionado");

            if (audio.paused) {
                console.log("ACCIÓN: Intentando reproducir...");
                var playPromise = audio.play();
                if (playPromise !== undefined) {
                    playPromise.catch(error => {
                        console.error("ERROR PLAY PROMISE:", error);
                    });
                }
            } else {
                console.log("ACCIÓN: Intentando pausar...");
                audio.pause();
            }
        });

        $(document).on('click', '.play_btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            console.log("CLICK: Botón en tabla presionado para ID:", btn.data('id'));

            // Datos de la canción
            var demoUrl = btn.data('demo');
            var title = btn.data('title');
            var artist = btn.data('artist');
            var cover = btn.data('cover');
            var id = btn.data('id');

            $('#player-title').text(title);
            $('#player-artist').text(artist);
            $('#player-cover').attr('src', cover);

            var playerDlBtn = $('#player-download-btn');
            playerDlBtn.data('id', id);

            var originalDownloadBtn = btn.closest('tr').find('.btn-smart-download');
            if(originalDownloadBtn.length) {
                playerDlBtn.data('logged', originalDownloadBtn.data('logged'));
                playerDlBtn.data('access', originalDownloadBtn.data('access'));
            } else {
                // Fallbacks
                playerDlBtn.data('logged', '<? echo $this->session->userdata("is_logued_in") ? 1 : 0; ?>');
                playerDlBtn.data('access', '<? echo ($this->session->userdata("is_user_unlimited") || $this->session->userdata("tokens") > 0) ? 1 : 0; ?>');
            }

            var currentSrc = decodeURIComponent(audio.src);
            var newSrc = decodeURIComponent(demoUrl);

            if (currentSrc === newSrc || audio.src.indexOf(demoUrl) !== -1) {
                console.log("LOGICA TABLA: Es la misma canción.");
                if (audio.paused) {
                    audio.play();
                } else {
                    audio.pause();
                }
            } else {
                console.log("LOGICA TABLA: Nueva canción. Cargando...");
                audio.src = demoUrl;
                audio.load();
                // Reset visual
                progressBar.css('width', '0%');
                progressThumb.css('left', '0%');

                var playPromise = audio.play();
                if (playPromise !== undefined) {
                    playPromise.catch(error => console.error("Error al reproducir nueva:", error));
                }
            }

            $('#music-player-bar').removeClass('translate-y-full');
        });

        function updateVolumeVisual(val) {
            var percentage = val * 100;
            volumeSlider.css('background', `linear-gradient(to right, #2563EB ${percentage}%, #e2e8f0 ${percentage}%)`);

            var iconVol = muteBtn.find('i');
            iconVol.removeClass('fa-volume-high fa-volume-low fa-volume-off fa-volume-xmark');

            if(val <= 0.01) { // Tolerancia pequeña
                iconVol.addClass('fa-volume-xmark');
            } else if(val < 0.5) {
                iconVol.addClass('fa-volume-low');
            } else {
                iconVol.addClass('fa-volume-high');
            }
        }

        updateVolumeVisual(1);

        volumeSlider.on('input', function() {
            var val = parseFloat($(this).val());
            audio.volume = val;
            audio.muted = (val === 0);
            updateVolumeVisual(val);
        });

        muteBtn.click(function(e) {
            e.preventDefault();
            console.log("CLICK: Mute presionado. Estado actual muted:", audio.muted, "Volumen:", audio.volume);

            if (audio.muted || audio.volume === 0) {
                // DESMUTEAR
                audio.muted = false;
                var prevVol = $(this).data('prev-vol') || 1;
                audio.volume = prevVol;
                volumeSlider.val(prevVol);
                updateVolumeVisual(prevVol);
            } else {
                // MUTEAR
                $(this).data('prev-vol', audio.volume);
                audio.muted = true;
                audio.volume = 0;
                volumeSlider.val(0);
                updateVolumeVisual(0);
            }
        });

        $(document).on('click', '#pagination-container a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            if(!url || url === '#' || url === '') return;

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
                        $('html, body').animate({ scrollTop: $("#table-body-content").offset().top - 150 }, 500);
                    }
                },
                complete: function() {
                    $('#table-body-content').removeClass('opacity-50');
                }
            });
        });

        // Controles de SKIP
        $('#skip-back-btn').click(function(e) { e.preventDefault(); audio.currentTime = Math.max(0, audio.currentTime - 10); });
        $('#skip-fwd-btn').click(function(e) { e.preventDefault(); audio.currentTime = Math.min(audio.duration, audio.currentTime + 10); });

        // Seek Bar Click
        progressContainer.click(function(e) {
            var width = $(this).width();
            var clickX = e.offsetX;
            var duration = audio.duration;
            if(!isNaN(duration)){
                audio.currentTime = (clickX / width) * duration;
            }
        });
    });
</script>