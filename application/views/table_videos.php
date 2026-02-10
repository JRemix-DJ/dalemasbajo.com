<table class="table clearfix canciones">
                    <thead> 
                        <tr>
                            <th class="">Preview</th>
                            <th class="">Remixer</th>
                            <th>Canción</th>
                           
                            <? if(isset($genero)){ ?>
                                <? if($genero->id==45){ ?>
                                    <th class="tcenter">Precio</th>
                                <? }else{ ?>
                                    <? if(MONEY_PAYMENTS){ ?>
                                        <? if($this->session->userdata('is_user_tokens')==false||$this->session->userdata('tokens_video')==0){ ?>
                                            <th class="tcenter">Comprar</th>
                                        <? }else{ ?>
                                            <th class="tcenter">Descargar</th>
                                        <? } ?>
                                    <? }else{ ?>
                                        <th class="tcenter">Descargar</th>
                                    <? } ?>
                                <? } ?>
                            <?  }else{ ?>
                                <? if(MONEY_PAYMENTS){ ?>
                                    <? if($this->session->userdata('is_user_tokens')==false||$this->session->userdata('tokens_video')==0){ ?>
                                            <th class="tcenter">Comprar</th>
                                    <? }else{ ?>
                                            <th class="tcenter">Descargar</th>
                                    <? } ?>
                                <? }else{ ?>
                                    <th class="tcenter">Descargar</th>
                                <? } ?>
                            <? } ?>
                        </tr>
                    </thead>
                    <tbody>
                         <?
                        $i=0;
                        if(!empty($products)){
                        foreach($products as $producto){
                            $i++;
                            ?>
                            <tr id="singleVideoPlayer-<? echo $i; ?>" data-product="<? echo $producto->id; ?>"class="song-unit singleVideoPlayer player-<? echo $producto->id; ?>" data-before="<? echo $i; ?>">
                                <td class="">
                                    <div class="thumb_container"  id="singleVideo-jplayer-<? echo $i; ?>" data-mp3="<? echo base_url(); ?>assets/products/demos/videos/<? echo $producto->demo; ?>" data-title="<? echo $producto->name; ?>">
                                        <img src="<? echo base_url('/images/television.png'); ?>" alt="" class="video_thumb">
                                    </div>
                                </td>
                                <? if($producto->gender_id!=45){ ?>
                                <td class="song-author">
                                    <a href="<? echo base_url('remixers/').$producto->owner_id; ?>">
                                    <? 

                                        $key = array_search($producto->owner_id, array_column($users, 'id'));

                                        echo $users[$key]->username;
                                    ?>
                                    </a>
                                </td>
                                <? } ?>
                                <td class="song-title jp-title">
                                    <em><? echo $producto->name; ?> - <? echo $producto->artist; ?></em> - <span class="intro"><? if($producto->version!=null){ ?><? echo $producto->version; ?><? } ?></span> - <? echo $producto->bpm; ?>BPM -  <? $key = array_search($producto->gender_id, array_column($generos, 'id'));echo '<a href="'.base_url().'genero/'.$generos[$key]->id.'">'.$generos[$key]->name.'</a>'; ?><br>
                                    <small>Created at: <? 
                                $fecha = date_format(date_create($producto->time_approved), 'm/d/Y');
                                echo $fecha; 
                                ?></small>
                                </td>

                                
                                
                                <? 
                                    // if(isset($this->session->userdata('is_user_tokens')==false)){   
                                    //     $userdata=array(
                                    //         'is_user_tokens'=>false,
                                    //     );      
                                    //     $this->session->set_userdata($userdata);
                                    // }    
                                ?>
                                <? //if($this->session->userdata('is_user_tokens')==false&&$this->session->userdata('role')!='is_admin'){ ?>
                                <? if($producto->gender_id==45){ ?>
                                <td>
                                    $<? echo $producto->price; ?>
                                </td>
                                <? }else{ ?>
                                    <?
                                        if(isset($_SESSION['user_products'])){
                                            if (in_array($producto->id, $_SESSION['user_products'])){
                                            // echo in_array($producto->id, $_SESSION['user_products']);
                                                $esuserfile = 1;
                                                //echo $esuserfile;
                                            }else{
                                                //echo in_array($producto->id, $_SESSION['user_products']);
                                                $esuserfile = 0;
                                            }
                                        }else{
                                            $esuserfile = 0;
                                        }
                                    ?>
                                    <? if(MONEY_PAYMENTS){ ?>
                                        <? if($this->session->userdata('tokens_video')==0&&$esuserfile==0){ ?>
                                            <td class="tcenter">    
                                                <button class="song-btn addToCart btn btn-orange" data-id="<? echo $producto->id; ?>">$<? echo $producto->price; ?></button>
                                                <button class="btn btn-green anadido"><i class="fa fa-check"></i>Añadido</button>
                                            </td>
                                        <? }else{ ?>
                                            <td class="tcenter">    
                                                <button class="song-btn downloadButtonVideo btn btn-orange" data-id="<? echo $producto->id; ?>"><i class="fa fa-download"></i></button>
                                            </td>
                                        <? } ?>
                                    <? }else{ ?>
                                        <td class="tcenter">    
                                            <button class="song-btn downloadButtonVideo btn btn-orange" data-id="<? echo $producto->id; ?>"><i class="fa fa-download"></i></button>
                                        </td>
                                    <? } ?>
                                <? } ?>
                            </tr> 
                            <?
                            }
                        }else{
                            echo '<tr><td>No hemos encontrado productos.</td></tr>';
                        }
                    ?>
                    </tbody>
                </table>