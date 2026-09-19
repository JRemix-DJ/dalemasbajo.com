var base_url = (window.DMB_ADMIN && window.DMB_ADMIN.baseUrl) ? window.DMB_ADMIN.baseUrl : (window.location.origin + "/");
var userId = (window.DMB_ADMIN && window.DMB_ADMIN.userId) ? window.DMB_ADMIN.userId : "";

function ready(i){
    var demo = 0;
    if(data_[i]['type']==3){
        demo = 1;
    }else{
        demo = data_[i]['demo'];
    }
    if(demo!=='' && data_[i]['descargable']!==''){
        $.ajax({
            url:url_return,
            type:"POST",
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
                size: data_[i]['size'],
                price: data_[i]['price'],
                type: data_[i]['type'],
                payment_link: data_[i]['payment_link'],
            }
        }).fail(function(e){
            alert(e);
        }).done(function(data){
            $('#upload'+i).slideToggle(400,'',function(){ $('#upload'+i).remove(); });
            $('#title'+i).css({'background':'#33994E'});
            if(i>=(data_.length-1)){
                upload_position=0;
                data_=[];
                upload_object=[];
                alert('Tus archivos fueron cargados correctamente. Gracias!');
                window.location.href='';
            }
        });
    }
}

var time = Date.now || function() {
    return +new Date;
};
var upload_position=0;
var upload_object=[];
var upload_object_preview=[];

