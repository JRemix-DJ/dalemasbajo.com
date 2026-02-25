/*!
 * Starlight v2.0.0 (https://themepixels.me/starlight)
 * Copyright 2017-2018 ThemePixels
 * Licensed under ThemeForest License
 */

 'use strict';
var base_url = "http://localhost/dalemasbajo.com/";

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


 $(document).ready(function(){

  // This will auto show sub menu using the slideDown()
  // when top level menu have a class of .show-sub
  $('.show-sub + .sl-menu-sub').slideDown();

  if ($(".audio_product").length) {
     $('.audio_demo').each(function(num, ele) {
      var temp_id = $(this).attr("id");
      var temp_song = $(this).data('mp3');
      var temp_wrap = "#"+$(this).parent().parent().attr('id');
      var temp_title="Demo";
      console.log(temp_wrap);
      $(".audio_demo#" + temp_id).jPlayer({
          play: function() {
              var jPlayerElement = $(this);
              $(this).jPlayer("pauseOthers"); // pause all players except this one.
              jPlayerElement.bind($.jPlayer.event.progress,function(event){
                  console.log(event.jPlayer.status);
              });
          },
          ready: function() {
              $(this).jPlayer("setMedia", {
                  mp3: temp_song,
                  title: temp_title
              });
          },
          cssSelectorAncestor: temp_wrap,
          volume: 0.5,
          supplied: "mp3",
          swfPath: "assets/js/jPlayer/jquery.jplayer.swf",
      });
     });
  }


  if ($(".video_product").length) {
    $('.video_demo').each(function(num, ele) {
     var temp_id = $(this).attr("id");
     var temp_song = $(this).data('mp4');
     var temp_wrap = "#"+$(this).parent().parent().attr('id');
     var temp_title="Demo";
     console.log(temp_wrap);
     $(".video_demo#" + temp_id).jPlayer({
         play: function() {
             var jPlayerElement = $(this);
             $(this).jPlayer("pauseOthers"); // pause all players except this one.
             jPlayerElement.bind($.jPlayer.event.progress,function(event){
                 console.log(event.jPlayer.status);
             });
         },
         ready: function() {
             $(this).jPlayer("setMedia", {
                 m4v: temp_song,
                 title: temp_title
             });
         },
         cssSelectorAncestor: temp_wrap,
         volume: 0.5,
         supplied: "mp3,m4v",
         size: {
            width: "250px",
            height: "150px"
         },
         swfPath: "assets/js/jPlayer/jquery.jplayer.swf",
     });
    });
 }
  

  // This will collapsed sidebar menu on left into a mini icon menu
  $('#btnLeftMenu').on('click', function(){
    var menuText = $('.menu-item-label,.menu-item-arrow');

    if($('body').hasClass('collapsed-menu')) {
      $('body').removeClass('collapsed-menu');

      // show current sub menu when reverting back from collapsed menu
      $('.show-sub + .sl-menu-sub').slideDown();

      $('.sl-sideleft').one('transitionend', function(e) {
        menuText.removeClass('op-lg-0-force');
        menuText.removeClass('d-lg-none');
      });

    } else {
      $('body').addClass('collapsed-menu');

      // hide toggled sub menu
      $('.show-sub + .sl-menu-sub').slideUp();

      menuText.addClass('op-lg-0-force');
      $('.sl-sideleft').one('transitionend', function(e) {
        menuText.addClass('d-lg-none');
      });
    }
    return false;
  });



  // This will expand the icon menu when mouse cursor points anywhere
  // inside the sidebar menu on left. This will only trigget to left sidebar
  // when it's in collapsed mode (the icon only menu)
  $(document).on('mouseover', function(e){
    e.stopPropagation();

    if($('body').hasClass('collapsed-menu') && $('#btnLeftMenu').is(':visible')) {
      var targ = $(e.target).closest('.sl-sideleft').length;
      if(targ) {
        $('body').addClass('expand-menu');

        // show current shown sub menu that was hidden from collapsed
        $('.show-sub + .sl-menu-sub').slideDown();

        var menuText = $('.menu-item-label,.menu-item-arrow');
        menuText.removeClass('d-lg-none');
        menuText.removeClass('op-lg-0-force');

      } else {
        $('body').removeClass('expand-menu');

        // hide current shown menu
        $('.show-sub + .sl-menu-sub').slideUp();

        var menuText = $('.menu-item-label,.menu-item-arrow');
        menuText.addClass('op-lg-0-force');
        menuText.addClass('d-lg-none');
      }
    }
  });



  // This will show sub navigation menu on left sidebar
  // only when that top level menu have a sub menu on it.
  $('.sl-menu-link').on('click', function(){
    var nextElem = $(this).next();
    var thisLink = $(this);

    if(nextElem.hasClass('sl-menu-sub')) {

      if(nextElem.is(':visible')) {
        thisLink.removeClass('show-sub');
        nextElem.slideUp();
      } else {
        $('.sl-menu-link').each(function(){
          $(this).removeClass('show-sub');
        });

        $('.sl-menu-sub').each(function(){
          $(this).slideUp();
        });

        thisLink.addClass('show-sub');
        nextElem.slideDown();
      }
      return false;
    }
  });



  // This will trigger only when viewed in small devices
  // #btnLeftMenuMobile element is hidden in desktop but
  // visible in mobile. When clicked the left sidebar menu
  // will appear pushing the main content.
  $('#btnLeftMenuMobile').on('click', function(){
    $('body').addClass('show-left');
    return false;
  });



  // This is the right menu icon when it's clicked, the
  // right sidebar will appear that contains the four tab menu
  $('#btnRightMenu').on('click', function(){
    $('body').addClass('show-right');
    return false;
  });



  // This will hide sidebar when it's clicked outside of it
  $(document).on('click', function(e){
    e.stopPropagation();

    // closing left sidebar
    if($('body').hasClass('show-left')) {
      var targ = $(e.target).closest('.sl-sideleft').length;
      if(!targ) {
        $('body').removeClass('show-left');
      }
    }

    // closing right sidebar
    if($('body').hasClass('show-right')) {
      var targ = $(e.target).closest('.sl-sideright').length;
      if(!targ) {
        $('body').removeClass('show-right');
      }
    }
  });

  // custom scrollbar style
  $('.sl-sideleft, .sl-sideright .tab-pane').perfectScrollbar();

  // highlight syntax highlighter
  $('pre code').each(function(i, block) {
    hljs.highlightBlock(block);
  });

  // Initialize tooltip
  $('[data-toggle="tooltip"]').tooltip();

  // Initialize popover
  $('[data-popover-color="default"]').popover();

  // By default, Bootstrap doesn't auto close popover after appearing in the page
  // resulting other popover overlap each other. Doing this will auto dismiss a popover
  // when clicking anywhere outside of it
  $(document).on('click', function (e) {
    $('[data-toggle="popover"],[data-original-title]').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
        }

    });
  });

  if($('#genero-productos').length){
    $('#genero-productos').on('change', function(){
       var genero=$(this).val();
       var $_GET = {};
       if(document.location.toString().indexOf('?') !== -1) {
          var query = document.location
                         .toString()
                         // get the query string
                         .replace(/^.*?\?/, '')
                         // and remove any existing hash string (thanks, @vrijdenker)
                         .replace(/#.*$/, '')
                         .split('&');

          for(var i=0, l=query.length; i<l; i++) {
             var aux = decodeURIComponent(query[i]).split('=');
             $_GET[aux[0]] = aux[1];
          }
      }
      //get the 'index' query parameter
      //alert($_GET['aprobacion']);
      if(typeof $_GET['aprobacion']!== "undefined"){
        if(typeof $_GET['search']!== "undefined"){
          window.location.href = 'http://localhost/dalemasbajo.com/admin/listar_productos/?aprobacion=1&search='+$_GET['search']+'genero_filter='+genero;
        }else{
          window.location.href = 'http://localhost/dalemasbajo.com/admin/listar_productos/?aprobacion=1&genero_filter='+genero;
        }
      }else{
        if(typeof $_GET['search']!== "undefined"){
          window.location.href = 'http://localhost/dalemasbajo.com/admin/listar_productos/?search='+$_GET['search']+'&genero_filter='+genero;
        }else{
          window.location.href = 'http://localhost/dalemasbajo.com/admin/listar_productos/?genero_filter='+genero;
        }
      }
    });
  }

  if($('#genero-videos').length){
    $('#genero-videos').on('change', function(){
       var genero=$(this).val();
       var $_GET = {};
       if(document.location.toString().indexOf('?') !== -1) {
          var query = document.location
                         .toString()
                         // get the query string
                         .replace(/^.*?\?/, '')
                         // and remove any existing hash string (thanks, @vrijdenker)
                         .replace(/#.*$/, '')
                         .split('&');

          for(var i=0, l=query.length; i<l; i++) {
             var aux = decodeURIComponent(query[i]).split('=');
             $_GET[aux[0]] = aux[1];
          }
      }
      //get the 'index' query parameter
      //alert($_GET['aprobacion']);
      if(typeof $_GET['aprobacion']!== "undefined"){
        if(typeof $_GET['search']!== "undefined"){
          window.location.href = 'http://localhost/dalemasbajo.com/admin/listar_videos/?aprobacion=1&search='+$_GET['search']+'genero_filter='+genero;
        }else{
          window.location.href = 'http://localhost/dalemasbajo.com/admin/listar_videos/?aprobacion=1&genero_filter='+genero;
        }
      }else{
        if(typeof $_GET['search']!== "undefined"){
          window.location.href = 'http://localhost/dalemasbajo.com/admin/listar_videos/?search='+$_GET['search']+'&genero_filter='+genero;
        }else{
          window.location.href = 'http://localhost/dalemasbajo.com/admin/listar_videos/?genero_filter='+genero;
        }
      }
    });
  }

  var where = $('#where').val();
  var user_id = $('#user_id').val();
  var accion = $('#accion').val();
  mostrar_paginacion(1,25,user_id, accion, where)

  $("body").on("click",".paginacion li a",function(e){
		e.preventDefault();
		var valorhref = $(this).attr("href");
		mostrar_paginacion(valorhref, 25, user_id, accion, where);
  });
  
});

