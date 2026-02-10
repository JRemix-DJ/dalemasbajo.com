<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><? echo $title; ?></title>
    <meta name="description" content="<? echo $description; ?>">
    <link rel="shortcut icon" href="<? echo base_url(); ?>images/icons/favicon.ico">
    <link rel="stylesheet" href="<? echo base_url('css/newhome.css'); ?>">
    <link rel="stylesheet" href="<? echo base_url('css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<? echo base_url('css/colors/blue.css'); ?>">
    <link rel="stylesheet" href="<? echo base_url('css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<? echo base_url('css/newhomeblue.css?v=1.0.4'); ?>">
    <link rel="stylesheet" href="<? echo base_url(); ?>css/table.css?v=1.14">
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
    <section id="cuerpo">
        <div class="container planeshome">
            <div class="row">

                <div class="col-xs-12">
                    <h2 class="home-title">NUESTROS PLANES</h2>
                    <section id="cuerpo" class="planespage">
                        <header class="style4 confirmacion">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xs-12">

                                        <div class="contenedor">
                                            <? if (isset($plans)) {  ?>
                                                <? foreach ($plans as $plan) { ?>
                                                    <div class="tabla tabla hover ">
                                                        <div class="section_plan">
                                                            <h2><?= $plan->name; ?></h2>
                                                        </div>
                                                        <div class="section_plan">
                                                            <p><? echo $plan->description;  ?></p>
                                                        </div>

                                                        <div class="section_plan">
                                                            <span class="precio">$<? echo $plan->price; ?></span>
                                                        </div>

                                                        <div class="section_plan">
                                                            <span class=""><? echo $plan->duration; ?></span>
                                                            <p> &nbsp; días</p>
                                                        </div>

                                                        <? if ($plan->ilimitado_activo == 1) { ?>
                                                            <div class="section_plan">
                                                                <h6>Descargas Ilimitadas de Audio.</h6>
                                                            </div>
                                                        <? } else { ?>
                                                            <div class="section_plan">
                                                                <span class="table-tokens-audio"><? if ($plan->tokens != 0 && $plan->tokens != NULL) {
                                                                                                        echo $plan->tokens;
                                                                                                    } else {
                                                                                                        echo '0';
                                                                                                    } ?></span>
                                                                <p> &nbsp; Descargas Audio </p>
                                                            </div>
                                                        <? } ?>
                                                        <div class="section_plan">
                                                            <p> Renovacion Automatica </p>
                                                        </div>

                                                        <div class="section_plan">
                                                            <p>Busqueda Avanzada </p>
                                                        </div>
                                                        <div class="section_plan">
                                                            <p>Nueva Música Diariamente </p>
                                                        </div>

                                                        <div class="section_plan">
                                                            <p> Descargas con 1 Click </p>
                                                        </div>

                                                        <div class="section_plan">
                                                            <p>HQ Audio</p>
                                                        </div>





                                                        <a class="btn btn-default" href="<? echo base_url(); ?>getplan/?plan_id=<? echo $plan->id; ?>&currency=USD"><b>Comprar</b></a>

                                                    </div>


                                                    <? ?>
                                                <? } ?>
                                            <? } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <div id="mc_embed_signup">
        <form action="https://dalemasbajo.us20.list-manage.com/subscribe/post?u=4afe99e94b5e3203738542a04&amp;id=8e6342c46d" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
            <div id="mc_embed_signup_scroll">
                <h2>Registrate para recibir novedades y descuentos exclusivos.</h2>
                <div class="mc-field-group">
                    </label>
                    <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                </div>
                <div id="mce-responses" class="clear">
                    <div class="response" id="mce-error-response" style="display:none"></div>
                    <div class="response" id="mce-success-response" style="display:none"></div>
                </div> <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_4afe99e94b5e3203738542a04_8e6342c46d" tabindex="-1" value=""></div>
                <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
            </div>
        </form>
    </div>
    <footer>
        <div class="row">
            <div class="container">
                <ul class="style1 footer-links">

                    <li><a href="<? echo base_url(); ?>faq">FAQ</a></li>
                    <li><a href="<? echo base_url(); ?>pages/become_a_member/">CONVERTIRME EN EDITOR</a></li>
                    <li><a href="<? echo base_url(); ?>pages/terms_conditions/">TERMINOS Y CONDICIONES</a></li>

                </ul>
                <ul class="social-list style2 circular">
                    <li><a href="https://www.facebook.com/dalemasbajo/" target="_blank" class="fa fa-facebook"></a></li>
                    <li><a href="https://www.instagram.com/dalemasbajo/" target="_blank" class="fa fa-instagram"></a></li>
                    <li><a href="https://soundcloud.com/dalemasbajo" target="_blank" class="fa fa-soundcloud"></a></li>
                </ul>
                <div class="row">
                    <div class="col-xs-12 copy">
                        <strong>&copy; Copyright <? echo date('Y'); ?> DALE MÁS BAJO</strong>
                        <p>Descubre nuevos remixes cada día en nuestro sitio web.</p>
                        <p>Sitio web desarrollado por <a href="http://shiftandcontrol.com">Shift & Ctrl</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v7.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- Your customer chat code -->
    <div class="fb-customerchat" attribution=setup_tool page_id="1650087545070454" theme_color="#0084ff" logged_in_greeting="Hola! ¿Cómo te podemos ayudar?" logged_out_greeting="Hola! ¿Cómo te podemos ayudar?">
    </div>
    <style>
        .fb_dialog {
            bottom: 40pt !important;
        }

        /* The following are for the chat box, on display and on hide */
        iframe.fb_customer_chat_bounce_in_v2 {
            bottom: 110px !important;
        }

        iframe.fb_customer_chat_bounce_out_v2 {
            bottom: 110px !important;
        }
    </style>
</body>

</html>