<?php $this->load->helper('url'); ?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <title><?= isset($title) ? $title : 'Dale Más Bajo'; ?></title>
    <meta name="description" content="<?= isset($description) ? $description : 'La mejor plataforma para DJs'; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="<?= base_url('assets/front/img/icons/favicon.ico'); ?>" type="image/x-icon"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/build/tailwind.min.css?v=' . (file_exists(FCPATH.'assets/build/tailwind.min.css') ? filemtime(FCPATH.'assets/build/tailwind.min.css') : time())) ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/front/css/modules/auth-modals.css'); ?>?v=<?= file_exists(FCPATH . 'assets/front/css/modules/auth-modals.css') ? filemtime(FCPATH . 'assets/front/css/modules/auth-modals.css') : '1.0'; ?>">
    <?php if (isset($styles) && is_array($styles)): ?>
        <?php foreach ($styles as $style): ?>
            <link rel="stylesheet" href="<?= base_url($style); ?>?v=<?= file_exists(FCPATH . $style) ? filemtime(FCPATH . $style) : '1.0'; ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <link rel="stylesheet" href="<?= base_url('assets/front/css/modules/header.css'); ?>?v=<?= file_exists(FCPATH . 'assets/front/css/modules/header.css') ? filemtime(FCPATH . 'assets/front/css/modules/header.css') : '1.0'; ?>">
</head>
<body class="bg-white text-slate-900 antialiased">

