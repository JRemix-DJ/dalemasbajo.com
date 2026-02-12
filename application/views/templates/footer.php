<style>
    .modal-hidden { display: none !important; }
    .modal-flex { display: flex !important; }

    .backdrop-blur-sm { backdrop-filter: blur(4px); }
</style>

<div id="modal-login" class="modal-hidden fixed inset-0 z-[9999] items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm close-modal-trigger"></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 transform transition-all">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-slate-900">Iniciar Sesión</h3>
            <button class="close-modal-btn text-gray-400 hover:text-red-500 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <form id="login-form-new" class="space-y-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Email</label>
                    <input type="email" id="login-email" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Contraseña</label>
                    <input type="password" id="login-password" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                </div>
                <div class="text-right">
                    <a href="#" class="trigger-recover text-sm text-primary font-medium hover:underline">¿Olvidaste tu contraseña?</a>
                </div>
                <button type="button" id="btn-ingresar-accion" class="w-full py-3 bg-primary text-white font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-primary/20">
                    Ingresar
                </button>
            </form>
        </div>
        <div class="p-4 bg-gray-50 text-center text-sm border-t border-gray-100">
            ¿No tienes cuenta? <a href="#" class="trigger-register text-primary font-bold hover:underline">Regístrate gratis</a>
        </div>
    </div>
</div>

<div id="modal-register" class="modal-hidden fixed inset-0 z-[9999] items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm close-modal-trigger"></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-slate-900">Crear Cuenta</h3>
            <button class="close-modal-btn text-gray-400 hover:text-red-500 transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <form id="register-form-new" class="space-y-3">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Email</label>
                    <input type="email" id="reg-email" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-700">Usuario</label>
                    <input type="text" id="reg-username" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Contraseña</label>
                        <input type="password" id="reg-pass" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Repetir</label>
                        <input type="password" id="reg-repass" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary">
                    </div>
                </div>
                <button type="button" id="btn-registrar-accion" class="w-full py-3 bg-slate-900 text-white font-bold rounded-lg hover:bg-slate-800 transition-colors mt-2">
                    Registrarme
                </button>
            </form>
        </div>
    </div>
</div>

<div id="modal-recover" class="modal-hidden fixed inset-0 z-[9999] items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm close-modal-trigger"></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 border border-gray-100">
        <h3 class="text-lg font-bold mb-4 text-slate-900">Recuperar Contraseña</h3>
        <form class="space-y-4">
            <input type="email" id="rec-email" placeholder="Tu Email" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary">
            <button type="button" id="btn-recuperar-accion" class="w-full py-2 bg-primary text-white font-bold rounded-lg hover:bg-blue-600">Enviar</button>
        </form>
        <button class="close-modal-btn mt-4 text-sm text-gray-500 w-full text-center hover:text-slate-900">Cancelar</button>
    </div>
</div>

<div id="modal-upsell" class="modal-hidden fixed inset-0 z-[9999] items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/90 backdrop-blur-sm"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden border border-slate-100 transform transition-all">

        <button type="button" class="close-modal-btn absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none z-10">
            <i class="fa-solid fa-xmark text-2xl"></i>
        </button>

        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <div class="flex justify-center -space-x-4 mb-6 pt-2">
                <div class="w-16 h-16 rounded-full border-4 border-white shadow-lg bg-cover bg-center bg-gray-200" style="background-image: url('<? echo base_url(); ?>images/default_cover.jpg');"></div>
                <div class="w-20 h-20 rounded-full border-4 border-white shadow-xl bg-cover bg-center z-10 -mt-2 bg-primary flex items-center justify-center" style="background-color: #0066FF;">
                    <i class="fa-solid fa-star text-white text-3xl"></i>
                </div>
                <div class="w-16 h-16 rounded-full border-4 border-white shadow-lg bg-cover bg-center bg-gray-200" style="background-image: url('<? echo base_url(); ?>images/default_cover.jpg');"></div>
            </div>

            <div class="text-center mt-2">
                <h3 class="text-2xl font-black text-slate-900 mb-2 leading-tight">
                    Lleva tus Sets al <br> <span class="text-primary">Siguiente Nivel</span>
                </h3>
                <p class="text-sm text-slate-500 mb-6 px-4">
                    Deja de usar rips de baja calidad. Obtén acceso instantáneo a música lista para clubes, versiones exclusivas y descargas ilimitadas.
                </p>

                <div class="text-left bg-slate-50 rounded-xl p-4 space-y-3 mb-6 border border-slate-100">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-check-circle text-primary text-lg"></i>
                        <span class="text-sm font-semibold text-slate-700">Descargas High-Speed Directas</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-bolt text-primary text-lg"></i>
                        <span class="text-sm font-semibold text-slate-700">Versiones Intro & Outro Exclusivas</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-gem text-primary text-lg"></i>
                        <span class="text-sm font-semibold text-slate-700">Calidad Premium</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-fire text-primary text-lg"></i>
                        <span class="text-sm font-semibold text-slate-700">Actualizaciones Diarias</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
            <a href="<? echo base_url('planes'); ?>" class="inline-flex w-full justify-center rounded-xl bg-primary px-3 py-3 text-sm font-bold text-white shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all hover:scale-[1.02] sm:ml-3">
                Get Started - Desbloquear Acceso
            </a>
        </div>
    </div>
