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
                <? $img_cover = base_url('audios/cover_mp3/' . $audio->id); ?>

                <a href="javascript:;"
                   class="play_btn inline-flex items-center justify-center w-8 h-8 rounded-full bg-transparent text-primary hover:bg-slate-200 hover:text-primary transition-colors duration-150"
                   data-id="<? echo $audio->id; ?>"
                   data-demo="<? echo base_url().'assets/products/demos/'.$preview; ?>"
                   data-cover="<? echo $img_cover; ?>"
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
                <a href="<? echo base_url('remixers/'.$remixer_id); ?>" class="flex items-center gap-2 hover:text-blue-700 transition-colors font-semibold text-sm">
                    <i class="fa-solid fa-user-music text-xs opacity-50"></i>
                    <? echo $remixer_name; ?>
                </a>
            </td>

            <td class="p-4 text-slate-400 font-mono text-xs">
                <? echo $bpm; ?>
            </td>

            <td class="p-4">
                <a href="<? echo base_url('genero/'.$genre_id); ?>"
                   class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100/70 border border-slate-200 text-[rgb(0,102,255)] text-xs font-semibold hover:bg-slate-200 hover:text-blue-700 transition-colors">
                    <? echo $genre_name; ?>
                </a>
            </td>

            <td class="p-4 text-center">
                <?
                $is_logged = $this->session->userdata('is_logued_in') ? 1 : 0;

                $is_unlimited = $this->session->userdata('is_user_unlimited');
                $tokens = $this->session->userdata('tokens');
                $has_access = ($is_unlimited || $tokens > 0) ? 1 : 0;
                ?>

                <button class="btn-smart-download inline-flex items-center justify-center w-8 h-8 rounded-full border-slate-200 text-slate-500 hover:border-primary hover:text-primary hover:bg-blue-50 transition-all focus:outline-none"
                        data-logged="<? echo $is_logged; ?>"
                        data-access="<? echo $has_access; ?>"
                        data-id="<? echo $audio->id; ?>"
                        title="Descargar">
                    <i class="fa-solid fa-download"></i>
                </button>
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