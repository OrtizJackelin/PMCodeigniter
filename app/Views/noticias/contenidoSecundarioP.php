          

    <div class="categoriasEscritorio" >
        <p style=" margin:0px; padding: 10px; text-align: center;"><b>Categorías</b></p>

        <div   id="listaCategoriasEscritorio"   >
            <?php
                if (!empty($todasLasCategorias)) {
                    echo isset($todasLasCategorias) 
                        ? "<a href='" . $todasLasCategorias . "'>Todas las categorías</a>" 
                        : "";
                }
                if (!empty($listadoCategorias) && is_array($listadoCategorias)){
                    //var_dump($listadoCategorias);

                    foreach ($listadoCategorias as $categorias) {  
                        echo "<a href='" . $categorias[0] . "'>" . $categorias[1] . "</a>";
                    }
                }
            ?>
        </div> 
    </div>  

    <div class="categoriasMobile" >
                <div class="categoriaShowControl" >
                <p ><b>Categorías</b></p>
                     <span class="toggleList" data-bs-toggle="collapse" data-bs-target="#listaCategoriasMobile" aria-expanded="false" aria-controls="listaCategoriasMobile">
                        <i class="bi bi-arrow-down-square-fill" style="font-size: 1.3rem; color: cornflowerblue;" ></i>
                    </span>
                </div>
                
        <div   id="listaCategoriasMobile" class="collapse listaCategoriasMobile" >
            <?php
                if (!empty($todasLasCategorias)){
                    echo isset($todasLasCategorias) 
                    ? "<a href='" . $todasLasCategorias . "'>Todas las categorías</a>" 
                    : " no disponible ";
                    
                }

                if (!empty($listadoCategorias) && is_array($listadoCategorias)){

                    foreach($listadoCategorias as $items){    
                        if(isset($items)) {
                            echo "<a href='" . $items[0] . "'>" . $items[1] . "</a>";
                        }
                    } 
                }
        ?>
        </div> 
    </div>  
