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


    <link rel="stylesheet" href="<? echo base_url('css/newhomeblue.css?v=1.0.4'); ?>">

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
        a { text-decoration: none; }
        .btn { display: inline-block; font-weight: 400; text-align: center; vertical-align: middle; }

        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-heading { font-family: 'Montserrat', sans-serif; }

        [x-cloak] { display: none !important; }
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
        <a href="<? echo base_url(); ?>" id="logo">
            <img src="<? echo base_url('images/logo_horizontal.png?v=1.2'); ?>" alt="<? echo $title; ?>">
        </a>
        <div id="btnvideos">
            <a target=“_blank” href="https://videoremixpool.com/videos/" class="btn">Videos</a><br>
        </div>
        <div id="btnaudios">
            <a href="<? echo base_url('audios/') ?>" class="btn">Audios</a>
        </div>
    </div>
    <div class="msg-announcement">
        <p>DaleMasBajo es un <b>servicio</b> diseñado principalmente para mejorar el rendimiento de DJs. Las ediciones de nuestro sitio son producidas por profesionales con el único propósito de mejorar el rendimiento general de los DJs.</p>
        <p>Al ingresar usted certifica que es un DJ que trabaja y que utilizará el material obtenido con el único propósito de mejorar su rendimiento y <b>NO</b> venderá, revenderá ni redistribuirá ninguno de los archivos. adquiridos dentro de este sitio web.</p>
        <p>Además usted certifica que ya está en posesión de las obras originales contenidas en las composiciones editadas en este sitio.</p>
    </div>
</section>
