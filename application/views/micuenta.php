<div id="ajaxArea">
    <section class="bg-white py-10 md:py-14">
        <div class="container mx-auto px-4">

            <!-- Header -->
            <div class="mb-10">
                <h1 class="text-4xl md:text-5xl font-heading font-bold text-slate-900">
                    Hi <? echo $this->session->userdata('username'); ?>
                </h1>
                <p class="mt-2 text-slate-500 text-base">
                    Welcome to your personal account
                </p>
            </div>

            <!-- Content grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left: My Info -->
                <div class="lg:col-span-1">
                    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6 md:p-8">
                        <h2 class="text-xl font-heading font-bold text-slate-900 mb-6">
                            My Information
                        </h2>

                        <!-- Username item -->
                        <div class="flex items-center gap-4 bg-slate-50 rounded-2xl p-5 border border-slate-100 mb-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-b from-primary to-slate-900 text-white flex items-center justify-center shadow-lg shadow-blue-500/20">
                                <i class="fa-solid fa-user text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Username</p>
                                <p class="text-slate-900 font-semibold">
                                    <? echo $this->session->userdata('username'); ?>
                                </p>
                            </div>
                        </div>

                        <!-- Email item -->
                        <div class="flex items-center gap-4 bg-slate-50 rounded-2xl p-5 border border-slate-100">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-b from-primary to-slate-900 text-white flex items-center justify-center shadow-lg shadow-blue-500/20">
                                <i class="fa-solid fa-envelope text-xl"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Email</p>
                                <p class="text-slate-900 font-semibold">
                                    <? echo $this->session->userdata('email'); ?>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right: Orders -->
                <div class="lg:col-span-2">
                    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6 md:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-primary flex items-center justify-center border border-blue-100">
                                <i class="fa-solid fa-credit-card text-lg"></i>
                            </div>
                            <h2 class="text-xl font-heading font-bold text-slate-900 uppercase tracking-wide">
                                MY LATEST PURCHASES
                            </h2>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-separate border-spacing-0">
                                <thead>
                                <tr class="text-sm text-slate-700">
                                    <th class="py-4 px-4 border-b border-slate-200 font-bold">Date</th>
                                    <th class="py-4 px-4 border-b border-slate-200 font-bold">Order ID</th>
                                    <th class="py-4 px-4 border-b border-slate-200 font-bold text-right">Total Price</th>
                                </tr>
                                </thead>

                                <tbody class="text-sm">
                                <? if(isset($orders) && !empty($orders)){ ?>
                                    <? foreach($orders as $orden){ ?>
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="py-5 px-4 border-b border-slate-100 text-slate-600">
                                                <?
                                                // Ej: Feb 5, 2026 (como screenshot)
                                                echo date_format(date_create($orden->date_order), 'M j, Y');
                                                ?>
                                            </td>

                                            <td class="py-5 px-4 border-b border-slate-100">
                                                <a class="inline-flex items-center px-3 py-1.5 rounded-full bg-blue-50 text-primary font-bold text-xs border border-blue-100 hover:bg-blue-100 transition">
                                                    ORD-<? echo date('Y', strtotime($orden->date_order)); ?>-<? echo str_pad($orden->id, 3, '0', STR_PAD_LEFT); ?>
                                                </a>
                                            </td>

                                            <td class="py-5 px-4 border-b border-slate-100 text-right font-bold text-slate-900">
                                                $<? echo number_format((float)$orden->total_price, 2); ?>
                                            </td>
                                        </tr>
                                    <? } ?>
                                <? } else { ?>
                                    <tr>
                                        <td colspan="3" class="py-10 text-center text-slate-500">
                                            No purchases recorded.
                                        </td>
                                    </tr>
                                <? } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
