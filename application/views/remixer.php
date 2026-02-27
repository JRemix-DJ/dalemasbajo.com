<div id="ajaxArea" class="bg-slate-50 min-h-screen">
    <section class="pt-10 bg-slate-50">
        <div class="container mx-auto px-4">
            <div class="relative w-full overflow-hidden rounded-[28px] bg-[#0066FF] shadow-xl border border-white/10">
                <!-- contenido centrado -->
                <div class="relative z-10 flex min-h-[240px] sm:min-h-[260px] md:min-h-[300px] items-center justify-center text-center p-[15px] md:p-0">
                    <div class="w-full max-w-3xl">

                        <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight mb-2 drop-shadow-md">
                            <? echo $user->username; ?>
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
                <div class="pagination-modern" id="pagination-container">
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
    @media (max-width: 880px) {
        .remix-table-wrap { overflow-x: visible !important; }

        table.remix-table,
        table.remix-table thead,
        table.remix-table tbody,
        table.remix-table th,
        table.remix-table td,
        table.remix-table tr {
            display: block;
            width: 100%;
        }

        table.remix-table thead { display: none; }

        table.remix-table tbody {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 10px;
        }

        table.remix-table tr {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0 !important;
            border-radius: 16px;
            overflow: hidden;
        }

        table.remix-table td {
            padding: 10px 12px !important;
            border: 0 !important;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        table.remix-table td + td {
            border-top: 1px solid #f1f5f9 !important;
        }

        table.remix-table td::before {
            content: attr(data-label);
            font-size: 11px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
            flex: 0 0 auto;
            margin-right: 10px;
        }

        table.remix-table td > * {
            margin-left: auto;
            text-align: right;
        }

        table.remix-table td[data-label="Song Title"] > * {
            text-align: right;
            font-weight: 800;
            color: #0f172a;
        }

        table.remix-table td[data-label="Play"] a.play_btn,
        table.remix-table td[data-label="Download"] button.btn-smart-download {
            margin-left: auto;
        }

        table.remix-table td[data-label="Play"] a.play_btn,
        table.remix-table td[data-label="Download"] button.btn-smart-download {
            width: 40px !important;
            height: 40px !important;
        }
        table.remix-table td[data-label="Artist"] {
            max-width: none !important;
        }
    }
</style>

<script>
    window.addEventListener('load', function() {
        $(document).ready(function() {
            $(document).on('click', '#pagination-container a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                if(!url || url === '#' || url === '') return;

                $('#table-body-content').addClass('opacity-50');

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if(response.status === 'success') {
                            $('#table-body-content').html(response.html_table);
                            $('#pagination-container').html(response.html_pagination);
                            window.history.pushState({path: url}, '', url);
                            $('html, body').animate({ scrollTop: $("#table-body-content").offset().top - 150 }, 500);
                        }
                    },
                    complete: function() {
                        $('#table-body-content').removeClass('opacity-50');
                    }
                });
            });
        });
    });
</script>