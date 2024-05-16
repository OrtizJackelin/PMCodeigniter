


<div  style="display: flex; flex:1; height:100%; padding:0px; overflow:hidden; position:realetive;  " >

    <div class = "contenidoPrincipal" >
        <div class = "container" >
            <?php
                $session = session();
                $mensaje = $session->getFlashdata('mensaje');

                // Verifica si hay un mensaje
                if ($mensaje !== null) {
                ?>
                    <div id="liveAlertPlaceholder"></div>                 
                    <div class="alert alert-primary d-flex align-items-center alert-dismissible" role="alert" 
                        style = "margin-top: 20px; margin-bottom: 5px;" type = "hidedeng">
                        <?php include "../public/imagenes/redes/exclamation-triangle.svg" ?> 

                        <div>
                            <H6><b><?= esc( $mensaje); ?></H6></b>                
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div> 
                <?php            
                }
            ?>
        </div>
            
        <?php if(isset($contenidoPrincipal)){
            echo $contenidoPrincipal;
        } 
        ?>
    </div>

    <div class = "contenidoSecundario" >
       
        <?php echo $contenidoSecundario; ?>
    </div>
    
</div>