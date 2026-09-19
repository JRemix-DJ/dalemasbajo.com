(function(){
    function el(id){ return document.getElementById(id); }
    function toggle(show, node){ if(node) node.style.display = show ? '' : 'none'; }

    function refreshTrending(){
        var pt = el('product_type_id');
        var row = el('row-trending-slot-edit');
        var sel = el('trending_slot_edit');
        if(!pt || !row) return;

        var isAudioNormal = String(pt.value) === '1';
        toggle(isAudioNormal, row);
        if(!isAudioNormal && sel) sel.value = '';
    }

    document.addEventListener('DOMContentLoaded', function(){
        refreshTrending();
        var pt = el('product_type_id');
        if(pt) pt.addEventListener('change', refreshTrending);
    });
})();
