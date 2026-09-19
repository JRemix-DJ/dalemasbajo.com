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
            const res = await fetch(window.DMB.baseUrl + 'users/reset_password', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
                body: new URLSearchParams({ email, token, pass, rpass }).toString()
            });

            const data = await res.json().catch(() => null);

            if (data && data.success) {
                showMsg('ok', 'Password updated. Redirecting…');
                setTimeout(() => window.location.href = window.DMB.baseUrl, 900);
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
