<div id="ajaxArea" class="bg-slate-50 min-h-screen">
    <section class="py-12 md:py-16">
        <div class="container mx-auto px-4">

            <?php if(isset($error) && $error){ ?>
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-10 text-center">
                        <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fa fa-triangle-exclamation text-3xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-3">Checkout error</h2>
                        <p class="text-slate-600 mb-6"><?php echo htmlspecialchars($error, ENT_QUOTES); ?></p>
                        <a href="<?php echo base_url('drops'); ?>" class="px-6 py-3 bg-slate-900 text-white rounded-xl font-bold hover:bg-slate-800 transition-colors">
                            Back to Drops
                        </a>
                    </div>
                </div>
                <?php return; } ?>

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
                                <span class="text-slate-900 font-bold font-mono bg-slate-100 px-2 py-1 rounded text-sm"><?php echo $this->session->userdata('id_usuario'); ?></span>
                            </div>

                            <div class="h-px bg-slate-100 w-full"></div>

                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                <span class="text-sm text-slate-500 font-medium uppercase tracking-wider">User</span>
                                <span class="text-slate-900 font-semibold text-lg"><?php echo $this->session->userdata('username'); ?></span>
                            </div>

                            <div class="h-px bg-slate-100 w-full"></div>

                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center p-3 rounded-lg hover:bg-slate-50 transition-colors">
                                <span class="text-sm text-slate-500 font-medium uppercase tracking-wider">E-mail</span>
                                <span class="text-slate-900 font-medium"><?php echo $this->session->userdata('email'); ?></span>
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
                            <a href="<?php echo base_url('drops'); ?>" class="text-sm font-medium text-primary hover:text-blue-700 hover:underline transition-colors">
                                <i class="fa fa-pencil-alt mr-1"></i> Edit
                            </a>
                        </div>

                        <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 mb-6">
                            <div class="flex justify-between items-start gap-4 mb-2">
                                <div>
                                    <h4 class="font-bold text-slate-900 text-lg"><?php echo htmlspecialchars($producto->name, ENT_QUOTES); ?></h4>
                                    <div class="text-sm text-slate-500 mt-1 space-y-1">
                                        <p class="flex items-center gap-2"><i class="fa fa-check text-green-500 text-xs"></i> Exclusive drop pack</p>
                                        <p class="flex items-center gap-2"><i class="fa fa-receipt text-slate-400 text-xs"></i> Order #<?php echo (int)$orden->id; ?></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="block text-2xl font-bold text-slate-900">$<?php echo number_format((float)$producto->price, 2); ?></span>
                                    <span class="text-xs text-slate-400">USD</span>
                                </div>
                            </div>

                            <?php if(!empty($producto->description)){ ?>
                                <p class="text-sm text-slate-600 mt-3">
                                    <?php echo htmlspecialchars($producto->description, ENT_QUOTES); ?>
                                </p>
                            <?php } ?>
                        </div>

                        <div class="flex justify-between items-center py-4 border-t-2 border-slate-100 border-dashed">
                            <span class="text-slate-600 font-medium">Order Total</span>
                            <strong class="text-2xl font-extrabold text-primary">$<?php echo number_format((float)$producto->price, 2); ?> USD</strong>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                        <div class="flex items-center gap-3 mb-6 border-b border-slate-100 pb-4">
                            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-primary">
                                <i class="fa fa-credit-card"></i>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">PAYMENT METHOD</h3>
                        </div>

                        <a href="<?php echo htmlspecialchars($producto->payment_link, ENT_QUOTES); ?>"
                           class="block w-full text-center py-4 px-6 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow-md transition-all transform hover:-translate-y-1"
                           id="pay_drop_now"
                           data-order-id="<?php echo (int)$orden->id; ?>"
                           data-drop-id="<?php echo (int)$producto->id; ?>"
                           data-email="<?php echo htmlspecialchars($this->session->userdata('email'), ENT_QUOTES); ?>"
                           data-amount="<?php echo number_format((float)$producto->price, 2, '.', ''); ?>">
                            PAY BY CREDIT/DEBIT CARD
                        </a>

                        <p class="text-xs text-slate-400 mt-4 text-center">
                            You will be redirected to our secure payment provider.
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </section>
</div>