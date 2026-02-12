<style>
    [x-cloak] { display: none !important; }
    .modal-hidden { display: none !important; }
    .modal-flex { display: flex !important; }
</style>

<div id="modal-login" class="modal-hidden fixed inset-0 z-[9999] items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm close-modal-trigger"></div>
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
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm close-modal-trigger"></div>
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
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm close-modal-trigger"></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 border border-gray-100">
        <h3 class="text-lg font-bold mb-4 text-slate-900">Recuperar Contraseña</h3>
        <form class="space-y-4">
            <input type="email" id="rec-email" placeholder="Tu Email" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-primary">
            <button type="button" id="btn-recuperar-accion" class="w-full py-2 bg-primary text-white font-bold rounded-lg hover:bg-blue-600">Enviar</button>
        </form>
        <button class="close-modal-btn mt-4 text-sm text-gray-500 w-full text-center hover:text-slate-900">Cancelar</button>
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

</div>
<div id="jquery_jplayer_1" class="jp-jplayer"></div>
<div id="jp_container_1" class="hidden"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<? echo base_url(); ?>js/jplayer/jquery.jplayer.min.js"></script>
<script src="<? echo base_url(); ?>js/jplayer/jplayer.playlist.min.js"></script>
<script src="<? echo base_url(); ?>js/main.js?v=2.9.2021"></script>

<script>
    $(document).ready(function() {

        function cerrarTodos() {
            $('#modal-login, #modal-register, #modal-recover').addClass('modal-hidden').removeClass('modal-flex');
        }

        $(document).on('click', '[data-target="#myModal"]', function(e) {
            e.preventDefault();
            e.stopPropagation();
            cerrarTodos();
            $('#modal-login').removeClass('modal-hidden').addClass('modal-flex').hide().fadeIn(200);
        });

        $(document).on('click', '[data-target="#myModalRegistrarme"], .trigger-register', function(e) {
            e.preventDefault();
            e.stopPropagation();
            cerrarTodos();
            $('#modal-register').removeClass('modal-hidden').addClass('modal-flex').hide().fadeIn(200);
        });

        $(document).on('click', '.trigger-recover', function(e) {
            e.preventDefault();
            cerrarTodos();
            $('#modal-recover').removeClass('modal-hidden').addClass('modal-flex').hide().fadeIn(200);
        });

        $('.close-modal-btn, .close-modal-trigger').click(function(e) {
            e.preventDefault();
            $(this).closest('.modal-flex').fadeOut(200, function() {
                $(this).addClass('modal-hidden').removeClass('modal-flex');
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
                    console.log("Respuesta Servidor:", response);

                    if(response.success === true || response.status == 'success' || response.status === true || response == 1) {
                        window.location.reload();
                    } else {
                        var mensajeError = response.message || response.msg || response.error || 'Error desconocido al ingresar';
                        alert(mensajeError);
                        btn.text(originalText).prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error AJAX:", error);
                    if(xhr.status == 200) {
                        window.location.reload();
                    } else {
                        alert('Error de conexión con el servidor.');
                        btn.text(originalText).prop('disabled', false);
                    }
                }
            });
        });

        $('#btn-registrar-accion').click(function() {
            alert('Función de registro pendiente de conectar al controlador');
        });
    });
</script>

</body>
</html>