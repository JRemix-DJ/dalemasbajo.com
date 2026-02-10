 <div id="ajaxArea"> 
      <section class="album-header">
            <figure class="album-cover-wrap">
                <div class="album-cover_overlay"></div>
            </figure>
            <div class="container">
                <div class="cover-content">
                   <hr>
                    <div class="clearfix text-uppercase">
                        <h1 style="padding-top: 30px"><? echo $genero->name; ?></h1>
                    </div>
                </div>
            </div>
        </section>

    <!--=================================
    Albums
    =================================-->
        <section <? if($this->session->userdata('content_type')=='videos'){ ?>id="cuerpo"<? } ?>>
            <? $this->load->view('search_box'); ?>

            <div class="container">
                <? if($this->session->userdata('content_type')=='videos'){ ?>
                    <? $this->load->view('table_videos'); ?>
                <? }else{ ?>
                    <? $this->load->view('table_products'); ?>
                <? } ?>
                <?php if (isset($links)) { ?>
                    <?php echo $links ?>
                <?php } ?>
            </div>

        </section>
    </div>