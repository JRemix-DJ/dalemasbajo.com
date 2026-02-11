<? $this->load->helper('url'); ?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <title><? echo isset($title) ? $title : 'Dale Más Bajo'; ?></title>
    <meta name="description" content="<? echo isset($description) ? $description : 'La mejor plataforma para DJs'; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="<? echo base_url(); ?>images/icons/favicon.ico" type="image/x-icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#0066FF",      /* Tu azul principal */
                        secondary: "#020817",    /* Fondo oscuro casi negro */
                        accent: "#F8FAFC",       /* Blanco humo para fondos claros */
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Montserrat', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Estilos base */
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-heading { font-family: 'Montserrat', sans-serif; }

        /* Corrección para que el menú móvil no parpadee */
        [x-cloak] { display: none !important; }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body class="bg-white text-slate-900 antialiased">

<header x-data="{ mobileMenuOpen: false, scrolled: false }"
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-sm' : 'bg-white'"
        class="fixed top-0 w-full z-50 transition-all duration-300 border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <div class="flex-shrink-0 flex items-center">
                <a href="<? echo base_url(); ?>" class="flex items-center gap-2 group decoration-0">
                        <span class="text-2xl font-heading font-black tracking-tighter text-slate-900 group-hover:text-primary transition-colors">
                            DALE MÁS BAJO
                        </span>
                </a>
            </div>

            <nav class="hidden lg:flex items-center gap-8">
                <a href="<? echo base_url(); ?>" class="text-sm font-semibold text-slate-600 hover:text-primary transition-colors">Inicio</a>

                <div class="relative group h-20 flex items-center cursor-pointer">
                    <button class="text-sm font-semibold text-slate-600 group-hover:text-primary flex items-center gap-1 focus:outline-none">
                        Remixers <i class="fa-solid fa-chevron-down text-[10px] opacity-50 ml-1"></i>
                    </button>
                    <div class="absolute top-16 left-0 w-56 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0 p-2 z-50">
                        <? foreach($djs as $dj) { ?>
                            <a href="<? echo base_url('remixers/').$dj->id;?>" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary rounded-lg">
                                <? echo $dj->username; ?>
                            </a>
                        <? } ?>
                    </div>
                </div>

                <div class="relative group h-20 flex items-center cursor-pointer">
                    <button class="text-sm font-semibold text-slate-600 group-hover:text-primary flex items-center gap-1 focus:outline-none">
                        Géneros <i class="fa-solid fa-chevron-down text-[10px] opacity-50 ml-1"></i>
                    </button>
                    <div class="absolute top-16 left-0 w-56 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0 p-2 z-50 max-h-96 overflow-y-auto">
                        <? foreach($generos as $genre){ ?>
                            <a href="<? echo base_url('genero/').$genre->id; ?>" class="block px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary rounded-lg">
                                <? echo $genre->name; ?>
                            </a>
                        <? } ?>
                    </div>
                </div>

                <a href="<? echo base_url('drops');?>" class="text-sm font-semibold text-slate-600 hover:text-primary transition-colors">Drops</a>
                <a href="<? echo base_url('planes');?>" class="text-sm font-semibold text-slate-600 hover:text-primary transition-colors">Plans</a>
                <a href="<? echo base_url('pages/become_a_member');?>" class="text-sm font-semibold text-slate-600 hover:text-primary transition-colors">Be a remixer</a>
                <a href="<? echo base_url('pages/request_remix');?>" class="text-sm font-semibold text-slate-600 hover:text-primary transition-colors">Request Your Remix</a>
            </nav>

            <div class="flex items-center gap-4">
                <div class="hidden md:block h-6 w-px bg-gray-200"></div>

                <? if($this->session->userdata('is_logued_in')){ ?>
                    <div class="relative group" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-3 focus:outline-none">
                            <div class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center font-bold shadow-md shadow-primary/30">
                                <? echo substr($this->session->userdata('username'), 0, 1); ?>
                            </div>
                            <span class="hidden lg:block text-sm font-bold text-slate-700"><? echo $this->session->userdata('username'); ?></span>
                            <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                        </button>
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-xl p-1 z-50"
                             style="display: none;">
                            <a href="<? echo base_url(); ?>micuenta" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg">Mi Cuenta</a>
                            <div class="h-px bg-gray-100 my-1"></div>
                            <a href="<? echo base_url(); ?>login/logout/" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">Cerrar Sesión</a>
                        </div>
                    </div>
                <? }else{ ?>
                    <div class="hidden md:flex items-center gap-2">
                        <a href="#" data-toggle="modal" data-target="#myModal" class="px-4 py-2 text-sm font-bold text-slate-600 hover:text-primary transition-colors">
                            Ingresar
                        </a>
                        <a href="#" data-toggle="modal" data-target="#myModalRegistrarme" class="px-5 py-2.5 text-sm font-bold text-white bg-primary rounded-full hover:bg-blue-700 shadow-lg shadow-primary/30 transition-all hover:scale-105">
                            Registrarse
                        </a>
                    </div>
                <? } ?>

                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-slate-700 hover:text-primary focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-leave="opacity-0 -translate-y-2"
         class="lg:hidden absolute top-20 left-0 w-full bg-white border-t border-gray-100 shadow-xl z-40 max-h-[80vh] overflow-y-auto"
         style="display: none;">

        <div class="p-4 space-y-2">
            <a href="<? echo base_url(); ?>" class="block p-3 rounded-lg font-semibold text-slate-700 hover:bg-slate-50 hover:text-primary">Inicio</a>
            <a href="<? echo base_url('drops');?>" class="block p-3 rounded-lg font-semibold text-slate-700 hover:bg-slate-50 hover:text-primary">Drops</a>
            <a href="<? echo base_url('planes');?>" class="block p-3 rounded-lg font-semibold text-slate-700 hover:bg-slate-50 hover:text-primary">Planes</a>
            <a href="<? echo base_url('pages/become_a_member');?>" class="block p-3 rounded-lg font-semibold text-slate-700 hover:bg-slate-50 hover:text-primary">Be a remixer</a>
            <a href="<? echo base_url('pages/request_remix');?>" class="block p-3 rounded-lg font-semibold text-slate-700 hover:bg-slate-50 hover:text-primary">Request Your Remix</a>

            <div class="h-px bg-gray-100 my-2"></div>
            <div class="px-3 text-xs font-bold text-slate-400 uppercase tracking-wider">Remixers</div>

            <div class="grid grid-cols-2 gap-2 mt-2">
                <? foreach($djs as $dj) { ?>
                    <a href="<? echo base_url('remixers/').$dj->id;?>" class="block px-3 py-2 text-sm text-slate-600 hover:text-primary truncate">
                        <? echo $dj->username; ?>
                    </a>
                <? } ?>
            </div>

            <? if(!$this->session->userdata('is_logued_in')){ ?>
                <div class="h-px bg-gray-100 my-4"></div>
                <div class="flex flex-col gap-3">
                    <a href="#" data-toggle="modal" data-target="#myModal" class="w-full py-3 text-center font-bold text-slate-700 border border-slate-200 rounded-xl hover:bg-slate-50">Ingresar</a>
                    <a href="#" data-toggle="modal" data-target="#myModalRegistrarme" class="w-full py-3 text-center font-bold text-white bg-primary rounded-xl shadow-lg shadow-primary/20">Registrarse</a>
                </div>
            <? } ?>
        </div>
    </div>
</header>

<div class="h-20"></div>

<div class="w-full relative">