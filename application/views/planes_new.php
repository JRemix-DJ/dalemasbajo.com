<div id="ajaxArea" class="bg-slate-50 min-h-screen">

    <section class="album-header relative h-[250px] w-full overflow-hidden flex items-center justify-center text-center bg-gradient-to-r from-slate-900 to-[#0066FF]">
        <figure class="album-cover-wrap absolute inset-0 z-0 opacity-20 mix-blend-multiply bg-[url('<? echo base_url(); ?>images/default_cover.jpg')] bg-cover bg-center"></figure>

        <div class="container relative z-10 flex flex-col items-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight mb-4 font-heading drop-shadow-md">
                PLANES DE SUSCRIPCIÓN
            </h1>

            <div class="inline-flex items-center gap-2 bg-green-500/10 border border-green-500/30 backdrop-blur-sm px-4 py-2 rounded-full text-green-300 text-sm font-medium">
                <i class="fa fa-shield-alt"></i>
                <span>Sistema de pagos seguro y mejorado.</span>
            </div>
        </div>
    </section>

    <section id="cuerpo" class="py-16 md:py-24">
        <div class="container mx-auto px-4">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto items-start">

                <? if(isset($plans) && !empty($plans)){
                    foreach($plans as $plan){

                        $es_premium_nombre = (stripos($plan->name, 'Premium') !== false);
                        $es_ilimitado = ($plan->ilimitado_activo == 1);
                        $is_highlighted = ($es_ilimitado || $es_premium_nombre);

                        if ($is_highlighted) {
                            $container_classes = 'relative w-full rounded-2xl p-[2px] bg-gradient-to-b from-[#0066FF] to-slate-900 shadow-xl z-10';
                            $inner_classes = 'bg-white rounded-[14px] h-full p-6 md:p-8 flex flex-col';
                        } else {
                            $container_classes = 'relative w-full rounded-2xl border border-slate-200 bg-white hover:border-slate-300 shadow-sm transition-all duration-300';
                            $inner_classes = 'h-full p-6 md:p-8 flex flex-col';
                        }

                        // BOTÓN
                        if ($is_highlighted) {
                            $btn_class = 'bg-gradient-to-r from-[#0066FF] to-slate-900 text-white shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:from-blue-600 hover:to-black';
                        } else {
                            $btn_class = 'bg-slate-900 text-white hover:bg-slate-800';
                        }
                        ?>

                        <div class="<? echo $container_classes; ?>">

                            <? if($is_highlighted){ ?>
                                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-[#0066FF] to-slate-900 text-white text-xs font-bold px-4 py-1.5 rounded-full shadow-md uppercase tracking-wide flex items-center gap-2 whitespace-nowrap">
                                    <i class="fa fa-star text-white"></i> Most Popular
                                </div>
                            <? } ?>

                            <div class="<? echo $inner_classes; ?>">

                                <div class="mb-6">
                                    <h2 class="text-xl font-bold text-slate-900 uppercase tracking-wide mb-2"><?= $plan->name; ?></h2>
                                    <p class="text-slate-500 text-sm h-10 overflow-hidden text-ellipsis leading-relaxed">
                                        <? echo $plan->description; ?>
                                    </p>
                                </div>

                                <div class="flex items-baseline gap-1 mb-8">
                                    <span class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight">$<? echo $plan->price; ?></span>
                                    <span class="text-slate-400 font-medium">/ <? echo $plan->duration; ?> días</span>
                                </div>

                                <ul class="space-y-4 mb-8 flex-1">
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                            <i class="fa fa-check text-primary text-xs"></i>
                                        </div>
                                        <span class="ml-3 text-slate-700 font-medium">
                                <? if ($plan->ilimitado_activo == 1) { ?>
                                    <span class="text-primary font-bold">Descargas Ilimitadas</span> de Audio
                                <? } else { ?>
                                    <span class="font-bold"><? if($plan->tokens!=0 && $plan->tokens!=NULL){ echo $plan->tokens; }else{ echo '0'; } ?></span> Descargas de Audio
                                <? } ?>
                            </span>
                                    </li>

                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                            <i class="fa fa-check text-primary text-xs"></i>
                                        </div>
                                        <span class="ml-3 text-slate-600 text-sm">Renovación Automática</span>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                            <i class="fa fa-check text-primary text-xs"></i>
                                        </div>
                                        <span class="ml-3 text-slate-600 text-sm">Nueva música diariamente</span>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                            <i class="fa fa-check text-primary text-xs"></i>
                                        </div>
                                        <span class="ml-3 text-slate-600 text-sm">Descargas directas (1 Click)</span>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                            <i class="fa fa-check text-primary text-xs"></i>
                                        </div>
                                        <span class="ml-3 text-slate-600 text-sm">Alta Calidad (HQ Audio)</span>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                            <i class="fa fa-check text-primary text-xs"></i>
                                        </div>
                                        <span class="ml-3 text-slate-600 text-sm">Búsqueda Avanzada</span>
                                    </li>
                                </ul>

                                <a href="<? echo base_url(); ?>getplan/?plan_id=<? echo $plan->id; ?>&currency=USD"
                                   class="w-full block text-center py-4 rounded-xl font-bold transition-all duration-200 transform hover:-translate-y-1 <? echo $btn_class; ?>">
                                    Obtener Plan
                                </a>

                                <p class="text-center text-xs text-slate-400 mt-4">Pago seguro garantizado</p>

                            </div> </div> <? } } else { ?>
                    <div class="col-span-full text-center py-10">
                        <p class="text-xl text-slate-500">No hay planes disponibles en este momento.</p>
                    </div>
                <? } ?>
            </div>

            <div class="mt-20 mb-10 text-center">
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">All Plans Include</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16 max-w-7xl mx-auto">

                <div class="flex flex-col items-center text-center p-6 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-gradient-to-r from-[#0066FF] to-slate-900 text-white rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-blue-500/30">
                        <i class="fa fa-mouse-pointer text-xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-2">1-Click Download</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Instantly download your favorite remixes in high quality
                    </p>
                </div>

                <div class="flex flex-col items-center text-center p-6 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-gradient-to-r from-[#0066FF] to-slate-900 text-white rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-blue-500/30">
                        <i class="fa fa-sliders-h text-xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-2">HQ Audio</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Crystal clear 320kbps audio quality for professional use
                    </p>
                </div>

                <div class="flex flex-col items-center text-center p-6 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-gradient-to-r from-[#0066FF] to-slate-900 text-white rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-blue-500/30">
                        <i class="fa fa-bolt text-xl"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-2">Instant Access</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Get immediate access to our entire library of remixes
                    </p>
                </div>
            </div>

            <div class="mt-16 text-center max-w-2xl mx-auto">
                <p class="text-slate-500 text-sm mb-4">
                    Need a custom plan?
                </p>
                <p class="text-slate-500 text-sm">
                    <a href="<? echo base_url('request_remix'); ?>" class="text-primary hover:underline font-bold flex items-center justify-center gap-1">
                        Contact us for enterprise solutions <i class="fa fa-arrow-right text-xs"></i>
                    </a>
                </p>
            </div>

        </div>
    </section>
</div>