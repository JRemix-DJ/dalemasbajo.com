<style>
    [x-cloak] { display: none !important; }
</style>

<div x-data="{ open: false }"
     x-cloak
     @keydown.escape.window="open = false"
     class="relative z-[100]"
     id="modal-login-container">

    <button id="openLoginModalBtn" @click="open = true" style="display:none"></button>

    <div x-show="open"
         style="display: none;"
         x-transition.opacity
         class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

    <div x-show="open"
         style="display: none;"
         x-transition.scale.origin.center
         class="fixed inset-0 flex items-center justify-center p-4">

        <div @click.outside="open = false" class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-lg font-bold text-slate-900">Iniciar Sesión</h3>
                <button @click="open = false" class="text-gray-400 hover:text-red-500 transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <div class="p-6">
                <form id="login-form" class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="email">Email</label>
                        <input type="email" name="email" id="email" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="password">Contraseña</label>
                        <input type="password" name="password" id="password" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    </div>

                    <div class="text-right">
                        <a href="#" @click="open = false; document.getElementById('openRecoverModalBtn').click()" class="text-sm text-primary font-medium hover:underline">¿Olvidaste tu contraseña?</a>
                    </div>

                    <button type="button" id="login-btn" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full">
                        Ingresar
                    </button>
                </form>
            </div>
            <div class="p-4 bg-gray-50 text-center text-sm border-t border-gray-100">
                ¿No tienes cuenta? <a href="#" @click="open = false; document.getElementById('openRegisterModalBtn').click()" class="text-primary font-bold hover:underline">Regístrate gratis</a>
            </div>
        </div>
    </div>
</div>

<div x-data="{ open: false }"
     x-cloak
     @keydown.escape.window="open = false"
     class="relative z-[100]"
     id="modal-register-container">

    <button id="openRegisterModalBtn" @click="open = true" style="display:none"></button>

    <div x-show="open" style="display: none;" x-transition.opacity class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

    <div x-show="open" style="display: none;" x-transition.scale.origin.center class="fixed inset-0 flex items-center justify-center p-4">
        <div @click.outside="open = false" class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-lg font-bold text-slate-900">Crear Cuenta</h3>
                <button @click="open = false" class="text-gray-400 hover:text-red-500 transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="registrar-form" class="space-y-3">
                    <div class="space-y-2">
                        <label class="text-sm font-medium" for="registro-email">Email</label>
                        <input type="email" name="registro-email" id="registro-email" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium" for="registro-username">Usuario</label>
                        <input type="text" name="registro-username" id="registro-username" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-2">
                            <label class="text-sm font-medium" for="registro-password">Contraseña</label>
                            <input type="password" name="registro-password" id="registro-password" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium" for="registro-repeatpassword">Repetir</label>
                            <input type="password" name="registro-repeatpassword" id="registro-repeatpassword" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                        </div>
                    </div>
                    <button type="button" id="registrar-btn" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 bg-slate-900 text-white hover:bg-slate-800 h-10 px-4 py-2 w-full mt-2">
                        Registrarme
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div x-data="{ open: false }" x-cloak class="relative z-[100]" id="modal-recover-container">
    <button id="openRecoverModalBtn" @click="open = true" style="display:none"></button>
    <div x-show="open" style="display: none;" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div x-show="open" style="display: none;" class="fixed inset-0 flex items-center justify-center p-4">
        <div @click.outside="open = false" class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold mb-4">Recuperar Contraseña</h3>
            <form id="recuperar-form" class="space-y-4">
                <input type="email" name="email" id="recuperar-email" placeholder="Tu Email" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                <button type="button" id="recuperar-btn" class="w-full bg-primary text-primary-foreground h-10 px-4 py-2 rounded-md font-medium hover:bg-primary/90">Enviar</button>
            </form>
            <button @click="open = false" class="mt-4 text-sm text-muted-foreground w-full text-center hover:text-foreground">Cancelar</button>
        </div>
    </div>
</div>

