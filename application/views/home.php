<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><? echo $title; ?></title>
    <meta name="description" content="<? echo $description; ?>">
    <link rel="shortcut icon" href="<? echo base_url(); ?>images/icons/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/newhomeblue.css?v=' . filemtime(FCPATH.'css/newhomeblue.css')) ?>">
    <link rel="stylesheet" href="<?= base_url('assets/tailwind/tailwind.min.css?v=' . filemtime(FCPATH.'assets/tailwind/tailwind.min.css')) ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        a { text-decoration: none; }
        .btn { display: inline-block; font-weight: 400; text-align: center; vertical-align: middle; }

        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-heading { font-family: 'Montserrat', sans-serif; }

        [x-cloak] { display: none !important; }
        @media (max-width: 640px) {
            .msg-announcement {
                padding: 10px 12px;
                margin-top: 8px;
                margin-bottom: 8px;
                max-height: 140px;
                overflow: auto;
                border-radius: 12px;
            }

            .msg-announcement p {
                font-size: 10px;
                line-height: 1.05;
                margin: 0 0 8px 0;
            }

            .msg-announcement p:last-child {
                margin-bottom: 0;
            }
        }
        .hero-line{
            display:block;
            will-change: transform, opacity, filter;
            opacity: 0;
            animation-duration: 1.8s;
            animation-timing-function: cubic-bezier(.22,.61,.36,1);
            animation-iteration-count: 1;
            animation-fill-mode: forwards;
        }

        /* Direcciones */
        .hero-right{ animation-name: slideInRightOnce; }
        .hero-left { animation-name: slideInLeftOnce;  }


        .hero-right{ animation-delay: 0s; }
        .hero-left { animation-delay: 0.35s; }
        .hero-delay-2{ animation-delay: 0.7s; }
        .hero-delay-3{ animation-delay: 1s; }


        @keyframes slideInRightOnce{
            0%   { opacity:0; transform: translateX(-28px); filter: blur(2px); }
            100% { opacity:1; transform: translateX(0);     filter: blur(0);  }
        }

        @keyframes slideInLeftOnce{
            0%   { opacity:0; transform: translateX(28px);  filter: blur(2px); }
            100% { opacity:1; transform: translateX(0);     filter: blur(0);  }
        }

        /* Accesibilidad */
        @media (prefers-reduced-motion: reduce){
            .hero-line{
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
            }
        }
    </style>

    <meta property="og:image" content="<? echo base_url('images/dj_new.jpg'); ?>" />
    <meta property="og:title" content="DALE MAS BAJO" />
    <meta property="og:description" content="La mejor página para obtener tus remixes." />

</head>

<body>
<section class="home-hero">
    <video class="home-hero-video" autoplay muted loop>
        <source src="<? echo base_url('assets/new_video.mp4'); ?>" type="video/mp4">
    </video>
</section>
<section class="home">
    <div class="content">
        <a href="<? echo base_url(); ?>"
           class="absolute top-6 right-6 z-20 inline-flex items-center rounded-xl px-5 py-3">
            <img class="h-10 md:h-14 lg:h-16 w-auto"
                 src="<? echo base_url('images/logo_horizontal.png?v=1.2'); ?>"
                 alt="<? echo $title; ?>">
        </a>

        <div class="pl-4 inline-block max-w-none mb-12">
            <h1 class="mt-3 pb-4 text-white font-oswald font-medium leading-[0.92] tracking-tight
               text-[55px] sm:text-[60px] md:text-[75px] lg:text-[135px] uppercase">
                <span class="block hero-line hero-right">Boost your</span>
                <span class="block hero-line hero-left">DJ library</span>
                <span class="block hero-line hero-right hero-delay-2">With exclusive</span>
                <span class="block hero-line hero-left hero-delay-3">Music</span>
            </h1>

            <div class="mt-3 flex w-full gap-3">
                <a target="_blank"
                   href="https://videoremixpool.com/videos/"
                   class="btn flex-1 w-full font-bold text-center block py-5 sm:py-3 md:py-4">
                    VIDEOS
                </a>

                <a href="<? echo base_url('audios/'); ?>"
                   class="btn flex-1 w-full font-bold text-center block py-5 sm:py-3 md:py-4">
                    AUDIOS
                </a>
            </div>
        </div>
    </div>
    <div class="msg-announcement">
        <p>DaleMasBajo is a <b>service</b> primarily designed to enhance DJs’ performance. The edits on our site are produced by professionals with the sole purpose of improving DJs’ overall performance.</p>
        <p>By accessing this site, you certify that you are a working DJ and that you will use the material obtained solely to enhance your performance and will <b>NOT</b> sell, resell, or redistribute any of the files acquired through this website.</p>
        <p>Furthermore, you certify that you already own the original works contained within the edited compositions available on this site.</p>
    </div>
