           
    <?php
    
    if (!empty($noticia)){            
    ?>   

    <article>
        <div class = "container" style="display:flex;flex-direction:column;align-items:center;"  >
            
            <div class = "row g-2">                       
                    <div class="col-md-12">
                        <div style=" text-align: center;">
                            <label id = "titulo" style = "text-align: center; margin-top: 40px"><b><h2>
                                <?php if(isset($noticia['titulo'])) {?>
                                    <h2 style="font-weight: 600; "> <?php echo $noticia['titulo']; ?></h2></b>
                                <?php
                                }
                                ?>
                                
                            </label>                  
                        </div>
                    </div> 

                    <div class="col-md-12">
                        <div style=" text-align: center;">
                            <label id = "categoria" style = "text-align: center">
                                <?php if(isset($noticia['categoria']) && isset($noticia['fecha'])){
                                    ?>                                    
                                        <h6 style="color:#808080!important; font-size: 13px; margin-top:-10px!important;  "> 
                                        <em> <?= esc($noticia['categoria'] . " ". $noticia['fecha'])?></em></h6>
                                    <?php                                    
                                    }
                                ?>
                            </label>                   
                        </div>
                    </div>
                </div> 
            
            <div style = "display:flex; flex-direction:column; max-width:1000px;">                  

                <?php if(isset($noticia['descripcion'])){
                    $expresion_regular = '/\r\n|\r|\n/';

                    // Dividir el texto en párrafos usando la expresión regular
                    $parrafos = preg_split($expresion_regular, $noticia['descripcion']);

                    for($i=0; $i < count($parrafos); $i++){
                        if($i == 3){
                            ?>
                            <div style = "display:flex; justify-content:center; ">
                                <img src="<?php if(isset($noticia['imagen']) && $noticia['imagen']!= ""){
                                                    echo base_url('/imagenesNoticia/' . $noticia['imagen']);
                                                }else{
                                                    echo base_url('/imagenesNoticia/' . "imagen-no-disponible.jpeg");

                                                }
                                            ?>" 
                                    class="img-fluid" alt="..."  style="max-width: 90%; width:500px; max-height: 368px;">
                                
                            </div>  
                            <?php
                        }
                        echo "<p style=' font-size:20px; font-weight:lighter;  padding:5px;'>$parrafos[$i]</p>";
                    }
            
                } //echo($noticia['descripcion']); ?>

            </div>
    </article>
    <?php
    } 
    ?>

