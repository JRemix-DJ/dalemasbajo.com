$(function() {
    var header = document.getElementById('siteHeader');
    var firstLink = document.getElementById('navFirstLink');

    function setSplit() {
        if (!header) return;

        if (window.innerWidth < 1024) {
            header.style.setProperty('--blue-cut', '170px');
            return;
        }

        if (!firstLink) return;

        var h = header.getBoundingClientRect();
        var a = firstLink.getBoundingClientRect();
        var cut = Math.max(340, Math.floor(a.left - h.left - 48));
        header.style.setProperty('--blue-cut', cut + 'px');
    }

    var raf = 0;
    function schedule() {
        if (raf) return;
        raf = requestAnimationFrame(function() {
            raf = 0;
            setSplit();
        });
    }

    window.addEventListener('resize', schedule, { passive: true });
    window.addEventListener('orientationchange', schedule, { passive: true });
    window.addEventListener('pageshow', schedule, { passive: true });
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) schedule();
    }, { passive: true });

    if (window.visualViewport) {
        visualViewport.addEventListener('resize', schedule, { passive: true });
        visualViewport.addEventListener('scroll', schedule, { passive: true });
    }

    schedule();
});
