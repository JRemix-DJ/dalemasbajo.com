$(function(){
    'use strict';
    $('#tipo').on('change', function(){
        if($(this).val() == 2){
            $('#pagominimo').css({'display':'block'});
        }else{
            $('#pagominimo').css({'display':'none'});
        }
    });
});
