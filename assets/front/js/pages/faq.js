(function () {
    const root = document.getElementById('faq-accordion');
    if (!root) return;

    const btns = Array.from(root.querySelectorAll('.faq-btn'));
    const DURATION_MS = 260;

    function setIcon(btn, open) {
        const iconWrap = btn.querySelector('.faq-icon');
        if (!iconWrap) return;
        iconWrap.style.transform = open ? 'rotate(180deg)' : 'rotate(0deg)';
    }

    function closePanel(btn, panel) {
        btn.setAttribute('aria-expanded', 'false');
        setIcon(btn, false);

        panel.hidden = false;
        panel.style.maxHeight = panel.scrollHeight + 'px';

        requestAnimationFrame(() => {
            panel.style.maxHeight = '0px';

            const onEnd = (e) => {
                if (e.propertyName !== 'max-height') return;
                panel.hidden = true;
                panel.removeEventListener('transitionend', onEnd);
            };

            panel.addEventListener('transitionend', onEnd);

            setTimeout(() => {
                if (panel.style.maxHeight === '0px') panel.hidden = true;
                panel.removeEventListener('transitionend', onEnd);
            }, DURATION_MS + 60);
        });
    }

    function openPanel(btn, panel) {
        btn.setAttribute('aria-expanded', 'true');
        setIcon(btn, true);

        panel.hidden = false;
        panel.style.maxHeight = '0px';

        requestAnimationFrame(() => {
            panel.style.maxHeight = panel.scrollHeight + 'px';
        });
    }

    function closeAll(exceptId) {
        btns.forEach(b => {
            const panelId = b.dataset.target;
            if (panelId === exceptId) return;

            const p = document.getElementById(panelId);
            if (!p) return;

            if (b.getAttribute('aria-expanded') === 'true') {
                closePanel(b, p);
            }
        });
    }

    function toggle(btn) {
        const panelId = btn.dataset.target;
        const panel = document.getElementById(panelId);
        if (!panel) return;

        const expanded = btn.getAttribute('aria-expanded') === 'true';

        if (expanded) {
            closePanel(btn, panel);
        } else {
            closeAll(panelId);
            openPanel(btn, panel);
        }
    }

    btns.forEach(btn => {
        setIcon(btn, btn.getAttribute('aria-expanded') === 'true');
        btn.addEventListener('click', () => toggle(btn));
    });

    window.addEventListener('resize', () => {
        btns.forEach(btn => {
            if (btn.getAttribute('aria-expanded') !== 'true') return;
            const panel = document.getElementById(btn.dataset.target);
            if (!panel || panel.hidden) return;
            panel.style.maxHeight = panel.scrollHeight + 'px';
        });
    });
})();
