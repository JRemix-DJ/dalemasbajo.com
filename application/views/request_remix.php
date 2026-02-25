<?php
$state = 'ok';
if(!empty($force_login_modal)) $state = 'login';
else if(empty($eligible)) $state = 'upgrade';
?>

<section class="album-header relative w-full overflow-hidden flex items-center justify-center text-center bg-white py-16">
    <div class="container relative z-10 flex flex-col items-center px-4">
        <h1 class="font-heading font-light text-slate-900 leading-tight tracking-normal text-[44px] md:text-[64px] mb-3">
            Request Your Custom Remix
        </h1>

        <p class="text-[18px] md:text-[20px] text-slate-500 font-normal max-w-2xl leading-relaxed">
            Tell us about your vision and our professional DJs will bring it to life
        </p>

        <p class="text-center text-xs text-slate-400 mt-4">
            Limited access
        </p>
    </div>
</section>

<section class="pb-16 md:pb-24 bg-white">
    <div class="container mx-auto px-4">

        <?php if($state === 'login'){ ?>
            <div class="max-w-4xl mx-auto bg-white border border-slate-200 rounded-2xl shadow-sm p-8 text-center mb-24">
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Sign in required</h2>
                <p class="text-slate-500 mb-6">Please sign in to request a custom remix.</p>
                <a href="#" data-toggle="modal" data-target="#myModal"
                   class="inline-flex items-center justify-center px-6 py-3 rounded-xl font-bold text-white bg-primary hover:bg-blue-700 transition">
                    Sign in
                </a>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function(){
                    if (window.$ && $('#myModal').length) $('#myModal').modal('show');
                });
            </script>

        <?php } elseif($state === 'upgrade'){ ?>

            <div class="max-w-4xl mx-auto bg-white border border-slate-200 rounded-2xl shadow-sm p-8 text-center mb-24">
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Access limited</h2>
                <p class="text-slate-500 mb-6">
                    You need an active <span class="font-bold text-slate-900">Standard</span> plan or higher to request a custom remix.
                </p>
                <a href="<?php echo base_url('planes'); ?>"
                   class="inline-flex items-center justify-center px-6 py-3 rounded-xl font-bold text-white bg-slate-900 hover:bg-slate-800 transition">
                    View Plans
                </a>
            </div>

        <?php } else { ?>
            <div class="max-w-5xl mx-auto">
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 md:p-10">

                    <form id="customRemixForm" class="space-y-8">

                        <!-- STEP 1 -->
                        <div class="flex items-start gap-4 pb-8 border-b border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-[rgb(0,102,255)] text-white flex items-center justify-center font-bold shadow">
                                1
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-slate-900">Your Information</h3>

                                <div class="mt-4">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Email Address *</label>
                                    <input
                                            type="email"
                                            name="email"
                                            value="<?php echo htmlspecialchars($user_email ?? ''); ?>"
                                            readonly
                                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-700 outline-none focus:ring-2 focus:ring-primary/30"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2 + SIDE CARD -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-8 border-b border-slate-100">
                            <div class="lg:col-span-2 flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-[rgb(0,102,255)] text-white flex items-center justify-center font-bold shadow">
                                    2
                                </div>

                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-slate-900">Song Details</h3>

                                    <div class="mt-4">
                                        <label class="block text-sm font-bold text-slate-700 mb-2">
                                            Song Link (YouTube, Spotify, SoundCloud) *
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                              <i class="fa-solid fa-link"></i>
                                            </span>
                                            <input
                                                    type="url"
                                                    name="song_link"
                                                    required
                                                    placeholder="https://www.youtube.com/watch?v=..."
                                                    class="w-full pl-11 rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-700 outline-none focus:ring-2 focus:ring-primary/30"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SIDE CARD STEP 2 -->
                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col items-center text-center">
                                <div class="w-12 h-12 bg-[rgb(0,102,255)] text-white rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-blue-500/20">
                                    <i class="fa-solid fa-clock text-xl"></i>
                                </div>
                                <h4 class="font-bold text-slate-900 mb-2">Fast Turnaround</h4>
                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Get your remix in as little as 1-2 days
                                </p>
                            </div>
                        </div>

                        <!-- STEP 3 + SIDE CARD -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-2 flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-[rgb(0,102,255)] text-white flex items-center justify-center font-bold shadow">
                                    3
                                </div>

                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-slate-900">Remix Preferences</h3>

                                    <div class="mt-6">
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Message</label>
                                        <textarea
                                                name="instructions"
                                                rows="5"
                                                placeholder="Tell us about any specific elements you'd like in your remix: drops, builds, vocal effects, tempo changes, etc..."
                                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-700 outline-none focus:ring-2 focus:ring-primary/30"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- SIDE CARD STEP 3 -->
                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col items-center justify-center text-center">
                                <div class="w-12 h-12 bg-[rgb(0,102,255)] text-white rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-blue-500/20">
                                    <i class="fa-solid fa-wand-magic-sparkles text-xl"></i>
                                </div>
                                <h4 class="font-bold text-slate-900 mb-2">Studio-Quality Sound</h4>
                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Pro mix & master so your remix is ready for your sets
                                </p>
                            </div>
                        </div>

                        <div class="pt-8">
                            <button type="submit"
                                    class="w-full py-4 rounded-2xl font-bold text-white bg-[rgb(0,102,255)] shadow-xl shadow-blue-500/20 hover:bg-blue-700 hover:shadow-blue-500/30 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.99]">
                                Submit Your Request
                            </button>
                            <p class="text-center text-xs text-slate-400 mt-4">
                                We'll get back to you within 24 hours with a confirmation
                            </p>
                        </div>

                    </form>

                </div>
            </div>
        <?php } ?>

    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function(){
        const form = document.getElementById("customRemixForm");
        if(!form) return;

        form.addEventListener("submit", async function(e){
            e.preventDefault();

            const fd = new FormData(form);

            try{
                const res = await fetch("<?php echo base_url('pages/submit_request_remix'); ?>", {
                    method: "POST",
                    body: fd
                });
                const json = await res.json();

                if(json && json.success){
                    alert("Request sent successfully!");
                    form.reset();
                }else{
                    alert((json && json.message) ? json.message : "Error sending request.");
                }
            }catch(err){
                alert("Network error.");
            }
        });
    });
</script>