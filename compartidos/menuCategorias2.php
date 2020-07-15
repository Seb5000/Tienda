<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Categoria.php';
$bd = new DataBase();
$conn = $bd->conectar();
$Categoria = new Categoria($conn);

$arrCat = $Categoria->listaCategorias2();

?>
<div class="menuCategorias">
    <div class="nuestrasCategorias">
        <button class="botonCategorias" id="botonCategorias">
            <div class="burgerCategorias">
                <div class="linea1Categorias"></div>
                <div class="linea2Categorias"></div>
                <div class="linea3Categorias"></div>
            </div>
            <p id="textoBotonCategorias">Nuestras Categorias</p></button>
    </div>
    <div class="dropdownContenedor oculto" id="dropdownContenedor">
        <div class="contenedor_pagina" id="categoriasPagina">
            <ul id="listaCategorias">
                <?php
                foreach($arrCat as $cat):
                    echo "<li><a href='' target='".$cat["id"]."'>".$cat["nombre"]."</a></li>";
                endforeach
                //<li><a href='' target='1'>nombre cat 1</a></li>
                ?>
            </ul>
        </div>
        <div class="contenedor_pagina" id="subcategoriasPagina">
            <?php
            foreach($arrCat as $cat):
                echo "<ul class='listaSubcategorias' categoria=".$cat['id'].">";
                for($i=0; $i<count($cat['subcategorias']); $i++){
                    echo "<li><a href='' >".$cat["subcategorias"][$i]['nombre']."</a></li>";
                }
                echo "</ul>";
            endforeach
            //<li><a href='' target='1'>nombre cat 1</a></li>
            ?>
        </div>

    </div>
    <div class="barraBuscar">
        <form action="">
            <div class="contenedorInput">
                <input id="inputBuscar" placeholder="Que estas buscando?" type="text">
            </div>
        </form>
    </div>
</div>