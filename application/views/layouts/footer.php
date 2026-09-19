
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

<div id="modal-upsell" class="modal-hidden fixed inset-0 z-[99999] items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/90 backdrop-blur-sm close-modal-trigger"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden border border-slate-100 transform transition-all">
        <button type="button" class="close-modal-btn absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none z-10">
            <i class="fa-solid fa-xmark text-2xl"></i>
        </button>

        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <div class="flex justify-center -space-x-4 mb-6 pt-2">
                <div class="w-16 h-16 rounded-full border-4 border-white shadow-lg bg-cover bg-center bg-gray-200" style="background-image: url('<?= base_url(); ?>images/default_cover.jpg');"></div>
                <div class="w-20 h-20 rounded-full border-4 border-white shadow-xl bg-cover bg-center z-10 -mt-2 bg-primary flex items-center justify-center" style="background-color: #0066FF;">
                    <i class="fa-solid fa-star text-white text-3xl"></i>
                </div>
                <div class="w-16 h-16 rounded-full border-4 border-white shadow-lg bg-cover bg-center bg-gray-200" style="background-image: url('<?= base_url(); ?>images/default_cover.jpg');"></div>
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
            <a href="<?= base_url('planes'); ?>" class="btn-get-started inline-flex w-full justify-center rounded-xl bg-primary px-3 py-3 text-sm font-bold text-white shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all hover:scale-[1.02] sm:ml-3">
                Get Started
            </a>
        </div>
    </div>
</div>

<footer class="mt-auto border-t border-white/10" style="background-color: #0066FF;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12">
            <div>
                <h3 class="font-extrabold text-white mb-4 text-lg">Follow Us</h3>
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
                        <a href="<?= base_url('faq'); ?>" class="hover:text-gray-300 transition-colors font-bold">
                            FAQ
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('pages/terms_conditions/'); ?>" class="hover:text-gray-300 transition-colors font-bold">
                            Terms and Conditions
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('pages/become_a_member/'); ?>" class="hover:text-gray-300 transition-colors font-bold">
                            Be a Remixer
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 mt-12 pt-8 flex justify-center text-center">
            <p class="text-sm text-blue-200">
                &copy; <?= date('Y'); ?> Dale Mas Bajo. All rights reserved.
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
                <span id="player-current-time">0:00</span>
                <div class="relative w-full min-w-0 h-1.5 group cursor-pointer py-1" id="player-progress-container">
                    <div class="absolute top-1/2 -translate-y-1/2 left-0 w-full h-1 bg-slate-200 rounded-full overflow-hidden">
                        <div id="player-progress" class="h-full bg-primary w-0 rounded-full relative"></div>
                    </div>
                    <div id="progress-thumb" class="absolute top-1/2 -translate-y-1/2 w-3 h-3 bg-white border-2 border-primary rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity transform -translate-x-1.5 pointer-events-none" style="left: 0%"></div>
                </div>
                <span id="player-duration">0:00</span>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 md:gap-6 min-w-0 w-auto md:w-1/4 md:min-w-[200px]">
            <div class="hidden md:flex items-center gap-2 group relative">
                <button id="mute-btn" class="text-slate-400 hover:text-slate-600 w-6 text-center" type="button">
                    <i class="fa fa-volume-high"></i>
                </button>
                <input type="range" id="player-volume" min="0" max="1" step="0.05" value="1" class="w-20 lg:w-24 h-1 rounded-lg appearance-none cursor-pointer">
            </div>

            <div class="h-8 w-px bg-slate-200 hidden md:block"></div>

            <button id="player-download-btn"
                    class="btn-smart-download w-10 h-10 rounded-full flex items-center justify-center bg-slate-100 hover:bg-primary hover:text-white text-slate-600 transition-all shadow-sm border border-slate-200 flex-shrink-0"
                    data-id="" data-logged="" data-access="" title="Download" type="button">
                <i class="fa fa-download"></i>
            </button>
        </div>
    </div>

    <audio id="main-audio" preload="none"></audio>
</div>

</div> 
<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="hidden"></div>

<script src="<?= base_url('assets/front/vendor/jquery.js'); ?>"></script>
<script src="<?= base_url('assets/front/vendor/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/front/vendor/jplayer/jquery.jplayer.min.js'); ?>"></script>
<script src="<?= base_url('assets/front/vendor/jplayer/jplayer.playlist.min.js'); ?>"></script>
<script src="<?= base_url('assets/front/vendor/owl.carousel.min.js'); ?>"></script>
<script src="<?= base_url('assets/front/vendor/main.js?v=2.9.2021'); ?>"></script>

<?php
$raw_user_prods = $this->session->userdata('user_products') ?: [];
$clean_user_prods = [];
foreach ($raw_user_prods as $p) {
    $clean_user_prods[] = (string)(is_object($p) && isset($p->product_id) ? $p->product_id : $p);
}
?>
<script>
    window.DMB = {
        baseUrl: "<?= base_url(); ?>",
        isLoggedIn: <?= $this->session->userdata('is_logued_in') ? 'true' : 'false'; ?>,
        userId: "<?= $this->session->userdata('id_usuario') ?: $this->session->userdata('user_id'); ?>",
        userProducts: <?= json_encode(array_values(array_unique($clean_user_prods))); ?>
    };
</script>

<script src="<?= base_url('assets/front/js/modules/auth-modals.js?v=' . (file_exists(FCPATH.'assets/front/js/modules/auth-modals.js') ? filemtime(FCPATH.'assets/front/js/modules/auth-modals.js') : time())); ?>"></script>
<script src="<?= base_url('assets/front/js/modules/player.js?v=' . (file_exists(FCPATH.'assets/front/js/modules/player.js') ? filemtime(FCPATH.'assets/front/js/modules/player.js') : time())); ?>"></script>

<?php if (isset($scripts) && is_array($scripts)): ?>
    <?php foreach ($scripts as $script): ?>
        <script src="<?= base_url($script . '?v=' . (file_exists(FCPATH . $script) ? filemtime(FCPATH . $script) : time())); ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>