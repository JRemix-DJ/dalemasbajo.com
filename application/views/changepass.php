<div id="ajaxArea" class="bg-slate-50 min-h-screen flex items-start justify-center px-4 py-10">
    <div class="w-full max-w-lg">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/60">
                <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">
                    Change password
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Enter your new password below.
                </p>
            </div>

            <div class="p-6">
                <form id="changepass-form" class="space-y-4">
                    <div class="space-y-2">
                        <label for="cpassword" class="text-sm font-semibold text-slate-700">Password</label>
                        <input
                                type="password"
                                name="password"
                                id="cpassword"
                                autocomplete="new-password"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 outline-none
                                   focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                placeholder="New password"
                        >
                    </div>

                    <div class="space-y-2">
                        <label for="crpassword" class="text-sm font-semibold text-slate-700">Repeat password</label>
                        <input
                                type="password"
                                name="rpassword"
                                id="crpassword"
                                autocomplete="new-password"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 outline-none
                                   focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                placeholder="Repeat new password"
                        >
                    </div>

                    <input type="hidden" id="reset_email" value="<?php echo htmlspecialchars($reset_email, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="reset_token" value="<?php echo htmlspecialchars($reset_token, ENT_QUOTES, 'UTF-8'); ?>">

                    <button id="resetpass-btn" type="button"
                            class="w-full py-3 rounded-xl bg-primary text-white font-extrabold hover:bg-blue-700 transition shadow-lg shadow-blue-500/20">
                        Update password
                    </button>

                    <div id="cp-msg" class="hidden rounded-xl border p-3 text-sm"></div>

                    <p class="text-xs text-slate-400 text-center pt-2">
                        If you didn’t request this, you can ignore this page.
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const btn = document.getElementById('resetpass-btn');
        const msg = document.getElementById('cp-msg');

        function showMsg(type, text) {
            msg.classList.remove('hidden');
            msg.className = 'rounded-xl border p-3 text-sm ' + (type === 'ok'
                ? 'border-green-200 bg-green-50 text-green-800'
                : 'border-red-200 bg-red-50 text-red-700');
            msg.textContent = text;
        }

        if (!btn) return;

        btn.addEventListener('click', async function (e) {
            e.preventDefault();

            const pass  = document.getElementById('cpassword').value;
            const rpass = document.getElementById('crpassword').value;
            const email = document.getElementById('reset_email').value;
            const token = document.getElementById('reset_token').value;

            if (!pass || !rpass) return showMsg('err', 'Complete the fields.');
            if (pass !== rpass) return showMsg('err', 'The passwords do not match.');

            btn.disabled = true;

            try {
                const res = await fetch("<?php echo base_url('users/reset_password'); ?>", {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
                    body: new URLSearchParams({ email, token, pass, rpass }).toString()
                });

                const data = await res.json().catch(() => null);

                if (data && data.success) {
                    showMsg('ok', 'Password updated. Redirecting…');
                    setTimeout(() => window.location.href = "<?php echo base_url(); ?>", 900);
                } else {
                    showMsg('err', (data && data.message) ? data.message : 'The password could not be changed.');
                }
            } catch (err) {
                showMsg('err', 'Connection error.');
            } finally {
                btn.disabled = false;
            }
        });
    })();
</script>