(function(){
    const IS_LOGGED_IN = !!(window.DMB && window.DMB.isLoggedIn);

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
        if (window.jQuery && jQuery('#myModal').length) {
            jQuery('#myModal').modal('show');
            return;
        }
        const trigger = document.querySelector('[data-target="#myModal"]');
        if(trigger) trigger.click();
    }

    if(!IS_LOGGED_IN){
        setTimeout(openLoginModal, 250);
        if(openLoginModalBtn){
            openLoginModalBtn.addEventListener('click', openLoginModal);
        }
    }

    function setActiveCircle(el, active){
        el.className = active
            ? "w-10 h-10 rounded-full flex items-center justify-center font-bold text-white bg-[#0066FF]"
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

    if(yearsInput){
        yearsInput.addEventListener('input', function(){
            const onlyDigits = this.value.replace(/[^\d]/g, "");
            this.value = onlyDigits;
            const label = yearsToLabel(onlyDigits);
            if (yearsHint) yearsHint.textContent = label ? ("= " + label) : "";
        });
    }

    function validateStep(){
        if(current === 1){
            if(!val('full_name') || !val('artist_name')) return false;
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
        if(!IS_LOGGED_IN){ openLoginModal(); return; }
        if(!validateStep()){ showError("Please complete all required fields."); return; }
        current = Math.min(3, current + 1);
        render();
    });

    prevBtn.addEventListener('click', function(){
        if(!IS_LOGGED_IN){ openLoginModal(); return; }
        current = Math.max(1, current - 1);
        render();
    });

    if(uploads){
        uploads.addEventListener('change', function(){
            if(!uploads.files || uploads.files.length === 0){
                if (uploadsList) uploadsList.textContent = "";
                uploadsNames = "";
                return;
            }
            const names = Array.from(uploads.files).map(f => f.name);
            uploadsNames = names.join(", ");
            if (uploadsList) uploadsList.textContent = uploadsNames;
        });
    }

    submitBtn.addEventListener('click', async function(){
        if(!IS_LOGGED_IN){ openLoginModal(); return; }

        if(!validateStep()){ showError("Please complete all required fields."); return; }

        const fullName = val('full_name');
        const artist = val('artist_name');
        const yearsDigits = val('years');
        const yearsLabel = yearsToLabel(yearsDigits);
        const country = val('country_select');
        const work = val('work_select');
        const social = val('social');
        const about = val('about');

        document.getElementById('name').value = fullName;
        document.getElementById('experience').value = yearsLabel;
        document.getElementById('country').value = country;
        document.getElementById('work').value = work;
        document.getElementById('trabajos').value = social;

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
        fd.append('email', document.getElementById('email').value);
        fd.append('experience', yearsLabel);
        fd.append('work', work);
        fd.append('country', country);
        fd.append('trabajos', social);
        fd.append('message', msg);

        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-70');
        showOk("Sending...");

        try{
            const res = await fetch(window.DMB.baseUrl + 'pages/ser_miembro_mail', {
                method: "POST",
                body: fd
            });

            const data = await res.json().catch(() => null);

            if(data && data.success){
                showOk("Application submitted successfully!");
                document.getElementById('beRemixerForm').reset();
                if (uploadsList) uploadsList.textContent = "";
                uploadsNames = "";
                if (yearsHint) yearsHint.textContent = "";
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
