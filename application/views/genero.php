<div id="ajaxArea" class="bg-slate-50 min-h-screen">

    <section class="album-header relative h-[250px] w-full overflow-hidden flex items-center justify-center text-center bg-gradient-to-r from-[#004a99] to-[#007bff]">

        <figure class="album-cover-wrap absolute inset-0 z-0 opacity-20 mix-blend-multiply">
        </figure>

        <div class="container relative z-10">
            <div class="cover-content">
                <div class="clearfix text-uppercase">
                    <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight mb-2 drop-shadow-md">
                        <? echo $genero->name; ?>
                    </h1>
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
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                                <th class="p-4 font-semibold w-24">Date</th>
                                <th class="p-4 font-semibold w-16 text-center">Play</th>
                                <th class="p-4 font-semibold">Song Title</th>
                                <th class="p-4 font-semibold">Version</th>
                                <th class="p-4 font-semibold">Artist</th>
                                <th class="p-4 font-semibold">Remixer</th>
                                <th class="p-4 font-semibold w-20">BPM</th>
                                <th class="p-4 font-semibold w-32">Genre</th>
                                <th class="p-4 font-semibold w-24 text-center">Download</th>
                            </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            <? $this->load->view('table_products'); ?>
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

<style>
    .pagination-modern ul.pagination {
        display: flex !important; flex-direction: row !important; gap: 8px; list-style: none; padding: 0; margin: 0; flex-wrap: wrap; justify-content: center;
    }
    .pagination-modern ul.pagination li { display: inline-block; margin: 0; }
    .pagination-modern ul.pagination li a,
    .pagination-modern ul.pagination li span {
        display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 8px;
        background: white; border: 1px solid #e2e8f0; color: #64748b; font-weight: 600; font-size: 14px; text-decoration: none; transition: all 0.2s; cursor: pointer;
    }
    .pagination-modern ul.pagination li a:hover { background: #f1f5f9; color: #007bff; border-color: #007bff; }
    .pagination-modern ul.pagination li.active span {
        background: #007bff !important; color: white !important; border-color: #007bff !important; pointer-events: none; box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3);
    }
</style>