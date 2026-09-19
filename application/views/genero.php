<div id="ajaxArea" class="bg-slate-50 min-h-screen">
    <section class="pt-10 bg-slate-50">
        <div class="container mx-auto px-4">
            <div class="relative w-full overflow-hidden rounded-[28px] bg-[#0066FF] shadow-xl border border-white/10">
                <!-- contenido centrado -->
                <div class="relative z-10 flex min-h-[240px] sm:min-h-[260px] md:min-h-[300px] items-center justify-center text-center p-[15px] md:p-0">
                    <div class="w-full max-w-3xl">

                        <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight mb-2 drop-shadow-md">
                            <? echo $genero->name; ?>
                        </h1>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12" <? if($this->session->userdata('content_type') == 'videos'){ ?>id="cuerpo"<? } ?>>

        <div class="container mx-auto px-4">

            <? $this->load->view('search_box'); ?>

            <? if($this->session->userdata('content_type') == 'videos'){ ?>

                <? $this->load->view('table_videos'); ?>

            <? } else { ?>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden relative mt-8">
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
                            <?php $this->load->view('table_products'); ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <? } ?>

            <div class="mt-8 flex justify-center">
                <div class="pagination-modern">
                    <?php if (isset($links)) { ?>
                        <?php echo $links ?>
                    <?php } ?>
                </div>
            </div>
        </div>

    </section>
</div>
