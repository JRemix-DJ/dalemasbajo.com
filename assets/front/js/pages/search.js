(function ($) {
    var audio = document.getElementById('main-audio-element');
    var playBtn = $('#player-play-btn');
    var icon = playBtn.find('i');

    var progressBar = $('#progress-bar');
    var progressThumb = $('#progress-thumb');
    var progressContainer = $('#progress-container');
    var currentTimeEl = $('#current-time');
    var totalTimeEl = $('#total-time');

    var volumeSlider = $('#volume-slider');
    var muteBtn = $('#mute-btn');

    function formatTime(seconds) {
        if(isNaN(seconds)) return "0:00";
        var min = Math.floor(seconds / 60);
        var sec = Math.floor(seconds % 60);
        return min + ":" + (sec < 10 ? "0" + sec : sec);
    }

    audio.addEventListener('play', function() {
        icon.removeClass('fa-play pl-1').addClass('fa-pause');
    });

    audio.addEventListener('pause', function() {
        icon.removeClass('fa-pause').addClass('fa-play pl-1');
    });

    audio.addEventListener('ended', function() {
        progressBar.css('width', '0%');
        progressThumb.css('left', '0%');
        currentTimeEl.text("0:00");
    });

    audio.addEventListener('timeupdate', function() {
        if (!isNaN(audio.duration)) {
            var percent = (audio.currentTime / audio.duration) * 100;
            progressBar.css('width', percent + '%');
            progressThumb.css('left', percent + '%');
            currentTimeEl.text(formatTime(audio.currentTime));
        }
    });

    audio.addEventListener('loadedmetadata', function() {
        totalTimeEl.text(formatTime(audio.duration));
    });

    playBtn.off('click').on('click', function(e) {
        e.preventDefault();
        if (audio.paused) {
            var playPromise = audio.play();
            if (playPromise !== undefined) {
                playPromise.catch(function(error) {
                    console.error("ERROR PLAY PROMISE:", error);
                });
            }
        } else {
            audio.pause();
        }
    });

    $(document).on('click', '.play_btn', function(e) {
        e.preventDefault();
        var btn = $(this);

        var demoUrl = btn.data('demo');
        var title = btn.data('title');
        var artist = btn.data('artist');
        var cover = btn.data('cover');
        var id = btn.data('id');

        $('#player-title').text(title);
        $('#player-artist').text(artist);
        $('#player-cover').attr('src', cover);

        var playerDlBtn = $('#player-download-btn');
        playerDlBtn.data('id', id);

        var originalDownloadBtn = btn.closest('tr').find('.btn-smart-download');
        if(originalDownloadBtn.length) {
            playerDlBtn.data('logged', originalDownloadBtn.data('logged'));
            playerDlBtn.data('access', originalDownloadBtn.data('access'));
        } else {
            playerDlBtn.data('logged', window.DMB.isLoggedIn ? 1 : 0);
            playerDlBtn.data('access', 0);
        }

        var currentSrc = decodeURIComponent(audio.src);
        var newSrc = decodeURIComponent(demoUrl);

        if (currentSrc === newSrc || audio.src.indexOf(demoUrl) !== -1) {
            if (audio.paused) {
                audio.play();
            } else {
                audio.pause();
            }
        } else {
            audio.src = demoUrl;
            audio.load();
            progressBar.css('width', '0%');
            progressThumb.css('left', '0%');

            var playPromise = audio.play();
            if (playPromise !== undefined) {
                playPromise.catch(function(error) {
                    console.error("Error al reproducir nueva:", error);
                });
            }
        }

        $('#music-player-bar').removeClass('translate-y-full');
    });

    function updateVolumeVisual(val) {
        var percentage = val * 100;
        volumeSlider.css('background', 'linear-gradient(to right, #2563EB ' + percentage + '%, #e2e8f0 ' + percentage + '%)');

        var iconVol = muteBtn.find('i');
        iconVol.removeClass('fa-volume-high fa-volume-low fa-volume-off fa-volume-xmark');

        if(val <= 0.01) {
            iconVol.addClass('fa-volume-xmark');
        } else if(val < 0.5) {
            iconVol.addClass('fa-volume-low');
        } else {
            iconVol.addClass('fa-volume-high');
        }
    }

    updateVolumeVisual(1);

    volumeSlider.on('input', function() {
        var val = parseFloat($(this).val());
        audio.volume = val;
        audio.muted = (val === 0);
        updateVolumeVisual(val);
    });

    muteBtn.click(function(e) {
        e.preventDefault();

        if (audio.muted || audio.volume === 0) {
            audio.muted = false;
            var prevVol = $(this).data('prev-vol') || 1;
            audio.volume = prevVol;
            volumeSlider.val(prevVol);
            updateVolumeVisual(prevVol);
        } else {
            $(this).data('prev-vol', audio.volume);
            audio.muted = true;
            audio.volume = 0;
            volumeSlider.val(0);
            updateVolumeVisual(0);
        }
    });

    $(document).on('click', '#pagination-container a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if(!url || url === '#' || url === '') return;

        $('#table-body-content').addClass('opacity-50');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    $('#table-body-content').html(response.html_table);
                    $('#pagination-container').html(response.html_pagination);
                    window.history.pushState({path: url}, '', url);
                    $('html, body').animate({ scrollTop: $('#table-body-content').offset().top - 150 }, 500);
                }
            },
            complete: function() {
                $('#table-body-content').removeClass('opacity-50');
            }
        });
    });

    $('#skip-back-btn').click(function(e) { e.preventDefault(); audio.currentTime = Math.max(0, audio.currentTime - 10); });
    $('#skip-fwd-btn').click(function(e) { e.preventDefault(); audio.currentTime = Math.min(audio.duration, audio.currentTime + 10); });

    function downloadViaIframe(url) {
        var iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = url;
        document.body.appendChild(iframe);
        setTimeout(function() {
            if (iframe.parentNode) iframe.parentNode.removeChild(iframe);
        }, 60000);
    }

    $(document).on('click', '.btn-smart-download, .btn-download, #player-download-btn', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var btn = $(this);
        var id = btn.data('id') || btn.attr('data-id');
        var logged = parseInt(btn.data('logged'), 10);
        var access = parseInt(btn.data('access'), 10);

        if (isNaN(logged)) {
            logged = (window.DMB && window.DMB.isLoggedIn) ? 1 : 0;
        }

        if (!logged) {
            $('#modal-login, #modal-register, #modal-recover').addClass('modal-hidden').removeClass('modal-flex');
            $('#modal-upsell').removeClass('modal-hidden').addClass('modal-flex');
            return;
        }

        if (!access && access !== undefined && !isNaN(access)) {
            window.location.href = (window.DMB ? window.DMB.baseUrl : '/') + 'planes';
            return;
        }

        var dlUrl = (window.DMB ? window.DMB.baseUrl : '/') + 'audios/download/' + id;
        downloadViaIframe(dlUrl);

        var audioId = String(id);
        if (window.DMB) {
            if (!Array.isArray(window.DMB.userProducts)) {
                window.DMB.userProducts = [];
            }
            if (window.DMB.userProducts.indexOf(audioId) === -1) {
                window.DMB.userProducts.push(audioId);
            }
        }

        var isUnlimited = (window.DMB && window.DMB.isUnlimited);
        if (!isUnlimited) {
            $('#cantidad_tokens, .token-count').each(function() {
                var current = parseInt($(this).text(), 10);
                if (!isNaN(current) && current > 0) {
                    $(this).text(current - 1);
                    if (current - 1 <= 0) {
                        btn.data('access', 0);
                    }
                }
            });
        }

        $('.btn-smart-download[data-id="' + audioId + '"]').each(function() {
            var b = $(this);
            b.removeClass('text-slate-500 hover:border-primary hover:text-primary hover:bg-blue-50')
             .addClass('btn-downloaded bg-primary text-white shadow-lg shadow-blue-500/30 hover:bg-blue-700')
             .attr('data-downloaded', 'true')
             .attr('title', 'Downloaded');
        });
    });
}(jQuery));
