(function($) {
    'use strict';

    var currentTrackId = null;

    function getAudioElement() {
        return document.getElementById('main-audio') || document.getElementById('main-audio-element');
    }

    function formatTime(seconds) {
        if (isNaN(seconds) || seconds < 0) return '0:00';
        var min = Math.floor(seconds / 60);
        var sec = Math.floor(seconds % 60);
        return min + ':' + (sec < 10 ? '0' + sec : sec);
    }

    function getPlayerCoverFallback() {
        var base = (window.DMB && window.DMB.baseUrl) ? window.DMB.baseUrl : '/';
        return base + 'assets/front/img/default_cover.jpg';
    }

    function showPlayerBar() {
        $('#music-player-bar').removeClass('translate-y-full');
    }

    function hidePlayerBar() {
        $('#music-player-bar').addClass('translate-y-full');
    }

    function setRowIcon(id, isPlaying) {
        var btn = $('.play_btn[data-id="' + id + '"]');
        if (!btn.length) return;
        var i = btn.find('i');
        i.removeClass('fa-play fa-pause fa-stop fa-solid fa ml-0.5 pl-1');
        if (isPlaying) {
            i.addClass('fa-solid fa-pause');
        } else {
            i.addClass('fa-solid fa-play ml-0.5');
        }
    }

    function resetAllRowIcons() {
        $('.play_btn i').each(function() {
            $(this).removeClass('fa-pause fa-stop fa-solid fa ml-0.5 pl-1').addClass('fa-solid fa-play ml-0.5');
        });
    }

    function setPlayerPlayingUI() {
        $('#player-play-btn i').removeClass('fa-play pl-1 fa').addClass('fa-solid fa-pause');
        if (currentTrackId !== null) setRowIcon(currentTrackId, true);
    }

    function setPlayerPausedUI() {
        $('#player-play-btn i').removeClass('fa-pause fa-solid').addClass('fa fa-play pl-1');
        if (currentTrackId !== null) setRowIcon(currentTrackId, false);
    }

    function playTrack(data) {
        var audio = getAudioElement();
        if (!audio) return;

        var id = String(data.id);
        var previewUrl = data.previewUrl;
        var title = data.title || 'Remix';
        var artist = data.artist || 'DJ';
        var cover = data.cover || getPlayerCoverFallback();

        if (currentTrackId !== null && String(currentTrackId) === id) {
            if (!audio.paused) {
                audio.pause();
                setPlayerPausedUI();
            } else {
                var resumePromise = audio.play();
                if (resumePromise !== undefined) {
                    resumePromise.then(setPlayerPlayingUI).catch(function() {});
                } else {
                    setPlayerPlayingUI();
                }
            }
            return;
        }

        if (currentTrackId !== null) {
            setRowIcon(currentTrackId, false);
        } else {
            resetAllRowIcons();
        }

        currentTrackId = id;

        $('#player-title').text(title);
        $('#player-artist').text(artist);
        $('#player-cover').attr('src', cover);

        var playerDlBtn = $('#player-download-btn');
        playerDlBtn.data('id', id);

        var rowDl = data.triggerBtn ? data.triggerBtn.closest('tr').find('.btn-smart-download') : [];
        if (rowDl.length) {
            playerDlBtn.data('logged', rowDl.data('logged'));
            playerDlBtn.data('access', rowDl.data('access'));
        } else {
            var isLogged = (window.DMB && window.DMB.isLoggedIn) ? 1 : 0;
            playerDlBtn.data('logged', isLogged);
            playerDlBtn.data('access', isLogged);
        }

        audio.src = previewUrl;
        audio.load();

        $('#player-progress, #progress-bar').css('width', '0%');
        $('#progress-thumb').css('left', '0%');
        $('#player-current-time, #current-time').text('0:00');
        $('#player-duration, #total-time').text('0:00');

        showPlayerBar();

        var playPromise = audio.play();
        if (playPromise !== undefined) {
            playPromise.then(function() {
                setPlayerPlayingUI();
            }).catch(function(err) {
                console.warn('Playback error:', err);
                setPlayerPausedUI();
            });
        }
    }

    $(document).on('click', '.play_btn', function(e) {
        e.preventDefault();
        var btn = $(this);
        var previewUrl = btn.data('preview') || btn.data('demo') || btn.attr('data-preview') || btn.attr('data-demo');
        var title = btn.data('title') || 'Remix';
        var artist = btn.data('artist') || 'DJ';
        var cover = btn.data('cover') || btn.data('image') || getPlayerCoverFallback();
        var id = btn.data('id') || btn.attr('data-id');

        if (!previewUrl) return;

        var base = (window.DMB && window.DMB.baseUrl) ? window.DMB.baseUrl : '/';
        if (!previewUrl.startsWith('http') && !previewUrl.startsWith('/')) {
            previewUrl = base + previewUrl;
        }

        playTrack({ id: id, title: title, artist: artist, cover: cover, previewUrl: previewUrl, triggerBtn: btn });
    });

    $(document).on('click', '#player-play-btn', function(e) {
        e.preventDefault();
        var audio = getAudioElement();
        if (!currentTrackId || !audio) return;

        if (audio.paused) {
            var p = audio.play();
            if (p !== undefined) {
                p.then(setPlayerPlayingUI).catch(function() {});
            } else {
                setPlayerPlayingUI();
            }
        } else {
            audio.pause();
            setPlayerPausedUI();
        }
    });

    $(document).on('click', '#player-progress-container, #progress-container', function(e) {
        var audio = getAudioElement();
        if (!audio || isNaN(audio.duration) || audio.duration <= 0) return;

        var rect = this.getBoundingClientRect();
        var clickX = e.clientX - rect.left;
        var width = rect.width;
        if (width > 0) {
            var newTime = (clickX / width) * audio.duration;
            audio.currentTime = Math.max(0, Math.min(newTime, audio.duration));
        }
    });

    function updateVolumeVisual(val) {
        var percentage = val * 100;
        $('#player-volume, #volume-slider').css('background', 'linear-gradient(to right, #2563EB ' + percentage + '%, #e2e8f0 ' + percentage + '%)');
        var iconVol = $('#mute-btn i');
        iconVol.removeClass('fa-volume-high fa-volume-low fa-volume-off fa-volume-xmark');
        if (val === 0) iconVol.addClass('fa-volume-xmark');
        else if (val < 0.5) iconVol.addClass('fa-volume-low');
        else iconVol.addClass('fa-volume-high');
    }

    $(document).on('input', '#player-volume, #volume-slider', function() {
        var audio = getAudioElement();
        var val = parseFloat($(this).val());
        if (audio) audio.volume = val;
        updateVolumeVisual(val);
    });

    $(document).on('click', '#mute-btn', function() {
        var audio = getAudioElement();
        if (!audio) return;
        var slider = $('#player-volume, #volume-slider');

        if (audio.volume > 0) {
            $(this).data('prev-vol', audio.volume);
            audio.volume = 0;
            slider.val(0);
            updateVolumeVisual(0);
        } else {
            var prev = $(this).data('prev-vol') || 1;
            audio.volume = prev;
            slider.val(prev);
            updateVolumeVisual(prev);
        }
    });

    $(document).on('click', '#skip-back-btn', function() {
        var audio = getAudioElement();
        if (audio) audio.currentTime = Math.max(0, audio.currentTime - 10);
    });

    $(document).on('click', '#skip-fwd-btn', function() {
        var audio = getAudioElement();
        if (audio && !isNaN(audio.duration)) audio.currentTime = Math.min(audio.duration, audio.currentTime + 10);
    });

    function initAudioEvents() {
        var audio = getAudioElement();
        if (!audio) return;

        audio.addEventListener('loadedmetadata', function() {
            $('#player-duration, #total-time').text(formatTime(audio.duration));
        });

        audio.addEventListener('timeupdate', function() {
            if (!isNaN(audio.duration) && audio.duration > 0) {
                var percent = (audio.currentTime / audio.duration) * 100;
                $('#player-progress, #progress-bar').css('width', percent + '%');
                $('#progress-thumb').css('left', percent + '%');
                $('#player-current-time, #current-time').text(formatTime(audio.currentTime));
            }
        });

        audio.addEventListener('ended', function() {
            setPlayerPausedUI();
            $('#player-progress, #progress-bar').css('width', '0%');
            $('#progress-thumb').css('left', '0%');
            $('#player-current-time, #current-time').text('0:00');
        });

        updateVolumeVisual(audio.volume !== undefined ? audio.volume : 1);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAudioEvents);
    } else {
        initAudioEvents();
    }
})(jQuery);
