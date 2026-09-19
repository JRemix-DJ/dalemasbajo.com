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