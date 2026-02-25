jQuery(function(d){function p(e,a,t,r,o){var s=new google.maps.Map(document.getElementById(e),{mapTypeId:google.maps.MapTypeId.type,scrollwheel:!1,draggable:!1,zoom:r,styles:o}),l;(new google.maps.Geocoder).geocode({address:a},function(e,a){a===google.maps.GeocoderStatus.OK&&(new google.maps.Marker({position:e[0].geometry.location,map:s}),s.setCenter(e[0].geometry.location))})}function o(e,a,t){var r=d("table.canciones").find("[data-product="+e+"]");r.find(".anadido").css({display:"block"}),r.find(".anadido").css({left:a.left+t}),r.find(".anadido").css({top:a.top}),console.log(r),setTimeout(function(){console.log(r),r.find(".anadido").css({display:"none"})},3e3)}function s(e){d(".mini-cart .cant").html(e),console.log("cart updated with "+e)}function t(){function l(e){var a=e.closest("tr").attr("id"),t=d("#jquery_jplayer_1").attr("data-audio-id");if("undefined"!=t)
//console.log('div is: '+divID+'. and playing id is: '+playing_id+'.');
//console.log(String(divID)==String(playing_id));
return String(a)==String(t)?(
//console.log($('#jquery_jplayer_1').data().jPlayer.status.paused);
d("#jquery_jplayer_1").data().jPlayer.status.paused?(d("#jquery_jplayer_1").jPlayer("play"),d("#"+t).find(".fa").removeClass().addClass(c)):(d("#jquery_jplayer_1").jPlayer("stop"),d("#"+t).find(".fa").removeClass().addClass(n)),!0):(d("#"+t).find(".fa").removeClass().addClass(n),!1)}
/*===========================
        Contact
        ============================*/
function i(e){var a;return/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(e)}
/*custome Placeholder*/
d(".field-wrap input,.field-wrap textarea").each(function(e,a){""!==d(this).val()&&d("label[for="+d(this).attr("id")+"]").hide()}),d(".field-wrap input,.field-wrap textarea").focus(function(){d("label[for="+d(this).attr("id")+"]").hide()}),d(".field-wrap input,.field-wrap textarea").blur(function(){""===d(this).val()&&d("label[for="+d(this).attr("id")+"]").show()}),
/*============================
        Home slider
        ===========================*/
y<=768&&(f=!1),d("#home-slider").flexslider({animation:"slide",directionNav:!0,controlNav:!0,pauseOnHover:!0,slideshowSpeed:5e3,slideshow:!0,direction:"horizontal",//Direction of slides
start:function(){d(window).trigger("resize"),768<=y&&d(".xv_slider .animated").addClass("go").removeClass("goAway")},before:function(){768<=y&&d(".xv_slider .animated").addClass("goAway").removeClass("go")},after:function(){768<=y&&d(".xv_slider .animated").addClass("go").removeClass("goAway")}}),0!==d(".xv_slider").length&&d(".xv_slide").each(function(){d(this).css("background-image",function(){return d(this).attr("data-slidebg")})})
/*=======================================
        Parallax
        =======================================*/,768<=y&&d.stellar({horizontalScrolling:!1,verticalOffset:0,responsive:!0})
/*======================================
        custome selectbox
        =======================================*/,d(".custome-select select").on("change",function(){var e;d(this).parent(".custome-select").find("span").html(d(this).find("option:selected").text())}),
/*=========================================
        Twitter widget (it uses owl carousel)
        ===========================================*/
d(".tweet").length&&d(".tweet").twittie({username:"envato",dateFormat:"%b. %d, %Y",template:'{{tweet}} <time class="date">{{date}}</time>',count:3,apiPath:"assets/php/tweet_api/tweet.php"},function(){d(".tweet ul").addClass("tweet_slider owl-carousel owl-theme"),d(".tweet_slider").owlCarousel({autoplaySpeed:1e3,navSpeed:500,items:1,center:!0})})
/*=========================================
        Owl slider
        ===========================================*/,d(".article-slider").each(function(e,a){d(this).owlCarousel({autoplaySpeed:1e3,navSpeed:500,items:1,dots:!1,nav:!0,center:!0,navText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"]})}),d(".store-grid-slider").owlCarousel({navSpeed:500,items:5,dots:!1,nav:!0,navContainer:"#relatedAlbumsSlderNav",navText:['<div class="col-xs-6"><a href="javascript:;"><i class="fa fa-arrow-left"></i> previous  Albums</a></div>','<div class="col-xs-6"><a href="javascript:;"><i class="fa fa-arrow-right"></i> Next  Albums</a></div>'],responsive:{0:{items:2},600:{items:4},1e3:{items:5}}}),
/*==============================================
        Masonry
        ==============================================*/
d(window).on("resize load",function(){var e=0,a=d(window).width();e=1200<=a?100:20,581<=a&&d(".masonry-container").waitForImages(function(){d(".masonry-container").masonry({itemSelector:".ele-masonry",gutter:e})})}),
/*==============================================
        Song List
        ==============================================*/
d("body").on("click",".showAllTrending",function(e){var a=d(this);e.preventDefault(),a.fadeOut(),d(".populateSongList li").show(),d("body,html").animate({scrollTop:d(".populateSongList").offset().top-70})}),
/*================
        Events countdown
        ====================*/
d(".countdown").length&&d(".countdown").each(function(e,a){var t;d(this).downCount({date:"09/09/2016 12:00:00",offset:10},function(){alert("WOOT WOOT, done!")})})
/*================
        date time picker
        ====================*/,d(".xvDatePicker").length&&d(".xvDatePicker").each(function(e,a){var t;d(this).datetimepicker({timepicker:!1})}),
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
console.log("la variable vale "+sessionStorage.wasVisited2),null==sessionStorage.wasVisited2||"undefined"==sessionStorage.wasVisited2?
//sessionStorage.setItem("wasVisited2", "1");
d("#myModalTerms").modal("show"):null!=sessionStorage.wasVisited2&&
//var newVal=parseInt(sessionStorage.getItem('wasVisited2')) + 1;
//sessionStorage.setItem('wasVisited2', newVal);
console.log(sessionStorage.wasVisited2),d("#accept-terms").on("click",function(){sessionStorage.setItem("wasVisited2","1")}),d("#enviarBecome").on("click",function(){var e=d("#name").val(),a=d("#country").val(),t=d("#time").val(),r=d("#work").val(),o=d("#email-become").val(),s=d("#why").val(),l=d("#trabajos").val();""==e||""==a||""==t||""==r||""==o||""==s||""==l?alert("Todos los campos son obligatorios"):i(o)?d.ajax({data:{name:e,country:a,experience:t,work:r,email:o,message:s,trabajos:l},type:"POST",dataType:"json",
//contentType: "application/json",
url:u+"pages/ser_miembro_mail/"}).done(function(e){e.success?alert("Mensaje Enviado. Gracias"):alert(e.message)}).fail(function(){alert("Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com")}):alert("Formato de correo erroneo, por favor confirma que todo este bien escrito")});
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
var n="fa fa-play-circle-o",c="fa fa-stop-circle-o",e;
/*=======================================
        packery
        =======================================*/
(d(".singleSongPlayer").length&&d(".singleSong-jplayer").on("click",function(){
//console.log('row_click');
if(!l(d(this))){var e=d(this).attr("id"),a=d(this).attr("data-mp3"),t=d(this).attr("data-title"),r="#"+d(this).closest("tr").attr("id"),o=d(this).closest("tr").attr("id"),s;d(this).find(".fa").removeClass().addClass(c),d("#jquery_jplayer_1").attr("data-audio-id",o),d("#jquery_jplayer_1").jPlayer("destroy"),d("#jquery_jplayer_1").jPlayer({ready:function(){d(this).jPlayer("setMedia",{mp3:a})},pause:function(){var e="#"+d(this).attr("data-audio-id");d(e).find(".fa").removeClass().addClass(n)},play:function(){var e="#"+d(this).attr("data-audio-id");d(e).find(".fa").removeClass().addClass(c)},cssSelectorAncestor:"#jp_container_1",swfPath:"/js/jplayer",supplied:"mp3",useStateClassSkin:!0,autoBlur:!1,smoothPlayBar:!0,keyEnabled:!0,remainingDuration:!0,toggleDuration:!0,errorAlerts:!0}),setTimeout(function(){d("#jquery_jplayer_1").jPlayer("play")},100)}}),d(".xvPackeryItems").length)&&d(".xvPackeryItems").packery({itemSelector:".xvPackeryItem",gutter:0})
/*==============================
        Events Slider
        ==========================*/;var a=d(".eventsSlider"),t=a.data("nexttext"),r=a.data("prevtext");d(".eventsSlider").bxSlider({mode:"vertical",minSlides:3,maxSlider:3,slideMargin:10,pager:!1,nextSelector:"#nextEvents",prevSelector:"#prevEvents",nextText:t,prevText:r,infiniteLoop:!1,hideControlOnEnd:!0}),0!=d("#contactForm").length&&d("#contactForm").submit(function(e){e.preventDefault();var a=d("#xv_name").val(),t=d("#xv_email").val(),r=d("#xv_message").val(),o="name="+a+"&email="+t+"&message="+r;return""!==a&&i(t)&&""!==r?d.ajax({type:"POST",url:"assets/php/submit.php",data:o,success:function(){d("#contactForm").slideUp(),d(".messageSentSuccess").fadeIn()}}):d(".validationError").show(),!1})
/*============================
		Google Maps
        ============================*/,d(".xv-gmap").length&&d(".xv-gmap").each(function(){var e=d(this),a=e.attr("id"),t=e.data("address"),r=e.data("maptype"),o=e.data("zoomlvl"),s,l;switch(e.data("theme")){case"pink":l=[{stylers:[{hue:"#e62948"},{visibility:"on"},{invert_lightness:!0},{saturation:40},{lightness:10}]}];break;case"red":l=[{featureType:"water",elementType:"geometry",stylers:[{color:"#ffdfa6"}]},{featureType:"landscape",elementType:"geometry",stylers:[{color:"#b52127"}]},{featureType:"poi",elementType:"geometry",stylers:[{color:"#c5531b"}]},{featureType:"road.highway",elementType:"geometry.fill",stylers:[{color:"#74001b"},{lightness:-10}]},{featureType:"road.highway",elementType:"geometry.stroke",stylers:[{color:"#da3c3c"}]},{featureType:"road.arterial",elementType:"geometry.fill",stylers:[{color:"#74001b"}]},{featureType:"road.arterial",elementType:"geometry.stroke",stylers:[{color:"#da3c3c"}]},{featureType:"road.local",elementType:"geometry.fill",stylers:[{color:"#990c19"}]},{elementType:"labels.text.fill",stylers:[{color:"#ffffff"}]},{elementType:"labels.text.stroke",stylers:[{color:"#74001b"},{lightness:-8}]},{featureType:"transit",elementType:"geometry",stylers:[{color:"#6a0d10"},{visibility:"on"}]},{featureType:"administrative",elementType:"geometry",stylers:[{color:"#ffdfa6"},{weight:.4}]},{featureType:"road.local",elementType:"geometry.stroke",stylers:[{visibility:"off"}]}];break;case"blue":l=[{stylers:[{hue:"#007fff"},{saturation:89}]},{featureType:"water",stylers:[{color:"#ffffff"}]},{featureType:"administrative.country",elementType:"labels",stylers:[{visibility:"off"}]}];break;case"yellow":l=[{featureType:"water",elementType:"geometry",stylers:[{color:"#a2daf2"}]},{featureType:"landscape.man_made",elementType:"geometry",stylers:[{color:"#f7f1df"}]},{featureType:"landscape.natural",elementType:"geometry",stylers:[{color:"#d0e3b4"}]},{featureType:"landscape.natural.terrain",elementType:"geometry",stylers:[{visibility:"off"}]},{featureType:"poi.park",elementType:"geometry",stylers:[{color:"#bde6ab"}]},{featureType:"poi",elementType:"labels",stylers:[{visibility:"off"}]},{featureType:"poi.medical",elementType:"geometry",stylers:[{color:"#fbd3da"}]},{featureType:"poi.business",stylers:[{visibility:"off"}]},{featureType:"road",elementType:"geometry.stroke",stylers:[{visibility:"off"}]},{featureType:"road",elementType:"labels",stylers:[{visibility:"off"}]},{featureType:"road.highway",elementType:"geometry.fill",stylers:[{color:"#ffe15f"}]},{featureType:"road.highway",elementType:"geometry.stroke",stylers:[{color:"#efd151"}]},{featureType:"road.arterial",elementType:"geometry.fill",stylers:[{color:"#ffffff"}]},{featureType:"road.local",elementType:"geometry.fill",stylers:[{color:"black"}]},{featureType:"transit.station.airport",elementType:"geometry.fill",stylers:[{color:"#cfb2db"}]}];break;case"green":l=[{featureType:"water",elementType:"geometry",stylers:[{visibility:"on"},{color:"#aee2e0"}]},{featureType:"landscape",elementType:"geometry.fill",stylers:[{color:"#abce83"}]},{featureType:"poi",elementType:"geometry.fill",stylers:[{color:"#769E72"}]},{featureType:"poi",elementType:"labels.text.fill",stylers:[{color:"#7B8758"}]},{featureType:"poi",elementType:"labels.text.stroke",stylers:[{color:"#EBF4A4"}]},{featureType:"poi.park",elementType:"geometry",stylers:[{visibility:"simplified"},{color:"#8dab68"}]},{featureType:"road",elementType:"geometry.fill",stylers:[{visibility:"simplified"}]},{featureType:"road",elementType:"labels.text.fill",stylers:[{color:"#5B5B3F"}]},{featureType:"road",elementType:"labels.text.stroke",stylers:[{color:"#ABCE83"}]},{featureType:"road",elementType:"labels.icon",stylers:[{visibility:"off"}]},{featureType:"road.local",elementType:"geometry",stylers:[{color:"#A4C67D"}]},{featureType:"road.arterial",elementType:"geometry",stylers:[{color:"#9BBF72"}]},{featureType:"road.highway",elementType:"geometry",stylers:[{color:"#EBF4A4"}]},{featureType:"transit",stylers:[{visibility:"off"}]},{featureType:"administrative",elementType:"geometry.stroke",stylers:[{visibility:"on"},{color:"#87ae79"}]},{featureType:"administrative",elementType:"geometry.fill",stylers:[{color:"#7f2200"},{visibility:"off"}]},{featureType:"administrative",elementType:"labels.text.stroke",stylers:[{color:"#ffffff"},{visibility:"on"},{weight:4.1}]},{featureType:"administrative",elementType:"labels.text.fill",stylers:[{color:"#495421"}]},{featureType:"administrative.neighborhood",elementType:"labels",stylers:[{visibility:"off"}]}];break;default:l=[]}p(a,t,r,o,l)})}/*suonoApp*/function e(a){(a=Object.create(WaveSurfer)).init({container:"#waveform",waveColor:w,progressColor:j,cursorColor:x,height:k}),a.load("assets/demo-data/demo.wav"),a.on("ready",function(e){a.play(),d(".playWave").hide()}),a.on("error",function(e){console.error(e)}),a.on("finish",function(){console.log("Finished playing"),d(".pauseWave").hide(),d(".playWave").show()}),d("body").on("click",".playWave",function(e){e.preventDefault(),a.play(),d(this).hide(),d(".pauseWave").show()}),d("body").on("click",".pauseWave",function(e){e.preventDefault(),a.pause(),d(this).hide(),d(".playWave").show()}),d("body").on("click",".muteWave",function(e){e.preventDefault(),d(this).toggleClass("pc-mute","pc-volume"),a.toggleMute()})}/*wave init funtion*/var u="https://dalemasbajo.com/",y=d(window).width(),f=!0,r;if(
// $('#ajaxArea').ajaxify({
//     forms: false,
//     requestDelay:500
// });
d(window).on("pronto.render",function(e,a){d("html, body").animate({scrollTop:0}),t(),d(".pageLoader").removeClass("active")}),d(window).on("pronto.request",function(e,a){d(".pageLoader").addClass("active")}),
/*====================
    Main
    =====================*/
d(function(){d('[data-toggle="tooltip"]').tooltip()}),d(".addToCart").on("click",function(){var a=d(this).position(),t=d(this).outerWidth(),r=d(this).closest("tr").attr("data-product"),e=d(this).data("id");console.log(e),d.ajax({data:{id:e},type:"POST",dataType:"json",
//contentType: "application/json",
url:u+"cart/acciones/add_to_cart/"}).done(function(e){e.success?(
//console.log('añadido');
//console.log(data);
s(e.cart_count),console.log(e.cart_count),o(r,a,t)):alert(e.message)}).fail(function(){alert("Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com")})}),d("#login-btn").on("click",function(e){console.log("ingresando"),d.ajax({data:{email:d("#email").val(),password:d("#password").val()},type:"POST",dataType:"json",
//contentType: "application/json",
url:u+"login/front/"}).done(function(e){e.success?location.reload():alert(e.message)}).fail(function(){alert("Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com")})}),d("#myModalRecuperar").on("shown.bs.modal",function(){d("#myModal").modal("hide")}),d("#recuperar-btn").on("click",function(e){console.log("recuperando"),d.ajax({data:{email:d("#recuperar-email").val()},type:"POST",
//contentType: "application/json",
dataType:"json",url:u+"login/recuperar_contrasena/"}).done(function(e){e.success?(alert(e.message),location.reload()):alert(e.message)}).fail(function(){alert("Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com")})}),d("#cambiarpass").on("click",function(e){console.log("cambiando pass"),
//$(e).preventDefault();
0!=d("#cpassword").val().length&&0!=d("#crpassword").val().length?d("#cpassword").val()!=d("#crpassword").val()?alert("Ambos campos deben ser iguales"):d.ajax({data:{pass:d("#cpassword").val(),rpass:d("#crpassword").val(),id:d("#cuser_id").val()},type:"POST",dataType:"json",
//contentType: "application/json",
url:u+"users/changepass/"}).done(function(e){e.success?(alert("Tu contraseña ha sido modificada. Serás redirigido para que ingreses."),location.href="https://dalemasbajo.com"):alert("Algo ha salido mal, intentalo más tarde")}).fail(function(e){return alert("Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com"),!1}):alert("Ambos campos deben estar llenos")}),d("#registrar-btn").on("click",function(e){console.log("registrando"),0!=d("#registro-password").val().length&&0!=d("#registro-repeatpassword").val().length&&0!=d("#registro-email").val().length&&0!=d("#registro-username").val().length?d("#registro-password").val()!=d("#registro-repeatpassword").val()?alert("password y repetir password deben ser iguales"):d.ajax({data:{email:d("#registro-email").val(),username:d("#registro-username").val(),password:d("#registro-password").val()},type:"POST",dataType:"json",
//contentType: "application/json",
url:u+"users/registro/"}).done(function(e){"email_existe"==e.respuesta?alert("Este e-mail ya esta registrado"):"username_existe"==e.respuesta?alert("Este username ya esta registrado"):"ok"==e.respuesta&&(d("#registrar-form").trigger("reset"),alert("Gracias por registrarte, en breve recibirás un e-mail para confirmar tu dirección de correo electrónico y finalizar el registro."),location.reload())}).fail(function(){alert("Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com")}):alert("Todos los campos son obligatorios")}),d("#paynow").on("click",function(e){e.preventDefault(),
//console.log($('#amount').val());
d.ajax({data:{total:d("#amount").val()},type:"POST",
//contentType: "application/json",
dataType:"json",url:u+"cart/create_order/"}).done(function(e){if(e.success)return d("#custom").val(e.order_id),console.log("añadida orden"),d("#pagarpaypal").submit(),!0;alert(e.message)}).fail(function(){alert("Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com"),e.preventDefault()})}),d(".deleteFromCart").on("click",function(){var e=d(this).data("id");d.ajax({data:{id:e},type:"POST",dataType:"json",
//contentType: "application/json",
url:u+"cart/acciones/remove_from_cart/"}).done(function(e){e.success?(console.log("eliminado"),location.reload()):alert(e.message)}).fail(function(){alert("Algo extraño ha ocurrido 🤔 envía un mensaje a soporte para corregirlo lo antes posible a: support@dalemasbajo.com")})}),t(),
/*======================================
    Menu
    ======================================*/
d("#sticktop").sticky({topSpacing:0}),d(window).on("resize load",function(){d(".sticky-wrapper").css("height",+d("#sticktop").innerHeight()+"px")}),d("body").on("click",".dl-menu > li > a",function(e){var a=d(this),t=a.parent();t.children("ul").length?(e.preventDefault(),t.children("ul").addClass("expand"),a.parents(".dl-menu").addClass("backed")):(d(".dl-menu").removeClass("xvMenuShow"),d(".dl-menu > li").removeClass("active"),a.parent().addClass("active"))}),d("body").on("click",".dl-menu > li > ul > li > a",function(e){d(this).hasClass("backLvl")||(d(".dl-menu").removeClass("backed"),d(".dl-menu").removeClass("xvMenuShow"))}),d("body").on("click",".menuTrigger",function(e){e.preventDefault(),d(".dl-menu").toggleClass("xvMenuShow")}),d("body").on("click",".backLvl",function(e){var a=d(this);e.preventDefault(),a.parents(".dl-submenu").removeClass("expand"),a.parents(".dl-menu").removeClass("backed")}),d(".dl-submenu").each(function(){var e;d(this).prepend('<li class="gobackLvl"><a class="backLvl" href="#"><i class="fa fa-long-arrow-left"></i>Go Back</li>')}),
/*==============================================
	Header Player
	==============================================*/
d("body").on("click",function(e){d(e.target).closest(".the-xv-Jplayer").length||(d(".jp-playlist").slideUp(),d("body").removeClass("playerFullOn"))}),d(".sound-trigger").click(function(e){d(this).parent(".jp-volume-controls").toggleClass("open")}),d(".playList-trigger").click(function(e){d("body").toggleClass("playerFullOn"),d(".jp-playlist").slideToggle()}),d("#audio-player").length){if(d("#player-instance").jPlayer({cssSelectorAncestor:"#audio-player"}),d(".playlist-files").length){for(var a=[],l=d(".playlist-files li"),i=l.length,n=0;n<i;n++){var c={};c.title=l.eq(n).attr("data-title"),c.artist=l.eq(n).attr("data-artist"),c.mp3=l.eq(n).attr("data-mp3"),a.push(c)}r=new jPlayerPlaylist({jPlayer:"#player-instance",enableRemoveControls:!1,cssSelectorAncestor:"#audio-player"},a,{playlistOptions:{autoPlay:!1,loopOnPrevious:!0}},{swfPath:"assets/js/jPlayer/jquery.jplayer.swf",supplied:"mp3",displayTime:"fast",addTime:"fast"}),d("#player-instance").bind(d.jPlayer.event.play,function(e){var t=r.current,a=r.playlist;jQuery.each(a,function(e,a){e==t&&d(".the-xv-Jplayer .audio-title").html('<span class="jp-artist">'+a.artist+'</span><span class="jp-songTitle">'+a.title+"</span>")})})}d(".jp-prev").click(function(){r.previous()})}if(d("#audio-player-radio").length){var m=d("#audio-player-radio").attr("data-radio-url"),g,v={title:d("#audio-player-radio").attr("data-title"),mp3:m},h=!1;d("#player-instance-radio").jPlayer({ready:function(e){h=!0,d(this).jPlayer("setMedia",v).jPlayer("play")},pause:function(){d(this).jPlayer("clearMedia")},error:function(e){h&&e.jPlayer.error.type===d.jPlayer.error.URL_NOT_SET&&d(this).jPlayer("setMedia",v).jPlayer("play")},cssSelectorAncestor:"#audio-player-radio",swfPath:"assets/js/jPlayer/jquery.jplayer.swf",preload:"none"})}
/*================
    WavePlayer ( used in header)
    ====================*/var b=d(".waveSurferPlayer"),T=d("#waveform"),w=T.attr("data-wave-color"),j=T.attr("data-wave-progress"),x=T.attr("data-cursor"),k=+T.attr("data-height"),S;b.length&&(WaveSurfer.Swf.supportsAudioContext()&&WaveSurfer.Swf.supportsCanvas()?e(S=Object.create(WaveSurfer)):(swfobject.embedSWF("assets/js/wavesurfer/wavesurfer.swf","wavesurfer","100%","128","11.1.0","expressInstall.swf",{},{allowScriptAccess:"always"},{}),(S=new WaveSurfer.Swf).on("init",function(){e(S)})))});