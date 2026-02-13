<div x-data="{ open: false }"
     @open-upsell-modal.window="open = true"
     class="relative z-[9999]"
     aria-labelledby="modal-title"
     role="dialog"
     aria-modal="true"
     style="display: none;"
     x-show="open">

    <div x-show="open"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm transition-opacity"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-100">

                <button @click="open = false" type="button" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none z-10">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>

                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">

                    <div class="flex justify-center -space-x-4 mb-6 pt-2">
                        <div class="w-16 h-16 rounded-full border-4 border-white shadow-lg bg-cover bg-center" style="background-image: url('<? echo base_url(); ?>images/default_cover.jpg');"></div>
                        <div class="w-20 h-20 rounded-full border-4 border-white shadow-xl bg-cover bg-center z-10 -mt-2" style="background-image: url('<? echo base_url(); ?>images/icons/favicon.ico'); background-size: contain; background-color: #0066FF;"></div>
                        <div class="w-16 h-16 rounded-full border-4 border-white shadow-lg bg-cover bg-center" style="background-image: url('<? echo base_url(); ?>images/default_cover.jpg');"></div>
                    </div>

                    <div class="text-center mt-2">
                        <h3 class="text-2xl font-heading font-black text-slate-900 mb-2 leading-tight" id="modal-title">
                            Lleva tus Sets al <br> <span class="text-primary">Siguiente Nivel</span>
                        </h3>
                        <p class="text-sm text-slate-500 mb-6 px-4">
                            Deja de usar rips de baja calidad. Obtén acceso instantáneo a música lista para clubes, versiones exclusivas y descargas ilimitadas.
                        </p>

                        <div class="text-left bg-slate-50 rounded-xl p-4 space-y-3 mb-6 border border-slate-100">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-check-circle text-primary text-lg"></i>
                                <span class="text-sm font-semibold text-slate-700">Descargas High-Speed Directas</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-bolt text-primary text-lg"></i>
                                <span class="text-sm font-semibold text-slate-700">Versiones Intro & Outro Exclusivas</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-gem text-primary text-lg"></i>
                                <span class="text-sm font-semibold text-slate-700">Calidad Premium (320kbps & WAV)</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-fire text-primary text-lg"></i>
                                <span class="text-sm font-semibold text-slate-700">Actualizaciones Diarias</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
                    <a href="<? echo base_url('planes'); ?>" class="inline-flex w-full justify-center rounded-xl bg-primary px-3 py-3 text-sm font-bold text-white shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all hover:scale-[1.02] sm:ml-3">
                        Get Started - Desbloquear Acceso
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>