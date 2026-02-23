<div id="ajaxArea">

    <?php
    $is_logged = (bool)$this->session->userdata('is_logued_in');
    $session_email = (string)$this->session->userdata('email'); // confirmado en proyecto :contentReference[oaicite:1]{index=1}
    ?>

    <!-- HERO -->
    <section class="relative w-full overflow-hidden flex items-center justify-center text-center bg-white py-16 md:py-20">
        <div class="container relative z-10 flex flex-col items-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 tracking-tight mb-3 font-heading drop-shadow-sm">
                Become a Remixer
            </h1>
            <p class="text-lg text-slate-500 font-medium max-w-2xl">
                Join our community of talented remixers and share your music with the world
            </p>
        </div>
    </section>

    <!-- BENEFITS -->
    <section class="bg-white pb-10 md:pb-14">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php
                $benefits = [
                        ["icon" => "fa-dollar-sign", "title" => "Earn Revenue", "desc" => "Get paid for every download of your remixes"],
                        ["icon" => "fa-users", "title" => "Global Audience", "desc" => "Reach thousands of DJs and music lovers worldwide"],
                        ["icon" => "fa-arrow-trend-up", "title" => "Grow Your Brand", "desc" => "Build your reputation in the DJ community"],
                        ["icon" => "fa-music", "title" => "Creative Freedom", "desc" => "Choose the tracks you want to remix"],
                ];
                foreach($benefits as $b){
                    ?>
                    <div class="flex flex-col items-center text-center p-7 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                        <div class="w-16 h-16 bg-gradient-to-r from-[#0066FF] to-slate-900 text-white rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-blue-500/30">
                            <i class="fa-solid <?= $b['icon']; ?> text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2"><?= $b['title']; ?></h3>
                        <p class="text-sm text-slate-500 leading-relaxed max-w-xs">
                            <?= $b['desc']; ?>
                        </p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- APPLICATION FORM -->
    <section class="bg-white pb-16 md:pb-24">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm px-6 py-10 md:px-12 md:py-14">

                    <h2 class="text-3xl md:text-4xl font-semibold text-slate-900 text-center mb-2">
                        Application Form
                    </h2>
                    <p class="text-slate-500 text-center mb-8">
                        Tell us about yourself and your music
                    </p>

                    <!-- NOT LOGGED IN NOTICE -->
                    <div id="loginGate" class="<?= $is_logged ? 'hidden' : ''; ?> mb-8">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 text-center">
                            <p class="text-slate-700 font-semibold mb-3">
                                You need to sign in to continue.
                            </p>
                            <button id="openLoginModalBtn"
                                    class="px-6 py-3 rounded-full font-bold text-white bg-gradient-to-r from-[#0066FF] to-slate-900 hover:shadow-lg hover:shadow-blue-500/20 hover:scale-[1.01] transition-all">
                                Sign in
                            </button>
                        </div>
                    </div>

                    <!-- STEPPER -->
                    <div class="flex items-center justify-center gap-3 mb-10 select-none">
                        <div class="flex items-center">
                            <div id="stepCircle1" class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white bg-gradient-to-r from-[#0066FF] to-slate-900">1</div>
                            <div id="stepLine1" class="w-16 h-1 rounded-full bg-slate-200 mx-3"></div>
                        </div>
                        <div class="flex items-center">
                            <div id="stepCircle2" class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-slate-500 bg-slate-200">2</div>
                            <div id="stepLine2" class="w-16 h-1 rounded-full bg-slate-200 mx-3"></div>
                        </div>
                        <div class="flex items-center">
                            <div id="stepCircle3" class="w-10 h-10 rounded-full flex items-center justify-content-center font-bold text-slate-500 bg-slate-200">3</div>
                        </div>
                    </div>

                    <form id="beRemixerForm" class="space-y-5" onsubmit="return false;">

                        <!-- Backend-required fields -->
                        <input type="hidden" name="email" id="email" value="<?= htmlspecialchars($session_email, ENT_QUOTES); ?>">
                        <input type="hidden" name="name" id="name">
                        <input type="hidden" name="experience" id="experience">
                        <input type="hidden" name="work" id="work">
                        <input type="hidden" name="country" id="country">
                        <input type="hidden" name="trabajos" id="trabajos">
                        <input type="hidden" name="message" id="message">

                        <!-- STEP 1 -->
                        <div id="step1" class="space-y-5 <?= $is_logged ? '' : 'opacity-50 pointer-events-none'; ?>">
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">Full Name <span class="text-red-500">*</span></label>
                                <input id="full_name" type="text"
                                       class="w-full h-12 rounded-xl border border-slate-200 bg-slate-100 px-4 outline-none focus:bg-white focus:border-[#0066FF] focus:ring-4 focus:ring-blue-500/10"
                                       placeholder="John Doe" required>
                            </div>

                            <!-- Email: from session -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">Email Address <span class="text-red-500">*</span></label>
                                <input id="email_display" type="text"
                                       class="w-full h-12 rounded-xl border border-slate-200 bg-slate-100 px-4 text-slate-600"
                                       value="<?= $is_logged ? htmlspecialchars($session_email, ENT_QUOTES) : 'Sign in to load your email'; ?>"
                                       readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">Artist/DJ Name <span class="text-red-500">*</span></label>
                                <input id="artist_name" type="text"
                                       class="w-full h-12 rounded-xl border border-slate-200 bg-slate-100 px-4 outline-none focus:bg-white focus:border-[#0066FF] focus:ring-4 focus:ring-blue-500/10"
                                       placeholder="DJ Shadow" required>
                            </div>
                        </div>

                        <!-- STEP 2 -->
                        <div id="step2" class="space-y-5 hidden <?= $is_logged ? '' : 'opacity-50 pointer-events-none'; ?>">

                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">Years of Experience <span class="text-red-500">*</span></label>
                                <input id="years" inputmode="numeric" pattern="[0-9]*"
                                       class="w-full h-12 rounded-xl border border-slate-200 bg-slate-100 px-4 outline-none focus:bg-white focus:border-[#0066FF] focus:ring-4 focus:ring-blue-500/10"
                                       placeholder="5" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">Country <span class="text-red-500">*</span></label>
                                <select id="country_select"
                                        class="w-full h-12 rounded-xl border border-slate-200 bg-slate-100 px-4 outline-none focus:bg-white focus:border-[#0066FF] focus:ring-4 focus:ring-blue-500/10"
                                        required>
                                    <option value="">Select a country</option>
                                    <? foreach($paises as $pais){ ?>
                                        <option value="<? echo $pais->name; ?>"><? echo $pais->name; ?></option>
                                    <? } ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">Do you work with another service like this? <span class="text-red-500">*</span></label>
                                <select id="work_select"
                                        class="w-full h-12 rounded-xl border border-slate-200 bg-slate-100 px-4 outline-none focus:bg-white focus:border-[#0066FF] focus:ring-4 focus:ring-blue-500/10"
                                        required>
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>

                        </div>

                        <!-- STEP 3 -->
                        <div id="step3" class="space-y-5 hidden <?= $is_logged ? '' : 'opacity-50 pointer-events-none'; ?>">

                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">
                                    Works Done <span class="text-red-500">*</span>
                                </label>
                                <input id="social" type="url"
                                       class="w-full h-12 rounded-xl border border-slate-200 bg-slate-100 px-4 outline-none focus:bg-white focus:border-[#0066FF] focus:ring-4 focus:ring-blue-500/10"
                                       placeholder="It could be a link to SoundCloud, Google Drive, etc."
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-900 mb-2">Tell Us About Yourself</label>
                                <textarea id="about"
                                          class="w-full min-h-[160px] rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 outline-none focus:bg-white focus:border-[#0066FF] focus:ring-4 focus:ring-blue-500/10"
                                          placeholder="Share your story, achievements, and why you want to join Dale Más Bajo..."></textarea>
                            </div>

                        </div>

                        <!-- ACTIONS -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-4 <?= $is_logged ? '' : 'opacity-50 pointer-events-none'; ?>">
                            <button id="prevBtn" type="button"
                                    class="w-full sm:w-1/2 h-12 rounded-full border border-slate-300 bg-white font-bold text-slate-900 hover:shadow-md hover:scale-[1.01] transition-all hidden">
                                Previous
                            </button>

                            <button id="nextBtn" type="button"
                                    class="w-full sm:flex-1 h-12 rounded-full font-bold text-white bg-[rgb(0,102,255)] hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.99]">
                                Next Step
                            </button>

                            <button id="submitBtn" type="button"
                                    class="w-full sm:flex-1 h-12 rounded-full font-bold text-white bg-[rgb(0,102,255)] hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.99] hidden">
                                Submit Application
                            </button>
                        </div>

                        <div id="formMsg" class="text-center text-sm mt-2"></div>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <script>
        (function(){
            const IS_LOGGED_IN = <?= $is_logged ? 'true' : 'false'; ?>;

            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const step3 = document.getElementById('step3');

            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');
            const formMsg = document.getElementById('formMsg');

            const c1 = document.getElementById('stepCircle1');
            const c2 = document.getElementById('stepCircle2');
            const c3 = document.getElementById('stepCircle3');
            const l1 = document.getElementById('stepLine1');
            const l2 = document.getElementById('stepLine2');

            const yearsInput = document.getElementById('years');
            const yearsHint = document.getElementById('yearsHint');

            const uploads = document.getElementById('uploads');
            const uploadsList = document.getElementById('uploadsList');

            const openLoginModalBtn = document.getElementById('openLoginModalBtn');

            let current = 1;
            let uploadsNames = "";

            function openLoginModal(){
                // Bootstrap/jQuery (compat)
                if (window.jQuery && jQuery('#myModal').length) {
                    jQuery('#myModal').modal('show');
                    return;
                }
                // fallback: click any trigger if exists
                const trigger = document.querySelector('[data-target="#myModal"]');
                if(trigger) trigger.click();
            }

            // If not logged, force login modal on load
            if(!IS_LOGGED_IN){
                setTimeout(openLoginModal, 250);
                if(openLoginModalBtn){
                    openLoginModalBtn.addEventListener('click', openLoginModal);
                }
            }

            function setActiveCircle(el, active){
                el.className = active
                    ? "w-10 h-10 rounded-full flex items-center justify-center font-bold text-white bg-gradient-to-r from-[#0066FF] to-slate-900"
                    : "w-10 h-10 rounded-full flex items-center justify-center font-bold text-slate-500 bg-slate-200";
            }
            function setLineDone(el, done){
                el.className = done
                    ? "w-16 h-1 rounded-full bg-[#0066FF] mx-3"
                    : "w-16 h-1 rounded-full bg-slate-200 mx-3";
            }

            function render(){
                step1.classList.toggle('hidden', current !== 1);
                step2.classList.toggle('hidden', current !== 2);
                step3.classList.toggle('hidden', current !== 3);

                prevBtn.classList.toggle('hidden', current === 1);
                nextBtn.classList.toggle('hidden', current === 3);
                submitBtn.classList.toggle('hidden', current !== 3);

                setActiveCircle(c1, true);
                setLineDone(l1, current >= 2);
                setActiveCircle(c2, current >= 2);
                setLineDone(l2, current >= 3);
                setActiveCircle(c3, current >= 3);

                formMsg.textContent = '';
                formMsg.className = "text-center text-sm mt-2";
            }

            function val(id){ return (document.getElementById(id)?.value || "").trim(); }

            function showError(msg){
                formMsg.textContent = msg;
                formMsg.className = "text-center text-sm mt-2 text-red-600 font-semibold";
            }
            function showOk(msg){
                formMsg.textContent = msg;
                formMsg.className = "text-center text-sm mt-2 text-emerald-600 font-semibold";
            }

            function yearsToLabel(n){
                const num = parseInt(n, 10);
                if(!num || num < 0) return "";
                return num + " " + (num === 1 ? "year" : "years");
            }

            // Years: only digits + hint "year(s)"
            if(yearsInput){
                yearsInput.addEventListener('input', function(){
                    const onlyDigits = this.value.replace(/[^\d]/g, "");
                    this.value = onlyDigits;
                    const label = yearsToLabel(onlyDigits);
                    yearsHint.textContent = label ? ("= " + label) : "";
                });
            }

            function validateStep(){
                if(current === 1){
                    if(!val('full_name') || !val('artist_name')) return false;
                    // email comes from session; if not logged we block anyway
                }
                if(current === 2){
                    if(!val('years') || !val('country_select') || !val('work_select')) return false;
                }
                if(current === 3){
                    if(!val('social')) return false;
                }
                return true;
            }

            nextBtn.addEventListener('click', function(){
                if(!IS_LOGGED_IN){
                    openLoginModal();
                    return;
                }
                if(!validateStep()){
                    showError("Please complete all required fields.");
                    return;
                }
                current = Math.min(3, current + 1);
                render();
            });

            prevBtn.addEventListener('click', function(){
                if(!IS_LOGGED_IN){
                    openLoginModal();
                    return;
                }
                current = Math.max(1, current - 1);
                render();
            });

            if(uploads){
                uploads.addEventListener('change', function(){
                    if(!uploads.files || uploads.files.length === 0){
                        uploadsList.textContent = "";
                        uploadsNames = "";
                        return;
                    }
                    const names = Array.from(uploads.files).map(f => f.name);
                    uploadsNames = names.join(", ");
                    uploadsList.textContent = uploadsNames;
                });
            }

            submitBtn.addEventListener('click', async function(){
                if(!IS_LOGGED_IN){
                    openLoginModal();
                    return;
                }

                if(!validateStep()){
                    showError("Please complete all required fields.");
                    return;
                }

                // Build backend payload
                const fullName = val('full_name');
                const artist = val('artist_name');

                const yearsDigits = val('years');
                const yearsLabel = yearsToLabel(yearsDigits);

                const country = val('country_select');
                const work = val('work_select');

                const social = val('social');
                const about = val('about');

                // Hidden backend fields
                document.getElementById('name').value = fullName;
                document.getElementById('experience').value = yearsLabel; // backend expects text
                document.getElementById('country').value = country;
                document.getElementById('work').value = work;
                document.getElementById('trabajos').value = social; // Social Media Links -> trabajos

                // message composed
                let msg = "";
                msg += "Artist/DJ Name: " + artist + "\\n";
                msg += "Experience: " + yearsLabel + "\\n";
                msg += "Country: " + country + "\\n";
                msg += "Works with another service: " + work + "\\n";
                msg += "Social/Portfolio Link: " + social + "\\n";
                if(uploadsNames) msg += "Selected Uploads (names only): " + uploadsNames + "\\n";
                if(about) msg += "\\nAbout:\\n" + about;

                document.getElementById('message').value = msg;

                const fd = new FormData();
                fd.append('name', fullName);
                fd.append('email', document.getElementById('email').value); // session email
                fd.append('experience', yearsLabel);
                fd.append('work', work);
                fd.append('country', country);
                fd.append('trabajos', social);
                fd.append('message', msg);

                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-70');
                showOk("Sending...");

                try{
                    const res = await fetch("<?= base_url('pages/ser_miembro_mail'); ?>", {
                        method: "POST",
                        body: fd
                    });

                    const data = await res.json().catch(() => null);

                    if(data && data.success){
                        showOk("Application submitted successfully!");
                        document.getElementById('beRemixerForm').reset();
                        uploadsList.textContent = "";
                        uploadsNames = "";
                        yearsHint.textContent = "";
                        current = 1;
                        render();
                    } else {
                        showError("Something went wrong. Please try again.");
                    }
                } catch(e){
                    showError("Network error. Please try again.");
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-70');
                }
            });

            render();
        })();
    </script>

</div>
