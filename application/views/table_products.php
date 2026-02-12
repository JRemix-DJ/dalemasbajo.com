<?php
if(isset($products) && !empty($products)) {
    foreach($products as $audio) {
        $title = isset($audio->name) ? $audio->name : (isset($audio->title) ? $audio->title : 'Unknown');
        $preview = isset($audio->demo) ? $audio->demo : (isset($audio->preview) ? $audio->preview : '');
        $artist = isset($audio->artist) ? $audio->artist : 'Unknown Artist';
        $date = isset($audio->created_on) ? $audio->created_on : (isset($audio->created_at) ? $audio->created_at : '');
        $version = (isset($audio->version) && $audio->version != '') ? $audio->version : 'Intro';
        $bpm = isset($audio->bpm) ? $audio->bpm : '--';

        $remixer_id = isset($audio->owner_id) ? $audio->owner_id : 0;
        $remixer_name = 'DJ Member';

        if(isset($djs) && !empty($djs)) {
            foreach($djs as $dj_obj) {
                if($dj_obj->id == $remixer_id) {
                    $remixer_name = $dj_obj->username;
                    break;
                }
            }
        }

        $genre_name = 'General';
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
        <tr class="hover:bg-blue-50/50 transition-colors group border-b border-slate-50 last:border-0">

            <td class="p-4 text-slate-400 whitespace-nowrap text-xs">
                <? echo ($date != '') ? date('d M', strtotime($date)) : '-'; ?>
            </td>

            <td class="p-4 text-center">
                <a href="javascript:;" class="play_btn inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-600 group-hover:bg-primary group-hover:text-white transition-all shadow-sm"
                   data-id="<? echo $audio->id; ?>"
                   data-preview="<? echo base_url().'uploads/previews/'.$preview; ?>"
                   data-title="<? echo $title; ?>"
                   data-artist="<? echo $artist; ?>">
                    <i class="fa fa-play text-xs ml-0.5"></i>
                </a>
            </td>

            <td class="p-4 font-bold text-slate-900 text-sm">
                <? echo $title; ?>
                <? if(isset($audio->is_new) && $audio->is_new == 1) { ?>
                    <span class="ml-2 px-1.5 py-0.5 bg-green-100 text-green-700 text-[10px] font-bold uppercase rounded tracking-wide">NEW</span>
                <? } ?>
            </td>

            <td class="p-4 text-slate-500 text-sm">
                <span class="bg-slate-50 text-slate-600 px-2 py-1 rounded border border-slate-100 text-xs">
                    <? echo $version; ?>
                </span>
            </td>

            <td class="p-4 text-slate-600 text-sm font-medium">
                <? echo $artist; ?>
            </td>

            <td class="p-4">
                <a href="<? echo base_url('remixers/'.$remixer_id); ?>" class="flex items-center gap-2 text-primary hover:text-blue-700 transition-colors font-semibold text-sm">
                    <i class="fa-solid fa-user-music text-xs opacity-50"></i>
                    <? echo $remixer_name; ?>
                </a>
            </td>

            <td class="p-4 text-slate-400 font-mono text-xs">
                <? echo $bpm; ?>
            </td>

            <td class="p-4">
                <a href="<? echo base_url('genero/'.$genre_id); ?>" class="text-slate-500 hover:text-primary transition-colors text-xs font-medium">
                    <? echo $genre_name; ?>
                </a>
            </td>

            <td class="p-4 text-center">
                <? if($this->session->userdata('logged_in')) { ?>
                    <a href="<? echo base_url('audios/download/'.$audio->id); ?>" class="inline-flex items-center justify-center w-8 h-8 rounded border border-slate-200 text-slate-500 hover:border-primary hover:text-primary hover:bg-blue-50 transition-all" title="Descargar">
                        <i class="fa fa-download"></i>
                    </a>
                <? } else { ?>
                    <button class="trigger-register inline-flex items-center justify-center w-8 h-8 rounded border border-slate-200 text-slate-400 hover:bg-slate-50 transition-colors">
                        <i class="fa-lock"></i>
                    </button>
                <? } ?>
            </td>
        </tr>
    <? }
} else { ?>
    <tr>
        <td colspan="9" class="p-12 text-center text-slate-400">
            <div class="flex flex-col items-center justify-center">
                <i class="fa-solid fa-music text-3xl mb-2 opacity-30"></i>
                <p>No remixes found.</p>
            </div>
        </td>
    </tr>
<? } ?>