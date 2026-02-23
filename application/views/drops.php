<div id="ajaxArea" class="bg-white min-h-screen">
    <section class="album-header relative w-full overflow-hidden flex items-center justify-center text-center bg-white py-16">
        <div class="container relative z-10 flex flex-col items-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 tracking-tight mb-4 font-heading drop-shadow-sm uppercase">
                Exclusive Drops
            </h1>
            <p class="text-lg text-slate-500 font-medium max-w-2xl">
                Limited edition remix packs curated by the world's top DJs
            </p>
        </div>
    </section>

    <section class="pb-16 md:pb-24 bg-white">
        <div class="container mx-auto px-4">

            <div id="table-body-content" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <?php if(isset($products) && !empty($products)) { ?>
                    <?php foreach($products as $producto) { ?>
                        <?php
                        $img = !empty($producto->featured_image)
                                ? base_url().ltrim($producto->featured_image, '/')
                                : base_url().'images/default_cover.jpg';

                        $demo_url = !empty($producto->demo)
                                ? base_url().'assets/products/demos/'.$producto->demo
                                : '';

                        $title = !empty($producto->name) ? $producto->name : 'Exclusive Drop';
                        $author = !empty($producto->artist) ? $producto->artist : 'Dale Más Bajo';

                        $desc = !empty($producto->description)
                                ? $producto->description
                                : 'Limited edition drop pack ready for your sets.';

                        $buy_url = !empty($producto->payment_link)
                                ? $producto->payment_link
                                : base_url('drops/get_drop?drop_id='.$producto->id);

                        $tags = ['Exclusive', 'Drops'];
                        if(!empty($producto->version)) $tags[] = $producto->version;

                        $is_logged = $this->session->userdata('is_logued_in') ? 1 : 0;
                        $has_access = ($this->session->userdata('is_user_unlimited') || (int)$this->session->userdata('tokens') > 0) ? 1 : 0;
                        ?>

                        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                            <div class="relative h-72 md:h-80">
                                <img
                                        src="<?php echo $img; ?>"
                                        class="w-full h-full object-cover"
                                        alt="<?php echo htmlspecialchars($title, ENT_QUOTES); ?>"
                                >

                                <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>

                                <button
                                        type="button"
                                        class="play_btn absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-16 h-16 rounded-full bg-white/90 backdrop-blur flex items-center justify-center shadow-xl opacity-0 group-hover:opacity-100 transition-all duration-200 hover:scale-105 active:scale-95"
                                        data-id="<?php echo (int)$producto->id; ?>"
                                        data-source="drops"
                                        data-demo="<?php echo $demo_url; ?>"
                                        data-cover="<?php echo $img; ?>"
                                        data-title="<?php echo htmlspecialchars($title, ENT_QUOTES); ?>"
                                        data-artist="<?php echo htmlspecialchars($author, ENT_QUOTES); ?>"
                                        data-logged="<?php echo $is_logged; ?>"
                                        data-access="<?php echo $has_access; ?>"
                                        <?php echo empty($demo_url) ? 'disabled' : ''; ?>
                                >
                                    <i class="fa fa-play text-primary text-xl ml-1"></i>
                                </button>

                                <div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur px-4 py-2 rounded-full shadow flex items-center gap-2">
                                    <span class="text-primary font-bold">$</span>
                                    <span class="font-bold text-slate-900">$<?php echo number_format((float)$producto->price, 2); ?></span>
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="text-lg md:text-xl font-semibold text-slate-900 mb-1">
                                    <?php echo htmlspecialchars($title, ENT_QUOTES); ?>
                                </h3>

                                <p class="text-primary text-sm font-semibold mb-3">
                                    by <?php echo htmlspecialchars($author, ENT_QUOTES); ?>
                                </p>

                                <p class="text-sm text-slate-500 leading-relaxed mb-5">
                                    <?php echo htmlspecialchars($desc, ENT_QUOTES); ?>
                                </p>

                                <div class="flex flex-wrap gap-2 mb-6">
                                    <?php foreach($tags as $t){ ?>
                                        <span class="text-xs bg-slate-100 text-slate-700 px-3 py-1 rounded-full">
                                            <?php echo htmlspecialchars($t, ENT_QUOTES); ?>
                                        </span>
                                    <?php } ?>
                                </div>

                                <?php if(!$this->session->userdata('is_logued_in')){ ?>
                                    <a href="#"
                                       data-target="#myModal"
                                       class="block text-center w-full py-4 rounded-2xl font-bold text-white bg-gradient-to-r from-primary to-slate-900 hover:shadow-lg hover:shadow-blue-500/20 transition-all duration-200">
                                        Buy Now
                                    </a>
                                <?php } else { ?>
                                    <a href="<?php echo base_url('drops/checkout_drop?drop_id='.(int)$producto->id); ?>"
                                       class="block text-center w-full py-4 rounded-2xl font-bold text-white bg-gradient-to-r from-primary to-slate-900 hover:shadow-lg hover:shadow-blue-500/20 transition-all duration-200">
                                        Buy Now
                                    </a>
                                <?php } ?>
                            </div>
                        </div>

                    <?php } ?>
                <?php } else { ?>
                    <div class="col-span-full flex flex-col items-center justify-center py-24 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4 text-slate-300">
                            <i class="fa-solid fa-music text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">No drops available</h3>
                        <p class="text-sm text-slate-500 max-w-sm mx-auto mt-2">
                            Try again later or check back soon for new exclusive drops.
                        </p>
                    </div>
                <?php } ?>
            </div>

            <div class="mt-12 flex justify-center">
                <div class="pagination-modern" id="pagination-container">
                    <?php if (isset($links)) { echo $links; } ?>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    window.addEventListener('load', function() {
        $(document).on('click', '#pagination-container a', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');
            if(!url || url === '#' || url === '') return;

            $('#table-body-content').addClass('opacity-50 pointer-events-none');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response && response.status === 'success') {
                        $('#table-body-content').html(response.html_table);
                        $('#pagination-container').html(response.html_pagination);
                        window.history.pushState({path: url}, '', url);
                        $('html, body').animate({ scrollTop: $("#table-body-content").offset().top - 150 }, 500);
                    }
                },
                complete: function() {
                    $('#table-body-content').removeClass('opacity-50 pointer-events-none');
                }
            });
        });
    });
</script>