function mostrar_paginacion(pagina ,cantidad, user_id, accion, where){
	$.ajax({
		url : base_url+accion,
		type: "POST",
    data: {nropagina:pagina,cantidad:cantidad, user_id:user_id, where:where},
    dataType:"json",
		success:function(data){

      $("#total_descargas").html(data.html);
      
			var linkseleccionado = Number(pagina);
			//total registros
            var totalregistros = data.total_registros;
			//cantidad de registros por pagina
        var cantidadregistros = cantidad;
			var numerolinks = Math.ceil(totalregistros/cantidadregistros);
			var paginador = "<ul class='paginacion justify-content-center'>";
			if(linkseleccionado>1){
				paginador+="<li class='page-item'><a class='page-link' href='1'>&laquo;</a></li>";
				paginador+="<li class='page-item'><a class='page-link' href='"+(linkseleccionado-1)+"' '>&lsaquo;</a></li>";

			}else{
				paginador+="<li class='disabled page-item'><a class='page-link' href='#'>&laquo;</a></li>";
				paginador+="<li class='disabled page-item'><a class='page-link' href='#'>&lsaquo;</a></li>";
			}
			//muestro de los enlaces 
			//cantidad de link hacia atras y adelante
 			var cant = 2;
 			//inicio de donde se va a mostrar los links
			var pagInicio = (linkseleccionado > cant) ? (linkseleccionado - cant) : 1;
			//condicion en la cual establecemos el fin de los links
			if (numerolinks > cant){
				//conocer los links que hay entre el seleccionado y el final
				var pagRestantes = numerolinks - linkseleccionado;
				//defino el fin de los links
				var pagFin = (pagRestantes > cant) ? (linkseleccionado + cant) :numerolinks;
			}else{
				var pagFin = numerolinks;
			}

			for (var i = pagInicio; i <= pagFin; i++) {
				if (i == linkseleccionado)
					paginador +="<li class='active page-item'><a class='page-link' href='javascript:void(0)'>"+i+"</a></li>";
				else
					paginador +="<li class='page-item' ><a class='page-link' href='"+i+"'>"+i+"</a></li>";
			}
			//condicion para mostrar el boton sigueinte y ultimo
			if(linkseleccionado<numerolinks){
				paginador+="<li class='page-item'><a class='page-link' href='"+(linkseleccionado+1)+"' >&rsaquo;</a></li>";
				paginador+="<li class='page-item'><a class='page-link' href='"+numerolinks+"'>&raquo;</a></li>";

			}else{
				paginador+="<li class='disabled page-item'><a class='page-link' href='#'>&rsaquo;</a></li>";
				paginador+="<li class='disabled page-item'><a class='page-link' href='#'>&raquo;</a></li>";
			}
			
			paginador +="</ul>";
				$(".paginacion").html(paginador);
		}
	});
}