function startUpload(){
    if(upload_object.length>0 && (upload_object.length == upload_object_preview.length)){
        if(data_[upload_position]['size']!==''){
            if($('#upload'+upload_position).length>0){
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

function create_upload(i,server){
    var final_name = userId + datetime();
    var pack = $('#setPack').val();
    upload_object[i]=$("#mp34"+i).uploadFile({
        url: base_url + "admin/subir/",
        fileName:"files",
        multiple:false,
        autoSubmit:false,
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
        onError: function(files,status,errMsg,pd){
            alert('ERROR: CONNECTION LOST');
        },
        onSelect:function(files){
            data_[i]['size'] = size=parseInt(((parseInt(files[0].size)/1000)/1024));
            return true;
        },
        onSuccess:function(files,resp,xhr){
            if(resp=='true'){
                state[i]=state[i]+1;
                data_[i]['descargable']=final_name +'.'+(files[0].toString().split('.').pop());
                data_[i]['demo']=data_[i]['demo'];

                ready(i);
                if(upload_position<data_.length){
                    startUpload();
                }
            }else{
                upload_object[i].startUpload();
            }
        }
    });

    upload_object_preview[i]=$("#preview"+i).uploadFile({
        url: base_url + "admin/subir/",
        fileName:"files",
        multiple:false,
        autoSubmit:true,
        uploadButtonClass:"submit",
        allowedTypes:"mp3,mp4,rar,zip",
        dragDropStr: "<span><b>Arrastra y Suelta archivos</b></span>",
        formData:{
            'action':'file_upload',
            'file':final_name,
            'preview':'false',
            'demo':1
        },
        onError: function(files,status,errMsg,pd){
            alert('ERROR: CONNECTION LOST');
        },
        dragdropWidth: 300,statusBarWidth: 300,
        onSuccess:function(files,resp,xhr){
            if(resp=='true'){
                state[i]=state[i]+1;
                data_[i]['demo']=final_name + '.' + (files.toString().split('.').pop());
            }else{
                alert('ERROR: '+resp);
            }
        }
    });

    if(String(data_[i]['type']) === '5'){
        $("#cover"+i).uploadFile({
            url: base_url + "admin/subir/",
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
                if(resp && resp !== 'false'){
                    $('#hide_cover'+i).val(resp);
                    data_[i]['cover'] = resp;
                }else{
                    alert('Cover upload failed');
                }
            }
        });
    }
}

function set_cover(obj,data_indice){
    if(obj.is(':checked')){
        data_[data_indice]['cover'] = '';
    }else{
        if($('#hide_cover'+data_indice).val() !== ''){
            data_[data_indice]['cover'] = $('#hide_cover'+data_indice).val();
        }
    }
}

var url_return = base_url + "admin/subir/";
var server_ip = [base_url + "admin/subir/"];
var server_btn = '';
for(var k=0; k<server_ip.length; k++){
    server_btn = server_btn+'<input type="radio" name="server" '+(k==0?'checked':'')+' id="server'+k+'" onClick="server_id='+k+';"><label for="server'+k+'">SERVER #'+k+'</label>';
}

var upload_preview = true;
var server_id=0;
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

var data_=[];
var data_indice=0;
var state=[];

function remove_video(i){
    $('#upload'+i).parent().remove();
    $('#upload'+i).remove();
    $('#title'+i).remove();
}

function queue(nGenres){
    type = $('#setPack').val();
    var isDrop = (String(type) === '5');

    if(isDrop){
        gender_id = 45;
        name_genre = 'Drops';
    } else {
        genre_list(nGenres);
        if(genre==''){
            return alert('Choose at least one genre');
        }
        var _generos = $('#format input');
        _generos.each(function(){
            if($(this).is(':checked')){
                gender_id = $(this).val();
            }
        });
    }

    if(empty($('#video_name'))==false){
        return false;
    }

    video_name = $('#video_name').val();
    video_artist = isDrop ? 'Dale Más Bajo' : $('#video_artist').val();

    if(empty($('#precio'))==false){
        return false;
    }

    price = $('#precio').val();
    description = $('#description').val();
    bpm = $('#bpm').val();
    if(empty($('#version'))==false){
        return false;
    }
    version = $('#version').val();

    data_[data_indice] = [];
    data_[data_indice]['video_name'] = video_name;
    data_[data_indice]['video_artist'] = video_artist;
    data_[data_indice]['price'] = price;
    data_[data_indice]['name_genre'] = name_genre;
    data_[data_indice]['description'] = description;
    data_[data_indice]['bpm'] = bpm;
    data_[data_indice]['demo'] = demo;
    data_[data_indice]['version'] = version;
    data_[data_indice]['descargable'] = descargable;
    data_[data_indice]['type'] = type;
    data_[data_indice]['gender_id'] = gender_id;
    data_[data_indice]['payment_link'] = $('#payment_link').val();
    data_[data_indice]['cover'] = '';

    var html = '<div class="item"><h6 class="card-body-title tx-12 mg-b-5" id="title'+data_indice+'" onclick="$(\'#upload'+data_indice+'\').slideToggle(400);" style="cursor:pointer">'+data_[data_indice]['video_name']+'</h6>\
    <article class="toggle" id="upload'+data_indice+'">\
    <table>\
      <tr><td>Price:</td><td>'+data_[data_indice]['price']+'</td></tr>\
      <tr><td>Artist:</td><td>'+data_[data_indice]['video_artist']+'</td></tr>\
      <tr><td>Description:</td><td>'+(data_[data_indice]['description'] || '-')+'</td></tr>\
      <tr><td>Payment Link:</td><td>'+(data_[data_indice]['payment_link'] || '-')+'</td></tr>\
      <tr><td>File</td><td><div id="mp34'+data_indice+'"></div></td></tr>';

    if(isDrop){
        html += '<tr><td>Cover</td><td><div id="cover'+data_indice+'"></div><input type="hidden" id="hide_cover'+data_indice+'" value=""></td></tr>';
        html += '<tr><td>Preview</td><td><div id="preview'+data_indice+'"></div></td></tr>';
    } else {
        if(data_[data_indice]['type']!=3){
            html += '<tr><td>Preview File (only on mp3)</td><td><div id="preview'+data_indice+'"></div></td></tr>';
        }
    }

    html += '</table>\
    <input type="button" class="btn btn-danger" style="width:120px !important;" value="DELETE" onclick="remove_video('+data_indice+')" />\
    </article></div>';

    $('.content_upload').append(html);
    create_upload(data_indice,server_id);
    state[data_indice]=0;
    data_indice++;
}

function empty(e){
    if(e.val()!==''){
        return e.val();
    }else{
        e.focus();
        return false;
    }
}

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

function datetime(){
    var currentdate = new Date();
    return currentdate.getDate() +''+ (currentdate.getMonth()+1) +''+ currentdate.getFullYear() +''+ currentdate.getHours() +''+ currentdate.getMinutes() +''+ currentdate.getSeconds();
}

function set_type(val,btn){
    video_type=val;
    $('#type_').html(val);
    $('.video_type').stop().animate({opacity:0.2},200,'',function(){ btn.stop().animate({opacity:1},400); });
}

$(document).ready(function(e){
    $('#servers').html(server_btn);

    $(".genre_chbox").on('click', function() {
        var $box = $(this);
        $box.change(function(){
            $box=$(this).attr('id');
            if ($('#'+$box).prop("checked")) {
                var group = ".genre_chbox";
                $(group).prop("checked", false);
                $(this).prop("checked", true);
            } else {
                $(this).prop("checked", false);
                $(this).attr('checked', false);
            }
        });
    });
});
