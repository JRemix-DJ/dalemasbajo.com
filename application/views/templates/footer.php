<style>
    .modal-hidden { display: none !important; }
    .modal-flex { display: flex !important; }

    .backdrop-blur-sm { backdrop-filter: blur(4px); }
    <style>
    @media (max-width: 767px){
        #music-player-bar .container{
            padding-left: .75rem !important;
            padding-right: .75rem !important;
        }
        #music-player-bar img#player-cover{
            object-fit: cover;
        }
    }
</style>
</style>

<div id="modal-login" class="modal-hidden fixed inset-0 z-[9999] items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm close-modal-trigger"></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 transform transition-all">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-slate-900">Sign In</h3>
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
                    <label class="text-sm font-medium text-slate-700">Password</label>
                    <input type="password" id="login-password" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20">
                </div>
                <div class="text-right">
                    <a href="#" class="trigger-recover text-sm text-primary font-medium hover:underline">Forgot your password?</a>
                </div>
                <button type="button" id="btn-ingresar-accion" class="w-full py-3 bg-primary text-white font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-primary/20">
                    Log in
                </button>
            </form>
        </div>
        <div class="p-4 bg-gray-50 text-center text-sm border-t border-gray-100">
            Don't have an account? <a href="#" class="trigger-register text-primary font-bold hover:underline">Sign up for free</a>
        </div>
    </div>
</div>

<div id="modal-register" class="modal-hidden fixed inset-0 z-[9999] items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm close-modal-trigger"></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-slate-900">Create Account</h3>
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
                    <label class="text-sm font-medium text-slate-700">User</label>
                    <input type="text" id="reg-username" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Password</label>
                        <input type="password" id="reg-pass" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-700">Repeat Password</label>
                        <input type="password" id="reg-repass" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary">
                    </div>
                </div>
                <button type="button" id="btn-registrar-accion" class="w-full py-3 bg-primary text-white font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-primary/20">
                    Sign Up
                </button>
            </form>
        </div>
    </div>
</div>

<div id="modal-recover" class="modal-hidden fixed inset-0 z-[9999] items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm close-modal-trigger"></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 border border-gray-100">
        <h3 class="text-lg font-bold mb-4 text-slate-900">Recover Password</h3>
        <form class="space-y-4">
            <input type="email" id="rec-email" placeholder="Your e-mail" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary">
            <button type="button" id="btn-recuperar-accion" class="w-full py-2 bg-primary text-white font-bold rounded-lg hover:bg-blue-600">Send</button>
        </form>
        <button class="close-modal-btn mt-4 text-sm text-gray-500 w-full text-center hover:text-slate-900">Cancel</button>
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
                    Take your sets <br> <span class="text-primary">To the next level</span>
                </h3>
                <p class="text-sm text-slate-500 mb-6 px-4">
                    Stop using low-quality music. Get instant access to club-ready remixes, exclusive versions, and high-speed downloads.
                </p>

                <div class="text-left bg-slate-50 rounded-xl p-4 space-y-3 mb-6 border border-slate-100">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-check-circle text-primary text-lg"></i>
                        <span class="text-sm font-semibold text-slate-700">High download speed</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-bolt text-primary text-lg"></i>
                        <span class="text-sm font-semibold text-slate-700">Intro, extended, remix, breakdown, transition, and more...</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-gem text-primary text-lg"></i>
                        <span class="text-sm font-semibold text-slate-700">High-quality audio</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-fire text-primary text-lg"></i>
                        <span class="text-sm font-semibold text-slate-700">Daily updates</span>
                    </div>
                </div>
                <p class="text-sm text-slate-500 mb-6 px-4">
                    Our audio files are 100% compatible with the most popular DJ software in the world
                </p>
            </div>
        </div>

        <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
            <a href="<? echo base_url('planes'); ?>" class="inline-flex w-full justify-center rounded-xl bg-primary px-3 py-3 text-sm font-bold text-white shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all hover:scale-[1.02] sm:ml-3">
                Get Started
            </a>
        </div>
    </div>