</div>

<footer class="mt-auto border-t border-white/10" style="background-color: oklch(0.605 0.217 257.214);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12">

            <div class="col-span-1 md:col-span-1 flex flex-col gap-4">
                <a href="<? echo base_url(); ?>" class="flex items-center gap-2">
                    <span class="text-xl font-bold tracking-tighter text-white">
                        DALE MÁS BAJO
                    </span>
                </a>
                <p class="text-sm text-blue-100 leading-relaxed">
                    Descubre nuevos remixes cada día en nuestro sitio web.
                </p>
            </div>

            <div>
                <h3 class="font-semibold text-white mb-4">Plataforma</h3>
                <ul class="space-y-3 text-sm text-blue-100">
                    <li><a href="<? echo base_url('drops'); ?>" class="hover:text-gray-300 transition-colors">Drops Exclusivos</a></li>
                    <li><a href="<? echo base_url('planes'); ?>" class="hover:text-gray-300 transition-colors">Planes de Suscripción</a></li>
                    <li><a href="<? echo base_url('search'); ?>" class="hover:text-gray-300 transition-colors">Explorar Música</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-semibold text-white mb-4">Ayuda</h3>
                <ul class="space-y-3 text-sm text-blue-100">
                    <li><a href="<? echo base_url('faq'); ?>" class="hover:text-gray-300 transition-colors">Preguntas Frecuentes</a></li>
                    <li><a href="<? echo base_url('pages/terms_conditions/'); ?>" class="hover:text-gray-300 transition-colors">Términos y Condiciones</a></li>
                    <li><a href="<? echo base_url('pages/become_a_member/'); ?>" class="hover:text-gray-300 transition-colors">Be a Remixer</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-semibold text-white mb-4">Síguenos</h3>
                <ul class="space-x-3 text-blue-100">
                    <a href="https://www.facebook.com/dalemasbajo/" target="_blank" class="hover:text-gray-300 transition-colors">
                        <i class="fa-brands fa-facebook-f text-lg"></i>
                    </a>
                    <a href="https://www.instagram.com/dalemasbajo/" target="_blank" class="hover:text-gray-300 transition-colors">
                        <i class="fa-brands fa-instagram text-lg"></i>
                    </a>
                    <a href="https://soundcloud.com/dalemasbajo" target="_blank" class="hover:text-gray-300 transition-colors">
                        <i class="fa-brands fa-soundcloud text-lg"></i>
                    </a>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 mt-12 pt-8 flex justify-center text-center">
            <p class="text-sm text-blue-200">
                &copy; <? echo date('Y'); ?> Dale Más Bajo. Todos los derechos reservados.
            </p>
        </div>
    </div>
</footer>

</div> <div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="hidden"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<? echo base_url(); ?>js/jplayer/jquery.jplayer.min.js"></script>
<script src="<? echo base_url(); ?>js/jplayer/jplayer.playlist.min.js"></script>
<script src="<? echo base_url(); ?>js/main.js?v=2.9.2021"></script>

