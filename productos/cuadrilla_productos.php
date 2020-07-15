<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Categoria.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Subcategoria.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';

$bd = new DataBase();

$conn = $bd->conectar();

$Categoria = new Categoria($conn);
$Subcategoria = new Subcategoria($conn);
$Producto = new Producto($conn);

$idCat = $_GET['categoria'] ?? -1;
$idSub = $_GET['subcategoria'] ?? -1;
$pagina = $_GET['pagina'] ?? 1;
$productos_x_pagina = 20;
$offset = ($pagina-1)*$productos_x_pagina;
$numero_de_paginas = 1;
$queryUrl = "";


$existeC = $Categoria->existeId($idCat);
$existeS = $Subcategoria->existeIdEnCategoria($idSub, $idCat);

?>
<ul class="cuadrilla_Productos">
<?php

if($existeC and $existeS){
    $queryUrl = "categoria=$idCat&subcategoria=$idSub";
    //OBTENER LOS PRODUCTOS DE ESA CATEGORIA Y SUBCATEGORIA
    //echo "La categoria y la subcategoria existen y son correctas".PHP_EOL;
    $nCat = $Categoria->obtenerNombre($idCat);
    $nSub = $Subcategoria->obtenerNombre($idSub);
    //echo "Categoria : $idCat - $nCat".PHP_EOL;
    //echo "Subategoria : $idSub - $nSub".PHP_EOL;
    $productos = $Producto->obtenerProductos3($offset, $productos_x_pagina, null, $idCat, $idSub);
    $total_productos = $Producto->numero_filas;
    $numero_de_paginas = ceil($total_productos/$productos_x_pagina);
    $numero_de_paginas = ($numero_de_paginas == 0)?1:$numero_de_paginas;
    
    //print_r($productos);
    foreach($productos as $prod){
?>
        <li>
            <a href="producto.php?id=<?php echo $prod['id']?>" >
                <div class="producto">
                    <div class="producto_foto">
                        <img src="<?=$prod['imagen_s']?>" alt="">
                    </div>
                    <div class="producto_nombre">
                        <?=$prod['nombre']?>
                    </div>
                    <div class="producto_numero">
                        <?=$prod['id']?>
                    </div>
                    <div class="producto_descripcion">
                        <?=$prod['descripcion']?>
                    </div>
                    <div class="producto_precio">
                        <?=$prod['precio']?>
                    </div>
                </div>
            </a>
        </li>   
<?php
    }
}elseif($existeC){
    $queryUrl = "categoria=$idCat";
    //OBTENER LAS SUBCATEGORIAS DE ESA CATEGORIA
    //echo "Solo existe la categoria o solo esta es correcta";
    $nCat = $Categoria->obtenerNombre($idCat);
    //echo "Categoria : $idCat - $nCat".PHP_EOL;
    $subcategorias = $Subcategoria->obtenerProductos2($offset, $productos_x_pagina, null, $idCat);
    $total_subcategorias = $Subcategoria->numeroFilas();
    $numero_de_paginas = ceil($total_subcategorias/$productos_x_pagina);
    $numero_de_paginas = ($numero_de_paginas == 0)?1:$numero_de_paginas;
    //print_r($subcategorias);

    foreach($subcategorias as $sub){
?>
        <li>
            <a href="index.php?categoria=<?=$idCat?>&subcategoria=<?=$sub['id']?>">
                <div class="producto">
                    <div class="producto_foto">
                        <img src="<?=$sub['imagenS']?>" alt="">
                    </div>
                    <div class="producto_nombre">
                        <?=$sub['nombre']?>
                    </div>
                    <div class="producto_numero">
                        <?=$sub['id']?>
                    </div>
                    <div class="producto_descripcion">
                        <?=$sub['descripcion']?>
                    </div>
                </div>
            </a>
        </li>
<?php
    }
}else{
    //MOSTRAR UN MENSAJE QUE NO SE ENCONTRO LA CATEGORIA
    // O MOSTRAR LA PRIMERA CATEGORIA DE LA BASE DE DATOS
    echo "No existe la categoria";
}
?>
</ul>

<div class="paginacion">
    <a class="pagina <?php echo $pagina-1<=0? 'desactivado': '' ?>" 
    href="index.php?<?php echo $queryUrl.'&pagina='.($pagina-1) ?>">Anterior</a>
    <?php for($i = 1; $i<= $numero_de_paginas; $i++):?>
    <a class="pagina <?php echo $pagina==$i? 'activo': '' ?>" 
    href="index.php?<?php echo $queryUrl ?>&pagina=<?php echo ($i) ?>">
    <?php echo $i ?></a>
    <?php endfor ?>
    <a class="pagina <?php echo $pagina+1>$numero_de_paginas? 'desactivado': '' ?>" href="<?php echo 'index.php?'.$queryUrl.'&pagina='.($pagina+1) ?>">Siguiente</a>
</div>
