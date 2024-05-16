<?php
    $session = session();
    $mensaje = $session->getFlashdata('mensaje');

    // Verifica si hay un mensaje
    if ($mensaje !== null) {
    ?>
        <div id="liveAlertPlaceholder"></div>                 
        <div class="alert alert-primary d-flex align-items-center alert-dismissible" role="alert" 
            style = "margin-top: 20px; margin-bottom: 5px;" type = "hidedeng">
            <?php base_url('/imagenes/redes/exclamation-triangle.svg') ?> 

            <div>
                <H6><b><?= esc( $mensaje); ?></H6></b>                
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div> 
    <?php            
    }
?>

<div class="container-fluid" > 

    <?php if(isset($tituloCuerpo)) {?>             
            <div class=" col-md-12 text-center" style=" margin-top: 20px;  margin-bottom: 40px">
                <h4> <?php  echo esc($tituloCuerpo)?></h4>
            </div>
    <?php
         }
    ?>

    <?php if(isset($titulo)) {?>             
            <div class=" col-md-12 text-center" style=" margin-top: 40px;">
                <h5> <?php  echo esc($titulo)?></h5>
            </div>
    <?php
         }
    ?>

    <?php if(isset($subTitulo)) {?>             
            <div class=" col-md-12 text-center" style=" margin-top: 10px; margin-bottom: 40px">
                <h8> <?php  echo esc($subTitulo)?></h8>
            </div>
    <?php
         }
    ?>

    <div class = "table-responsive">
        <table class="table table-striped table-hover" id = "solicitudVerificacion" name = "solicitudVerificacion">

            <?php
            if (!empty($noticias) && is_array($noticias)){ 
                echo"<tr>";
                foreach($cabecera as $titulo){
                    echo"<th><h7>$titulo</h7></th>";
                }
                echo"</tr>";
                foreach($noticias as $noticia){  ?>  
                    <tr>
                        <td><?php if (isset($noticia[0])) echo $noticia[0]?></td>
                        <td><?php if (isset($noticia[1])) echo $noticia[1]?></td>
                        <td><?php if (isset($noticia[2])) echo $noticia[2]?></td>
                        <td>
                            <?php if (isset($noticia[3]) && $noticia[3] == 1){
                                    echo'<p style= "color: green">Activo</p>';
                                }
                                if (isset($noticia[3]) && $noticia[3] == 0){
                                    echo'<p style="text-decoration: line-through; color: red">Inactivo</p>';
                                } 
                            ?>
                        </td>
                        <td><?php if (isset($noticia[4])) echo $noticia[4]?></td>
                        <td><?php if (isset($noticia[5])) echo $noticia[5]?></td>
                        <?php
                           if(isset($noticia[0])) {
                            if(($noticia[2] === 'Borrador' && $noticia[3] == 1)  || $noticia[2] === 'Corregir') {
                                ?>
                                  <td><a href = "<?php echo base_url('/noticia/editar_noticia/'. $noticia[7]) ?>"
                                            style="display: flex; justify-content: center; align-items: center;">
                                            Ver
                                        </a>
                                    </td>
                                <?php                                
                            } else {
                                // Si no se cumplen las condiciones para editar, retornar 'n/a'
                                echo '<td>n/a</td>';
                            } 
                        } else {
                            // Si el estado no está definido, retornar 'No disponible'
                            echo '<td>No disponible</td>';
                        }
                        ?>
                      
                        <td><a href = "<?php if (isset($noticia[6])) echo $noticia[6]; ?>"
                                style="display: flex; justify-content: center; align-items: center;">
                                Ver
                            </a>
                        </td>
                        <td><a href = "<?php if (isset($noticia[7])) echo base_url('/noticia/historial/' . $noticia[7]); ?>"
                                style="display: flex; justify-content: center; align-items: center;">
                                Ver
                            </a>
                        </td>

                        <td>
                            <?php if(isset($noticia[2]) && isset($noticia[3]) && isset($noticia[7])){
                                $url = site_url('noticia/nuevo_estado') . '?esActivo=' . $noticia[3] . '&id=' . $noticia[7] . '&estado=' . $noticia[2];
                                if($noticia[2] === "Borrador" || $noticia[2] === "Validar"){
                                    if($noticia[3] == 0 &&  $cantidadBorradoresActivos >= 3){
                                    ?>
                                    
                                        <button type="buttom" style = "min-width: 82px!important;" 
                                            class="btn btn-secondary btn-block mt-2 btn-sm disabled"  name="inhabilitar_borrador" disabled>
                                            Activar
                                        </button>
                                    <?php
                                    } 
                                    if($noticia[3] == 0 &&  $cantidadBorradoresActivos < 3){
                                    ?>
                                        <button type="buttom" style = "min-width: 82px!important;" class="btn btn-secondary btn-block mt-2 btn-sm"  name="activar_borrador"
                                            onclick= "window.location.href='<?php echo $url ?>'">
                                            Activar
                                        </button>
                                    <?php
                                    }else{
                                    ?>
                                        <button type="buttom"  style = "min-width: 82px!important;" class="btn btn-secondary btn-block mt-2 btn-sm"  name="desactivar_borrador"
                                            onclick= "window.location.href='<?php echo $url?>'">
                                            Desactivar
                                        </button>
                                    <?php
                                    }
                                }
                            } else echo "ninguno de los 3";

                        ?>
                        </td>
                    </tr>               
                    <?php             
                } 
            }
            ?>
        </table>
    </div> 
</div>