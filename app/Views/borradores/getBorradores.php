<div class = "container" style="align-content:center">
    <div class=" col-md-12 text-center" style=" margin: 40px;">
        <h4> <?php echo esc($tituloCuerpo)?></h4>
    </div>

    <div  style = " display:flex; width:100%; justify-content:space-between; margin-bottom:20px">
        <div style="margin-bottom:10px;" >
            <a 
            <?php
                if ($offSet > 0) {
                    echo "href=\"" . base_url("noticia/" . $idNoticia . "/borradores") . "?offset=" . $offSet-1 . "\"";
                }
                ?>
                
                style="display: flex; justify-content: left; align-items: left; text-decoration:none">
                    <i class="bi bi-arrow-left-square-fill" style="font-size: 1.3rem; color: cornflowerblue;"></i>
                        &nbsp; Ver más recientes 
            </a>
        </div>

        <div style=" margin-bottom:10px; display: flex; justify-content: rigth; align-items: rigth; text-align:right" >
            <a <?php
                if ($offSet < $total-2) {
                    echo "href=\"" . base_url("noticia/" . $idNoticia . "/borradores") . "?offset=" . $offSet+1 . "\"";
                }
                ?>
                style="display: flex; justify-content: flex-end;width:100%; align-items: rigth !important; text-align:right; text-decoration:none"> 
                
                     Ver más antigüos&nbsp;<i class="bi bi-arrow-right-square-fill" style="font-size: 1.3rem; color: cornflowerblue;"></i>
            </a>

        </div>
    </div>

    <div class="row" style = "margin-bottom:20px">
        <div class="col-md-6" style=" height:100%; flex-direction:column; overflow:auto;" >
            <?= esc($numero1)?>          
        </div>

        <div class="col-md-6" style=" height:100%; flex-direction:column; overflow:auto;" >
            <?= esc($numero2)?>              
        </div>
    </div>
    

    <div class="row no-margin">
        <div class="col-md-6" style="align-items: rigth; display: flex; height:100%; flex-direction:column; overflow:auto; padding-right:0px " >
            <table> 
                <tr>
                    <td>Fecha</td>
                    <td></td>
                </tr>
            
                <tr>
                    <td><input readonly type="text" name="fecha1"  value="<?= esc($fecha1)?>" class="form-control" ></td>
                </tr>

                <tr>
                    <td>Categoria</td>
                    <td></td>
                </tr>

                <tr>
                    <td><input readonly type="text" name="categoria1"  value="<?= esc($categoria1)?>" class="form-control" ></td>
                    <td style="padding-left:12px;">
                        <?php if($diferencia_categoria){?>
                            <i class="bi bi-arrow-left-square-fill" style="font-size: 1.3rem; color: red;"></i>
                        <?php
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Titulo</td>
                    <td></td>
                </tr>

                <tr>
                    
                    <td><input readonly type="text" name="titulo1"  value="<?= esc($titulo1)?>" class="form-control"></td>
                    <td    style="padding-left:12px;">
                        <?php if($diferencia_titulo){?>
                            <i class="bi bi-arrow-left-square-fill" style="font-size: 1.3rem; color: red;"></i>
                        <?php
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Descripcion</td>
                    <td></td>
                </tr>

                <tr>        
                    <td>
                        <textarea readonly name="descripcion1" cols="45" rows="10" class="form-control">
                            <?= esc($descripcion1)?>             
                        </textarea>
                    </td>
                    <td style="padding-left:12px;">
                        <?php if($diferencia_descripcion){?>
                            <i class="bi bi-arrow-left-square-fill" style="font-size: 1.3rem; color: red;"></i>
                        <?php
                        }
                        ?>
                    </td>

                </tr>

                <tr>
                    <td>Imagen</td>
                    <td></td>
                </tr>

                <tr>        
                    <td><input readonly type="text" name="imagen1"  value="<?= esc($imagen1)?>" class="form-control" ></td>
                    <td style="padding-left:12px;">
                        <?php if($diferencia_imagen){?>
                            <i class="bi bi-arrow-left-square-fill" style="font-size: 1.3rem; color: red;"></i>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>


        <div class="col-md-6" class="borradorColumna2" >
            <table style="width: 100%;" >
                <tr>
                    <td>Fecha</td>
                </tr>
            
                <tr>
                    <td><input readonly type="text" name="fecha2"  value="<?= esc($fecha2)?>" class="form-control" ></td>
                </tr>

                <tr>
                    <td>Categoria</td>
                </tr>

                <tr>
                    <td><input readonly type="text" name="categoria2"  value="<?= esc($categoria2)?>" class="form-control" ></td>
                </tr>

                <tr>
                    <td>Titulo</td>
                </tr>

                <tr>                 
                    <td><input readonly type="text" name="titulo2"  value="<?= esc($titulo2)?>" class="form-control" ></td>
                </tr>

                <tr>
                    <td>Descripcion</td>
                </tr>

                <tr>        
                    
                    <td>
                        <textarea readonly name="descripcion2" cols="45" rows="10" class="form-control">
                            <?= esc($descripcion2)?>             
                        </textarea>
                    </td>
                </tr>

                <tr>
                    <td>Imagen</td>
                </tr>

                <tr>        
                    
                    <td><input readonly type="text" name="imagen2"  value="<?= esc($imagen2)?>" class="form-control" ></td>
                </tr>
            </table>
            
        </div>
        <label><br><h20><b>Nota: Los cambios entre borradores son mostrados con la flecha roja </b></h20></label>
    </div>
</div>