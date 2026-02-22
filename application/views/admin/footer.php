      <footer class="sl-footer">
        <div class="footer-left">
          <div class="mg-b-2">Copyright &copy; 2018. Dale Más Bajo. Todos los derechos reservados.</div>
          <div>Sitio web desarrollado por <a href="http://shiftandcontrol.com">Shift & Ctrl</a></div>
        </div>
        
      </footer>
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    <script src="<? echo site_url(); ?>admin_assets/lib/jquery/jquery.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/popper.js/popper.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/bootstrap/bootstrap.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/jquery-ui/jquery-ui.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/jquery.sparkline.bower/jquery.sparkline.min.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/highlightjs/highlight.pack.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/d3/d3.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/rickshaw/rickshaw.min.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/chart.js/Chart.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/Flot/jquery.flot.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/Flot/jquery.flot.pie.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/Flot/jquery.flot.resize.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/flot-spline/jquery.flot.spline.js"></script>
    
    <script src="<? echo site_url(); ?>admin_assets/lib/datatables/jquery.dataTables.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/datatables-responsive/dataTables.responsive.js"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/select2/js/select2.min.js"></script>

    <script src="<? echo site_url(); ?>admin_assets/js/starlight.js?v=1.5"></script>
    <script src="<? echo site_url(); ?>admin_assets/lib/spectrum/spectrum.js"></script>
    
    <script src="<? echo base_url(); ?>js/jplayer/jquery.jplayer.min.js"></script>
    <script src="<? echo base_url(); ?>js/jplayer/jplayer.playlist.min.js"></script>

    <script src="<? echo site_url(); ?>admin_assets/js/ResizeSensor.js"></script>
    <? if(isset($aditional_scripts)){ ?>
        <? echo $aditional_scripts; ?>
    <? } ?>

    <? if(isset($scripts)){
        foreach($scripts as $script){
            echo '<script src="'.$script.'" type="text/javascript"></script>';
        }
     
     } ?>

     <? if(isset($uploader)){ ?>
        <? if($uploader){ ?>
        <script type="text/javascript">
            //ESTA FUNCIÓN SE EJECUTARÁ AL FINAL DE LA CARGA DEL COVER O MP4 Y SI AMBOS ESTAN CARGADOS, SE PROCEDE A ENVIAR LA INFORMACIÓN AL HOSTING PARA SER INSERTADA
            //No confundir con document.ready()
                    function ready(i){
                        var demo = 0;
                        if(data_[i]['type']==3){
                            demo = 1;
                        }else{
                            demo = data_[i]['demo'];
                        }
                        if(demo!=='' && data_[i]['descargable']!==''){
                            console.log('COVER VALUE =>', data_[i]['cover']);
                            console.log('TYPE =>', data_[i]['type'], 'NAME =>', data_[i]['video_name']);
                            $.ajax({
                                url:url_return,
                                type:"POST",
                                //Artist = version **
                                data:{
                                    action:'file_add',
                                    real_file_name: data_[i]['descargable'],
                                    file_preview: data_[i]['demo'],
                                    video_name: data_[i]['video_name'], 
                                    video_artist: data_[i]['video_artist'], 

                                    cover: data_[i]['cover'],
                                    version: data_[i]['version'], 
                                    gender_id: data_[i]['gender_id'], 
                                    descargable: data_[i]['descargable'], 
                                    demo: data_[i]['demo'], 
                                    description: data_[i]['description'],
                                    bpm: data_[i]['bpm'], 
                                    //calidad: data_[i]['calidad'], 
                                    size: data_[i]['size'],
                                    price: data_[i]['price'],
                                    type: data_[i]['type'],
                                }

                                }).fail(function(e){
                                    alert(e);
                                }).done(function(data){
                                    $('#upload'+i).slideToggle(400,'',function(){ $('#upload'+i).remove(); });
                                    $('#title'+i).css({'background':'#33994E'});
                                    if(i>=(data_.length-1))
                                    {
                                        //FINISH
                                        upload_position=0;
                                        data_=[];
                                        upload_object=[];
                                        alert('Tus archivos fueron cargados correctamente. Gracias!');
                                        window.location.href='';
                                    }
                            });
                        }
                    }

                    //TIMESTAMPFUNCTION
                    var time = Date.now || function() {
                        return +new Date;
                    };
                    var upload_position=0;
                    var upload_object=[];
                    var upload_object_preview=[];

                    function startUpload(){
                        console.log('subiendo: '+data_[upload_position]);
                        //VAN SUBIENDO DE A UNO
                        //Check if form was queued
                        if(upload_object.length>0 && (upload_object.length == upload_object_preview.length))
                        {
                            //!=='' Means that a file was really selected and have a Size.
                            if(data_[upload_position]['size']!=='')
                            {
                                if($('#upload'+upload_position).length>0)
                                {
                                    upload_object[upload_position].startUpload();
                                }
                                upload_position++;
                            }else{
                                alert('Please, complete ALL FILES with respective File, Preview and Cover.');
                            }
                        }else{
                                alert('Please, complete the form and select your files first.');
                        }
                    }
                    //CREATE LOS BOXES DE UPLOAD
                    function create_upload(i,server){
                        //Create mp3 upload
                        var final_name = '<? echo $this->session->userdata["id_usuario"]; ?>'+datetime();
                        var pack       = $('#setPack').val();
                        upload_object[i]=$("#mp34"+i).uploadFile({
                            url:"<? echo site_url().'admin/subir/'; ?>",
                            fileName:"files",
                            multiple:false,
                            autoSubmit:false, //SOLO TRUE PARA EL COVER
                            uploadButtonClass:"submit",
                            allowedTypes:"mp3,zip,rar,mp4",
                            dragDropStr: "<span><b>Arrastra y Suelta archivos</b></span>",
                            formData:{
                                'action':'file_upload',
                                'file':final_name,
                                'pack':pack,
                                'preview':(upload_preview?'true':'false'),
                                'demo':'0'
                            },
                            dragdropWidth: 300,statusBarWidth: 300,
                            onError: function(files,status,errMsg,pd)
                            {
                                alert('ERROR: CONNECTION LOST');
                            },
                            onSelect:function(files)
                            {
                                data_[i]['size'] = size=parseInt(((parseInt(files[0].size)/1000)/1024));
                                return true; //to allow file submission.
                            },

                            onSuccess:function(files,resp,xhr)
                            {
                                if(resp=='true'){
                                    state[i]=state[i]+1;
                                    //data:{video_name: 0, video_img: 1, artista: 2, genre: 3, video_download: 4, muestra: 5, bpm: 6, calidad: 8, size: 9, Type_price: 10, hot: 13, new: 14}
                                    console.log('to ready:'+files);
                                    data_[i]['descargable']=final_name +'.'+(files[0].toString().split('.').pop());
                                    data_[i]['demo']=data_[i]['demo'];

                                    ready(i);
                                        //COntinue uploading
                                        if(upload_position<data_.length){
                                            startUpload();
                                        }else{

                                        }

                                }else{
                                    //Restart upload
                                    upload_object[i].startUpload();
                                }
                            }
                        });
                        //Create preview
                        upload_object_preview[i]=$("#preview"+i).uploadFile({
                            url:"<? echo site_url().'admin/subir/'; ?>",
                            fileName:"files",
                            multiple:false,
                            autoSubmit:true, //SOLO TRUE PARA EL COVER
                            uploadButtonClass:"submit",
                            allowedTypes:"mp3,mp4,rar,zip",
                            dragDropStr: "<span><b>Arrastra y Suelta archivos</b></span>",
                            formData:{
                                'action':'file_upload',
                                'file':final_name,
                                'preview':'false',
                                'demo':1
                            },
                            onError: function(files,status,errMsg,pd)
                            {
                                alert('ERROR: CONNECTION LOST');
                            },
                            dragdropWidth: 300,statusBarWidth: 300,
                            onSuccess:function(files,resp,xhr)
                            {
                                if(resp=='true'){
                                    state[i]=state[i]+1;
                                    //data:{video_name: 0, video_img: 1, artista: 2, genre: 3, video_download: 4, muestra: 5, bpm: 6, calidad: 8, size: 9, Type_price: 10, hot: 13, new: 14}

                                    data_[i]['demo']=final_name + '.' + (files.toString().split('.').pop());

                                    /*ready(i);
                                        //Continue Uploading files
                                        if(upload_position<data_.length){
                                            startUpload();
                                        }else{
                                            //FINISH
                                            upload_position=0;
                                            data_=[];
                                            upload_object=[];
                                            upload_object_preview=[];
                                            alert('Your files were uploaded properly. Thanks!')
                                            window.location.href='';
                                        }
                                    */
                                }else{
                                    alert('ERROR: '+resp);
                                }
                            }
                        });
                        // Create cover upload (image)
                        $("#cover"+i).uploadFile({
                            url:"<? echo site_url().'admin/subir/'; ?>",
                            fileName:"files",
                            multiple:false,
                            autoSubmit:true,
                            uploadButtonClass:"submit",
                            allowedTypes:"jpg,jpeg,png,webp",
                            dragDropStr: "<span><b>Arrastra y Suelta portada</b></span>",
                            formData:{
                                'action':'cover_upload',
                                'file':'cover_'+final_name
                            },
                            dragdropWidth: 300, statusBarWidth: 300,
                            onError: function(files,status,errMsg,pd){
                                alert('ERROR uploading cover');
                            },
                            onSuccess:function(files,resp,xhr){
                                // resp debe devolverte el path o filename
                                if(resp && resp !== 'false'){
                                    // resp ideal: "assets/products/covers/xxx.jpg"
                                    $('#hide_cover'+i).val(resp);
                                    data_[i]['cover'] = resp;
                                    console.log('COVER SAVED =>', data_[i]['cover']);
                                }else{
                                    alert('Cover upload failed');
                                }
                            }
                        });
                    }
                    //Use default cover or upload a new cover
                    function set_cover(obj,data_indice)
                    {
                        if(obj.is(':checked'))
                        {
                            //Set default
                            data_[data_indice]['cover']   = '<?php // echo $image_name; ?>';
                        }else{
                            //Empty value? keep default
                            if( $('#hide_cover'+data_indice).val()  !== ''  )
                            {
                                //Replace cover value
                                data_[data_indice]['cover']   =  $('#hide_cover'+data_indice).val();
                            }
                        }
                    }
                    //RETURN_VIDEO.php
                    //SET VARS
                    var url_return="<? echo site_url().'admin/subir/'; ?>";
                    var server_ip=[];
                    server_ip[0]='<? echo site_url().'admin/subir/'; ?>';
                    var server_btn = '';
                    for(var k=0; k<server_ip.length; k++)
                    {
                        server_btn = server_btn+'<input type="radio" name="server" '+(k==0?'checked':'')+' id="server'+k+'" onClick="server_id='+k+';"><label for="server'+k+'">SERVER #'+k+'</label>';
                    }

                    //data:{video_name: 0, video_img: 1, artista: 2, genre: 3, video_download: 4, muestra: 5, bpm: 6, calidad: 8, size: 9, Type_price: 10, hot: 13, new: 14}
                    <?php
                    //if($upload_preview)
                    if(1)
                    {
                        echo 'var upload_preview = true;';
                    }else{
                        echo 'var upload_preview = false;';
                    }
                    ?>
                    var server_id=0; //default
                    var video_name='';
                    var video_artist='';
                    var cover='';
                    var artist='';
                    var genre= '';
                    var gender_id;
                    var video_download='';
                    var preview='';
                    var version='';
                    var CodDj='';
                    var demo = '';
                    var descargable="";
                    var bpm='';
                    var calidad='';
                    var size='';
                    var type_price=15;
                    var hot=0;
                    var new_=0;
                    var price = 0;
                    var description = '';
                    //SET ARRAY DATA
                    var data_=[];
                    var data_indice=0;
                    var state=[]; //IF EACH UPLOAD IS COMPLETE
        
            function remove_video(i){
                $('#upload'+i).parent().remove();
                $('#upload'+i).remove();
                $('#title'+i).remove();
            }
            function queue(nGenres){
                genre_list(nGenres);
                if(genre==''){ 
                    return alert('Choose at least one genre'); 
                }
                var _generos = $('#format input');
                _generos.each(function(){
                    if($(this).is(':checked')){
                        gender_id=$(this).val();
                        console.log(gender_id);
                    }
                });
                if(empty($('#video_name'))==false){
                    return false;
                }
                video_name=$('#video_name').val();
                // if(empty($('#video_artist'))==false){
                //     return false;
                // }
                video_artist=$('#video_artist').val();
                if(empty($('#precio'))==false){
                    return false;
                }
                price=$('#precio').val();
                // if(empty($('#description'))==false){
                //     return false;
                // }
                description=$('#description').val();
                // if(empty($('#bpm'))==false){
                //     return false;
                // }
                bpm=$('#bpm').val();
                if(empty($('#version'))==false){
                    return false;
                }
                version=$('#version').val();
                // if(empty($('#quality'))==false){
                //     return false;
                // }
                //calidad=$('#quality').val();
                type = $('#setPack').val(); 
                //GENERAR ARRAY, FILEUPLOADER Y HTML
                data_[data_indice]=[];
                /*
                    'name',
                    'price',
                    'featured_image',
                    'gender_id',
                    'description',
                    'bpm',
                    'demo',
                    'descargable',
                */
                data_[data_indice]['video_name']=video_name;
                data_[data_indice]['video_artist']=video_artist;
                data_[data_indice]['price']=price;
                data_[data_indice]['name_genre']=name_genre;
                data_[data_indice]['description']=description;
                data_[data_indice]['bpm']=bpm;
                data_[data_indice]['demo']=demo;
                //data_[data_indice]['calidad']=calidad;
                data_[data_indice]['version']=version;
                data_[data_indice]['descargable']=descargable;
                data_[data_indice]['type']=type;
                data_[data_indice]['gender_id']= gender_id;

                var html='<div class="item"><h6 class="card-body-title tx-12 mg-b-5" id="title'+data_indice+'" onclick="$(\'#upload'+data_indice+'\').slideToggle(400); " style="cursor:pointer"> '+data_[data_indice]['video_name']+'</h1>\
                    <article class="toggle" id="upload'+data_indice+'">\
                    <table>\
                        <tr>\
                            <td>Bpm: </td><td>'+data_[data_indice]['bpm']+'</td>\
                        </tr>\
                        <tr>\
                            <td>Price: </td><td>'+data_[data_indice]['price']+'</td>\
                        </tr>\
                        <tr>\
                            <td>Artist: </td><td>'+data_[data_indice]['video_artist']+'</td>\
                        </tr>\
                        <tr>\
                            <td>Version: </td><td>'+data_[data_indice]['version']+'</td>\
                        </tr>\
                        <tr>\
                            <td>Genre: </td><td>'+name_genre+'</td>\
                        </td>\
                        <tr>\
                            <td>File</td>\
                            <td><div id="mp34'+data_indice+'"></div></td>\
                        </tr>';
                    if(data_[data_indice]['type']!=3){
                        html = html+ '<tr>\
                                    <td>Preview File (only on mp3)</td>\
                                    <td><div id="preview'+data_indice+'"></div></td>\
                                </tr>';
                        html = html + '<tr>\
                        <td>Cover (image)</td>\
                        <td>\
                        <div id="cover'+data_indice+'"></div>\
                        <input type="hidden" id="hide_cover'+data_indice+'" value="">\
                        <small style="display:block;margin-top:6px;color:#666;">JPG/PNG/WebP</small>\
                        </td>\
                        </tr>';
                    }
                    html=html+'</table>\
                    <input type="button" class="btn btn-danger" style="width:120px !important;" value="DELETE" onclick="remove_video('+data_indice+')" /></article></div>';
                $('.content_upload').append(html);
                create_upload(data_indice,server_id);
                state[data_indice]=0; //DEFINO ESTADOS DE UPLOAD
                //LUEGO DE GENERAR ARRAY
                data_indice++;
                //CHANGE
            }

            function empty(e){
                if(e.val()!==''){
                    return e.val()
                }else{
                    e.focus();
                    return false;
                }
            }



            //GENRE GENERATOR FUNCTION
            function genre_list(elements){
                genre='';
                name_genre='';
                var i2=0;
                for(var i=0; i<elements; i++){
                    if($('#check'+i).is(':checked')){
                        genre=genre+(i2==0?'':',')+$('#check'+i).val();
                        name_genre=name_genre+(i2==0?'':',')+$('#label'+i).text();
                        i2++;
                    }
                }
            }
            
            function datetime()
            {
                var currentdate = new Date();
                return currentdate.getDate() +''+ (currentdate.getMonth()+1) +''+ currentdate.getFullYear() +''+ currentdate.getHours() +''+ currentdate.getMinutes() +''+ currentdate.getSeconds();
            }
            //SET VIDEO_TYPE
            function set_type(val,btn){
                video_type=val;
                $('#type_').html(val);
                $('.video_type').stop().animate({opacity:0.2},200,'',function(){ btn.stop().animate({opacity:1},400); });
            }
        
            $(document).ready(function(e)
            {
                $('#servers').html(server_btn);
                //$( "#format" ).buttonset();
                //$( "#options" ).buttonset();
                //$( "#servers" ).buttonset();

                $(".genre_chbox").on('click', function() {
                   
                    var $box = $(this);

                    $box.change(function(){
                        console.log('cambió');
                        $box=$(this).attr('id');
                        if ($('#'+$box).prop("checked")) {
                            var group = ".genre_chbox";
                            $(group).prop("checked", false);
                            console.log($box);
                            $(this).prop("checked", true);
                            $(this).prop('checked');
                        } else {
                            $(this).prop("checked", false);
                            $(this).attr('checked', false);
                        }
                    });
                });
            });
            

        </script>
    <? } }?>
    <script type="text/javascript">
        $('#tipo').on('change', function(){
            if($(this).val()==2){
                $('#pagominimo').css({'display':'block'});
            }else{
                $('#pagominimo').css({'display':'none'});
            }
        });
    </script>

  </body>
</html>