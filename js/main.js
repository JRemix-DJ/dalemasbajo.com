//hide header on scroll > 100 and show on scroll up

var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
    if(window.pageYOffset>100){
        var currentScrollPos = window.pageYOffset;
        if (prevScrollpos > currentScrollPos) {
          document.getElementById("sticktop").style.top = "0";
        } else {
          document.getElementById("sticktop").style.top = "-100px";
        }
        prevScrollpos = currentScrollPos;
    }
}

$('#pagar_tarjeta').on('click', function(e){
    var base_url = "https://dalemasbajo.com/";
    e.preventDefault();
    var user_id = $(this).data('user_id');
    var plan_id = $(this).data('plan_id');
    var email_user = $(this).data('email');
    var monto = $(this).data('monto');
    var self = this;
    $.ajax({
        data:{
            user_id : user_id,
            plan_id : plan_id
        },
        type: "POST",
        //contentType: "application/json",
        dataType: "html",
        url: base_url+"getplan/create_order/"
    })
    .done(function(){
    
        console.log('go');
        var r = confirm('Recuerda utilizar el mismo email ['+email_user+'] En el siguiente formulario. De esta forma tu plan será aplicado al instante. De lo contrario podría tardar unos minutos.');
        if(r==true){
            window.location = $(self).attr('href');
        }else{
            alert('Debes dar click en OK o Aceptar en la caja de confirmación, por favor procede de nuevo');
        }
    })
    console.log('end');
});

//eliminar video player cuando se cierra el modal
$('#myModalVideo').on('hidden.bs.modal', function (e) {
    $("#jquery_jplayer_2").jPlayer("destroy");
});

