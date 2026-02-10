<div id="ajaxArea"> 
        <section class="album-header">
            <figure class="album-cover-wrap">
                <div class="album-cover_overlay"></div>
            </figure>
            <div class="container">
                <div class="cover-content">
                   <hr>
                    <div class="clearfix text-uppercase">
                        <h1 style="padding-top: 30px">GÉNEROS</h1>
                        <cite class="album-author mb-20">DALE MAS BAJO</cite>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="album-grid-wrap style2">
                            <div class="album-grid text-uppercase clearfix">
                                <? foreach($generos as $genero){ ?>
                                    <a href="<? echo base_url(); ?>genero/<? echo $genero->id; ?>" class="album-unit">
                                        <figure>
                                            <img src="<? echo base_url(); ?>images/generos/<? echo $genero->img; ?>" alt="" width="265" height="265">
                                            <figcaption>
                                                <span></span>
                                                <h3><? echo $genero->name; ?></h3>
                                            </figcaption>
                                        </figure>
                                    </a>
                                <? } ?>
                            </div><!--album-grid-->
                         </div><!--album-grid-wrap-->  
                    </div><!--column-->     
                </div><!--row-->
            </div><!--container-->
        </section>
    </div>