<footer class="border-t border-gray-200 mt-auto" style="background-color: oklch(.985 .002 247.839);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12">

            <div class="col-span-1 md:col-span-1 flex flex-col gap-4">
                <a href="<? echo base_url(); ?>" class="flex items-center gap-2">
                    <span class="text-xl font-bold tracking-tighter text-foreground">
                        DALE MÁS BAJO
                    </span>
                </a>
                <p class="text-sm text-muted-foreground leading-relaxed">
                    Descubre nuevos remixes cada día en nuestro sitio web.
                </p>
            </div>

            <div>
                <h3 class="font-semibold text-foreground mb-4">Plataforma</h3>
                <ul class="space-y-3 text-sm text-muted-foreground">
                    <li><a href="<? echo base_url('drops'); ?>" class="hover:text-primary transition-colors">Drops Exclusivos</a></li>
                    <li><a href="<? echo base_url('planes'); ?>" class="hover:text-primary transition-colors">Planes de Suscripción</a></li>
                    <li><a href="<? echo base_url('search'); ?>" class="hover:text-primary transition-colors">Explorar Música</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-semibold text-foreground mb-4">Ayuda</h3>
                <ul class="space-y-3 text-sm text-muted-foreground">
                    <li><a href="<? echo base_url('faq'); ?>" class="hover:text-primary transition-colors">Preguntas Frecuentes</a></li>
                    <li><a href="<? echo base_url('pages/terms_conditions/'); ?>" class="hover:text-primary transition-colors">Términos y Condiciones</a></li>
                    <li><a href="<? echo base_url('pages/become_a_member/'); ?>" class="hover:text-primary transition-colors">Be a Remixer</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-semibold text-foreground mb-4">Síguenos</h3>

                <ul class="space-x-3">
                    <a href="https://www.facebook.com/dalemasbajo/" target="_blank" class="text-muted-foreground hover:text-primary transition-colors">
                        <i class="fa-brands fa-facebook-f text-lg"></i>
                    </a>
                    <a href="https://www.instagram.com/dalemasbajo/" target="_blank" class="text-muted-foreground hover:text-primary transition-colors">
                        <i class="fa-brands fa-instagram text-lg"></i>
                    </a>
                    <a href="https://soundcloud.com/dalemasbajo" target="_blank" class="text-muted-foreground hover:text-primary transition-colors">
                        <i class="fa-brands fa-soundcloud text-lg"></i>
                    </a>
                </ul>
            </div>
        </div>

        <div class="border-t border-border mt-12 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm text-muted-foreground">
                &copy; <? echo date('Y'); ?> Dale Más Bajo. Todos los derechos reservados.
            </p>
            <p class="text-xs text-muted-foreground flex items-center gap-1">
                Desarrollado por <span class="font-semibold text-foreground">Chex</span>
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
    // Conector Header -> Modales Alpine
    $(document).on('click', '[data-target="#myModal"]', function(e) {
        e.preventDefault();
        // Disparamos el click en el botón oculto dentro del componente Alpine
        document.getElementById('openLoginModalBtn').click();
    });

    $(document).on('click', '[data-target="#myModalRegistrarme"]', function(e) {
        e.preventDefault();
        document.getElementById('openRegisterModalBtn').click();
    });

    // Lógica AJAX para el Login (Reemplazo de la lógica vieja de Bootstrap)
    $('#login-btn').on('click', function() {
        var btn = $(this);
        var originalText = btn.text();
        btn.text('Cargando...').prop('disabled', true);

        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
            url: '<? echo base_url("login/front"); ?>',
            type: 'POST',
            data: { email: email, password: password },
            dataType: 'json',
            success: function(response) {
                if(response.status == 'success') {
                    window.location.reload();
                } else {
                    alert(response.message || 'Error al ingresar');
                    btn.text(originalText).prop('disabled', false);
                }
            },
            error: function() {
                alert('Error de conexión con el servidor');
                btn.text(originalText).prop('disabled', false);
            }
        });
    });
</script>

</body>
</html>