jQuery(function($) {
    var base_url = "https://dalemasbajo.com/";
    "use strict";
    /*Table OF Contents
	==========================
	1-Custome Placeholder
	2-Home slider
	3-Parallax
	4-custome selectbox
	5-Twitter
	6-Owl slider
	7-Masonry
	8-Show Trending Song List
	9-Events countdown
	10-Date Time Picker
	11-Audio Player for blog post
	12-Player for Individual Songs
	13-packery
	14-Google Maps
	15-Menu
	16-Header Player
	17-WavePlayer ( used in header)
    */

    /*==========================
    ajax call
    ========================*/
    var xv_ww = $(window).width(),
        xv_slideshow = true;
    
    // $('#ajaxArea').ajaxify({
    //     forms: false,
    //     requestDelay:500
    // });
    
	$(window).on('pronto.render', function(event, eventInfo){
        $('html, body').animate({scrollTop: 0});
		suonoApp();
		$('.pageLoader').removeClass("active");
	});
	
    $(window).on('pronto.request', function(event, eventInfo){
		$('.pageLoader').addClass("active");
	});
    
    /*====================
    Main
    =====================*/

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
    function contactemaps(selector_map, address, type, zoom_lvl, map_theme) {
        var map = new google.maps.Map(document.getElementById(selector_map), {
            mapTypeId: google.maps.MapTypeId.type,
            scrollwheel: false,
            draggable: false,
            zoom: zoom_lvl,
            styles: map_theme,
        });
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
                'address': address
            },
            function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    new google.maps.Marker({
                        position: results[0].geometry.location,
                        map: map,
                        /* icon: map_pin*/
                    });
                    map.setCenter(results[0].geometry.location);
                }
            });
    }

    $('.downloadButtonVideo').on('click', function(e){
        e.preventDefault();
        var product_id = $(this).data('id');
        $.ajax({
            data:{
                product_id : product_id,
            },
            type: "POST",
            //contentType: "application/json",
            dataType: "json",
            url: base_url+"micuenta/descargar_producto_video/"
        })
        .done(function(data){
            if(data.success){
                console.log(data);
                var parent_div = '.player-'+product_id;
                $(parent_div).addClass('archivo_cliente');
                if(!data.is_unlimited){
                    $('#cantidad_tokens_video').html(data.total_tokens);
                }
                window.location.assign(base_url+'products/descargar_producto_video/'+product_id);
                $.ajax({
                    type: "POST",
                    //contentType: "application/json",
                    dataType: "json",
                    url: base_url+"micuenta/hasTokensPostVideo/"
                }).done(function(data2){
                    console.log(data2);
                    if(!data.is_unlimited){
                        $('#cantidad_tokens_video').html(data2.tokens_video);
                    }
                }).fail(function(){
                    alert('Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com. Código: ERR-P-HTPV');
                });
            }else{
                if(data.message=="NOTOKENS"){
                    console.log('entro no tokens');
                    $('#messagesModal').modal('show');
                    $('#messagesModal .modal-title').empty();
                    $('#messagesModal .modal-title').append('<i class="fa fa-exclamation-triangle"></i> NO POSEES DESCARGAS DISPONIBLES PARA VIDEO');
                    $('#messagesModal .modal-body').empty();
                    $('#messagesModal .modal-body').append('Obtén uno de nuestros planes de DESCARGAS en el siguiente enlace para que continues disfrutando de nuestro contenido<br> <a href="'+base_url+'planes/" class="btn btn-default">Comprar Planes</a>');

                }
                if(data.message=="NOLOGGUEDIN"){
                    $('#myModal').modal('show');
                    $('#myModal .modal-body .alert').remove();
                    $('#myModal .modal-body').append('<div class="alert alert-danger">Necesitas estar logueado y adquirir uno de nuestros planes para poder descargar este contenido</div>');
                }
                console.log(data.message);
                //alert(data.message);
            }
        })
        .fail(function(){ 
            alert('Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com. Código: ERR-MC-DPV');
        });
    });



    $('.downloadButton').on('click', function(e){
        e.preventDefault();
        var product_id = $(this).data('id');
        var promise = $.ajax({
                data:{
                    product_id : product_id,
                },
                type: "POST",
                dataType: "json",
                async: true,
                url: base_url+"micuenta/descargar_producto/"
            })
            .done(function(data){
                if(data.success){
                    console.log(data);
                    var parent_div = '.player-'+product_id;
                    $(parent_div).addClass('archivo_cliente');
                    if(!data.is_unlimited){
                        $('#cantidad_tokens').html(data.total_tokens);
                    }
                    window.location.assign(base_url+'products/descargar_producto/'+product_id);
                }else{
                    if(data.message=="NOTOKENS"){
                        console.log('entro no tokens');
                        $('#messagesModal').modal('show');
                        $('#messagesModal .modal-title').empty();
                        $('#messagesModal .modal-title').append('<i class="fa fa-exclamation-triangle"></i> NO POSEES DESCARGAS DISPONIBLES');
                        $('#messagesModal .modal-body').empty();
                        $('#messagesModal .modal-body').append('Obtén uno de nuestros planes de DESCARGAS en el siguiente enlace para que continues disfrutando de nuestro contenido<br> <a href="'+base_url+'planes/" class="btn btn-default">Comprar Planes</a>');

                    }
                    if(data.message=="NOLOGGUEDIN"){
                        $('#myModal').modal('show');
                        $('#myModal .modal-body .alert').remove();
                        $('#myModal .modal-body').append('<div class="alert alert-danger">Necesitas estar logueado y adquirir uno de nuestros planes para poder descargar este contenido</div>');
                    }
                    console.log(data.message);
                    //alert(data.message);
                }
            })
            .fail(function(){ 
                alert('Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com. Codigo: ERR-MC-DP');
            });
        promise.then(function(){
            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                headers: { "cache-control": "no-cache" },
                dataType: "json",
                url: base_url+"micuenta/hasTokensPost/"
            }).done(function(data2){
                if(!data2.success){
                    if(data2.message="NOTLOGGEDIN"){
                        alert("Debes estar logueado y contar con un plan para descargar. ");
                    }
                }else{
                    if(!data2.is_unlimited){
                        $('#cantidad_tokens').html(data2.tokens);
                    }
                }
            }).fail(function(){
                //alert('Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com. Código: ERR-MC-HTP');
            });
        })
    });

    $('.addToCart').on('click', function(){
        var button_position = $(this).position();
        var box_width = $(this).outerWidth();
        var producto = $(this).closest('tr').attr('data-product');
        var product_id = $(this).data('id');
        console.log(product_id);
        $.ajax({
            data: {
                id: product_id,
            },
            type: "POST",
            dataType: "json",
            //contentType: "application/json",
            url: base_url+"cart/acciones/add_to_cart/"
        })
        .done(function(data){
            if(data.success){
                //console.log('añadido');
                //console.log(data);
                updateMiniCart(data.cart_count);
                console.log(data.cart_count);
                showAddedToCart(producto, button_position, box_width);
            }else{
                alert(data.message);
            }
        })  
        .fail(function(){
            alert('Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com');
        });
    });

    function showAddedToCart(id, button_position, box_width){
        var div = $("table.canciones").find('[data-product='+id+']');
        div.find('.anadido').css({'display': 'block'});
        div.find('.anadido').css({'left': button_position.left+box_width});
        div.find('.anadido').css({'top': button_position.top});
        console.log(div);
        setTimeout(function(){
            console.log(div);
            div.find('.anadido').css({'display': 'none'});
        }, 6000);
    }


    $('.anadido').on('click', function(){
        window.location.href=base_url+'cart/';
    })

    /*
    CUPON TYPE
        1 = DESCUENTO
        2 = PAGO MINIMO DESCUENTO PORCENTAJE
        3 = PAGO MINIMO DESCUENTO TOTAL
    */

    $('#aplicarDescuento').on('click', function(e){
        console.log('Aplicando Cupon de descuento');
        $.ajax({
            data:{
                cupon: $('#cuponcode').val()
            },
            type: "POST",
            dataType: "json",
            //contentType: "application/json",
            url: base_url+"cart/applyCupon/"
        })
        .done(function(data){
            if(data.success){
                alert(data.message);
                location.reload();
            }else{
                alert(data.message);
            }
        })
        .fail(function(){ 
            alert('Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com');
        });
    });

    $('#removeCupon').on('click', function(e){
        console.log('Eliminando Cupon de descuento');
        $.ajax({
            type: "POST",
            dataType: "json",
            //contentType: "application/json",
            url: base_url+"cart/removeCupon/"
        })
        .done(function(data){
            if(data.success){
                alert(data.message);
                location.reload();
            }else{
                alert(data.message);
            }
        })
        .fail(function(){ 
            alert('Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com');
        });
    });


    $("#login-btn").on('click', function(e){
        console.log('ingresando');
        $.ajax({
            data:{
                email: $('#email').val(),
                password: $('#password').val()
            },
            type: "POST",
            dataType: "json",
            //contentType: "application/json",
            url: base_url+"login/front/"
        })
        .done(function(data){
            if(data.success){
                location.reload();
            }else{
                alert(data.message);
            }
        })
        .fail(function(){ 
            alert('Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com');
        });
    });

    $("#myModalRecuperar").on("shown.bs.modal", function(){
        $('#myModal').modal('hide');
    })

    $("#recuperar-btn").on('click', function(e){
        console.log('recuperando');
        $.ajax({
            data:{
                email: $('#recuperar-email').val()
            },
            type: "POST",
            //contentType: "application/json",
            dataType: "json",
            url: base_url+"login/recuperar_contrasena/"
        })
        .done(function(data){
            if(data.success){
                alert(data.message);
                location.reload();
            }else{
                alert(data.message);
            }
        })
        .fail(function(){ 
            alert('Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com');
        });
    });

    $('#cambiarpass').on('click', function(e){
        console.log('cambiando pass');
        //$(e).preventDefault();
        if($('#cpassword').val().length != 0 && $('#crpassword').val().length != 0){
            if($('#cpassword').val()!=$('#crpassword').val()){
                alert("Ambos campos deben ser iguales");
            }else{
                $.ajax({
                    data: {
                        pass: $('#cpassword').val(),
                        rpass: $('#crpassword').val(),
                        id: $('#cuser_id').val(),
                    },
                    type: "POST",
                    dataType: "json",
                    //contentType: "application/json",
                    url: base_url + 'users/changepass/'
                })
                .done(function(data){
                    if(data.success){
                        alert('Tu contraseña ha sido modificada. Serás redirigido para que ingreses.');
                        location.href ="https://dalemasbajo.com";
                    }else{
                        alert('Algo ha salido mal, intentalo más tarde');
                    }
                })
                .fail(function(data){
                    alert('Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com');
                    return false;
                });
            }
        }else{
            alert("Ambos campos deben estar llenos");
        }
    });

    $('#registrar-btn').on('click', function(e){
        console.log('registrando');
        if($('#registro-password').val().length != 0 && $('#registro-repeatpassword').val().length != 0 && $('#registro-email').val().length != 0 && $('#registro-username').val().length != 0 ){

            if($('#registro-password').val() != $('#registro-repeatpassword').val()){
                alert("password y repetir password deben ser iguales");
            }else{
                $.ajax({
                    data: {
                        email: $('#registro-email').val(),
                        username: $('#registro-username').val(),
                        password: $('#registro-password').val(),
                    },
                    type: "POST",
                    dataType: "json",
                    //contentType: "application/json",
                    url: base_url + 'users/registro/'
                })
                .done(function(data){
                    if(data.respuesta=="email_existe"){
                        alert('Este e-mail ya esta registrado');
                    }else if(data.respuesta=="username_existe"){    
                        alert('Este username ya esta registrado');
                    }else{
                        if(data.respuesta=='ok'){
                            $('#registrar-form').trigger("reset");
                            alert("Gracias por registrarte. Ya puedes ingresar.");
                            location.reload();
                        }
                    }
                })
                .fail(function(){
                    alert('Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com');
                });
            }
        }else{
            alert('Todos los campos son obligatorios');
        }
    });

    // $('#paynow').on('click', function(e){
    //     e.preventDefault();
    //     //console.log($('#amount').val());
    //     $.ajax({
    //         data:{
    //             total: $('#amount').val()
    //         },
    //         type: "POST",
    //         //contentType: "application/json",
    //         dataType: "json",
    //         url: base_url+"cart/create_order/"
    //     })
    //     .done(function(data){
    //         if(data.success){
    //             $('#custom').val(data.order_id);
    //             console.log('añadida orden');
    //             $('#pagarpaypal').submit();
    //             return true;
    //         }else{
    //             alert(data.message);
    //         }
    //     })
    //     .fail(function(){
    //         alert('Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com');
    //         e.preventDefault(); 
    //     });
    // })

    $('.deleteFromCart').on('click', function(){
        var product_id = $(this).data('id');
        $.ajax({
            data:{
                id: product_id,
            },
            type: "POST",
            dataType: "json",
            //contentType: "application/json",
            url: base_url+"cart/acciones/remove_from_cart/"
        })
        .done(function(data){
            if(data.success){
                console.log('eliminado');
                location.reload();
            }else{
                alert(data.message);
            }
        })
        .fail(function(){
            alert('Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com');
        });
    });


    function updateMiniCart(cant){
        $('.mini-cart .cant').html(cant);
        console.log('cart updated with ' + cant);
    }


    function suonoApp() {

        /*custome Placeholder*/
        $('.field-wrap input,.field-wrap textarea').each(function(index, element) {
            if ($(this).val() !== "") {
                $('label[for=' + $(this).attr("id") + ']').hide();
            }
        });

        $('.field-wrap input,.field-wrap textarea').focus(function() {
            $('label[for=' + $(this).attr("id") + ']').hide();
        });
        $('.field-wrap input,.field-wrap textarea').blur(function() {
            if ($(this).val() === "") {
                $('label[for=' + $(this).attr("id") + ']').show();
            }
        });
        /*============================
        Home slider
        ===========================*/
        if (xv_ww <= 768)
            xv_slideshow = false;
        $('#home-slider').flexslider({
            animation: "slide",
            directionNav: true,
            controlNav: true,
            pauseOnHover: true,
            slideshowSpeed: 5000,
            slideshow: true,
            direction: "horizontal", //Direction of slides
          
        });
        if ($('.xv_slider').length !== 0) {
            $('.xv_slide').each(function() {
                $(this).css('background-image', function() {
                    return $(this).attr('data-slidebg');
                });
            });
        }

        /*=======================================
        Parallax
        =======================================*/
        if (xv_ww >= 768) {
            $.stellar({
                horizontalScrolling: false,
                verticalOffset: 0,
                responsive: true,
            });
        }

        /*======================================
        custome selectbox
        =======================================*/
        $('.custome-select select').on('change', function() {
            var p = $(this).parent(".custome-select");
            p.find('span').html($(this).find('option:selected').text());
        });

        /*=========================================
        Twitter widget (it uses owl carousel)
        ===========================================*/
        if ($('.tweet').length) {
            $('.tweet').twittie({
                username: 'envato',
                dateFormat: '%b. %d, %Y',
                template: '{{tweet}} <time class="date">{{date}}</time>',
                count: 3,
                apiPath: "assets/php/tweet_api/tweet.php",
            }, function() {
                $(".tweet ul").addClass("tweet_slider owl-carousel owl-theme");
                $(".tweet_slider").owlCarousel({
                    autoplaySpeed: 1000,
                    navSpeed: 500,
                    items: 1,
                    center: true
                });
            });
        }

        /*=========================================
        Owl slider
        ===========================================*/
        $(".article-slider").each(function(index, element) {
            $(this).owlCarousel({
                autoplaySpeed: 1000,
                navSpeed: 500,
                items: 1,
                dots: false,
                nav: true,
                center: true,
                navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]
            });
        });

        $(".store-grid-slider").owlCarousel({
            navSpeed: 500,
            items: 5,
            dots: false,
            nav: true,
            navContainer: "#relatedAlbumsSlderNav",
            navText: ['<div class="col-xs-6"><a href="javascript:;"><i class="fa fa-arrow-left"></i> previous  Albums</a></div>', '<div class="col-xs-6"><a href="javascript:;"><i class="fa fa-arrow-right"></i> Next  Albums</a></div>'],
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 4,
                },
                1000: {
                    items: 5
                }
            }
        });

        /*==============================================
        Masonry
        ==============================================*/
        $(window).on('resize load', function() {
            var gutterWidth = 0,
                winWidth = $(window).width();
            if (winWidth >= 1200) {
                gutterWidth = 100;
            } else {
                gutterWidth = 20;
            }
            if (winWidth >= 581) {
                $('.masonry-container').waitForImages(function() {
                    $('.masonry-container').masonry({
                        itemSelector: '.ele-masonry',
                        gutter: gutterWidth
                    });
                });
            }
        });

        /*==============================================
        Song List
        ==============================================*/
        $("body").on("click", ".showAllTrending", function(e) {
            var $this = $(this);
            e.preventDefault();
            $this.fadeOut();
            $(".populateSongList li").show();
            $("body,html").animate({
                scrollTop: $(".populateSongList").offset().top - 70
            });
        });

        /*================
        Events countdown
        ====================*/
        if ($('.countdown').length) {
            $('.countdown').each(function(num, ele) {
                var $this = $(this);
                $this.downCount({
                    date: '09/09/2016 12:00:00',
                    offset: +10
                }, function() {
                    alert('WOOT WOOT, done!');
                });
            });
        }

        /*================
        date time picker
        ====================*/
        if ($('.xvDatePicker').length) {
            $(".xvDatePicker").each(function(num, ele) {
                var $this = $(this);
                $this.datetimepicker({
                    timepicker: false
                });
            });
        }

        /*=========================
        Audio Player for blog post
        =========================*/
        // if ($(".post-audio-player").length) {
        //     $('.post-jplayer').each(function(num, ele) {
        //         var temp_id = $(this).attr("id"),
        //             temp_song = $(this).attr('data-mp3'),
        //             temp_title = $(this).attr('data-title'),
        //             temp_wrap = "#" + $(this).parents(".post-audio-player").attr("id");
        //         $("#jquery_jplayer_1").jPlayer({
        //             play: function() {
        //                 $(this).jPlayer("pauseOthers"); // pause all players except this one.
        //             },
        //             ready: function() {
        //                 $(this).jPlayer("setMedia", {
        //                     mp3: temp_song,
        //                     title: temp_title
        //                 });
        //             },
        //             //cssSelectorAncestor: temp_wrap,
        //             volume: 0.5,
        //             supplied: "mp3",
        //             swfPath: "assets/js/jPlayer/jquery.jplayer.swf",
        //         });
        //     });
        // }
        $('#myModalTerms').modal({
            backdrop: true,
            keyboard: false,
            show: false,
        });

        console.log('la variable vale ' + sessionStorage.wasVisited2);
        if (sessionStorage.wasVisited2 == null || sessionStorage.wasVisited2 == "undefined") {
            //sessionStorage.setItem("wasVisited2", "1");
            $('#myModalTerms').modal('show');
        }else{
            if(sessionStorage.wasVisited2!=null){
                //var newVal=parseInt(sessionStorage.getItem('wasVisited2')) + 1;
                //sessionStorage.setItem('wasVisited2', newVal);
                console.log(sessionStorage.wasVisited2);
            }
        }

        $("#accept-terms").on('click', function(){
            sessionStorage.setItem("wasVisited2", "1");
        });

        $('#enviarBecome').on('click', function(){
            var name = $('#name').val(), country = $("#country").val(), experience = $('#time').val(), work = $('#work').val(), email = $('#email-become').val(), message = $("#why").val(), trabajos = $("#trabajos").val();
            if(name==""||country==""||experience==""||work==""||email==""||message==""||trabajos==""){
                alert("Todos los campos son obligatorios");
            }else{
                if(IsEmail(email)){
                    $.ajax({
                        data: {
                            name: name,
                            country: country,
                            experience: experience,
                            work: work,
                            email: email,
                            message: message,
                            trabajos: trabajos
                        },
                        type: "POST",
                        dataType: "json",
                        //contentType: "application/json",
                        url: base_url+"pages/ser_miembro_mail/"
                    })
                    .done(function(data){
                        if(data.success){
                            alert("Mensaje Enviado. Gracias");
                        }else{
                            alert(data.message);
                        }
                    })  
                    .fail(function(){
                        alert('Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com');
                    });
                }else{
                    alert("Formato de correo erroneo, por favor confirma que todo este bien escrito");
                }
            }
        });

        /*============================
        Player for Individual Songs
        ==============================*/
          // $("#jquery_jplayer_1").jPlayer({
          //   ready: function () {
          //     $(this).jPlayer("setMedia", {
          //       mp3: 'https://dalemasbajo.com/assets/demo/demo.mp3'
          //     });
          //   },
          //   cssSelectorAncestor: "#jp_container_1",
          //   swfPath: "/js/jplayer",
          //   supplied: "mp3",
          //   useStateClassSkin: true,
          //   autoBlur: false,
          //   smoothPlayBar: true,
          //   keyEnabled: true,
          //   remainingDuration: true,
          //   toggleDuration: true,
          //   errorAlerts: true,
          // });
        var classPlay="fa fa-play-circle-o";
        var classPause="fa fa-stop-circle-o";
        function is_active(div){
            var divID = div.closest('tr').attr('id');
            var playing_id=$("#jquery_jplayer_1").attr('data-audio-id');
            if(playing_id!='undefined'){
                //console.log('div is: '+divID+'. and playing id is: '+playing_id+'.');
                //console.log(String(divID)==String(playing_id));
                if(String(divID)==String(playing_id)){
                    //console.log($('#jquery_jplayer_1').data().jPlayer.status.paused);
                    if($('#jquery_jplayer_1').data().jPlayer.status.paused){
                        $("#jquery_jplayer_1").jPlayer('play');
                        $('#'+playing_id).find('.singleSong-jplayer .fa').removeClass().addClass(classPause);
                        return true;
                    }else{
                        $("#jquery_jplayer_1").jPlayer('stop');
                        $('#'+playing_id).find('.singleSong-jplayer .fa').removeClass().addClass(classPlay);
                        return true;
                    }
                }else{
                    $('#'+playing_id).find('.singleSong-jplayer .fa').removeClass().addClass(classPlay);
                    //console.log('this row is not active');
                    return false;
                }
            }
        }
        
        if ($(".singleSongPlayer").length) {
            $('.singleSong-jplayer').on('click', function() {
                //console.log('row_click');
                if(!is_active($(this))){
                    var temp_id = $(this).attr("id"),
                        temp_song = $(this).attr('data-mp3'),
                        temp_title = $(this).attr('data-title'),
                        temp_wrap = "#" + $(this).closest('tr').attr("id");
                    var audio_wrap = $(this).closest('tr').attr("id");

                        //console.log('audio wrap is '+audio_wrap);
                        var div = $(this).find('.boton-play').removeClass();
                        div.addClass(classPause);

                        $("#jquery_jplayer_1").attr('data-audio-id', audio_wrap);
                        $("#jquery_jplayer_1").jPlayer("destroy");
                        $("#jquery_jplayer_1").jPlayer({
                            ready: function () {
                              $(this).jPlayer("setMedia", {
                                mp3: temp_song
                              });
                            },
                            pause: function() {
                                var rowid='#'+$(this).attr('data-audio-id');
                                $(rowid).find('.boton-play').removeClass().addClass(classPlay);
                            },
                            play: function() {
                                var rowid='#'+$(this).attr('data-audio-id');
                                $(rowid).find('.boton-play').removeClass().addClass(classPause);
                            },
                            cssSelectorAncestor: "#jp_container_1",
                            swfPath: "/js/jplayer",
                            supplied: "mp3",
                            useStateClassSkin: true,
                            autoBlur: false,
                            smoothPlayBar: true,
                            keyEnabled: true,
                            remainingDuration: true,
                            toggleDuration: true,
                            errorAlerts: true,
                          });
                        setTimeout(function(){ 
                            $("#jquery_jplayer_1").jPlayer("play");
                        }, 100);
                }

            });
        }


        var classPlayVideo="play";
        var classPauseVideo="pausa";
        function is_activeVideo(div){
            var divID = div.closest('tr').attr('id');
            var playing_id=$("#jquery_jplayer_2").attr('data-audio-id');
            if(playing_id!='undefined'){
                //console.log('div is: '+divID+'. and playing id is: '+playing_id+'.');
                //console.log(String(divID)==String(playing_id));
                if(String(divID)==String(playing_id)){
                    //console.log($('#jquery_jplayer_1').data().jPlayer.status.paused);
                    if($('#jquery_jplayer_2').data().jPlayer.status.paused){
                        $("#jquery_jplayer_2").jPlayer('play');
                        $('#'+playing_id).find('.fa').removeClass().addClass(classPauseVideo);
                        return true;
                    }else{
                        $("#jquery_jplayer_2").jPlayer('stop');
                        $('#'+playing_id).find('.fa').removeClass().addClass(classPlayVideo);
                        return true;
                    }
                }else{
                    $('#'+playing_id).find('.fa').removeClass().addClass(classPlayVideo);
                    //console.log('this row is not active');
                    return false;
                }
            }
        }
        $('#myModalTerms').hide();
        $('#myModalVideo').hide();  
        $('.modal-backdrop').remove(); // the modal hide call to remove the modal.
        this.document.body.classList.remove('modal-open'); // work around a bug in ngx-bootstrap

        if ($(".singleVideoPlayer").length) {
            $('.thumb_container').on('click', function() {
                //console.log('row_click');
                $('#myModalVideo').modal({
                    backdrop: true,
                    keyboard: false,
                    show: false,
                });
                if(!is_activeVideo($(this))){
                    $('#myModalVideo').modal('show');
                    var temp_id = $(this).attr("id"),
                        temp_song = $(this).attr('data-mp3'),
                        temp_title = $(this).attr('data-title'),
                        temp_wrap = "#" + $(this).closest('tr').attr("id");
                    var audio_wrap = $(this).closest('tr').attr("id");
                        var modalVideo = $('#myModalVideo').modal('show');
                        modalVideo.find('.modal-header h4').remove();
                        modalVideo.find('.modal-header').append('<h4>Preview: '+temp_title+'</h4>');
                        //console.log('audio wrap is '+audio_wrap);
                        var div = $(this).removeClass('play');
                        div.addClass(classPauseVideo);

                        $("#jquery_jplayer_2").attr('data-video-id', audio_wrap);
                        $("#jquery_jplayer_2").jPlayer("destroy");
                        $("#jquery_jplayer_2").jPlayer({
                            ready: function () {
                              $(this).jPlayer("setMedia", {
                                m4v: temp_song
                              });
                            },
                            pause: function() {
                                var rowid='#'+$(this).attr('data-video-id');
                                $(rowid).find('.thumb_container').removeClass('play').addClass(classPlayVideo);
                            },
                            play: function() {
                                var rowid='#'+$(this).attr('data-video-id');
                                $(rowid).find('.thumb_container').removeClass('pausa').addClass(classPauseVideo);
                            },
                            cssSelectorAncestor: "#jp_container_2",
                            swfPath: "/js/jplayer",
                            supplied: "m4v",
                            useStateClassSkin: true,
                            autoBlur: false,
                            smoothPlayBar: true,
                            keyEnabled: true,
                            remainingDuration: true,
                            toggleDuration: true,
                            errorAlerts: true,
                          });
                        setTimeout(function(){ 
                            $("#jquery_jplayer_2").jPlayer("play");
                        }, 100);
                }

            });
        }


        /*=======================================
        packery
        =======================================*/
        if ($('.xvPackeryItems').length) {
            var packery = $('.xvPackeryItems');
            packery.packery({
                itemSelector: '.xvPackeryItem',
                gutter: 0
            });
        }
        
        /*==============================
        Events Slider
        ==========================*/
        var evntSlider = $(".eventsSlider"),
            esNext = evntSlider.data("nexttext"),
            esPrev = evntSlider.data("prevtext");
        $('.eventsSlider').bxSlider({
            mode: 'vertical',
            minSlides:3,
            maxSlider :3,
            slideMargin:10,
            pager:false,
            nextSelector:"#nextEvents",
            prevSelector:"#prevEvents",
            nextText:esNext,
            prevText:esPrev,
            infiniteLoop:false,
            hideControlOnEnd:true
        });

        
        /*===========================
        Contact
        ============================*/
        function IsEmail(email) {
			var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}
		
		if($("#contactForm").length!=0){
			$("#contactForm").submit(function (e) {
				e.preventDefault();
				var name = $("#xv_name").val(),
				email = $("#xv_email").val(),
				message = $("#xv_message").val(),
				dataString = 'name=' + name + '&email=' + email + '&message=' + message;
		
				if (name === '' || !IsEmail(email) || message === '') {  
                    $(".validationError").show();
				} else {
					$.ajax({
						type: "POST",
						url: "assets/php/submit.php",
						data: dataString,
						success: function () {
							$('#contactForm').slideUp();
							$(".messageSentSuccess").fadeIn();
						}
					});
				}
				return false;
			});
		}
           
        /*============================
		Google Maps
        ============================*/

        if ($('.xv-gmap').length) {
            $('.xv-gmap').each(function() {
                var $this = $(this);

                var selector_map = $this.attr('id'),
                    mapAddress = $this.data('address'),
                    mapType = $this.data('maptype'),
                    zoomLvl = $this.data('zoomlvl'),
                    map_theme_control = $this.data('theme'),
                    map_theme;

                switch (map_theme_control) {
                    case 'pink':
                        map_theme = [{
                            stylers: [{
                                hue: "#e62948"
                            }, {
                                visibility: "on"
                            }, {
                                invert_lightness: true
                            }, {
                                saturation: 40
                            }, {
                                lightness: 10
                            }]
                        }];

                        break;
                    case 'red':
                        map_theme = [{
                            featureType: "water",
                            elementType: "geometry",
                            stylers: [{
                                color: "#ffdfa6"
                            }]
                        }, {
                            featureType: "landscape",
                            elementType: "geometry",
                            stylers: [{
                                color: "#b52127"
                            }]
                        }, {
                            featureType: "poi",
                            elementType: "geometry",
                            stylers: [{
                                color: "#c5531b"
                            }]
                        }, {
                            featureType: "road.highway",
                            elementType: "geometry.fill",
                            stylers: [{
                                color: "#74001b"
                            }, {
                                lightness: -10
                            }]
                        }, {
                            featureType: "road.highway",
                            elementType: "geometry.stroke",
                            stylers: [{
                                color: "#da3c3c"
                            }]
                        }, {
                            featureType: "road.arterial",
                            elementType: "geometry.fill",
                            stylers: [{
                                color: "#74001b"
                            }]
                        }, {
                            featureType: "road.arterial",
                            elementType: "geometry.stroke",
                            stylers: [{
                                color: "#da3c3c"
                            }]
                        }, {
                            featureType: "road.local",
                            elementType: "geometry.fill",
                            stylers: [{
                                color: "#990c19"
                            }]
                        }, {
                            elementType: "labels.text.fill",
                            stylers: [{
                                color: "#ffffff"
                            }]
                        }, {
                            elementType: "labels.text.stroke",
                            stylers: [{
                                color: "#74001b"
                            }, {
                                lightness: -8
                            }]
                        }, {
                            featureType: "transit",
                            elementType: "geometry",
                            stylers: [{
                                color: "#6a0d10"
                            }, {
                                visibility: "on"
                            }]
                        }, {
                            featureType: "administrative",
                            elementType: "geometry",
                            stylers: [{
                                color: "#ffdfa6"
                            }, {
                                weight: 0.4
                            }]
                        }, {
                            featureType: "road.local",
                            elementType: "geometry.stroke",
                            stylers: [{
                                visibility: "off"
                            }]
                        }];

                        break;
                    case 'blue':
                        map_theme = [{
                            stylers: [{
                                hue: "#007fff"
                            }, {
                                saturation: 89
                            }]
                        }, {
                            featureType: "water",
                            stylers: [{
                                color: "#ffffff"
                            }]
                        }, {
                            featureType: "administrative.country",
                            elementType: "labels",
                            stylers: [{
                                visibility: "off"
                            }]
                        }];

                        break;
                    case 'yellow':
                        map_theme = [{
                            featureType: "water",
                            elementType: "geometry",
                            stylers: [{
                                color: "#a2daf2"
                            }]
                        }, {
                            featureType: "landscape.man_made",
                            elementType: "geometry",
                            stylers: [{
                                color: "#f7f1df"
                            }]
                        }, {
                            featureType: "landscape.natural",
                            elementType: "geometry",
                            stylers: [{
                                color: "#d0e3b4"
                            }]
                        }, {
                            featureType: "landscape.natural.terrain",
                            elementType: "geometry",
                            stylers: [{
                                visibility: "off"
                            }]
                        }, {
                            featureType: "poi.park",
                            elementType: "geometry",
                            stylers: [{
                                color: "#bde6ab"
                            }]
                        }, {
                            featureType: "poi",
                            elementType: "labels",
                            stylers: [{
                                visibility: "off"
                            }]
                        }, {
                            featureType: "poi.medical",
                            elementType: "geometry",
                            stylers: [{
                                color: "#fbd3da"
                            }]
                        }, {
                            featureType: "poi.business",
                            stylers: [{
                                visibility: "off"
                            }]
                        }, {
                            featureType: "road",
                            elementType: "geometry.stroke",
                            stylers: [{
                                visibility: "off"
                            }]
                        }, {
                            featureType: "road",
                            elementType: "labels",
                            stylers: [{
                                visibility: "off"
                            }]
                        }, {
                            featureType: "road.highway",
                            elementType: "geometry.fill",
                            stylers: [{
                                color: "#ffe15f"
                            }]
                        }, {
                            featureType: "road.highway",
                            elementType: "geometry.stroke",
                            stylers: [{
                                color: "#efd151"
                            }]
                        }, {
                            featureType: "road.arterial",
                            elementType: "geometry.fill",
                            stylers: [{
                                color: "#ffffff"
                            }]
                        }, {
                            featureType: "road.local",
                            elementType: "geometry.fill",
                            stylers: [{
                                color: "black"
                            }]
                        }, {
                            featureType: "transit.station.airport",
                            elementType: "geometry.fill",
                            stylers: [{
                                color: "#cfb2db"
                            }]
                        }];


                        break;
                    case 'green':
                        map_theme = [{
                            featureType: "water",
                            elementType: "geometry",
                            stylers: [{
                                visibility: "on"
                            }, {
                                color: "#aee2e0"
                            }]
                        }, {
                            featureType: "landscape",
                            elementType: "geometry.fill",
                            stylers: [{
                                color: "#abce83"
                            }]
                        }, {
                            featureType: "poi",
                            elementType: "geometry.fill",
                            stylers: [{
                                color: "#769E72"
                            }]
                        }, {
                            featureType: "poi",
                            elementType: "labels.text.fill",
                            stylers: [{
                                color: "#7B8758"
                            }]
                        }, {
                            featureType: "poi",
                            elementType: "labels.text.stroke",
                            stylers: [{
                                color: "#EBF4A4"
                            }]
                        }, {
                            featureType: "poi.park",
                            elementType: "geometry",
                            stylers: [{
                                visibility: "simplified"
                            }, {
                                color: "#8dab68"
                            }]
                        }, {
                            featureType: "road",
                            elementType: "geometry.fill",
                            stylers: [{
                                visibility: "simplified"
                            }]
                        }, {
                            featureType: "road",
                            elementType: "labels.text.fill",
                            stylers: [{
                                color: "#5B5B3F"
                            }]
                        }, {
                            featureType: "road",
                            elementType: "labels.text.stroke",
                            stylers: [{
                                color: "#ABCE83"
                            }]
                        }, {
                            featureType: "road",
                            elementType: "labels.icon",
                            stylers: [{
                                visibility: "off"
                            }]
                        }, {
                            featureType: "road.local",
                            elementType: "geometry",
                            stylers: [{
                                color: "#A4C67D"
                            }]
                        }, {
                            featureType: "road.arterial",
                            elementType: "geometry",
                            stylers: [{
                                color: "#9BBF72"
                            }]
                        }, {
                            featureType: "road.highway",
                            elementType: "geometry",
                            stylers: [{
                                color: "#EBF4A4"
                            }]
                        }, {
                            featureType: "transit",
                            stylers: [{
                                visibility: "off"
                            }]
                        }, {
                            featureType: "administrative",
                            elementType: "geometry.stroke",
                            stylers: [{
                                visibility: "on"
                            }, {
                                color: "#87ae79"
                            }]
                        }, {
                            featureType: "administrative",
                            elementType: "geometry.fill",
                            stylers: [{
                                color: "#7f2200"
                            }, {
                                visibility: "off"
                            }]
                        }, {
                            featureType: "administrative",
                            elementType: "labels.text.stroke",
                            stylers: [{
                                color: "#ffffff"
                            }, {
                                visibility: "on"
                            }, {
                                weight: 4.1
                            }]
                        }, {
                            featureType: "administrative",
                            elementType: "labels.text.fill",
                            stylers: [{
                                color: "#495421"
                            }]
                        }, {
                            featureType: "administrative.neighborhood",
                            elementType: "labels",
                            stylers: [{
                                visibility: "off"
                            }]
                        }];

                        break;
                    default:
                        map_theme = [];
                }
                contactemaps(selector_map, mapAddress, mapType, zoomLvl, map_theme);

            });
        }

    } /*suonoApp*/
    suonoApp();

    /*======================================
    Menu
    ======================================*/
    
    $("#sticktop").sticky({
        topSpacing: 0
    });
    $(window).on('resize load', function() {
        $(".sticky-wrapper").css("height", +$("#sticktop").innerHeight() + "px");
    });

    $("body").on("click",".dl-menu > li > a",function(e){
        var $this = $(this),
            p = $this.parent();
        if(p.children("ul").length){
            e.preventDefault();
            p.children("ul").addClass("expand");
            $this.parents(".dl-menu").addClass("backed");
        }else{
            $(".dl-menu").removeClass("xvMenuShow");
            $(".dl-menu > li").removeClass("active");
            $this.parent().addClass("active");
        }
    });
    
    $("body").on("click",".dl-menu > li > ul > li > a",function(e){
        if(!$(this).hasClass("backLvl")){
            $(".dl-menu").removeClass("backed");
            $(".dl-menu").removeClass("xvMenuShow");
        }
        
    });
    
    $("body").on("click",".menuTrigger",function(e){
        e.preventDefault();
        $(".dl-menu").toggleClass("xvMenuShow");
    });
    
    $("body").on("click",".backLvl",function(e){
        var $this = $(this);
        e.preventDefault();
        $this.parents(".dl-submenu").removeClass("expand");
        $this.parents(".dl-menu").removeClass("backed");
    });
    
    $(".dl-submenu").each(function(){
        var $this = $(this);
        $this.prepend('<li class="gobackLvl"><a class="backLvl" href="#"><i class="fa fa-long-arrow-left"></i>Go Back</li>');
    });


    /*==============================================
	Header Player
	==============================================*/

    $('body').on("click", function(e) {
        if (!$(e.target).closest('.the-xv-Jplayer').length) {
            $(".jp-playlist").slideUp();
            $("body").removeClass("playerFullOn");
        }
    });

    $(".sound-trigger").click(function(e) {
        $(this).parent(".jp-volume-controls").toggleClass("open");
    });

    $(".playList-trigger").click(function(e) {
        $("body").toggleClass("playerFullOn");
        $(".jp-playlist").slideToggle();
    });

    var werock;

    if ($('#audio-player').length) {
        $("#player-instance").jPlayer({
            cssSelectorAncestor: "#audio-player",
        });

        if ($('.playlist-files').length) {
            var playlist_items = [],
                $playlist_audio = $('.playlist-files li'),
                playlist_items_length = $playlist_audio.length;
            for (var i = 0; i < playlist_items_length; i++) {
                var new_playlist_item = {};
                new_playlist_item['title'] = $playlist_audio.eq(i).attr('data-title');
                new_playlist_item['artist'] = $playlist_audio.eq(i).attr('data-artist');
                new_playlist_item['mp3'] = $playlist_audio.eq(i).attr('data-mp3');
                playlist_items.push(new_playlist_item);
            }

            werock = new jPlayerPlaylist({
                jPlayer: "#player-instance",
                enableRemoveControls: false,
                cssSelectorAncestor: "#audio-player"
            }, playlist_items, {
                playlistOptions: {
                    autoPlay: false,
                    loopOnPrevious: true
                }
            }, {
                swfPath: "assets/js/jPlayer/jquery.jplayer.swf",
                supplied: "mp3",
                displayTime: 'fast',
                addTime: 'fast',
            });


            $("#player-instance").bind($.jPlayer.event.play, function(event) {
                var current = werock.current,
                    playlist = werock.playlist;
                jQuery.each(playlist, function(index, obj) {
                    if (index == current) {
                        $('.the-xv-Jplayer .audio-title').html('<span class="jp-artist">' + obj.artist + '</span><span class="jp-songTitle">' + obj.title + '</span>');
                    }
                });
            });
        }


        $('.jp-prev').click(function() {
            werock.previous();
        });
    }

    if ($('#audio-player-radio').length) {
        var streamUrl = $('#audio-player-radio').attr("data-radio-url"),
            radioName = $('#audio-player-radio').attr("data-title"),
            stream = {
                title: radioName,
                mp3: streamUrl
            },
            radio_ready = false;
        $("#player-instance-radio").jPlayer({
            ready: function(event) {
                radio_ready = true;
                $(this).jPlayer("setMedia", stream).jPlayer("play");
            },
            pause: function() {
                $(this).jPlayer("clearMedia");
            },
            error: function(event) {
                if (radio_ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET) {
                    $(this).jPlayer("setMedia", stream).jPlayer("play");
                }
            },
            cssSelectorAncestor: "#audio-player-radio",
            swfPath: "assets/js/jPlayer/jquery.jplayer.swf",
            preload: "none"
        });
    }

    /*================
    WavePlayer ( used in header)
    ====================*/
    var $wavePlayer = $(".waveSurferPlayer"),
        $wave = $("#waveform"),
        wavColor = $wave.attr("data-wave-color"),
        waveProgress = $wave.attr("data-wave-progress"),
        waveCursor = $wave.attr("data-cursor"),
        waveHeight = +$wave.attr("data-height");

    function onWaveSurferInitialized(wavesurfer) {
        wavesurfer = Object.create(WaveSurfer),
            wavesurfer.init({
                container: '#waveform',
                waveColor: wavColor,
                progressColor: waveProgress,
                cursorColor: waveCursor,
                height: waveHeight
            });
        wavesurfer.load('assets/demo-data/demo.wav');
        wavesurfer.on('ready', function(e) {
            wavesurfer.play();
            $(".playWave").hide();
        });
        wavesurfer.on('error', function(err) {
            console.error(err);
        });
        wavesurfer.on('finish', function() {
            console.log('Finished playing');
            $(".pauseWave").hide();
            $(".playWave").show();
        });
        $("body").on("click", ".playWave", function(e) {
            e.preventDefault();
            wavesurfer.play();
            $(this).hide();
            $(".pauseWave").show();
        });
        $("body").on("click", ".pauseWave", function(e) {
            e.preventDefault();
            wavesurfer.pause();
            $(this).hide();
            $(".playWave").show();
        });
        $("body").on("click", ".muteWave", function(e) {
            e.preventDefault();
            $(this).toggleClass("pc-mute", "pc-volume");
            wavesurfer.toggleMute();
        });
    } /*wave init funtion*/


    if ($wavePlayer.length) {
      	var waveSurfer;
        if (WaveSurfer.Swf.supportsAudioContext() && WaveSurfer.Swf.supportsCanvas()) {
            waveSurfer = Object.create(WaveSurfer);
            onWaveSurferInitialized(waveSurfer);
        } else {
            swfobject.embedSWF('assets/js/wavesurfer/wavesurfer.swf', 'wavesurfer', '100%', '128', '11.1.0', 'expressInstall.swf', {}, {
                allowScriptAccess: 'always'
            }, {});
            waveSurfer = new WaveSurfer.Swf();
            waveSurfer.on('init', function() {
                onWaveSurferInitialized(waveSurfer);
            });
        }
    }

});