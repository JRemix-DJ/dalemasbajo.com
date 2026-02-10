<div id="ajaxArea"> 
    <!--=================================
    Main Slider
    =================================-->
        <section class="custom-slider">
          <div id="home-slider" class="xv_slider flexslider">
            <ul class="slides">
                <? 
                if($banners!=null){
                    foreach($banners as $banner){
                        ?>
                         <li class="xv_slide" data-slidebg="url('')">
                            <a href="<? echo $banner->url; ?>">
                            <img src="https://dalemasbajo.com/images/banners/<? echo $banner->image; ?>" alt="">
                            </a>
                          </li>
                         
                        <?
                    }
                }
                ?>
            </ul>
          </div>
        </section>
    <!--=================================================
    TOP songs /Trendding This week / Featured Songs
    ==================================================-->
        <section id="cuerpo">
            <? $this->load->view('search_box'); ?>

            <div class="container search-container">
                <div class="search-filters text-uppercase text-bold">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-5">
                            <? if(isset($_GET['s'])){ ?>
                            <div class="searched-for" data-before="Results For : ">
                                <span class="s-keyword">Hip-Hop</span>
                            </div>
                            <? } ?>
                        </div>
                       
                    </div>
                </div><!--row-->
            </div><!--container-->

            <div class="container">
                <? $this->load->view('table_products'); ?>
                <?php if (isset($links)) { ?>
                    <?php echo $links ?>
                <?php } ?>
            </div>
        </section>    
    
    </div>
