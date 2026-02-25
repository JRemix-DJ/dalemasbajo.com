<div id="ajaxArea" class="bg-slate-50">
    <div class="pageArea py-10 md:py-14">
        <div class="container mx-auto px-4">
            <article class="max-w-5xl mx-auto">

                <!-- Header -->
                <div class="text-center mb-10">
                    <h2 class="text-4xl md:text-5xl font-semibold tracking-tight text-slate-900 font-heading">
                        FAQ
                    </h2>

                    <div class="mt-4 flex items-center justify-center gap-3">
                        <a class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-primary hover:border-primary hover:bg-blue-50 transition"
                           href="http://www.facebook.com/sharer/sharer.php?u=<? echo base_url(); ?>faq" target="_blank" rel="noopener">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>

                        <a class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-primary hover:border-primary hover:bg-blue-50 transition"
                           href="http://twitter.com/intent/tweet?status=<? echo base_url(); ?>faq" target="_blank" rel="noopener">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    </div>

                    <p class="mt-4 text-slate-500 max-w-2xl mx-auto">
                        Haz click en una pregunta para ver la respuesta.
                    </p>
                </div>

                <!-- Card -->
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">

                        <!-- Image -->
                        <div class="relative min-h-[240px] lg:min-h-full">
                            <img
                                    src="<? echo base_url(); ?>images/dj-image.jpg"
                                    alt="FAQ"
                                    class="absolute inset-0 w-full h-full object-cover"
                            />
                            <div class="absolute inset-0 bg-slate-900/20"></div>
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
                                <strong>Nota:</strong> Haz click en el encabezado para expandir la respuesta.
                            </p>
                        </div>

                    </div>
                </div>

            </article>
        </div>
    </div>
</div>

<script>
    (function () {
        const root = document.getElementById('faq-accordion');
        if (!root) return;

        const btns = Array.from(root.querySelectorAll('.faq-btn'));
        const DURATION_MS = 260;

        function setIcon(btn, open) {
            const iconWrap = btn.querySelector('.faq-icon');
            if (!iconWrap) return;
            iconWrap.style.transform = open ? 'rotate(180deg)' : 'rotate(0deg)';
        }

        function closePanel(btn, panel) {
            btn.setAttribute('aria-expanded', 'false');
            setIcon(btn, false);

            // Asegura que partimos de una altura "real" para animar hacia 0
            panel.hidden = false;
            panel.style.maxHeight = panel.scrollHeight + 'px';

            requestAnimationFrame(() => {
                panel.style.maxHeight = '0px';

                const onEnd = (e) => {
                    if (e.propertyName !== 'max-height') return;
                    panel.hidden = true;
                    panel.removeEventListener('transitionend', onEnd);
                };

                panel.addEventListener('transitionend', onEnd);

                // Fallback por si transitionend no dispara (casos raros)
                setTimeout(() => {
                    if (panel.style.maxHeight === '0px') panel.hidden = true;
                    panel.removeEventListener('transitionend', onEnd);
                }, DURATION_MS + 60);
            });
        }

        function openPanel(btn, panel) {
            btn.setAttribute('aria-expanded', 'true');
            setIcon(btn, true);

            panel.hidden = false;
            panel.style.maxHeight = '0px';

            requestAnimationFrame(() => {
                panel.style.maxHeight = panel.scrollHeight + 'px';
            });
        }

        function closeAll(exceptId) {
            btns.forEach(b => {
                const panelId = b.dataset.target;
                if (panelId === exceptId) return;

                const p = document.getElementById(panelId);
                if (!p) return;

                if (b.getAttribute('aria-expanded') === 'true') {
                    closePanel(b, p);
                }
            });
        }

        function toggle(btn) {
            const panelId = btn.dataset.target;
            const panel = document.getElementById(panelId);
            if (!panel) return;

            const expanded = btn.getAttribute('aria-expanded') === 'true';

            if (expanded) {
                closePanel(btn, panel);
            } else {
                closeAll(panelId);
                openPanel(btn, panel);
            }
        }

        btns.forEach(btn => {
            // estado inicial icono
            setIcon(btn, btn.getAttribute('aria-expanded') === 'true');

            btn.addEventListener('click', () => toggle(btn));
        });

        // Recalcular altura si cambia el layout (responsive, fonts, etc.)
        window.addEventListener('resize', () => {
            btns.forEach(btn => {
                if (btn.getAttribute('aria-expanded') !== 'true') return;
                const panel = document.getElementById(btn.dataset.target);
                if (!panel || panel.hidden) return;
                panel.style.maxHeight = panel.scrollHeight + 'px';
            });
        });
    })();
</script>