<script>
    $(document).ready(function() {

        // ================= GESTIÓN CENTRALIZADA DE MODALES =================
        function cerrarTodos() {
            $('#modal-login, #modal-register, #modal-recover, #modal-upsell').addClass('modal-hidden').removeClass('modal-flex');
        }

        $(document).on('click', '.close-modal-btn, .close-modal-trigger', function(e) {
            e.preventDefault();
            $(this).closest('.modal-flex').fadeOut(200, function() {
                $(this).addClass('modal-hidden').removeClass('modal-flex');
            });
        });

        // ================= ACTIVADORES =================

        // Abrir Login
        $(document).on('click', '[data-target="#myModal"]', function(e) {
            e.preventDefault(); e.stopPropagation();
            cerrarTodos();
            $('#modal-login').removeClass('modal-hidden').addClass('modal-flex').hide().fadeIn(200);
        });

        // Abrir Registro
        $(document).on('click', '[data-target="#myModalRegistrarme"], .trigger-register', function(e) {
            e.preventDefault(); e.stopPropagation();
            cerrarTodos();
            $('#modal-register').removeClass('modal-hidden').addClass('modal-flex').hide().fadeIn(200);
        });

        // Abrir Recuperar
        $(document).on('click', '.trigger-recover', function(e) {
            e.preventDefault();
            cerrarTodos();
            $('#modal-recover').removeClass('modal-hidden').addClass('modal-flex').hide().fadeIn(200);
        });

        // ================= LÓGICA SMART DOWNLOAD =================
        $(document).on('click', '.btn-smart-download', function(e) {
            e.preventDefault();

            var btn = $(this);
            var isLogged = parseInt(btn.data('logged'));
            var hasAccess = parseInt(btn.data('access'));
            var productId = btn.data('id');
            var baseUrl = '<? echo base_url(); ?>';

            if (isLogged === 0 || hasAccess === 0) {
                cerrarTodos();
                $('#modal-upsell').removeClass('modal-hidden').addClass('modal-flex').hide().fadeIn(200);
                return;
            }

            $.ajax({
                url: baseUrl + "micuenta/descargar_producto/",
                type: "POST",
                dataType: "json",
                data: { product_id: productId },
                beforeSend: function() {
                    btn.html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(data) {
                    if(data.success) {
                        window.location.href = baseUrl + 'audios/download/' + productId;

                        if(!data.is_unlimited && data.total_tokens !== undefined){
                            $('.token-count').text(data.total_tokens);
                        }
                    } else {
                        if(data.message == "NOTOKENS" || data.message == "NOLOGGUEDIN") {
                            cerrarTodos();
                            $('#modal-upsell').removeClass('modal-hidden').addClass('modal-flex').hide().fadeIn(200);
                        } else {
                            alert(data.message || "Error al procesar la descarga");
                        }
                    }
                },
                error: function() {
                    alert('Error de conexión al intentar descargar.');
                },
                complete: function() {
                    btn.html('<i class="fa fa-download"></i>');
                }
            });
        });

        // ================= AJAX LOGIN =================
        $('#btn-ingresar-accion').click(function() {
            var btn = $(this);
            var originalText = btn.text();
            btn.text('Verificando...').prop('disabled', true);

            var email = $('#login-email').val();
            var password = $('#login-password').val();

            $.ajax({
                url: '<? echo base_url("login/front"); ?>',
                type: 'POST',
                data: { email: email, password: password },
                dataType: 'json',
                success: function(response) {
                    if(response.success === true || response.status == 'success' || response.status === true || response == 1) {
                        window.location.reload();
                    } else {
                        var mensajeError = response.message || response.msg || response.error || 'Error desconocido';
                        alert(mensajeError);
                        btn.text(originalText).prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    if(xhr.status == 200) {
                        window.location.reload();
                    } else {
                        alert('Error de conexión.');
                        btn.text(originalText).prop('disabled', false);
                    }
                }
            });
        });

        $('#btn-registrar-accion').click(function() {
            alert('Función de registro pendiente de conectar al controlador');
        });
    });

    var audio = document.getElementById('main-audio-element');
    var playBtn = $('#player-play-btn');
    var icon = playBtn.find('i');

    // Variables de Progreso
    var progressBar = $('#progress-bar');
    var progressThumb = $('#progress-thumb');
    var progressContainer = $('#progress-container');
    var currentTimeEl = $('#current-time');
    var totalTimeEl = $('#total-time');

    // Variables Volumen
    var volumeSlider = $('#volume-slider');

    // Helper: Formato mm:ss
    function formatTime(seconds) {
        if(isNaN(seconds)) return "0:00";
        var min = Math.floor(seconds / 60);
        var sec = Math.floor(seconds % 60);
        return min + ":" + (sec < 10 ? "0" + sec : sec);
    }

    // 1. CLICK EN CUALQUIER BOTÓN PLAY DE LA WEB (Inicio)
    $(document).on('click', '.play_btn', function(e) {
        e.preventDefault();

        var btn = $(this);
        var demoUrl = btn.data('demo');
        var title = btn.data('title');
        var artist = btn.data('artist');
        var cover = btn.data('cover');
        var id = btn.data('id');

        // Buscar datos de descarga (Smart Download)
        var originalDownloadBtn;
        if(btn.closest('tr').length > 0) {
            originalDownloadBtn = btn.closest('tr').find('.btn-smart-download');
        } else if(btn.closest('.group').length > 0) {
            // Lógica para cards (si aplica)
        }

        // UI Updates
        $('#player-title').text(title);
        $('#player-artist').text(artist);
        $('#player-cover').attr('src', cover);

        // Configurar botón descarga del player
        var playerDlBtn = $('#player-download-btn');
        playerDlBtn.data('id', id);

        if(originalDownloadBtn && originalDownloadBtn.length) {
            playerDlBtn.data('logged', originalDownloadBtn.data('logged'));
            playerDlBtn.data('access', originalDownloadBtn.data('access'));
        } else {
            // Fallbacks globales PHP
            playerDlBtn.data('logged', '<? echo $this->session->userdata("is_logued_in") ? 1 : 0; ?>');
            playerDlBtn.data('access', '<? echo ($this->session->userdata("is_user_unlimited") || $this->session->userdata("tokens") > 0) ? 1 : 0; ?>');
        }

        // Cargar Audio
        if(audio.src !== demoUrl) {
            audio.src = demoUrl;
            audio.load();
            // Reset UI
            progressBar.css('width', '0%');
            progressThumb.css('left', '0%');
            currentTimeEl.text("0:00");
            totalTimeEl.text("0:00");
        }

        playAudio();
        $('#music-player-bar').removeClass('translate-y-full');
    });

    // 2. CONTROLES DE REPRODUCCIÓN
    playBtn.click(function() {
        if (audio.paused) playAudio();
        else pauseAudio();
    });

    function playAudio() {
        var playPromise = audio.play();
        if (playPromise !== undefined) {
            playPromise.then(_ => {
                icon.removeClass('fa-play pl-1').addClass('fa-pause');
            }).catch(error => console.log(error));
        }
    }

    function pauseAudio() {
        audio.pause();
        icon.removeClass('fa-pause').addClass('fa-play pl-1');
    }

    // 3. SALTOS DE TIEMPO (+10s / -10s)
    $('#skip-back-btn').click(function() {
        audio.currentTime = Math.max(0, audio.currentTime - 10);
    });

    $('#skip-fwd-btn').click(function() {
        audio.currentTime = Math.min(audio.duration, audio.currentTime + 10);
    });

    // 4. BARRA DE PROGRESO Y TIEMPOS
    audio.addEventListener('loadedmetadata', function() {
        totalTimeEl.text(formatTime(audio.duration));
    });

    audio.addEventListener('timeupdate', function() {
        if (!isNaN(audio.duration)) {
            var percent = (audio.currentTime / audio.duration) * 100;
            progressBar.css('width', percent + '%');
            progressThumb.css('left', percent + '%');
            currentTimeEl.text(formatTime(audio.currentTime));
        }
    });

    audio.addEventListener('ended', function() {
        pauseAudio();
        progressBar.css('width', '0%');
        progressThumb.css('left', '0%');
        icon.removeClass('fa-pause').addClass('fa-play pl-1');
    });

    // Click en la barra para buscar
    progressContainer.click(function(e) {
        var width = $(this).width();
        var clickX = e.offsetX;
        var duration = audio.duration;
        if(!isNaN(duration)){
            audio.currentTime = (clickX / width) * duration;
        }
    });

    // 5. VOLUMEN CON COLOR VISUAL
    function updateVolumeVisual(val) {
        // Truco CSS: Actualiza el background gradient basado en el porcentaje
        var percentage = val * 100;
        volumeSlider.css('background', `linear-gradient(to right, #2563EB ${percentage}%, #e2e8f0 ${percentage}%)`);

        // Iconos
        var iconVol = $('#mute-btn i');
        iconVol.removeClass('fa-volume-high fa-volume-low fa-volume-off fa-volume-xmark');
        if(val == 0) iconVol.addClass('fa-volume-xmark');
        else if(val < 0.5) iconVol.addClass('fa-volume-low');
        else iconVol.addClass('fa-volume-high');
    }

    // Inicializar visualmente al cargar
    updateVolumeVisual(1);

    volumeSlider.on('input', function() {
        var val = $(this).val();
        audio.volume = val;
        updateVolumeVisual(val);
    });

    $('#mute-btn').click(function() {
        if(audio.volume > 0) {
            $(this).data('prev-vol', audio.volume);
            audio.volume = 0;
            volumeSlider.val(0);
            updateVolumeVisual(0);
        } else {
            var prev = $(this).data('prev-vol') || 1;
            audio.volume = prev;
            volumeSlider.val(prev);
            updateVolumeVisual(prev);
        }
    });
</script>
</body>
</html>