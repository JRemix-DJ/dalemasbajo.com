document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('pagar_tarjeta');
    if (!btn) return;

    btn.addEventListener('click', function (e) {
        e.preventDefault();

        const href = btn.getAttribute('data-href');
        const email = btn.getAttribute('data-email') || '';

        if (!href) return;

        const msg =
            "Important:\n\n" +
            "Please complete the payment using the SAME email address as your DaleMasBajo.com account.\n\n" +
            (email ? ("Your account email is: " + email + "\n\n") : "") +
            "Click OK to continue.";

        const ok = window.confirm(msg);
        if (ok) window.location.href = href;
    });
});
