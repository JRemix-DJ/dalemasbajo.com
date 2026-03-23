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

                    <?php if(isset($orden) && (int)$orden->is_plan === 0){ ?>
                        <?php
                        $dropNameUpper = strtoupper(trim($producto->name ?? ''));
                        $maxWords = 20;

                        if ($dropNameUpper === 'BASIC') {
                            $maxWords = 5;
                        } elseif ($dropNameUpper === 'STANDARD') {
                            $maxWords = 10;
                        } elseif ($dropNameUpper === 'PREMIUM') {
                            $maxWords = 20;
                        }
                        ?>

                        <div class="bg-blue-50 rounded-2xl border border-blue-200 shadow-sm p-6 md:p-8">
                            <div class="flex items-center gap-3 mb-6 border-b border-blue-100 pb-4">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-primary">
                                    <i class="fa fa-microphone"></i>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900">YOUR DROP MESSAGE</h3>
                            </div>

                            <label class="block text-sm font-bold text-slate-900 mb-2">
                                Short message for the Drop
                            </label>

                            <input
                                    id="drop_dj_message"
                                    type="text"
                                    maxlength="180"
                                    placeholder="E.g. DJ Example / 'For DJ Example'..."
                                    class="w-full px-4 py-3 rounded-xl border border-blue-200 bg-white focus:outline-none focus:ring-2 focus:ring-primary/30"
                                    value="<?php echo htmlspecialchars($orden->dj_message ?? '', ENT_QUOTES); ?>"
                                    data-max-words="<?php echo (int)$maxWords; ?>"
                            >

                            <div class="mt-2 flex items-center justify-between gap-3">
                                <p class="text-xs text-slate-600">
                                    This field is required. Maximum <?php echo (int)$maxWords; ?> words for this drop.
                                </p>
                                <p id="drop_words_counter" class="text-xs font-semibold text-blue-700">
                                    0 / <?php echo (int)$maxWords; ?> words
                                </p>
                            </div>

                            <p id="drop_message_error" class="hidden mt-3 text-sm font-medium text-red-600"></p>
                        </div>
                    <?php } ?>
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
<script>
    (function(){
        const payBtn = document.getElementById('pay_drop_now');
        if(!payBtn) return;

        const msgInput = document.getElementById('drop_dj_message');
        const errorBox = document.getElementById('drop_message_error');
        const wordsCounter = document.getElementById('drop_words_counter');

        function countWords(text){
            const clean = (text || '').trim().replace(/\s+/g, ' ');
            if(!clean) return 0;
            return clean.split(' ').length;
        }

        function showError(message){
            if(!errorBox) return;
            errorBox.textContent = message;
            errorBox.classList.remove('hidden');
            msgInput.classList.add('border-red-400', 'ring-2', 'ring-red-200');
        }

        function clearError(){
            if(!errorBox) return;
            errorBox.textContent = '';
            errorBox.classList.add('hidden');
            msgInput.classList.remove('border-red-400', 'ring-2', 'ring-red-200');
        }

        function updateCounter(){
            if(!msgInput || !wordsCounter) return;

            const maxWords = parseInt(msgInput.getAttribute('data-max-words') || '20', 10);
            const words = countWords(msgInput.value);

            wordsCounter.textContent = words + ' / ' + maxWords + ' words';

            if(words > maxWords){
                wordsCounter.classList.remove('text-blue-700');
                wordsCounter.classList.add('text-red-600');
            }else{
                wordsCounter.classList.remove('text-red-600');
                wordsCounter.classList.add('text-blue-700');
            }
        }

        if(msgInput){
            updateCounter();

            msgInput.addEventListener('input', function(){
                let value = msgInput.value || '';
                value = value.replace(/\s+/g, ' ').replace(/^\s+/, '');
                msgInput.value = value;

                updateCounter();
                clearError();
            });
        }

        payBtn.addEventListener('click', async function(e){
            if(!msgInput) return;

            e.preventDefault();

            const orderId = payBtn.getAttribute('data-order-id');
            const msg = (msgInput.value || '').trim();
            const maxWords = parseInt(msgInput.getAttribute('data-max-words') || '20', 10);
            const totalWords = countWords(msg);

            clearError();

            if(msg === ''){
                showError('You must write the message for your drop before continuing.');
                msgInput.focus();
                return;
            }

            if(msg.length > 180){
                showError('Message too long (max 180 chars).');
                msgInput.focus();
                return;
            }

            if(totalWords > maxWords){
                showError('This drop only allows up to ' + maxWords + ' words.');
                msgInput.focus();
                return;
            }

            const oldHtml = payBtn.innerHTML;
            payBtn.innerHTML = 'Saving message...';
            payBtn.style.pointerEvents = 'none';
            payBtn.style.opacity = '0.85';

            try{
                const res = await fetch("<?php echo base_url('drops/save_drop_message'); ?>", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                    body: new URLSearchParams({
                        order_id: orderId,
                        dj_message: msg
                    })
                });

                const data = await res.json();

                if(!data || !data.success){
                    payBtn.innerHTML = oldHtml;
                    payBtn.style.pointerEvents = '';
                    payBtn.style.opacity = '';
                    showError(data && data.message ? data.message : 'Error saving message.');
                    return;
                }

                window.location.href = payBtn.getAttribute('href');

            }catch(err){
                payBtn.innerHTML = oldHtml;
                payBtn.style.pointerEvents = '';
                payBtn.style.opacity = '';
                showError('Connection error saving message.');
            }
        });
    })();
</script>