
<div style="display: flex;flex-direction:column;  align-items:center; margin-top:20px" >               

    <div class = "container;" style="padding-top: 0px; flex:1; max-width:1000px; width:90%; height:100%;" >
        <table class="table  " id = "solicitudVerificacion" name = "solicitudVerificacion"
             style=" margin-top: 0%;">
             
            <?php
         
            if (!empty($noticias) && is_array($noticias)){   
                //var_dump($noticias);
                foreach($noticias as $noticia){                  
                
                ?>
                    <tr>
                        <th colspan = 2 style="text-align: center; background:transparent; ">
                            <h2 style="font-weight: 600; " ><?= esc($noticia[0])?></h2>
                            <h6 style="color:#808080!important; font-size: 13px; margin-top:-10px!important;  "> 
                            <em> <?= esc($noticia[1]). " ".esc($noticia[2]) ?></em></h6>
                        </th>
                    </tr>
                    <tr>
                        <td style="text-align: justify;flex-wrap:wrap-reverse;border-bottom-color :transparent;  
                            justify-content:space-evenly;  display:flex;">
                                
                            <p style="max-width: 600px; font-size:17px; font-weight:lighter;  padding:5px;" >
                                <?php echo word_limiter(esc($noticia[3]), 100);?>
                                <a href="<?= esc($noticia[6])?>"> ver </a>
                            </p>

                            <div style="max-width:260px; overflow:hidden; padding:5px; display:flex; " >
                                <?php if(isset($noticia[4]) && isset($noticia[5])) {
                                        echo '<a href="' . site_url("/noticia/" . esc($noticia[5], 'url')) . '">
                                                <img src="' . site_url("imagenesNoticia/" . esc($noticia[4], 'url')) . '" 
                                                    title="Imagen de la noticia" class="img-fluid" 
                                                    style="max-width: 324px; max-height: 168px;">
                                            </a>';
                                    }
                                ?>                             
                            </div>
                                
                        </td>
                    </tr>
                <?php
                    
                }
            }else{
                ?>
                <div class = "container">
                    <p><H4>¡No se encontraron noticias!</h4></p>
                </div>

                <?php
            }    
            ?>
        </table>
    </div> 
    
</div>