<header id="siteHeader" class="fixed top-0 w-full z-50 transition-all duration-300 bg-white">

    <div class="nav-split-bg absolute inset-0 pointer-events-none"></div>

    <div class="w-full px-4 sm:px-6 lg:px-10 relative shadow-lg">
        <div class="flex items-center h-20">
            <div class="logo-slot">
                <a href="<?= base_url(); ?>" class="flex items-center gap-2 group decoration-0">
                    <img src="<?= base_url('assets/front/img/HORIZONTAL--video.png'); ?>" alt="dalemasbajo"
                         class="h-10 md:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                </a>
            </div>

            <nav class="hidden lg:flex flex-1 items-center justify-center gap-8">
                <a id="navFirstLink" href="<?= base_url('audios'); ?>"
                   class="text-sm font-semibold text-slate-700 hover:text-primary transition-colors">Audios</a>

                <div class="relative group h-20 flex items-center cursor-pointer">
                    <button type="button"
                            class="text-sm font-semibold text-slate-700 group-hover:text-primary flex items-center gap-1 focus:outline-none">
                        Remixers <i class="fa-solid fa-chevron-down text-[10px] opacity-60 ml-1"></i>
                    </button>
                    <div class="absolute top-16 -left-20 w-[600px] bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0 p-4 z-50">
                        <div class="grid grid-cols-3 gap-x-4 gap-y-2 max-h-[60vh] overflow-y-auto custom-scrollbar">
                            <?php if (isset($djs) && !empty($djs)) {
                                foreach ($djs as $dj) { ?>
                                    <a href="<?= base_url('remixers/') . $dj->id; ?>"
                                       class="block px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary rounded-lg truncate transition-colors">
                                        <i class="fa-solid fa-user-music text-xs opacity-40 mr-2"></i><?= $dj->username; ?>
                                    </a>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>

                <div class="relative group h-20 flex items-center cursor-pointer">
                    <button type="button"
                            class="text-sm font-semibold text-slate-700 group-hover:text-primary flex items-center gap-1 focus:outline-none">
                        Genre <i class="fa-solid fa-chevron-down text-[10px] opacity-60 ml-1"></i>
                    </button>
                    <div class="absolute top-16 -left-32 w-[700px] bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform translate-y-2 group-hover:translate-y-0 p-4 z-50">
                        <div class="grid grid-cols-4 gap-x-2 gap-y-2 max-h-[60vh] overflow-y-auto custom-scrollbar">
                            <?php if (isset($generos) && !empty($generos)) {
                                foreach ($generos as $genre) { ?>
                                    <a href="<?= base_url('genero/') . $genre->id; ?>"
                                       class="block px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-primary rounded-lg truncate transition-colors">
                                        <?= $genre->name; ?>
                                    </a>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>

                <a href="<?= base_url('drops'); ?>"
                   class="text-sm font-semibold text-slate-700 hover:text-primary transition-colors">Drops</a>
                <a href="<?= base_url('planes'); ?>"
                   class="text-sm font-semibold text-slate-700 hover:text-primary transition-colors">Plans</a>
                <a href="<?= base_url('pages/become_a_member'); ?>"
                   class="text-sm font-semibold text-slate-700 hover:text-primary transition-colors">Be a remixer</a>

                <a href="<?= base_url('pages/request_remix'); ?>"
                   class="inline-flex items-center px-5 py-3 rounded-full bg-[rgb(0,102,255)] text-white text-sm font-bold hover:scale-[1.03] transition-all">
                    Request Your Remix
                </a>

                <?php if ($this->session->userdata('is_logued_in')) { ?>
                    <div class="relative ml-4">
                        <button id="userMenuBtn" type="button"
                                class="flex items-center gap-3 focus:outline-none"
                                aria-haspopup="menu" aria-expanded="false">
                            <div class="w-9 h-9 rounded-full bg-[rgb(0,102,255)] text-white flex items-center justify-center font-bold shadow-md shadow-blue-500/30">
                                <?= substr($this->session->userdata('username'), 0, 1); ?>
                            </div>
                            <span class="hidden lg:block text-sm font-bold text-slate-700"><?= $this->session->userdata('username'); ?></span>
                            <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                        </button>

                        <div id="userMenu"
                             class="hidden absolute right-0 top-full mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-xl p-1 z-50"
                             role="menu" aria-labelledby="userMenuBtn">
                            <a href="<?= base_url('micuenta'); ?>"
                               class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg"
                               role="menuitem">My Account</a>
                            <div class="h-px bg-gray-100 my-1"></div>
                            <a href="<?= base_url('login/logout/'); ?>"
                               class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg"
                               role="menuitem">Log out</a>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="hidden md:flex items-center gap-2 ml-4 mr-4">
                        <a href="#" data-toggle="modal" data-target="#myModal"
                           class="trigger-login px-4 py-2 text-sm font-bold text-slate-700 hover:text-primary transition-colors">
                            Sign in
                        </a>
                        <a href="#" data-toggle="modal" data-target="#myModalRegistrarme"
                           class="trigger-register text-sm font-bold mr-10 inline-flex items-center rounded-full bg-white text-[rgb(0,102,255)] px-4 py-2 border-2 border-[rgb(0,102,255)] hover:bg-[rgb(0,102,255)] hover:text-white transition-colors duration-200">
                            Sign Up
                        </a>
                    </div>
                <?php } ?>
            </nav>

            <div class="hidden md:flex items-center justify-end">
                <?php if ($this->session->userdata('is_logued_in')) {
                    $tokens = (int)$this->session->userdata('tokens');
                    $is_unlimited = ($this->session->userdata('is_user_unlimited') || $this->session->userdata('role') == 1);

                    if ($is_unlimited || $tokens > 0) { ?>
                        <div class="ml-4 inline-flex items-center rounded-full bg-white text-[rgb(0,102,255)] px-4 py-2"
                             style="border:2px solid rgb(0,102,255);">
                            <span class="text-sm font-bold tracking-wider text-[rgb(0,102,255)] mr-1">Downloads</span>
                            <?php if ($is_unlimited) { ?>
                                <div class="flex items-center gap-2 font-bold text-sm">
                                    <i class="fa-solid fa-infinity text-[rgb(0,102,255)]"></i>
                                    <span>UNLIMITED</span>
                                </div>
                            <?php } else { ?>
                                <div class="flex items-center gap-2 font-bold text-sm">
                                    <span class="token-count"><?= $tokens; ?></span>
                                    <i class="fa-solid fa-cloud-arrow-down text-[rgb(0,102,255)]"></i>
                                </div>
                            <?php } ?>
                        </div>
                    <?php }
                } ?>
            </div>

            <button id="mobileMenuBtn" type="button"
                    class="lg:hidden p-2 text-slate-700 hover:text-primary focus:outline-none ml-auto"
                    aria-controls="mobileMenu" aria-expanded="false">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>
    </div>

    <div id="mobileMenu"
         class="hidden lg:hidden absolute top-20 left-0 w-full bg-white backdrop-blur-md border-t border-slate-200 shadow-xl z-40 max-h-[80vh] overflow-y-auto">
        <div class="p-4 space-y-2">
            <?php if ($this->session->userdata('is_logued_in')) { ?>
                <div class="rounded-2xl border border-slate-200 bg-white backdrop-blur-md p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[rgb(0,102,255)] text-white flex items-center justify-center font-bold shadow-md shadow-blue-500/30">
                            <?= substr($this->session->userdata('username'), 0, 1); ?>
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-bold text-slate-900 truncate"><?= $this->session->userdata('username'); ?></div>
                            <div class="text-xs text-slate-500 truncate">Signed in</div>
                        </div>
                    </div>

                    <?php
                    $tokens = (int)$this->session->userdata('tokens');
                    $is_unlimited = ($this->session->userdata('is_user_unlimited') || $this->session->userdata('role') == 1);
                    if ($is_unlimited || $tokens > 0) { ?>
                        <div class="mt-3 inline-flex items-center rounded-full bg-[rgb(0,102,255)] text-white shadow-lg shadow-blue-500/20 px-4 py-2 w-full justify-between">
                            <span class="text-[10px] uppercase font-bold tracking-wider text-white/80">Downloads</span>
                            <?php if ($is_unlimited) { ?>
                                <span class="flex items-center gap-2 font-bold text-sm"><i class="fa-solid fa-infinity"></i> UNLIMITED</span>
                            <?php } else { ?>
                                <span class="flex items-center gap-2 font-bold text-sm"><span class="token-count"><?= $tokens; ?></span> <i class="fa-solid fa-cloud-arrow-down"></i></span>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <div class="mt-3 grid grid-cols-2 gap-3">
                        <a href="<?= base_url('micuenta'); ?>"
                           class="w-full py-3 text-center font-bold text-white bg-[rgb(0,102,255)] rounded-xl shadow-lg shadow-blue-500/20 hover:scale-[1.01] transition-all">
                            My Account
                        </a>
                        <a href="<?= base_url('login/logout/'); ?>"
                           class="w-full py-3 text-center font-bold text-red-600 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 transition-all">
                            Log out
                        </a>
                    </div>
                </div>
            <?php } ?>

            <a href="<?= base_url(); ?>" class="block p-3 rounded-lg font-semibold text-slate-800 hover:bg-slate-50">Home</a>
            <a href="<?= base_url('audios'); ?>" class="block p-3 rounded-lg font-semibold text-slate-800 hover:bg-slate-50">Audios</a>
            <a href="<?= base_url('drops'); ?>" class="block p-3 rounded-lg font-semibold text-slate-800 hover:bg-slate-50">Drops</a>
            <a href="<?= base_url('planes'); ?>" class="block p-3 rounded-lg font-semibold text-slate-800 hover:bg-slate-50">Plans</a>
            <a href="<?= base_url('pages/become_a_member'); ?>" class="block p-3 rounded-lg font-semibold text-slate-800 hover:bg-slate-50">Be a remixer</a>

            <a href="<?= base_url('pages/request_remix'); ?>"
               class="mt-2 block p-3 rounded-lg font-bold text-white bg-[rgb(0,102,255)] shadow-lg shadow-blue-500/30 text-center hover:scale-[1.01] transition-all">
                Request Your Remix
            </a>

            <div class="h-px bg-slate-200 my-3"></div>

            <button id="mobileRemixersBtn" type="button"
                    class="w-full flex items-center justify-between p-3 rounded-lg font-semibold text-slate-800 hover:bg-slate-50"
                    aria-controls="mobileRemixers" aria-expanded="false">
                <span>Remixers</span>
                <i id="mobileRemixersIcon" class="fa-solid fa-chevron-down text-xs text-slate-500 transition-transform"></i>
            </button>

            <div id="mobileRemixers" class="hidden">
                <div class="grid grid-cols-2 gap-2 mt-2">
                    <?php if (isset($djs) && !empty($djs)) {
                        foreach ($djs as $dj) { ?>
                            <a href="<?= base_url('remixers/') . $dj->id; ?>"
                               class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg truncate">
                                <?= $dj->username; ?>
                            </a>
                        <?php }
                    } ?>
                </div>
            </div>

            <button id="mobileGenresBtn" type="button"
                    class="w-full flex items-center justify-between p-3 rounded-lg font-semibold text-slate-800 hover:bg-slate-50"
                    aria-controls="mobileGenres" aria-expanded="false">
                <span>Genres</span>
                <i id="mobileGenresIcon" class="fa-solid fa-chevron-down text-xs text-slate-500 transition-transform"></i>
            </button>

            <div id="mobileGenres" class="hidden">
                <div class="grid grid-cols-2 gap-2 mt-2">
                    <?php if (isset($generos) && !empty($generos)) {
                        foreach ($generos as $genre) { ?>
                            <a href="<?= base_url('genero/') . $genre->id; ?>"
                               class="block px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 rounded-lg truncate">
                                <?= $genre->name; ?>
                            </a>
                        <?php }
                    } ?>
                </div>
            </div>

            <?php if (!$this->session->userdata('is_logued_in')) { ?>
                <div class="h-px bg-slate-200 my-4"></div>
                <div class="flex flex-col gap-3">
                    <a href="#" data-toggle="modal" data-target="#myModal"
                       class="trigger-login w-full py-3 text-center font-bold text-slate-800 border border-slate-200 rounded-xl hover:bg-slate-50">Sign in</a>
                    <a href="#" data-toggle="modal" data-target="#myModalRegistrarme"
                       class="trigger-register w-full py-3 text-center font-bold text-white bg-[rgb(0,102,255)] rounded-xl shadow-lg shadow-blue-500/20">Sign up</a>
                </div>
            <?php } ?>
        </div>
    </div>
</header>

<div class="h-20"></div>
<div class="w-full relative">

<script>
(function () {
    const header = document.getElementById("siteHeader");
    const firstLink = document.getElementById("navFirstLink");

    function setSplit() {
        if (!header) return;
        if (window.innerWidth < 1024) {
            header.style.setProperty('--blue-cut', '300px');
            return;
        }
        if (!firstLink) return;
        const h = header.getBoundingClientRect();
        const a = firstLink.getBoundingClientRect();
        const cut = Math.max(340, Math.floor(a.left - h.left - 48));
        header.style.setProperty('--blue-cut', cut + 'px');
    }

    window.addEventListener('resize', setSplit);
    window.addEventListener('load', setSplit);
    setSplit();
})();
(function () {
    const header = document.getElementById('siteHeader');
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const userBtn = document.getElementById('userMenuBtn');
    const userMenu = document.getElementById('userMenu');
    const remixersBtn = document.getElementById('mobileRemixersBtn');
    const remixersPanel = document.getElementById('mobileRemixers');
    const remixersIcon = document.getElementById('mobileRemixersIcon');
    const genresBtn = document.getElementById('mobileGenresBtn');
    const genresPanel = document.getElementById('mobileGenres');
    const genresIcon = document.getElementById('mobileGenresIcon');

    function setScrolled() {
        if (!header) return;
        const scrolled = window.scrollY > 8;
        header.classList.toggle('shadow-xl', scrolled);
        header.classList.toggle('backdrop-blur-md', scrolled);
    }

    function closeMobile() {
        if (!mobileMenu || !mobileBtn) return;
        mobileMenu.classList.add('hidden');
        mobileBtn.setAttribute('aria-expanded', 'false');
    }

    function toggleMobile() {
        if (!mobileMenu || !mobileBtn) return;
        const isOpen = !mobileMenu.classList.contains('hidden');
        if (isOpen) closeMobile();
        else {
            mobileMenu.classList.remove('hidden');
            mobileBtn.setAttribute('aria-expanded', 'true');
        }
    }

    function closeUserMenu() {
        if (!userMenu || !userBtn) return;
        userMenu.classList.add('hidden');
        userBtn.setAttribute('aria-expanded', 'false');
    }

    function toggleUserMenu() {
        if (!userMenu || !userBtn) return;
        const isOpen = !userMenu.classList.contains('hidden');
        if (isOpen) closeUserMenu();
        else {
            userMenu.classList.remove('hidden');
            userBtn.setAttribute('aria-expanded', 'true');
        }
    }

    function closePanel(btn, panel, icon) {
        if (!btn || !panel) return;
        panel.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
        if (icon) icon.style.transform = 'rotate(0deg)';
    }

    function togglePanel(btn, panel, icon) {
        if (!btn || !panel) return;
        const isOpen = !panel.classList.contains('hidden');
        if (isOpen) closePanel(btn, panel, icon);
        else {
            panel.classList.remove('hidden');
            btn.setAttribute('aria-expanded', 'true');
            if (icon) icon.style.transform = 'rotate(180deg)';
        }
    }

    window.addEventListener('scroll', setScrolled, {passive: true});
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) closeMobile();
    });

    if (mobileBtn) mobileBtn.addEventListener('click', (e) => {
        e.preventDefault();
        toggleMobile();
    });

    if (userBtn) userBtn.addEventListener('click', (e) => {
        e.preventDefault();
        toggleUserMenu();
    });

    if (remixersBtn) remixersBtn.addEventListener('click', (e) => {
        e.preventDefault();
        togglePanel(remixersBtn, remixersPanel, remixersIcon);
    });

    if (genresBtn) genresBtn.addEventListener('click', (e) => {
        e.preventDefault();
        togglePanel(genresBtn, genresPanel, genresIcon);
    });

    document.addEventListener('click', (e) => {
        if (mobileMenu && mobileBtn) {
            const insideMobile = mobileMenu.contains(e.target) || mobileBtn.contains(e.target);
            if (!insideMobile) closeMobile();
        }
        if (userMenu && userBtn) {
            const insideUser = userMenu.contains(e.target) || userBtn.contains(e.target);
            if (!insideUser) closeUserMenu();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeMobile();
            closeUserMenu();
            closePanel(remixersBtn, remixersPanel, remixersIcon);
            closePanel(genresBtn, genresPanel, genresIcon);
        }
    });

    setScrolled();
})();
</script>