</div>

<footer class="mt-auto border-t border-white/10" style="background-color: #0066FF;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12">
            <div>
                <h3 class="font-extrabold text-white mb-4 text-lg">
                    Follow Us
                </h3>

                <ul class="flex items-center gap-4 text-blue-100 font-extrabold">
                    <li>
                        <a href="https://www.facebook.com/dalemasbajo/" target="_blank" class="hover:text-gray-300 transition-colors">
                            <i class="fa-brands fa-facebook-f text-lg"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/dalemasbajo/" target="_blank" class="hover:text-gray-300 transition-colors">
                            <i class="fa-brands fa-instagram text-lg"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://soundcloud.com/dalemasbajo" target="_blank" class="hover:text-gray-300 transition-colors">
                            <i class="fa-brands fa-soundcloud text-lg"></i>
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <ul class="space-y-3 text-sm text-blue-100 font-extrabold">
                    <li>
                        <a href="<? echo base_url('faq'); ?>" class="hover:text-gray-300 transition-colors font-bold">
                            FAQ
                        </a>
                    </li>
                    <li>
                        <a href="<? echo base_url('pages/terms_conditions/'); ?>" class="hover:text-gray-300 transition-colors font-bold">
                            Terms and Conditions
                        </a>
                    </li>
                    <li>
                        <a href="<? echo base_url('pages/become_a_member/'); ?>" class="hover:text-gray-300 transition-colors font-bold">
                            Be a Remixer
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 mt-12 pt-8 flex justify-center text-center">
            <p class="text-sm text-blue-200">
                &copy; <? echo date('Y'); ?> Dale Mas Bajo. All rights reserved.
            </p>
        </div>
    </div>
</footer>

<div id="music-player-bar" class="fixed bottom-0 left-0 w-full bg-white/95 backdrop-blur-md border-t border-slate-200 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] z-50 transform translate-y-full transition-transform duration-500 ease-in-out">
    <div class="container mx-auto px-4 py-3 h-24 md:h-20 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3 min-w-0 w-auto md:w-1/4 md:min-w-[200px]">
            <div class="relative w-10 h-10 md:w-14 md:h-14 rounded-lg overflow-hidden shadow-sm flex-shrink-0 bg-slate-100">
                <img id="player-cover" src="" alt="Cover" class="w-full h-full object-cover">
            </div>
            <div class="overflow-hidden hidden sm:block">
                <h4 id="player-title" class="font-bold text-slate-900 text-sm truncate leading-tight">Select a track</h4>
                <p id="player-artist" class="text-xs text-slate-500 truncate mt-0.5">DALE MAS BAJO</p>
            </div>
        </div>

        <div class="flex flex-col items-center justify-center flex-1 min-w-0 max-w-2xl w-full">
            <div class="flex items-center gap-6 mb-1">
                <button id="skip-back-btn" class="text-slate-400 hover:text-slate-600 transition-colors" title="-10 seconds" type="button">
                    <i class="fa-solid fa-rotate-left text-lg"></i>
                </button>

                <button id="player-play-btn" class="w-10 h-10 bg-primary hover:bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg shadow-blue-500/30 transition-all transform hover:scale-105 active:scale-95" type="button">
                    <i class="fa fa-play pl-1"></i>
                </button>

                <button id="skip-fwd-btn" class="text-slate-400 hover:text-slate-600 transition-colors" title="+10 seconds" type="button">
                    <i class="fa-solid fa-rotate-right text-lg"></i>
                </button>
            </div>

            <div class="w-full flex items-center gap-3 text-[10px] md:text-xs font-mono text-slate-400 font-medium select-none">
                <span id="current-time">0:00</span>

                <div class="relative w-full min-w-0 h-1.5 group cursor-pointer py-1" id="progress-container">
                    <div class="absolute top-1/2 -translate-y-1/2 left-0 w-full h-1 bg-slate-200 rounded-full overflow-hidden">
                        <div id="progress-bar" class="h-full bg-primary w-0 rounded-full relative"></div>
                    </div>
                    <div id="progress-thumb" class="absolute top-1/2 -translate-y-1/2 w-3 h-3 bg-white border-2 border-primary rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity transform -translate-x-1.5 pointer-events-none" style="left: 0%"></div>
                </div>

                <span id="total-time">0:00</span>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 md:gap-6 min-w-0 w-auto md:w-1/4 md:min-w-[200px]">
            <div class="hidden md:flex items-center gap-2 group relative">
                <button id="mute-btn" class="text-slate-400 hover:text-slate-600 w-6 text-center" type="button">
                    <i class="fa fa-volume-high"></i>
                </button>
                <input type="range" id="volume-slider" min="0" max="1" step="0.05" value="1" class="w-20 lg:w-24 h-1 rounded-lg appearance-none cursor-pointer">
            </div>

            <div class="h-8 w-px bg-slate-200 hidden md:block"></div>

            <button id="player-download-btn"
                    class="btn-smart-download w-10 h-10 rounded-full flex items-center justify-center bg-slate-100 hover:bg-primary hover:text-white text-slate-600 transition-all shadow-sm border border-slate-200 flex-shrink-0"
                    data-id="" data-logged="" data-access="" title="Download" type="button">
                <i class="fa fa-download"></i>
            </button>
        </div>
    </div>

    <audio id="main-audio-element" preload="none"></audio>
