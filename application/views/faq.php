 <div id="ajaxArea"> 
    <!--========================================
    Page Content
    ===========================================-->
        <div class="pageArea">    
      
            <div>
                <div class="container">
                    <article class="articleSingle">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="about-article text-center text-uppercase">
                                    <h2 class="text-semibold">FAQ</h2>
                                    
                                    <ul class="social-list">
                                        <li><a class="fa fa-facebook fb-bg" href="http://www.facebook.com/sharer/sharer.php?u=<? echo base_url(); ?>faq"></a></li>
                                        <li><a class="fa fa-twitter tweet-bg" href="http://twitter.com/intent/tweet?status=<? echo base_url(); ?>faq"></a></li>
                                    </ul>
                                </div>
                             </div>
                             <div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">   
                                <figure>
                                    <img src="<? echo base_url(); ?>images/dj-image.jpg" alt="/"/>
                                </figure>
                                <div class="panel-group" id="accordion">
                                <? 
                                $i = 0;
                                foreach($faqs as $faq){ 
                                $i++;
                                    ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<? echo $i; ?>"><? echo $faq->title; ?></a>
                                            </h4>
                                        </div>
                                        <div id="collapse<? echo $i; ?>" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <? echo $faq->content; ?>
                                            </div>
                                        </div>
                                    </div>
                                <? } ?>
                                <p><strong>Nota:</strong> Haz click en el encabezado para expandir la respuesta a la pregunta frecuente.</p>
                                </div>  
                            </div><!--column-->
                        </div><!--row-->
                    </article>
                </div><!--container-->
            </div>

            
        </div>  
    </div>