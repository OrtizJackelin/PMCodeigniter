<div class="container-fluid" >               
        <div class=" col-md-12 text-center" style=" margin-top: 20px;">
            <h4> Noticias</h4>
        </div>
        <div class = "table-responsive">
            <table class="table table-striped table-hover" id = "solicitudVerificacion" name = "solicitudVerificacion">
                <tr>
                    <th>T&iacute;tulo</th>
                    <th>Categor&iacute;a</th>
                    <th>Descripci&oacute;n</th>
                    <th></th>

                </tr>
                <?php
                if (!empty($noticias) && is_array($noticias)){

                    foreach($noticias as $itemNoticia){
                        ?>            
                            <tr>                  
                                <td><?php if(isset($itemNoticia['titulo'])) echo($itemNoticia['titulo']);?></td>
                                <td><?php if(isset($itemNoticia['categoria'])) echo($itemNoticia['categoria']);?></td>
                                <td><?php if(isset($itemNoticia['descripcion'])) echo($itemNoticia['descripcion']);?></td>
                                <td><a href = "/noticia/<?= esc($itemNoticia['id'], 'url')?>">ver</a></td>
                            </tr>            
                        <?php
                    }
                }
                ?>
            </table>
        </div>

</body>
   