<?php
if(isset($products) && !empty($products)) {
    foreach($products as $audio) {
        // Variables seguras
        $title = isset($audio->name) ? $audio->name : (isset($audio->title) ? $audio->title : 'Unknown');
        $preview = isset($audio->demo) ? $audio->demo : (isset($audio->preview) ? $audio->preview : '');
        $artist = isset($audio->artist) ? $audio->artist : 'Unknown Artist';
        $date = isset($audio->created_on) ? $audio->created_on : (isset($audio->created_at) ? $audio->created_at : '');

        // Lógica de Imagen
        $img = base_url().'images/default_cover.jpg';
        if(isset($audio->featured_image) && $audio->featured_image != '') {
            $img = base_url().'uploads/covers/'.$audio->featured_image;
        } elseif(isset($audio->cover) && $audio->cover != '') {
            $img = base_url().'uploads/covers/'.$audio->cover;
        }

        $genre_name = 'General'; // Valor por defecto
        $genre_id = isset($audio->gender_id) ? $audio->gender_id : 0;

        if(isset($generos) && !empty($generos)){
            foreach($generos as $g){
                if($g->id == $genre_id){
                    $genre_name = $g->name;
                    break;
                }
            }
        }
        ?>
        <tr class="hover:bg-blue-50/50 transition-colors group animate-fade-in">

            <td class="p-4 text-slate-400 whitespace-nowrap">
                <? echo ($date != '') ? date('d M', strtotime($date)) : '-'; ?>
            </td>

            <td class="p-4 text-center">
                <a href="javascript:;" class="play_btn inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-600 group-hover:bg-primary group-hover:text-white transition-all"
                   data-id="<? echo $audio->id; ?>"
                   data-preview="<? echo base_url().'uploads/previews/'.$preview; ?>"
                   data-title="<? echo $title; ?>"
                   data-artist="<? echo $artist; ?>">
                    <i class="fa fa-play text-xs ml-0.5"></i>
                </a>
            </td>

            <td class="p-4 font-medium text-slate-900">
                <? echo $title; ?>
                <? if(isset($audio->is_new) && $audio->is_new == 1) { ?>
                    <span class="ml-2 px-1.5 py-0.5 bg-green-100 text-green-600 text-[10px] font-bold uppercase rounded tracking-wide">NEW</span>
                <? } ?>
            </td>

            <td class="p-4 text-slate-500">
                <? echo (isset($audio->version) && $audio->version != '') ? $audio->version : 'Intro'; ?>
            </td>

            <td class="p-4 text-slate-600">
                <? echo $artist; ?>
            </td>

            <td class="p-4 text-slate-500 font-mono text-xs">
                <? echo isset($audio->bpm) ? $audio->bpm : '--'; ?>
            </td>

            <td class="p-4">
                <a href="<? echo base_url('genero/'.$genre_id); ?>" class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs hover:bg-primary hover:text-white transition-colors no-underline">
                    <? echo $genre_name; ?>
                </a>
            </td>

            <td class="p-4 text-center">
                <? if($this->session->userdata('logged_in')) { ?>
                    <a href="<? echo base_url('audios/download/'.$audio->id); ?>" class="inline-flex items-center justify-center w-8 h-8 rounded border border-slate-200 text-slate-500 hover:border-primary hover:text-primary transition-colors" title="Descargar">
                        <i class="fa fa-download"></i>
                    </a>
                <? } else { ?>
                    <button class="trigger-register inline-flex items-center justify-center w-8 h-8 rounded border border-slate-200 text-slate-400 hover:bg-slate-50 transition-colors">
                        <i class="fa fa-lock"></i>
                    </button>
                <? } ?>
            </td>
        </tr>
    <? }
} else { ?>
    <tr>
        <td colspan="8" class="p-8 text-center text-slate-400">
            <div class="flex flex-col items-center justify-center">
                <i class="fa fa-music text-3xl mb-2 opacity-50"></i>
                <p>No remixes found.</p>
            </div>
        </td>
    </tr>
<? } ?>