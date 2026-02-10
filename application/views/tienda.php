 <div id="ajaxArea"> 
      <section class="album-header">
            <figure class="album-cover-wrap">
                <div class="album-cover_overlay"></div>
            </figure>
            <div class="container">
                <div class="cover-content">
                   <hr>
                    <div class="clearfix text-uppercase">
                        <h1 style="padding-top: 30px">NUESTRA TIENDA</h1>
                        <cite class="album-author mb-20">DALE MAS BAJO</cite>
                    </div>
                </div>
            </div>
        </section>

    <!--=================================
    Albums
    =================================-->
        <section>
           <? $this->load->view('search_box'); ?>

            <div class="container">
                 <ul class="song-list text-uppercase text-bold clearfix">
                   <?
                   $i=0;
                        foreach($products as $producto){
                            $i++;
                            ?>
                            <li id="singleSongPlayer-<? echo $i; ?>" class="song-unit singleSongPlayer clearfix" data-before="<? echo $i; ?>">
                                <div id="singleSong-jplayer-<? echo $i; ?>" class="singleSong-jplayer" data-title="<? echo $producto->name; ?>" data-mp3="<? echo base_url(); ?>assets/products/demos/<? echo $producto->demo; ?>"></div>
                                <span class="playit controls jp-controls-holder">
                                    <i class="jp-play pc-play"></i> 
                                    <i class="jp-pause pc-pause"></i>
                                </span>
                                <span class="song-title jp-title" data-before="Nombre"></span>
                                <span class="song-genero jp-genero">
                                     <? 

                                        $key = array_search($producto->gender_id, array_column($generos, 'id'));
                                        echo '<a href="'.base_url().'genero/'.$generos[$key]->id.'">'.$generos[$key]->name.'</a>';
                                    ?>
                                </span>
                                <span class="song-author" data-before="Autor">
                                    <? 

                                        $key = array_search($producto->owner_id, array_column($users, 'id'));

                                        echo $users[$key]->username;
                                    ?>

                                </span>
                                <span class="song-time jp-duration"></span>
                                <a class="song-btn" href="#">$<? echo $producto->price; ?></a>


                                    <div class="audio-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar" style="width:20%;"></div>
                                        </div><!--jp-seek-bar--> 
                                    </div><!--audio-progress--> 
                            </li> 
                            <?
                        } ?>
                 </ul>
                 <?php if (isset($links)) { ?>
                    <?php echo $links ?>
                <?php } ?>
            </div><!--container-->


        </section>
    </div>