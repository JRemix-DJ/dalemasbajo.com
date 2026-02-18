<section class="album-header relative w-full overflow-hidden flex items-center justify-center text-center bg-white py-16">
    <div class="container relative z-10 flex flex-col items-center px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-slate-900 tracking-tight mb-4 font-heading drop-shadow-sm uppercase">
            Choose Your Plan
        </h1>
        <p class="text-lg text-slate-500 font-medium max-w-2xl">
            Get immediate access to premium DJ remixes and exclusive content
        </p>
    </div>
</section>

<section id="cuerpo" class="pb-16 md:pb-24 bg-white">
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

                    // ESTILOS DEL BOTÓN
                    if ($is_highlighted) {
                        $btn_class = 'bg-gradient-to-r from-[#0066FF] to-slate-900 text-white shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:from-blue-600 hover:to-black';
                    } else {
                        $btn_class = 'bg-slate-900 text-white hover:bg-slate-800';
                    }

                    // LÓGICA DE ACCESO (NUEVO CÓDIGO AQUÍ)
                    // Si está logueado, va a pagar. Si no, abre modal.
                    if($this->session->userdata('is_logued_in')){
                        $btn_href = base_url()."getplan/?plan_id=".$plan->id."&currency=USD";
                        $btn_attrs = ""; // Sin atributos extra
                    } else {
                        $btn_href = "javascript:void(0);"; // Para que no recargue ni salte
                        $btn_attrs = 'data-toggle="modal" data-target="#myModal"'; // Abre el modal de login
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
                                <span class="text-slate-400 font-medium">/ <? echo $plan->duration; ?> days</span>
                            </div>

                            <ul class="space-y-4 mb-8 flex-1">
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                        <i class="fa fa-check text-primary text-xs"></i>
                                    </div>
                                    <span class="ml-3 text-slate-700 font-medium">
                                        <? if ($plan->ilimitado_activo == 1) { ?>
                                            <span class="text-primary font-bold">Unlimited Audio Downloads</span>
                                        <? } else { ?>
                                            <span class="font-bold"><? if($plan->tokens!=0 && $plan->tokens!=NULL){ echo $plan->tokens; }else{ echo '0'; } ?></span> Audio Downloads
                                        <? } ?>
                                    </span>
                                </li>

                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                        <i class="fa fa-check text-primary text-xs"></i>
                                    </div>
                                    <span class="ml-3 text-slate-600 text-sm">Automatic Renewal</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                        <i class="fa fa-check text-primary text-xs"></i>
                                    </div>
                                    <span class="ml-3 text-slate-600 text-sm">New music daily</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                        <i class="fa fa-check text-primary text-xs"></i>
                                    </div>
                                    <span class="ml-3 text-slate-600 text-sm">Direct downloads (1 Click)</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                        <i class="fa fa-check text-primary text-xs"></i>
                                    </div>
                                    <span class="ml-3 text-slate-600 text-sm">Intro, extended, remix, breakdown, transition and more</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center mt-0.5">
                                        <i class="fa fa-check text-primary text-xs"></i>
                                    </div>
                                    <span class="ml-3 text-slate-600 text-sm">Advanced Search</span>
                                </li>
                            </ul>

                            <a href="<? echo $btn_href; ?>" <? echo $btn_attrs; ?>
                               class="w-full block text-center py-4 rounded-xl font-bold transition-all duration-200 transform hover:-translate-y-1 <? echo $btn_class; ?>">
                                Get Plan
                            </a>

                            <p class="text-center text-xs text-slate-400 mt-4">Secure payment guaranteed</p>

                        </div>
                    </div>
                <? } } else { ?>
                <div class="col-span-full text-center py-10">
                    <p class="text-xl text-slate-500">No plans available at the moment.</p>
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
                    <i class="fa fa-headphones text-xl"></i>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">Extended Versions</h3>
                <p class="text-sm text-slate-500 leading-relaxed">
                    Intro, extended, remix, breakdown, transition and more
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
                    Contact us for custom solutions <i class="fa fa-arrow-right text-xs"></i>
                </a>
            </p>
        </div>

    </div>
</section>