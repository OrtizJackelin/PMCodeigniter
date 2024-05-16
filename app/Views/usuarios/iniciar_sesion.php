<?php
    $session = session();
    $mensaje = session()->getFlashdata('mensaje'); 
    $errors = validation_errors();
    if($errors || $mensaje !== null){
    ?>           
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
<div id="liveAlertPlaceholder"></div>  

<section class = "sectionPrincipal">
    <div class=" col-md-12 text-center" style=" margin-top: 60px;">
        <h4> <?php echo esc($tituloCuerpo)?></h4>
    </div>
        <div  style="display: flex; justify-content:center; width:100%;" >
            <form style="display:flex; width: 90%; flex-direction:column; max-width:900px;align-items:center; margin-top: 60px;" 
                    id="formularioIniciarSesion" method="post" action="<?= base_url('usuario/validar')?>" >
                <?= csrf_field() ?>

                <div style="display: flex; width:100%; justify-content:space-between; flex-wrap:wrap; width:100%; " >
                    <div style = "min-width:220px; margin:3px 10px; max-width:350px; flex:1; " >
                        <label for="email" class="form-label"><b>Email</b></label>
                        <input type="email" class="form-control" id="email" name = "correo" value = "" required>
                    </div>

                    <div  style = " min-width:220px; margin:3px 10px; max-width:350px;flex:1; " >
                        <label for="clave" class="form-label"><b>Password</b></label>
                        <input type="password" id="clave" name="clave"  class="form-control" 
                            pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&+=!])(?!.*\s).{8,}$"required>
                    </div>  
                </div>       

                <div class="col-12" style="margin-top:40px;" >
                    <button type="submit" class="btn btn-success" id="send" name = "send" style = "width: 100px">Iniciar</button>
                </div>

            </form>
       
    </div>
</section>
