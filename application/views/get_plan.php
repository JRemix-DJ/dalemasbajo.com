<div id="ajaxArea" class="bg-slate-50 min-h-screen">
    <section class="py-12 md:py-16">
        <div class="container mx-auto px-4">

            <? if($this->session->userdata('is_logued_in')){ ?>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-6xl mx-auto">

                    <div class="flex flex-col gap-6">
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                            <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-primary">
                                    <i class="fa fa-user"></i>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900">BILLING INFORMATION</h3>
                            </div>

                            <div class="space-y-4">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                    <span class="text-sm text-slate-500 font-medium uppercase tracking-wider">Customer Code</span>
                                    <span class="text-slate-900 font-bold font-mono bg-slate-100 px-2 py-1 rounded text-sm"><? echo $this->session->userdata('id_usuario'); ?></span>
                                </div>

                                <div class="h-px bg-slate-100 w-full"></div>

                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                    <span class="text-sm text-slate-500 font-medium uppercase tracking-wider">User</span>
                                    <span class="text-slate-900 font-semibold text-lg"><? echo $this->session->userdata('username'); ?></span>
                                </div>

                                <div class="h-px bg-slate-100 w-full"></div>

                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                    <span class="text-sm text-slate-500 font-medium uppercase tracking-wider">E-mail</span>
                                    <span class="text-slate-900 font-medium"><? echo $this->session->userdata('email'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-6">

                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                            <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-primary">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900">YOUR ORDER</h3>
                                </div>
                                <a href="<? echo base_url(); ?>planes" class="text-sm font-medium text-primary hover:text-blue-700 hover:underline transition-colors">
                                    <i class="fa fa-pencil-alt mr-1"></i> Edit
                                </a>
                            </div>

                            <div class="content">
                                <? if(isset($plan)){ ?>
                                    <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 mb-6">
                                        <div class="flex justify-between items-start gap-4 mb-2">
                                            <div>
                                                <h4 class="font-bold text-slate-900 text-lg"><? echo $plan->name; ?></h4>
                                                <div class="text-sm text-slate-500 mt-1 space-y-1">
                                                    <? if ($plan->ilimitado_activo == 1) { ?>
                                                        <p class="flex items-center gap-2"><i class="fa fa-check text-green-500 text-xs"></i> Unlimited Audio Downloads</p>
                                                    <? }else{ if($plan->tokens!=NULL||$plan->tokens!=0){ ?>
                                                        <p class="flex items-center gap-2"><i class="fa fa-check text-green-500 text-xs"></i> <? echo $plan->tokens; ?> Audio Downloads</p>
                                                    <? } } ?>
                                                    <p class="flex items-center gap-2"><i class="fa fa-clock text-slate-400 text-xs"></i> Duration <? echo $plan->duration; ?> days</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span class="block text-2xl font-bold text-slate-900">$<? echo $plan->price; ?></span>
                                                <span class="text-xs text-slate-400">USD</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center py-4 border-t-2 border-slate-100 border-dashed">
                                        <span class="text-slate-600 font-medium">Total de la Orden</span>
                                        <strong class="text-2xl font-extrabold text-primary">$<? echo $plan->price; ?> USD</strong>
                                    </div>
                                <? } ?>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                            <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-primary">
                                    <i class="fa fa-credit-card"></i>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900">PAYMENT METHOD</h3>
                            </div>

                            <div class="space-y-6">
                                <?
                                $metodos_pago=0;

                                // --- PAYPAL ---
                                if(PAYPAL_ACTIVE){
                                    $metodos_pago++;
                                    ?>
                                    <div class="relative">
                                        <label class="flex items-center justify-between p-4 border border-blue-200 bg-blue-50/50 rounded-xl cursor-pointer hover:border-primary transition-all shadow-sm">
                                            <div class="flex items-center gap-3">
                                                <input type="radio" value="paypal" name="pago" id="checkpaypal" checked class="w-5 h-5 text-primary border-gray-300 focus:ring-primary">
                                                <span class="font-bold text-slate-700">PayPal</span>
                                            </div>
                                            <img src="<? echo base_url(); ?>/images/paypal.png" alt="PayPal" class="h-8 object-contain">
                                        </label>
                                    </div>

                                    <form name="frm_customer_detail" id="pagarpaypal" action="https://www.paypal.com/cgi-bin/webscr" method="POST" class="mt-4">
                                        <input type='hidden' name='business' value='<? echo PAYPAL_MAIL; ?>'>
                                        <input type='hidden' name='item_name' value='<? echo $plan->name; ?>'>
                                        <input type='hidden' name='a3' id="amount" value='<? echo $plan->price; ?>'>
                                        <input type='hidden' name='p3' id="period" value='<? echo $plan->duration; ?>'>
                                        <input type='hidden' name='t3' id="type_period" value='D'>
                                        <input type='hidden' name='currency_code' value='USD'>
                                        <input type="hidden" name="lc" value="US">
                                        <input type="hidden" name="src" value="1">
                                        <input type='hidden' name='notify_url' value='<? echo base_url(); ?>payment/plan_realizado/'>
                                        <input type='hidden' name='return' value='<? echo base_url(); ?>payment/plan_finalizado/'>
                                        <input type="hidden" name="button_subtype" value="services">
                                        <input type="hidden" name="cancel_return" value="<? echo base_url(); ?>payment/plan_cancelar/">
                                        <input type="hidden" name="cmd" value="_xclick-subscriptions">
                                        <input type="hidden" name="order" value="">
                                        <input type="hidden" name="plan" id="plan" value="<?php echo $_GET['plan_id'];?>">
                                        <input type="hidden" name="custom" id="custom" value="">

                                        <button type="submit" class="w-full py-4 px-6 bg-[#0070BA] hover:bg-[#005ea6] text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2" name="continue_payment" id="paynow">
                                            <i class="fa fa-lock"></i> Pagar Ahora con Paypal
                                        </button>
                                    </form>
                                <? } ?>

                                <? if(PAYPAL_ACTIVE && PAGOLINK_ACTIVE && !is_null($plan->url_pago)){ ?>
                                    <div class="relative flex items-center py-2">
                                        <div class="flex-grow border-t border-slate-200"></div>
                                        <span class="flex-shrink-0 mx-4 text-slate-400 text-sm font-medium">O</span>
                                        <div class="flex-grow border-t border-slate-200"></div>
                                    </div>
                                <? } ?>

                                <? if(PAGOLINK_ACTIVE && !is_null($plan->url_pago)){
                                    $metodos_pago++;
                                    ?>
                                    <div class="item">
                                        <a href="javascript:void(0);"
                                           class="block w-full text-center py-4 px-6 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow-md transition-all transform hover:-translate-y-1 mb-3"
                                           id="pagar_tarjeta"
                                           data-href="<? echo $plan->url_pago; ?>"
                                           data-email="<? echo $this->session->userdata('email'); ?>">
                                            PAY BY CREDIT/DEBIT CARD
                                        </a>

                                        <div class="flex justify-center gap-3 text-2xl text-slate-400 grayscale opacity-70">
                                            <i class="fa fa-brands fa-cc-visa hover:text-[#1A1F71] hover:grayscale-0 transition-colors"></i>
                                            <i class="fa fa-brands fa-cc-mastercard hover:text-[#EB001B] hover:grayscale-0 transition-colors"></i>
                                            <i class="fa fa-brands fa-cc-amex hover:text-[#006FCF] hover:grayscale-0 transition-colors"></i>
                                            <i class="fa fa-brands fa-cc-diners-club hover:text-[#0079BE] hover:grayscale-0 transition-colors"></i>
                                        </div>
                                    </div>
                                <? } ?>

                                <? if(!$metodos_pago){ ?>
                                    <div class="p-4 bg-red-50 text-red-600 rounded-xl border border-red-100 text-center font-medium">
                                        <i class="fa fa-exclamation-circle mr-2"></i>
                                        NO HAY MÉTODOS DE PAGO DISPONIBLES PARA ESTE PLAN
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>

                </div>

            <? } else { ?>
                <div class="max-w-2xl mx-auto py-20">
                    <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-10 text-center">
                        <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fa fa-lock text-3xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-4">Acceso Restringido</h2>
                        <p class="text-slate-600 mb-8 text-lg">
                            Necesitas estar registrado y logueado para finalizar la compra de este plan.
                        </p>
                        <div class="flex gap-4 justify-center">
                            <a href="<? echo base_url('login'); ?>" class="px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-blue-700 transition-colors">
                                Iniciar Sesión
                            </a>
                            <a href="<? echo base_url('registro'); ?>" class="px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition-colors">
                                Crear Cuenta
                            </a>
                        </div>
                    </div>
                </div>
            <? } ?>

        </div>
    </section>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('pagar_tarjeta');
        if (!btn) return;

        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const href = btn.getAttribute('data-href');
            const email = btn.getAttribute('data-email') || '';

            if (!href) return;

            const msg =
                "Important:\n\n" +
                "Please complete the payment using the SAME email address as your DaleMasBajo.com account.\n\n" +
                (email ? ("Your account email is: " + email + "\n\n") : "") +
                "Click OK to continue.";

            const ok = window.confirm(msg);
            if (ok) window.location.href = href;
        });
    });
</script>