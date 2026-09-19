<div id="ajaxArea" class="bg-slate-50">
    <div class="pageArea py-10 md:py-14">
        <div class="container mx-auto px-4">
            <article class="max-w-5xl mx-auto">

                <!-- Header -->
                <div class="text-center mb-10">
                    <h2 class="text-4xl md:text-5xl font-semibold tracking-tight text-slate-900 font-heading">
                        FAQ
                    </h2>

                    <p class="mt-4 text-slate-500 max-w-2xl mx-auto">
                        Click a question to view the answer.
                    </p>
                </div>

                <!-- Card -->
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden" style="margin-bottom: 60px">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">

                        <!-- Video -->
                        <div class="relative min-h-[240px] lg:min-h-full overflow-hidden">
                            <video
                                    class="absolute inset-0 w-full h-full object-cover"
                                    autoplay
                                    muted
                                    loop
                                    playsinline
                                    preload="metadata"
                            >
                                <source src="<? echo base_url('assets/bg.mp4'); ?>" type="video/mp4">
                            </video>
                            <div class="absolute inset-0 bg-slate-900/30"></div>
                        </div>

                        <!-- Accordion -->
                        <div class="p-6 md:p-10">
                            <div class="space-y-3" id="faq-accordion">
                                <?php
                                $i = 0;
                                foreach($faqs as $faq){
                                    $i++;
                                    $panelId = "faq-panel-$i";
                                    $btnId   = "faq-btn-$i";
                                    $openFirst = false;
                                    ?>
                                    <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
                                        <button
                                                type="button"
                                                class="faq-btn w-full text-left px-5 py-4 flex items-center justify-between gap-4 hover:bg-slate-50 transition"
                                                aria-expanded="<? echo $openFirst ? 'true' : 'false'; ?>"
                                                aria-controls="<? echo $panelId; ?>"
                                                id="<? echo $btnId; ?>"
                                                data-target="<? echo $panelId; ?>"
                                        >
                      <span class="font-semibold text-slate-900">
                        <? echo $faq->title; ?>
                      </span>

                                            <span class="flex items-center justify-center w-9 h-9 rounded-full bg-slate-100 text-slate-600 transition faq-icon">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                      </span>
                                        </button>

                                        <div
                                                id="<? echo $panelId; ?>"
                                                role="region"
                                                aria-labelledby="<? echo $btnId; ?>"
                                                class="faq-panel overflow-hidden"
                                                style="max-height: <? echo $openFirst ? '999px' : '0px'; ?>; transition: max-height 260ms ease;"
                                                <?php if(!$openFirst){ ?> hidden <?php } ?>
                                        >
                                            <div class="px-5 pb-5 text-slate-600 leading-relaxed max-h-[360px] overflow-y-auto pr-2">
                                                <? echo $faq->content; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <p class="mt-6 text-xs text-slate-400">
                                <strong>Note:</strong> Click the header to expand the answer.
                            </p>
                        </div>

                    </div>
                </div>

            </article>
        </div>
    </div>
</div>
