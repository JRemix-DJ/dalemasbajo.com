(function($) {
    'use strict';

    function getBaseUrl() {
        return (window.DMB && window.DMB.baseUrl) ? window.DMB.baseUrl : '/';
    }

    function hideAllModals() {
        $('#modal-login, #modal-register, #modal-recover, #modal-upsell')
            .addClass('modal-hidden')
            .removeClass('modal-flex');
    }

    function openModal(modalId) {
        hideAllModals();
        $(modalId).removeClass('modal-hidden').addClass('modal-flex');
    }

    $(document).on('click', '[data-target="#myModal"], .trigger-login, #btn-login, a[href*="login"]', function(e) {
        var href = $(this).attr('href') || '';
        if (href.indexOf('logout') !== -1 || href.indexOf('admin') !== -1 || href.indexOf('micuenta') !== -1) {
            return;
        }
        if (window.DMB && window.DMB.isLoggedIn) {
            return;
        }
        e.preventDefault();
        e.stopPropagation();
        openModal('#modal-login');
        $('#login-email').trigger('focus');
    });

    $(document).on('click', '[data-target="#myModalRegistrarme"], .trigger-register, #btn-register, .btn-signup', function(e) {
        if (window.DMB && window.DMB.isLoggedIn) {
            return;
        }
        e.preventDefault();
        e.stopPropagation();
        openModal('#modal-register');
        $('#reg-email').trigger('focus');
    });

    $(document).on('click', '.trigger-recover, [data-target="#myModalRecuperar"]', function(e) {
        e.preventDefault();
        e.stopPropagation();
        openModal('#modal-recover');
        $('#rec-email').trigger('focus');
    });

    $(document).on('click', 'a[href*="download"], .btn-download, .download-btn, .btn-smart-download, #player-download-btn, [data-action="download"]', function(e) {
        if (!window.DMB || !window.DMB.isLoggedIn) {
            e.preventDefault();
            e.stopPropagation();
            hideAllModals();
            openModal('#modal-upsell');
            return false;
        }
    });

    $(document).on('click', '#modal-upsell .btn-get-started, #modal-upsell a[href*="planes"]', function(e) {
        e.preventDefault();
        hideAllModals();
        openModal('#modal-register');
    });

    $(document).on('click', '.close-modal-btn, .close-modal-trigger', function(e) {
        e.preventDefault();
        hideAllModals();
    });

    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' || e.keyCode === 27) {
            $('#modal-login, #modal-register, #modal-recover, #modal-upsell')
                .addClass('modal-hidden')
                .removeClass('modal-flex');
        }
    });

    function submitLogin() {
        var btn = $('#btn-ingresar-accion');
        var originalText = btn.text();
        var email = $('#login-email').val().trim();
        var password = $('#login-password').val();

        if (!email || !password) {
            alert('Por favor completa todos los campos.');
            return;
        }

        btn.text('Verificando...').prop('disabled', true);

        $.ajax({
            url: getBaseUrl() + 'login/front',
            type: 'POST',
            data: { email: email, password: password },
            dataType: 'json',
            success: function(res) {
                if (res.success === true || res.status === 'success' || res.status === true || res === 1) {
                    window.location.reload();
                } else {
                    alert(res.message || 'Error al iniciar sesión.');
                    btn.text(originalText).prop('disabled', false);
                }
            },
            error: function() {
                alert('Error de conexión con el servidor.');
                btn.text(originalText).prop('disabled', false);
            }
        });
    }

    $(document).on('click', '#btn-ingresar-accion', function(e) {
        e.preventDefault();
        submitLogin();
    });

    $(document).on('submit', '#login-form-new', function(e) {
        e.preventDefault();
        submitLogin();
    });

    $(document).on('keydown', '#login-email, #login-password', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            submitLogin();
        }
    });

    function submitRegister() {
        var btn = $('#btn-registrar-accion');
        var originalText = btn.text();
        var email = $('#reg-email').val().trim();
        var username = $('#reg-username').val().trim();
        var password = $('#reg-pass').val();
        var repass = $('#reg-repass').val();

        if (!email || !username || !password) {
            alert('Por favor completa todos los campos obligatorios.');
            return;
        }

        if (password !== repass) {
            alert('Las contraseñas no coinciden.');
            return;
        }

        btn.text('Registrando...').prop('disabled', true);

        $.ajax({
            url: getBaseUrl() + 'users/registro',
            type: 'POST',
            data: {
                email: email,
                username: username,
                password: password
            },
            dataType: 'json',
            success: function(data) {
                btn.text(originalText).prop('disabled', false);
                if (data.respuesta === 'ok') {
                    alert('Registro exitoso. ¡Bienvenido!');
                    window.location.reload();
                } else if (data.respuesta === 'email_existe') {
                    alert('Error: El correo electrónico ya está registrado.');
                } else if (data.respuesta === 'username_existe') {
                    alert('Error: El nombre de usuario ya está en uso.');
                } else {
                    alert('Ocurrió un error. Intenta nuevamente.');
                }
            },
            error: function() {
                alert('Error de conexión con el servidor.');
                btn.text(originalText).prop('disabled', false);
            }
        });
    }

    $(document).on('click', '#btn-registrar-accion', function(e) {
        e.preventDefault();
        submitRegister();
    });

    $(document).on('submit', '#register-form-new', function(e) {
        e.preventDefault();
        submitRegister();
    });

    $(document).on('keydown', '#reg-email, #reg-username, #reg-pass, #reg-repass', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            submitRegister();
        }
    });

    $(document).on('click', '#btn-recuperar-accion', function(e) {
        e.preventDefault();
        var email = $('#rec-email').val().trim();
        if (!email) {
            alert('Ingresa tu correo electrónico.');
            return;
        }

        var btn = $(this);
        var originalText = btn.text();
        btn.text('Enviando...').prop('disabled', true);

        $.ajax({
            url: getBaseUrl() + 'users/request_password_reset',
            type: 'POST',
            dataType: 'json',
            data: { email: email },
            success: function() {
                alert('Si el correo existe, te llegará un enlace para cambiar tu contraseña.');
                hideAllModals();
                btn.text(originalText).prop('disabled', false);
            },
            error: function() {
                alert('Error de conexión con el servidor.');
                btn.text(originalText).prop('disabled', false);
            }
        });
    });

    if (window.$ && window.$.fn && window.$.fn.modal) {
        var origModal = window.$.fn.modal;
        window.$.fn.modal = function(action) {
            var id = this.attr('id');
            if (id === 'myModal') {
                if (action === 'show' || !action) { openModal('#modal-login'); return this; }
                if (action === 'hide') { hideAllModals(); return this; }
            }
            if (id === 'myModalRegistrarme') {
                if (action === 'show' || !action) { openModal('#modal-register'); return this; }
                if (action === 'hide') { hideAllModals(); return this; }
            }
            if (id === 'myModalRecuperar') {
                if (action === 'show' || !action) { openModal('#modal-recover'); return this; }
                if (action === 'hide') { hideAllModals(); return this; }
            }
            return origModal.apply(this, arguments);
        };
    }
})(jQuery);