</div>

</div> <div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="hidden"></div>

<script src="<? echo base_url(); ?>js/jquery.js"></script>
<script src="<? echo base_url(); ?>js/ajaxify.min.js"></script>
<script src="<? echo base_url(); ?>js/jquery.downCount.js"></script>
<script src="<? echo base_url(); ?>js/jquery.datetimepicker.full.min.js"></script>
<script src="<? echo base_url(); ?>js/jplayer/jquery.jplayer.min.js"></script>
<script src="<? echo base_url(); ?>js/jplayer/jplayer.playlist.min.js"></script>

<script src="<? echo base_url(); ?>js/jquery.flexslider-min.js"></script>
<script src="<? echo base_url(); ?>js/jquery.stellar.min.js"></script>
<script src="<? echo base_url(); ?>js/jquery.sticky.js"></script>
<script src="<? echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<? echo base_url(); ?>js/jquery.waitforimages.js"></script>
<script src="<? echo base_url(); ?>js/masonry.pkgd.min.js"></script>
<script src="<? echo base_url(); ?>js/packery.pkgd.min.js"></script>
<script src="<? echo base_url(); ?>js/tweetie.min.js"></script>
<script src="<? echo base_url(); ?>js/owl.carousel.min.js"></script>
<script src="<? echo base_url(); ?>js/jquery.bxslider.min.js"></script>
<script src="<? echo base_url(); ?>js/main.js?v=2.9.2021"></script>

