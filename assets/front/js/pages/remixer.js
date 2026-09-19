window.addEventListener('load', function() {
    $(document).ready(function() {
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
    });
});