</section>
<div class="container mx-auto px-4 mt-10">
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
        <span class="bg-blue-100 p-2 rounded-full flex items-center justify-center w-8 h-8">
          <i class="fa fa-arrow-trend-up text-primary text-sm"></i>
        </span>
                Trending Now
            </h2>

            <a href="<? echo base_url('audios').'#trending' ?>"
               class="text-sm text-primary font-medium hover:underline">
                See all
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            <?
            $loop_trending = isset($trending_audios)
                    ? $trending_audios
                    : (isset($products) ? array_slice($products, 0, 5) : []);

            if(!empty($loop_trending)) {
                foreach($loop_trending as $audio) {

                    $img = base_url('audios/cover_mp3/' . $audio->id);
                    $title = isset($audio->name) ? $audio->name : (isset($audio->title) ? $audio->title : 'Unknown');
                    $artist = isset($audio->artist) ? $audio->artist : 'Unknown Artist';

                    $audiosUrl = base_url('audios').'#trending';
                    ?>
                    <a href="<? echo $audiosUrl; ?>"
                       class="block bg-white rounded-2xl p-3 shadow-sm hover:shadow-xl transition-all border-2 border-slate-100 group">

                        <div class="relative aspect-square rounded-xl overflow-hidden mb-3 bg-gray-100">
                            <img src="<? echo $img; ?>"
                                 alt="<? echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 onerror="this.onerror=null;this.src='<? echo base_url(); ?>images/default_cover.jpg';">

                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                <span class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-primary">
                  <i class="fa fa-play pl-1"></i>
                </span>
                            </div>
                        </div>

                        <h3 class="font-bold text-slate-900 text-sm truncate"><? echo $title; ?></h3>
                        <p class="text-xs text-slate-500 truncate"><? echo $artist; ?></p>
                    </a>
                <? }
            } else {
                echo '<p class="col-span-full text-center text-gray-400">No trendings now</p>';
            } ?>
        </div>
    </div>
