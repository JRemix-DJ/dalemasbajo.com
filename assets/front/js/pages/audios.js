$(function() {
    var audio = document.getElementById('main-audio-element');
    var playBtn = $('#player-play-btn');
    var playerIcon = playBtn.find('i');
    var progressBar = $('#progress-bar');
    var progressThumb = $('#progress-thumb');
    var progressContainer = $('#progress-container');
    var currentTimeEl = $('#current-time');
    var totalTimeEl = $('#total-time');
    var volumeSlider = $('#volume-slider');
    var currentTrackId = null;

    function formatTime(seconds) {
        if (isNaN(seconds)) return "0:00";
        var min = Math.floor(seconds / 60);
        var sec = Math.floor(seconds % 60);
        return min + ":" + (sec < 10 ? "0" + sec : sec);
    }

    function setRowIcon(id, isPlaying) {
        var btn = $('.play_btn[data-id="' + id + '"]');
        if (!btn.length) return;
        var i = btn.find('i');
        i.removeClass('fa-solid fa-play fa-solid fa-stop ml-0.5');
        if (isPlaying) i.addClass('fa-solid fa-stop');
        else i.addClass('fa-solid fa-play ml-0.5');
    }

    function resetAllRowIcons() {
        $('.play_btn i').each(function() {
            $(this).removeClass('fa-solid fa-stop fa-solid fa-play ml-0.5').addClass('fa-solid fa-play ml-0.5');
        });
    }

    function showPlayerBar() {
        $('#music-player-bar').removeClass('translate-y-full');
    }

    function hidePlayerBar() {
        $('#music-player-bar').addClass('translate-y-full');
    }

    function setPlayerPausedUI() {
        playerIcon.removeClass('fa-solid fa-pause').addClass('fa fa-play pl-1');
        if (currentTrackId !== null) setRowIcon(currentTrackId, false);
    }

    function setPlayerPlayingUI() {
        playerIcon.removeClass('fa fa-play pl-1').addClass('fa-solid fa-pause');
        if (currentTrackId !== null) setRowIcon(currentTrackId, true);
    }

    function playCurrent() {
        if (!audio || !audio.src) return;
        var p = audio.play();
        if (p && p.then) {
            p.then(function() { setPlayerPlayingUI(); }).catch(function() {});
        } else {
            setPlayerPlayingUI();
        }
    }

    function pauseCurrent() {
        if (!audio) return;
        audio.pause();
        setPlayerPausedUI();
    }

    function stopPlayback() {
        if (!audio) return;
        if (currentTrackId !== null) setRowIcon(currentTrackId, false);
        audio.pause();
        audio.currentTime = 0;
        try { audio.removeAttribute('src'); } catch (e) {}
        audio.load();

        currentTrackId = null;
        playerIcon.removeClass('fa-pause').addClass('fa fa-play pl-1');
        $('#player-title').text('Select a track');
        $('#player-artist').text('DALE MAS BAJO');
        $('#player-cover').attr('src', '');
        progressBar.css('width', '0%');
        progressThumb.css('left', '0%');
        currentTimeEl.text('0:00');
        totalTimeEl.text('0:00');
        hidePlayerBar();
    }

    $(document).on('click', '.play_btn', function(e) {
        e.preventDefault();
        var btn = $(this);
        var demoUrl = btn.data('demo');
        var title = btn.data('title');
        var artist = btn.data('artist');
        var cover = btn.data('cover');
        var id = String(btn.data('id'));
        var source = btn.data('source');

        if (currentTrackId !== null && String(currentTrackId) === id && audio && !audio.paused) {
            stopPlayback();
            return;
        }

        if (currentTrackId !== null && String(currentTrackId) !== id) {
            setRowIcon(currentTrackId, false);
        } else if (currentTrackId === null) {
            resetAllRowIcons();
        }

        currentTrackId = id;
        $('#player-title').text(title);
        $('#player-artist').text(artist);
        $('#player-cover').attr('src', cover);

        var playerDlBtn = $('#player-download-btn');
        playerDlBtn.data('id', id);

        if (source === 'drops') {
            playerDlBtn.hide();
        } else {
            playerDlBtn.show();
        }

        var originalDownloadBtn = btn.closest('tr').find('.btn-smart-download');
        if (originalDownloadBtn.length) {
            playerDlBtn.data('logged', originalDownloadBtn.data('logged'));
            playerDlBtn.data('access', originalDownloadBtn.data('access'));
        } else {
            var isLogged = (window.DMB && window.DMB.isLoggedIn) ? 1 : 0;
            playerDlBtn.data('logged', isLogged);
            playerDlBtn.data('access', isLogged);
        }

        if (audio && audio.src !== demoUrl) {
            audio.src = demoUrl;
            audio.load();
            progressBar.css('width', '0%');
            progressThumb.css('left', '0%');
            currentTimeEl.text('0:00');
            totalTimeEl.text('0:00');
        }

        showPlayerBar();
        playCurrent();
    });

    playBtn.off('click').on('click', function() {
        if (!currentTrackId || !audio) return;
        if (audio.paused) playCurrent();
        else pauseCurrent();
    });

    if (audio) {
        audio.addEventListener('loadedmetadata', function() {
            totalTimeEl.text(formatTime(audio.duration));
        });

        audio.addEventListener('timeupdate', function() {
            if (!isNaN(audio.duration) && audio.duration > 0) {
                var percent = (audio.currentTime / audio.duration) * 100;
                progressBar.css('width', percent + '%');
                progressThumb.css('left', percent + '%');
                currentTimeEl.text(formatTime(audio.currentTime));
            }
        });

        audio.addEventListener('ended', function() {
            stopPlayback();
        });
    }

    progressContainer.off('click').on('click', function(e) {
        if (!audio) return;
        var width = $(this).width();
        var clickX = e.offsetX;
        var duration = audio.duration;
        if (!isNaN(duration)) audio.currentTime = (clickX / width) * duration;
    });

    function updateVolumeVisual(val) {
        var percentage = val * 100;
        volumeSlider.css('background', 'linear-gradient(to right, #2563EB ' + percentage + '%, #e2e8f0 ' + percentage + '%)');
        var iconVol = $('#mute-btn i');
        iconVol.removeClass('fa-volume-high fa-volume-low fa-volume-off fa-volume-xmark');
        if (val === 0) iconVol.addClass('fa-volume-xmark');
        else if (val < 0.5) iconVol.addClass('fa-volume-low');
        else iconVol.addClass('fa-volume-high');
    }

    updateVolumeVisual(1);

    volumeSlider.off('input').on('input', function() {
        var val = parseFloat($(this).val());
        if (audio) audio.volume = val;
        updateVolumeVisual(val);
    });

    $('#mute-btn').off('click').on('click', function() {
        if (!audio) return;
        if (audio.volume > 0) {
            $(this).data('prev-vol', audio.volume);
            audio.volume = 0;
            volumeSlider.val(0);
            updateVolumeVisual(0);
        } else {
            var prev = $(this).data('prev-vol') || 1;
            audio.volume = prev;
            volumeSlider.val(prev);
            updateVolumeVisual(prev);
        }
    });

    $('#skip-back-btn').on('click', function() {
        if (audio) audio.currentTime = Math.max(0, audio.currentTime - 10);
    });

    $('#skip-fwd-btn').on('click', function() {
        if (audio && !isNaN(audio.duration)) audio.currentTime = Math.min(audio.duration, audio.currentTime + 10);
    });

    $(document).on('click', '#pagination-container a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (!url || url === '#' || url === '') return;

        $('#table-loader').removeClass('hidden');
        $('#table-body-content').addClass('opacity-50');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#table-body-content').html(response.html_table);
                    $('#pagination-container').html(response.html_pagination);
                    window.history.pushState({path: url}, '', url);
                    $('html, body').animate({
                        scrollTop: $("#table-body-content").offset().top - 150
                    }, 500);
                }
            },
            error: function() {
                window.location.href = url;
            },
            complete: function() {
                $('#table-loader').addClass('hidden');
                $('#table-body-content').removeClass('opacity-50');
            }
        });
    });

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

        var btn  = $(this);
        var id   = btn.data('id') || btn.attr('data-id');
        var logged = parseInt(btn.data('logged'), 10);
        var access = parseInt(btn.data('access'), 10);

        if (isNaN(logged)) {
            logged = (window.DMB && window.DMB.userId) ? 1 : 0;
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

    (function initHeroBanner() {
        var root = document.getElementById('heroBanner');
        if (!root) return;

        var basePath = (root.dataset.base || '').replace(/\/?$/, '/');
        var banners = [];
        try {
            banners = JSON.parse(root.dataset.banners || '[]') || [];
        } catch (e) {
            banners = [];
        }

        var videoLayer = root.querySelector('[data-video-layer]');
        var dotsWrap = root.querySelector('[data-dots]');
        var idx = 0;

        function makeDot(active) {
            var b = document.createElement('button');
            b.type = 'button';
            b.className = 'h-2.5 w-2.5 rounded-full transition-all ' + (active ? 'bg-white w-6' : 'bg-white/40 hover:bg-white/70');
            return b;
        }

        function renderDots() {
            if (!dotsWrap) return;
            dotsWrap.innerHTML = '';
            if (banners.length <= 1) return;

            banners.forEach(function(_, i) {
                var dot = makeDot(i === idx);
                dot.addEventListener('click', function() { go(i); });
                dotsWrap.appendChild(dot);
            });
        }

        function mountVideo() {
            if (!videoLayer) return;
            videoLayer.innerHTML = '';
            var b = banners[idx];
            var baseUrl = (window.DMB && window.DMB.baseUrl) ? window.DMB.baseUrl : '/';
            var src = (b && b.image) ? (basePath + b.image) : (baseUrl + 'assets/new_video.mp4');

            var v = document.createElement('video');
            v.className = 'h-full w-full object-cover';
            v.autoplay = true;
            v.muted = true;
            v.playsInline = true;
            v.loop = (banners.length <= 1);

            var s = document.createElement('source');
            s.src = src;
            s.type = 'video/mp4';
            v.appendChild(s);

            v.addEventListener('ended', function() { next(); });
            v.addEventListener('canplay', function() {
                v.play().catch(function() {});
            });

            videoLayer.appendChild(v);
        }

        function next() {
            if (!banners.length) return;
            idx = (idx + 1) % banners.length;
            mountVideo();
            renderDots();
        }

        function go(i) {
            if (!banners.length) return;
            idx = i;
            mountVideo();
            renderDots();
        }

        mountVideo();
        renderDots();
    })();
});
