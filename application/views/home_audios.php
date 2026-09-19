<div class="bg-slate-50 min-h-screen font-sans">
    <section class="py-10 md:py-14">
        <div class="container mx-auto px-4">
            <div id="heroBanner"
                 class="relative w-full overflow-hidden rounded-[28px] border border-slate-200 bg-slate-900 shadow-xl"
                 data-base="<?= base_url('assets/banners/'); ?>"
                 data-banners='<?= json_encode($banners ?? [], JSON_UNESCAPED_SLASHES); ?>'>

                <div class="absolute inset-0" data-video-layer></div>
                <div class="absolute inset-0 bg-slate-900/50 pointer-events-none"></div>
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(255,255,255,0.06),rgba(0,0,0,0.65))] pointer-events-none"></div>

                <div class="relative z-10 flex min-h-[420px] md:min-h-[520px] items-center justify-center px-6 py-12">
                    <div class="w-full max-w-3xl rounded-2xl px-6 py-10 md:px-12 md:py-12 text-center">
                        <h1 class="text-5xl sm:text-6xl md:text-9xl font-extrabold tracking-tight text-white drop-shadow-sm text-center">
                            Welcome
                        </h1>

                        <p class="mt-3 text-xs sm:text-sm md:text-lg text-white/80 font-medium text-center max-w-xs sm:max-w-md md:max-w-none mx-auto">
                            We’re launching Version 2.0 — Faster, clearer, more powerful
                        </p>

                        <a href="<?= base_url('planes'); ?>"
                           class="mt-8 inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-primary text-white font-bold transition-all duration-200 hover:scale-[1.03] hover:bg-blue-600 shadow-lg shadow-blue-500/30">
                            JOIN NOW <i class="fa fa-arrow-right text-sm"></i>
                        </a>
                    </div>
                </div>

                <div class="absolute bottom-4 left-0 right-0 z-20 flex items-center justify-center gap-2" data-dots></div>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 pb-20">
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                    <span class="bg-blue-100 p-2 rounded-full flex items-center justify-center w-8 h-8">
                        <i class="fa fa-arrow-trend-up text-primary text-sm"></i>
                    </span> Trending Now
                </h2>
                <a href="<?= base_url('/search/?sname=&sgenero=&sremixers='); ?>" class="text-sm text-primary font-medium hover:underline">See all</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <?php
                $loop_trending = isset($trending_audios) ? $trending_audios : (isset($products) ? array_slice($products, 0, 5) : []);

                if(!empty($loop_trending)) {
                    foreach($loop_trending as $audio) {
                        $img = base_url('audios/cover_mp3/' . $audio->id);
                        $title = isset($audio->name) ? $audio->name : (isset($audio->title) ? $audio->title : 'Unknown');
                        $artist = isset($audio->artist) ? $audio->artist : 'Unknown Artist';
                        $preview = isset($audio->demo) ? $audio->demo : (isset($audio->preview) ? $audio->preview : '');
                        ?>
                        <div class="bg-white rounded-2xl p-3 shadow-sm hover:shadow-xl transition-all border-2 border-slate-100 group">
                            <div class="relative aspect-square rounded-xl overflow-hidden mb-3 bg-gray-100">
                                <img src="<?= $img; ?>"
                                     alt="<?= $title; ?>"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     onerror="this.onerror=null;this.src='<?= base_url(); ?>images/default_cover.jpg';">

                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                                    <a href="javascript:;" class="play_btn w-12 h-12 bg-white rounded-full flex items-center justify-center text-primary hover:scale-110 transition-transform"
                                       data-id="<?= $audio->id; ?>"
                                       data-preview="<?= base_url('assets/uploads/demos/' . $preview); ?>"
                                       data-demo="<?= base_url('assets/uploads/demos/' . $preview); ?>"
                                       data-cover="<?= $img; ?>"
                                       data-title="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>"
                                       data-artist="<?= htmlspecialchars($artist, ENT_QUOTES, 'UTF-8'); ?>">
                                        <i class="fa fa-play pl-1"></i>
                                    </a>
                                </div>
                            </div>
                            <h3 class="font-bold text-slate-900 text-sm truncate"><?= $title; ?></h3>
                            <p class="text-xs text-slate-500 truncate"><?= $artist; ?></p>
                        </div>
                    <?php }
                } else { echo '<p class="col-span-full text-center text-gray-400">No trendings now</p>'; } ?>
            </div>
        </div>

        <div class="flex items-center justify-between mb-4 mt-8">
            <h2 class="text-2xl font-bold text-slate-900">Latest Remixes</h2>
            <div id="table-loader" class="hidden text-primary">
                <i class="fa fa-circle-o-notch fa-spin"></i> Cargando...
            </div>
        </div>

        <form action="<?= base_url('search/'); ?>" method="GET" class="mb-6">
            <div class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-grow group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fa fa-search text-slate-400 group-focus-within:text-primary transition-colors"></i>
                    </div>
                    <input type="text" name="sname" id="sname"
                           class="block w-full p-3 pl-10 text-sm text-slate-900 border border-slate-200 rounded-lg bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                           placeholder="Search for remix, artist or title..." autocomplete="off">
                </div>

                <div class="w-full md:w-48">
                    <div class="relative">
                        <select name="sgenero" id="sgenero" class="block w-full p-3 text-sm text-slate-700 border border-slate-200 rounded-lg bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none appearance-none cursor-pointer">
                            <option value="">Genre</option>
                            <?php if(isset($generos)){ foreach($generos as $g) { ?>
                                <option value="<?= $g->id; ?>"><?= $g->name; ?></option>
                            <?php }} ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="fa fa-angle-down text-slate-400"></i>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-48">
                    <div class="relative">
                        <select name="sremixers" id="sremixers" class="block w-full p-3 text-sm text-slate-700 border border-slate-200 rounded-lg bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none appearance-none cursor-pointer">
                            <option value="">Remixer</option>
                            <?php if(isset($djs)){ foreach($djs as $dj) { ?>
                                <option value="<?= $dj->id; ?>"><?= $dj->username; ?></option>
                            <?php }} ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="fa fa-angle-down text-slate-400"></i>
                        </div>
                    </div>
                </div>

                <button type="submit" class="p-3 px-6 text-white bg-primary hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm text-center transition-all shadow-md shadow-blue-500/20">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden relative">
            <div class="overflow-x-auto remix-table-wrap">
                <table class="w-full text-left border-collapse remix-table">
                    <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                        <th class="p-4 font-semibold w-24">Date</th>
                        <th class="p-4 font-semibold w-16 text-center">Play</th>
                        <th class="p-4 font-semibold">Song Title</th>
                        <th class="p-4 font-semibold">Artist</th>
                        <th class="p-4 font-semibold text-center">Version</th>
                        <th class="p-4 font-semibold">Remixer</th>
                        <th class="p-4 font-semibold w-20">BPM</th>
                        <th class="p-4 font-semibold text-center w-40">Genre</th>
                        <th class="p-4 font-semibold w-24 text-center">Download</th>
                    </tr>
                    </thead>

                    <tbody id="table-body-content" class="divide-y divide-slate-100 text-sm text-slate-700 transition-opacity duration-200">
                    <?php
                    $this->load->view('table_products', [
                        'products' => $products,
                        'user_products' => isset($user_products) ? $user_products : ($this->session->userdata('user_products') ?: [])
                    ]);
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex justify-center">
            <div class="pagination-modern" id="pagination-container">
                <?= $links; ?>
            </div>
        </div>
    </div>
</div>