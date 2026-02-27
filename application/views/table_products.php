<?php
if(isset($products) && !empty($products)) {
    $downloaded_ids = isset($downloaded_ids) && is_array($downloaded_ids) ? $downloaded_ids : [];
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

            <td class="p-4 text-slate-400 whitespace-nowrap text-xs" data-label="Date">
                <? echo ($date != '') ? date('d M', strtotime($date)) : '-'; ?>
            </td>

            <td class="p-4 text-center" data-label="Play">
                <? $img_cover = base_url('audios/cover_mp3/' . $audio->id); ?>

                <a href="javascript:;"
                   class="play_btn inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white hover:bg-blue-700 transition-colors duration-150"
                   data-id="<? echo $audio->id; ?>"
                   data-demo="<? echo base_url().'assets/products/demos/'.$preview; ?>"
                   data-cover="<? echo $img_cover; ?>"
                   data-title="<? echo $title; ?>"
                   data-artist="<? echo $artist; ?>">
                    <i class="fa-solid fa-play text-white text-xs ml-0.5"></i>
                </a>
            </td>

            <td class="p-4 font-bold text-slate-900 text-sm" data-label="Song Title">
                <? echo $title; ?>
                <? if(isset($audio->is_new) && $audio->is_new == 1) { ?>
                    <span class="ml-2 px-1.5 py-0.5 bg-green-100 text-green-700 text-[10px] font-bold uppercase rounded tracking-wide">NEW</span>
                <? } ?>
            </td>

            <td class="p-4 text-slate-600 text-sm font-medium max-w-[250px]" data-label="Artist">
                <? echo $artist; ?>
            </td>

            <td class="p-4 text-center align-middle" data-label="Version">
                <span class="inline-flex items-center justify-center text-center max-w-full px-3 py-1.5 rounded-lg bg-slate-50 text-slate-700 border border-slate-200 text-xs font-semibold whitespace-normal break-words leading-snug">
                    <? echo $version; ?>
                </span>
            </td>

            <td class="p-4" data-label="Remixer">
                <a href="<? echo base_url('remixers/'.$remixer_id); ?>" class="flex items-center gap-2 hover:text-blue-700 transition-colors font-semibold text-sm">
                    <i class="fa-solid fa-user-music text-xs opacity-50"></i>
                    <? echo $remixer_name; ?>
                </a>
            </td>

            <td class="p-4 text-slate-400 font-semibold text-s" data-label="BPM">
                <? echo $bpm; ?>
            </td>

            <td class="p-4 text-center" data-label="Genre">
                <a href="<? echo base_url('genero/'.$genre_id); ?>"
                   style="background-color: #0066ff1a"
                   class="inline-flex items-center text-center px-3 py-1 rounded-full text-[rgb(0,102,255)] text-xs font-semibold hover:bg-slate-200 hover:text-blue-700 transition-colors">
                    <? echo $genre_name; ?>
                </a>
            </td>

            <td class="p-4 text-center" data-label="Download">
                <?
                $is_logged = $this->session->userdata('is_logued_in') ? 1 : 0;

                $is_unlimited = $this->session->userdata('is_user_unlimited');
                $tokens = $this->session->userdata('tokens');
                $has_access = ($is_unlimited || $tokens > 0) ? 1 : 0;
                ?>

                <?php
                $is_downloaded = in_array((int)$audio->id, $downloaded_ids, true);

                $btn_base = "btn-smart-download inline-flex items-center justify-center w-8 h-8 rounded-full transition-all focus:outline-none";

                $btn_not_downloaded = "text-slate-500 hover:border-primary hover:text-primary hover:bg-blue-50";

                $btn_downloaded = "bg-[rgb(0,102,255)] text-white shadow-lg shadow-blue-500/30 hover:bg-blue-700";
                ?>

                <button
                        class="<?php echo $btn_base.' '.($is_downloaded ? $btn_downloaded : $btn_not_downloaded); ?>"
                        data-logged="<? echo $is_logged; ?>"
                        data-access="<? echo $has_access; ?>"
                        data-id="<? echo $audio->id; ?>"
                        title="<?php echo $is_downloaded ? 'Downloaded' : 'Download'; ?>"
                >
                    <i class="fa-solid fa-download text-xl"></i>
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