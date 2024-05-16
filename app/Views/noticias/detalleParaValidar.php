
<?php
    $session = session();
    $mensaje = session()->getFlashdata('mensaje'); 
    $errors = validation_errors();
    if($errors || $mensaje !== null){
?>
        <div id="liveAlertPlaceholder"></div>      

        <div class="alert alert-primary d-flex align-items-center alert-dismissible" role="alert" 
            style = "margin-top: 20px; margin-bottom: 5px;" type = "hidedeng">
                <?php //include "../public/imagenes/redes/exclamation-triangle.svg" 
                 base_url('/imagenes/redes/exclamation-triangle.svg')?>                
                <div>
                    <H6><b><?= validation_list_errors();  ?></H6></b>
                    <H6><b><?= $mensaje;  ?></H6></b>
                    
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div> 
    <?php
    }
?>

<section class = "sectionPrincipal">
            
    <div class="container">

        <div class=" col-md-12 text-center" style=" margin-top: 20px;">
            <h2> <?php echo esc($tituloCuerpo)?></h2>
        </div><br><br>

        <form class="row g-3 " name= "formulario" id="formulario" method="post" action="<?= base_url('noticia/post_validar')?>" enctype="multipart/form-data" >
            <?= csrf_field() ?>

            <div class="col-md-12">
                <label for="titulo"><b><h5>Título:</h5></b></label>
                <input type="text" name="titulo" 
                        value="<?= set_value('titulo', $noticia['titulo']) ?>"
                        class="form-control" readonly>
            </div>

            <div class="col-md-12">
                <label for="categoria"><b><h5>Categoría:</h5></b></label>
                <input type = "text" name = "categoria" 
                        value = "<?= set_value('categoria', $noticia['categoria']) ?>" 
                        class="form-control" readonly>
            </div>

            <div class="col-md-12">
                <label for="descripcion"><b><h5>Descripción:</h5></b></label>
                <textarea name="descripcion" cols="45" rows="10" class="form-control" readonly>
                <?= set_value('descripcion', $noticia['descripcion']) ?>             
                </textarea>
            </div>

                         
            <div class="col-md-12">
                <label ><b><h5>Imagen:</h5></b></label> 
                <div>  
                    <label id = "imagen" style = "text-align: center"><b><h8>
                        <div class = "container">
                            <img src="<?php if(isset($noticia['imagen']) && !empty($noticia['imagen'])){
                                                echo base_url('/imagenesNoticia/' . $noticia['imagen']);
                                            }else{
                                                echo base_url('/imagenesNoticia/' . "imagen-no-disponible.jpeg");
                                            }
                                    ?>" 
                                class="img-fluid" alt="..."  style="max-width: 624px; max-height: 368px;"></h8></b>
                        </div>
                    </label>  
                </div>                   
            </div> 
        

            <div class="col-md-4">
                <label for="estado"><b><h5>Acción:</h5></b></label>
                <select class="form-select" aria-label="Default select example" id="inputGroupSelect01" name = "estado" required>
                    <option value="" <?= set_select('estado', '') ?>>
                        Seleccione
                    </option>

                    <?php                     
                    if(isset($estados) && is_array($estados))
                    {             
                        foreach($estados as $estado){
                            ?>
                            <option value="<?= esc($estado['id']);?>"<?= set_select('estado', $estado['id']) ?>><?= esc($estado['nombre']);?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-12">
                <label for="descripcion"><b><h5>Observaciones:</h5></b></label>
                <textarea name="observaciones" cols="45" rows="5" class="form-control">
                <?= set_value('observaciones') ?>             
                </textarea>
            </div>

            <input type = "hidden" name = "id" value = "<?= set_value('id', $noticia['id']) ?>">
            
            <div class="row justify-content-center " style = "margin-top: 60px;">
                <div class="col-3">
                    <button type="submit" class="btn btn-secondary btn-block" id="guardar" name="guardar">GUARDAR</button>
                </div>
                <div class="col-3">
                    <button type="button" class="btn btn-secondary btn-block mt-2" id="volver_listado_validar" name="volver_listado_validar"
                        onclick="window.location.href='<?php echo base_url('noticia/validar'); ?>'">
                            CANCELAR
                    </button>
                   
                </div>
            </div>

        </form><br>

        <div id="liveAlertPlaceholder"></div>      
    </div>
</section> 
