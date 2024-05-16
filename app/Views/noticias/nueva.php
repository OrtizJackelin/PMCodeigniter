<?php
    $session = session();
    $mensaje = session()->getFlashdata('mensaje'); 
    $errors = validation_errors();
    if($errors || $mensaje !== null){
    ?>
        <div class="alert alert-primary d-flex align-items-center alert-dismissible" role="alert" 
            style = "margin-top: 20px; margin-bottom: 5px;" type = "hidedeng">
                <?php base_url('/imagenes/redes/exclamation-triangle.svg') ?>                
                <div>
                    <H6><b><?= validation_list_errors();  ?></H6></b>
                    <H6><b><?= $mensaje;  ?></H6></b>
                    
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div> 
    <?php
    }
?>
<div id="liveAlertPlaceholder"></div>

<section class = "sectionPrincipal">
            
    <div class="container">

        <div class=" col-md-12 text-center" style=" margin-top: 20px;">
            <h2> <?php echo esc($tituloCuerpo)?></h2>
        </div><br><br>

        <form class="row g-3 " name= "formulario" id="formularioNuevaNoticia" method="post" action="<?=base_url('noticia/post_nueva')?>" 
            enctype="multipart/form-data" >
            <?= csrf_field() ?>

            <div class="col-md-12">
                <label><b><h5>Título:</h5></b></label>
                <input type="text" name="titulo" autocomplete="off"
                    value="<?= set_value('titulo') ?>" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label><b><h5>Categoría:</h5></b></label>
                <select class="form-select" aria-label="Default select example" 
                    name = "categoria" required>
                <option value="" <?= set_select('categoria', '') ?>>
                    Seleccione
                </option>

                    <?php                     
                    if(isset($categorias) && is_array($categorias))
                    {             
                        foreach($categorias as $categoria){
                            ?>
                            <option value="<?= esc($categoria['id']);?>"<?= set_select('categoria')?>>
                                            <?= esc($categoria['nombre']);?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-12">
                <label><b><h5>Descripción:</h5></b></label>
                <textarea name="descripcion" cols="45" rows="10" class="form-control" autocomplete="off">
                <?= set_value('descripcion') ?>             
                </textarea required>
            </div>

            <label for="inputGroupFile02"><b><h5>Ingresar Imagen:</h5></b></label>
            <div class="input-group mb-3">
                <input type="file" class="form-control" name = "imagen" id="inputGroupFile02" accept = "image/avif,image/png,image/jpeg,image/webp"> <!--acept para colocar el tipo de archivo permitido-->
                <label class="input-group-text" for="inputGroupFile02"><b>Upload</b></label>
            </div>

            <div class="col-md-4">
                <label for="inputGroupSelect01"><b><h5>Guardar como:</h5></b></label>
                <select class="form-select" aria-label="Default select example" id="inputGroupSelect01" name = "estado" required>
                    <option value="" <?= set_select('estado', '') ?>>
                        Seleccione
                    </option>

                    <?php                     
                    if(isset($estados) && is_array($estados))
                    {             
                        foreach($estados as $estado){
                            ?>
                            <option value="<?= esc($estado['id']);?>"<?= set_select('estado') ?>><?= esc($estado['nombre']);?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>

            </div><br><br><br>
            
            <div class="col-md-10">
                <div class="form-check form-switch">
                    <input class="form-check-input" name = "es_activo" type="checkbox" 
                        id="flexSwitchCheckDefault">            
                    <label class="form-check-label" for="flexSwitchCheckDefault">Activar/Desactivar Publicación</label>
                </div>
            </div>

            
            <div class="row justify-content-center text-center " style = "margin-top: 60px;">
                <div class="col-6">
                    <button type="submit" class="btn btn-secondary btn-block" id="guardarNueva" name="guardarNueva">GUARDAR</button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-secondary btn-block " id="cancelarNueva" name="cancelarNueva"
                        onclick="window.location.href='<?php echo base_url('noticia'); ?>'">
                            CANCELAR
                    </button>
                </div>
            </div>

        </form><br>
    </div>
</section> 

