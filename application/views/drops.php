<div id="ajaxArea">
<pre style="display:none;" ><? print_r($products) ?></pre>
    <section class="album-header">
        <figure class="album-cover-wrap">
            <div class="album-cover_overlay"></div>
        </figure>
        <div class="container">
            <div class="cover-content">
                <hr>
                <div class="clearfix text-uppercase">
                    <h1 style="padding-top: 30px">Drops</h1>
                    <cite class="album-author mb-20">
                </div>
            </div>
        </div>
    </section>
    <section <? if($this->session->userdata('content_type')=='videos'){ ?>id="cuerpo"<? } ?>>

        <div class="container">
            <? $this->load->view('table_products'); ?>
            <?php if (isset($links)) { ?>
                <?php echo $links ?>
            <?php } ?>
        </div>

    </section>
</div>