<script>
    $(document).ready(function() {

        function cerrarTodos() {
            $('#modal-login, #modal-register, #modal-recover, #modal-upsell').addClass('modal-hidden').removeClass('modal-flex');
        }

        $(document).on('click', '.close-modal-btn, .close-modal-trigger', function(e) {
            e.preventDefault();
            $(this).closest('.modal-flex').fadeOut(200, function() {
                $(this).addClass('modal-hidden').removeClass('modal-flex');
            });
        });

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
                        if(data.total_tokens !== undefined){
                            $('.token-count').text(data.total_tokens);
                        }

                        window.location.href = baseUrl + 'audios/download/' + productId;

                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);

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
                        alert(response.message || 'Error al ingresar');
                        btn.text(originalText).prop('disabled', false);
                    }
                },
                error: function() {
                    alert('Error de conexión.');
                    btn.text(originalText).prop('disabled', false);
                }
            });
        });

        $('#btn-registrar-accion').click(function() {
            var btn = $(this);
            var originalText = btn.text();

            var email = $('#reg-email').val().trim();
            var username = $('#reg-username').val().trim();
            var password = $('#reg-pass').val();
            var repass = $('#reg-repass').val();

            if(email === '' || username === '' || password === '') {
                alert('Por favor completa todos los campos obligatorios.');
                return;
            }

            if(password !== repass) {
                alert('Las contraseñas no coinciden.');
                return;
            }

            btn.text('Registrando...').prop('disabled', true);

            $.ajax({
                url: '<? echo base_url("users/registro"); ?>',
                type: 'POST',
                data: {
                    email: email,
                    username: username,
                    password: password
                },
                dataType: 'json',
                success: function(data) {
                    btn.text(originalText).prop('disabled', false);

                    if(data.respuesta === 'ok') {
                        alert('Registro exitoso. ¡Bienvenido!');
                        window.location.reload();
                    }
                    else if(data.respuesta === 'email_existe') {
                        alert('Error: El correo electrónico ya está registrado.');
                    }
                    else if(data.respuesta === 'username_existe') {
                        alert('Error: El nombre de usuario ya está en uso.');
                    }
                    else {
                        alert('Ocurrió un error desconocido. Intenta nuevamente.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error de conexión con el servidor.');
                    btn.text(originalText).prop('disabled', false);
                }
            });
        });
    });

    var audio = document.getElementById('main-audio-element');
    var playBtn = $('#player-play-btn');
    var playerIcon = playBtn.find('i');

    var progressBar = $('#progress-bar');
    var progressThumb = $('#progress-thumb');
    var progressContainer = $('#progress-container');
    var currentTimeEl = $('#current-time');
    var totalTimeEl = $('#total-time');

    var volumeSlider = $('#volume-slider');

    var currentTrackId = null;

    function formatTime(seconds) {
        if (isNaN(seconds)) return "0:00";
        var min = Math.floor(seconds / 60);
        var sec = Math.floor(seconds % 60);
        return min + ":" + (sec < 10 ? "0" + sec : sec);
    }

    function setRowIcon(id, isPlaying) {
        var btn = $('.play_btn[data-id="' + id + '"]');
        if (!btn.length) return;

        var i = btn.find('i');
        i.removeClass('fa-solid fa-play fa-solid fa-stop ml-0.5');
        if (isPlaying) i.addClass('fa-solid fa-stop');
        else i.addClass('fa-solid fa-play ml-0.5');
    }

    function resetAllRowIcons() {
        $('.play_btn i').each(function () {
            var i = $(this);
            i.removeClass('fa-solid fa-stop fa-solid fa-play ml-0.5');
            i.addClass('fa-solid fa-play ml-0.5');
        });
    }

    function showPlayerBar() {
        $('#music-player-bar').removeClass('translate-y-full');
    }

    function hidePlayerBar() {
        $('#music-player-bar').addClass('translate-y-full');
    }

    function setPlayerPausedUI() {
        playerIcon.removeClass('fa-solid fa-pause').addClass('fa fa-play pl-1');
        if (currentTrackId !== null) setRowIcon(currentTrackId, false);
    }

    function setPlayerPlayingUI() {
        playerIcon.removeClass('fa fa-play pl-1').addClass('fa-solid fa-pause');
        if (currentTrackId !== null) setRowIcon(currentTrackId, true);
    }

    function playCurrent() {
        if (!audio.src) return;
        var p = audio.play();
        if (p && p.then) {
            p.then(function () {
                setPlayerPlayingUI();
            }).catch(function () {});
        } else {
            setPlayerPlayingUI();
        }
    }

    function pauseCurrent() {
        audio.pause();
        setPlayerPausedUI();
    }

    function stopPlayback() {
        if (currentTrackId !== null) setRowIcon(currentTrackId, false);
        audio.pause();
        audio.currentTime = 0;

        try { audio.removeAttribute('src'); } catch (e) {}
        audio.load();

        currentTrackId = null;

        playerIcon.removeClass('fa-pause').addClass('fa fa-play pl-1');

        $('#player-title').text('Select a track');
        $('#player-artist').text('DALE MAS BAJO');
        $('#player-cover').attr('src', '');

        progressBar.css('width', '0%');
        progressThumb.css('left', '0%');
        currentTimeEl.text('0:00');
        totalTimeEl.text('0:00');

        hidePlayerBar();
    }

    $(document).on('click', '.play_btn', function (e) {
        e.preventDefault();

        var btn = $(this);
        var demoUrl = btn.data('demo');
        var title = btn.data('title');
        var artist = btn.data('artist');
        var cover = btn.data('cover');
        var id = String(btn.data('id'));

        if (currentTrackId !== null && String(currentTrackId) === id && !audio.paused) {
            stopPlayback();
            return;
        }

        if (currentTrackId !== null && String(currentTrackId) !== id) {
            setRowIcon(currentTrackId, false);
        } else if (currentTrackId === null) {
            resetAllRowIcons();
        }

        currentTrackId = id;

        $('#player-title').text(title);
        $('#player-artist').text(artist);
        $('#player-cover').attr('src', cover);

        var playerDlBtn = $('#player-download-btn');
        playerDlBtn.data('id', id);

        var originalDownloadBtn = btn.closest('tr').find('.btn-smart-download');
        if (originalDownloadBtn.length) {
            playerDlBtn.data('logged', originalDownloadBtn.data('logged'));
            playerDlBtn.data('access', originalDownloadBtn.data('access'));
        } else {
            playerDlBtn.data('logged', '<? echo $this->session->userdata("is_logued_in") ? 1 : 0; ?>');
            playerDlBtn.data('access', '<? echo ($this->session->userdata("is_user_unlimited") || $this->session->userdata("tokens") > 0) ? 1 : 0; ?>');
        }

        if (audio.src !== demoUrl) {
            audio.src = demoUrl;
            audio.load();

            progressBar.css('width', '0%');
            progressThumb.css('left', '0%');
            currentTimeEl.text('0:00');
            totalTimeEl.text('0:00');
        }

        showPlayerBar();
        playCurrent();
    });

    playBtn.off('click').on('click', function () {
        if (!currentTrackId) return;
        if (audio.paused) playCurrent();
        else pauseCurrent();
    });

    audio.addEventListener('loadedmetadata', function () {
        totalTimeEl.text(formatTime(audio.duration));
    });

    audio.addEventListener('timeupdate', function () {
        if (!isNaN(audio.duration)) {
            var percent = (audio.currentTime / audio.duration) * 100;
            progressBar.css('width', percent + '%');
            progressThumb.css('left', percent + '%');
            currentTimeEl.text(formatTime(audio.currentTime));
        }
    });

    audio.addEventListener('ended', function () {
        stopPlayback();
    });

    progressContainer.off('click').on('click', function (e) {
        var width = $(this).width();
        var clickX = e.offsetX;
        var duration = audio.duration;
        if (!isNaN(duration)) audio.currentTime = (clickX / width) * duration;
    });

    function updateVolumeVisual(val) {
        var percentage = val * 100;
        volumeSlider.css('background', `linear-gradient(to right, #2563EB ${percentage}%, #e2e8f0 ${percentage}%)`);

        var iconVol = $('#mute-btn i');
        iconVol.removeClass('fa-volume-high fa-volume-low fa-volume-off fa-volume-xmark');
        if (val == 0) iconVol.addClass('fa-volume-xmark');
        else if (val < 0.5) iconVol.addClass('fa-volume-low');
        else iconVol.addClass('fa-volume-high');
    }

    updateVolumeVisual(1);

    volumeSlider.off('input').on('input', function () {
        var val = $(this).val();
        audio.volume = val;
        updateVolumeVisual(val);
    });

    $('#mute-btn').off('click').on('click', function () {
        if (audio.volume > 0) {
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
    $('#skip-back-btn').click(function() {
        audio.currentTime = Math.max(0, audio.currentTime - 10);
    });

    $('#skip-fwd-btn').click(function() {
        audio.currentTime = Math.min(audio.duration, audio.currentTime + 10);
    });
</script>
</body>
</html>