</div>
<div class="mt-20 mb-10 text-center">
    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">All Plans Include</h2>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16 max-w-7xl mx-auto">

    <div class="flex flex-col items-center text-center p-6 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="w-12 h-12 bg-[#0066FF] text-white rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-blue-500/30">
            <i class="fa fa-mouse-pointer text-xl"></i>
        </div>
        <h3 class="font-bold text-slate-900 mb-2">1-Click Download</h3>
        <p class="text-medium font-oswald text-slate-500 leading-relaxed">
            Instantly download your favorite remixes in high quality
        </p>
    </div>

    <div class="flex flex-col items-center text-center p-6 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="w-12 h-12 bg-[#0066FF] text-white rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-blue-500/30">
            <i class="fa fa-headphones text-xl"></i>
        </div>
        <h3 class="font-bold text-slate-900 mb-2">HQ Audio</h3>
        <p class="text-medium font-oswald text-slate-500 leading-relaxed">
            Crystal clear 320kbps audio quality for professional use
        </p>
    </div>

    <div class="flex flex-col items-center text-center p-6 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="w-12 h-12 bg-[#0066FF] text-white rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-blue-500/30">
            <i class="fa fa-bolt text-xl"></i>
        </div>
        <h3 class="font-bold text-slate-900 mb-2">Instant Access</h3>
        <p class="text-medium font-oswald text-slate-500 leading-relaxed">
            Get immediate access to our entire library of remixes
        </p>
    </div>

</div>
<section class="album-header relative w-full overflow-hidden flex items-center justify-center text-center bg-white py-16">
    <div class="container relative z-10 flex flex-col items-center px-4">
        <h1 class="font-heading font-light text-slate-900 leading-tight tracking-normal text-[44px] md:text-[64px] mb-3">
            Choose Your Plan
        </h1>

        <p class="text-[18px] md:text-[20px] text-slate-500 font-normal max-w-2xl leading-relaxed">
            Get immediate access to premium DJ remixes and exclusive content
        </p>
    </div>
</section>

<section id="cuerpo" class="pb-16 md:pb-24 bg-white">
    <div class="container mx-auto px-4">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto items-start">

            <? if(isset($plans) && !empty($plans)){
                foreach($plans as $plan){

                    $plan_name = trim((string)$plan->name);

                    $is_standard = (stripos($plan_name, 'Standard') !== false);
                    $is_premium  = (stripos($plan_name, 'Premium')  !== false);
                    $is_3_months = (stripos($plan_name, '3 months') !== false) || preg_match('/\b3\b.*months/i', $plan_name);
                    $is_6_months = (stripos($plan_name, '6 months') !== false) || preg_match('/\b6\b.*months/i', $plan_name);
                    $is_annual   = (stripos($plan_name, 'Annual')   !== false);

                    $show_most_popular = $is_standard;

                    // ---- NUEVO: label para Request Your Remix ----
                    $request_remix_label = null;

                    if ($is_standard) {
                        $request_remix_label = '3';
                    } else if ($is_premium) {
                        $request_remix_label = '5';
                    } else if ($is_3_months || $is_6_months || $is_annual) {
                        $request_remix_label = '3 Monthly';
                    }

                    $show_request_remix = ($request_remix_label !== null);

                    $es_ilimitado = ($plan->ilimitado_activo == 1);
                    $is_highlighted = ($es_ilimitado || $is_standard);

                    if ($is_highlighted) {
                        $container_classes = 'relative w-full h-full rounded-2xl p-[2px] bg-gradient-to-b from-[#0066FF] to-slate-900 shadow-xl z-10';
                        $inner_classes = 'bg-white rounded-[14px] h-full p-6 md:p-8 flex flex-col';
                    } else {
                        $container_classes = 'relative w-full h-full rounded-2xl border border-slate-200 bg-white hover:border-slate-300 shadow-sm transition-all duration-300';
                        $inner_classes = 'h-full p-6 md:p-8 flex flex-col';
                    }

                    if ($is_highlighted) {
                        $btn_class = 'bg-[rgb(0,102,255)] text-white shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:bg-blue-700';
                    } else {
                        $btn_class = 'bg-[rgb(0,102,255)] text-white hover:bg-blue-700';
                    }

                    if($this->session->userdata('is_logued_in')){
                        $btn_href = base_url()."getplan/?plan_id=".$plan->id."&currency=USD";
                        $btn_attrs = "";
                    } else {
                        $btn_href = "javascript:void(0);";
                        $btn_attrs = 'data-toggle="modal" data-target="#myModal"';
                    }
                    ?>

                    <div class="<? echo $container_classes; ?>">

                        <? if($show_most_popular){ ?>
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-[#0066FF] to-slate-900 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-md uppercase tracking-wide flex items-center gap-2 whitespace-nowrap">
                                <i class="fa fa-star text-white"></i> Most Popular
                            </div>
                        <? } ?>

                        <div class="<? echo $inner_classes; ?>">

                            <div class="mb-6 text-center">
                                <h2 class="text-xl font-bold text-slate-900 uppercase tracking-wide mb-2">
                                    <?= $plan->name; ?>
                                </h2>
                                <p class="text-slate-500 text-sm h-10 overflow-hidden text-ellipsis leading-relaxed">
                                    <? echo $plan->description; ?>
                                </p>
                            </div>

                            <div class="flex items-baseline justify-center gap-1 mb-8 text-center">
                                <span class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight">
                                    $<? echo $plan->price; ?>
                                </span>
                                <span class="text-slate-400 font-medium">
                                    / <? echo $plan->duration; ?> days
                                </span>
                            </div>

                            <ul class="space-y-4 mb-8 flex-1">
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                        <i class="fa fa-check text-primary text-xs"></i>
                                    </div>
                                    <span class="ml-3 text-slate-700 font-medium">
                                        <? if ($plan->ilimitado_activo == 1) { ?>
                                            <span class="text-primary font-bold">Unlimited Audio Downloads</span>
                                        <? } else { ?>
                                            <span class="font-bold"><? if($plan->tokens!=0 && $plan->tokens!=NULL){ echo $plan->tokens; }else{ echo '0'; } ?></span> Audio Downloads
                                        <? } ?>
                                    </span>
                                </li>

                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                        <i class="fa fa-check text-primary text-xs"></i>
                                    </div>
                                    <span class="ml-3 text-slate-600 text-sm">Automatic Renewal</span>
                                </li>

                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                        <i class="fa fa-check text-primary text-xs"></i>
                                    </div>
                                    <span class="ml-3 text-slate-600 text-sm">New music daily</span>
                                </li>

                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                        <i class="fa fa-check text-primary text-xs"></i>
                                    </div>
                                    <span class="ml-3 text-slate-600 text-sm">Direct downloads (1 Click)</span>
                                </li>

                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                        <i class="fa fa-check text-primary text-xs"></i>
                                    </div>
                                    <span class="ml-3 text-slate-600 text-sm">Intro, extended, remix, breakdown, transition and more</span>
                                </li>

                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                        <i class="fa fa-check text-primary text-xs"></i>
                                    </div>
                                    <span class="ml-3 text-slate-600 text-sm">Advanced Search</span>
                                </li>

                                <? if($show_request_remix){ ?>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                            <i class="fa fa-check text-primary text-xs"></i>
                                        </div>
                                        <span class="ml-3 text-slate-700 font-semibold">
                                            <span class="text-primary font-extrabold"><? echo htmlspecialchars($request_remix_label, ENT_QUOTES, 'UTF-8'); ?></span>
                                            Access to <span class="text-primary font-extrabold">Request Your Remix</span>
                                        </span>
                                    </li>
                                <? } ?>
                            </ul>

                            <a href="<? echo $btn_href; ?>" <? echo $btn_attrs; ?>
                               class="w-full block text-center py-4 rounded-xl font-bold transition-all duration-200 transform hover:-translate-y-1 <? echo $btn_class; ?>">
                                Get Plan
                            </a>

                            <p class="text-center text-xs text-slate-400 mt-4">Secure payment guaranteed</p>

                        </div>
                    </div>
                <? } } else { ?>
                <div class="col-span-full text-center py-10">
                    <p class="text-xl text-slate-500">No plans available at the moment.</p>
                </div>
            <? } ?>
        </div>
    </div>
</section>
<script>
    (function () {
        const header = document.getElementById('siteHeader');
        const firstLink = document.getElementById('navFirstLink');

        function setSplit() {
            if (!header) return;

            if (window.innerWidth < 1024) {
                header.style.setProperty('--blue-cut', '170px');
                return;
            }

            if (!firstLink) return;

            const h = header.getBoundingClientRect();
            const a = firstLink.getBoundingClientRect();
            const cut = Math.max(340, Math.floor(a.left - h.left - 48));
            header.style.setProperty('--blue-cut', cut + 'px');
        }

        let raf = 0;
        function schedule() {
            if (raf) return;
            raf = requestAnimationFrame(() => {
                raf = 0;
                setSplit();
            });
        }

        window.addEventListener('DOMContentLoaded', schedule, { passive: true });
        window.addEventListener('load', schedule, { passive: true });
        window.addEventListener('resize', schedule, { passive: true });
        window.addEventListener('orientationchange', schedule, { passive: true });

        window.addEventListener('pageshow', schedule, { passive: true });
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) schedule();
        }, { passive: true });

        if (window.visualViewport) {
            visualViewport.addEventListener('resize', schedule, { passive: true });
            visualViewport.addEventListener('scroll', schedule, { passive: true });
        }

        schedule();
    })();
</script>