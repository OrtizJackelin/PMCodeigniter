<?php
    $session = session();
    $mensaje = session()->getFlashdata('mensaje'); 
    $errors = validation_errors();
    if($errors || $mensaje !== null){
    ?>
        <div id="liveAlertPlaceholder"></div>      

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

        <form class="row g-3 " name= "formularioEditar" id="formularioEditar" method="post" action="<?=base_url('noticia/post_editar')?>" 
            enctype="multipart/form-data" >
            <?= csrf_field() ?>

            <div class="col-md-12">
                <label><b><h5>Título:</h5></b></label>
                <input type="text" name="titulo" 
                        value="<?= set_value('titulo', $noticia['titulo']) ?>"
                        class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="categoria"><b><h5>Categoría:</h5></b></label>
                <select class="form-select" aria-label="Default select example" id="categoria" name = "categoria" required>
                <option value="" <?= set_select('categoria', '') ?>>
                    Seleccione
                </option>

                    <?php                     
                    if(isset($categorias) && is_array($categorias))
                    {             
                        foreach($categorias as $categoria){
                            ?>
                            <option value="<?= esc($categoria['id']); ?>" <?= $noticia['id_categoria'] == $categoria['id'] ? 'selected' : '' ?>>
                                <?= esc($categoria['nombre']); ?>
                            </option>

                            <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-12">
                <label ><b><h5>Descripción:</h5></b></label>
                <textarea name="descripcion" cols="45" rows="10" class="form-control">
                <?= set_value('descripcion', $noticia['descripcion']) ?>             
                </textarea required>
            </div>

            <label for="inputGroupFile02"><b><h5>Ingresar Imagen:</h5></b></label>
            <div class="input-group mb-3">
                <input type="file" class="form-control" name = "imagen" id="inputGroupFile02" accept = "image/avif,image/png,image/jpeg"> <!--acept para colocar el tipo de archivo permitido-->
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
                            <option value="<?= esc($estado['id']);?>"<?= $noticia['id_estado'] == $estado['id'] ? 'selected' : '' ?>>
                                <?= esc($estado['nombre']);?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>

            </div><br><br><br>
           
            <div class="col-md-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" name = "es_activo" type="checkbox" 
                        id="flexSwitchCheckDefault" 
                        <?php if( $noticia['es_activo']) echo"checked" ?>
                    >            
                    <label class="form-check-label" for="flexSwitchCheckDefault">Activar/Desactivar Publicación</label>
                </div>
            </div>

            <div class="row justify-content-center  text-center">
                <label ><b><h5>Imagen:</h5></b></label>                 
                    <div class = "container justify-content-center text-center">
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

            <input type = "hidden" name = "id" value = "<?= set_value('id', $noticia['id']) ?>">
            <?php $es_activo_original = $noticia['es_activo']?>
            <input type = "hidden" name = "es_activo_original" value = "<?= set_value('es_activo_original', $es_activo_original) ?>">

            <div class="row justify-content-center  text-center" style = "margin-top: 60px;">
                <div class="col-6">
                    <button type="submit" class="btn btn-secondary btn-block" id="guardarEditar" name="guardarEditar">GUARDAR</button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-secondary btn-block " id="cancelarEditar" name="cancelarEditar"
                        onclick="window.location.href='<?php echo base_url('noticia/mis_noticias'); ?>'">
                            CANCELAR
                    </button>
                </div>
            </div>

        </form><br>
    </div>
</section> 
