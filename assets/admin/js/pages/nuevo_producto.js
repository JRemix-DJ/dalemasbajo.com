(function(){
    function el(id){ return document.getElementById(id); }
    function toggle(show, node){ if(node) node.style.display = show ? '' : 'none'; }

    function refreshUI(){
        var setPack = el('setPack');
        if(!setPack) return;

        var type = String(setPack.value);
        var isDrop = type === '5';
        var isAudioNormal = type === '1';

        toggle(isDrop, el('row-description'));
        toggle(isDrop, el('row-payment-link'));

        toggle(!isDrop, el('genres-title'));
        toggle(!isDrop, el('format-wrap'));

        toggle(isAudioNormal, el('row-trending-slot'));
        if(!isAudioNormal){
            var ts = el('trending_slot');
            if(ts) ts.value = '';
        }

        var bpm = el('bpm');
        var artist = el('video_artist');
        var version = el('version');

        if(isDrop){
            if(bpm){
                bpm.value = '0';
                bpm.readOnly = true;
            }
        }else{
            if(artist) artist.readOnly = false;
            if(bpm) bpm.readOnly = false;
            if(version) version.readOnly = false;
        }
    }

    document.addEventListener('DOMContentLoaded', function(){
        refreshUI();
        var setPack = el('setPack');
        if(setPack) setPack.addEventListener('change', refreshUI);
    });
})();
