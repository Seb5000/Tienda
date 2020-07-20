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

$idCategoria = $_GET["categoria"]??null;
$idSubcategoria = $_GET["subcategoria"]??null;
$pagina = $_GET['pagina'] ?? 1;
//$productos_x_pagina = 20;
$productos_x_pagina = 24;
$offset = ($pagina-1)*$productos_x_pagina;
$numero_de_paginas = 1;
$queryUrl = "";

$existeC = $Categoria->existeId($idCategoria);
$existeS = $Subcategoria->existeIdEnCategoria($idSubcategoria, $idCategoria);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/buscar.css">
    <link rel="stylesheet" href="css/menuTop.css">
    <link rel="stylesheet" href="css/menuCategorias2.css">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@300;400;600;700;900&family=Merienda:wght@400;700&display=swap" rel="stylesheet">
    <title>Casa de Arte | Buscar</title>
</head>
<body>
    <header>
        <div class="menu">
            <?php include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/menuTop.php'; ?>
            <?php include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/menuCategorias2.php'; ?>
        </div>
    </header>
    <main>
        <div class="contenedor_principal">
            <!-- BREADCRUMBS -->
            <section>
            <ul class="breadcrumbs">
                <li class="breadcrumbs__item">
                    <a href="index.php" class="breadcrumbs__link">Inicio</a>
                </li>
                <?php
                if($existeC):
                ?>
                <li class="breadcrumbs__item">
                    <a href="buscar.php?categoria=<?=$idCategoria?>" class="breadcrumbs__link <?php echo (!$existeS)?'breadcrumbs__link--active':''; ?>"><?=$Categoria->nombre?></a>
                </li>
                <?php
                endif;
                if($existeS):
                ?>
                <li class="breadcrumbs__item">
                    <a href="buscar.php?categoria=<?=$idCategoria?>&subcategoria=<?=$idSubcategoria?>" class="breadcrumbs__link breadcrumbs__link--active"><?=$Subcategoria->nombre?></a>
                </li>
                <?php
                endif;
                ?>
            </ul>
            </section>
            <!-- FIN BREADCRUMBS -->
            
            <!-- CAJA PRINCIPAL -->
            <section>
                <h1 class="titulo_buscar">
                    <?php
                        if($existeC and $existeS){
                            echo $Subcategoria->nombre;
                        }elseif($existeC){
                            echo $Categoria->nombre;
                        }
                    ?>
                </h1>
                <ul class="cuadrilla_Productos">
            <?php 
            if($existeC and $existeS){
                $queryUrl = "categoria=$idCategoria&subcategoria=$idSubcategoria";
                $productos = $Producto->obtenerProductos3($offset, $productos_x_pagina, null, $idCategoria, $idSubcategoria);
                $total_productos = $Producto->numero_filas;
                $numero_de_paginas = ceil($total_productos/$productos_x_pagina);
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
                $queryUrl = "categoria=$idCategoria";
                //$subcategorias = $Subcategoria->obtenerProductos2($offset, $productos_x_pagina, null, $idCategoria);
                $subcategorias = $Subcategoria->obtenerSubcategorias3($offset, $productos_x_pagina, null, $idCategoria);
                $total_subcategorias = $Subcategoria->numero_filas;
                $numero_de_paginas = ceil($total_subcategorias/$productos_x_pagina);
                
                foreach($subcategorias as $sub){
            ?>
                    <li>
                        <a href="buscar.php?categoria=<?=$idCategoria?>&subcategoria=<?=$sub['id']?>">
                            <div class="producto">
                                <div class="producto_foto">
                                    <img src="<?=$sub['imagen_s']?>" alt="">
                                </div>
                                <div class="producto_nombre">
                                    <?=$sub['nombre']?> (<?=$sub['cantidad']?>)
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
                echo "no se encontro ni categoria ni subcategoria";
            }
            ?>
                </ul>
                <div class="paginacion">
                    <a class="pagina <?php echo $pagina-1<=0? 'desactivado': '' ?>" 
                    href="buscar.php?<?php echo $queryUrl.'&pagina='.($pagina-1) ?>"><b><</b></a>
                    <?php for($i = 1; $i<= $numero_de_paginas; $i++):?>
                    <a class="pagina <?php echo $pagina==$i? 'activo': '' ?>" 
                    href="buscar.php?<?php echo $queryUrl ?>&pagina=<?php echo ($i) ?>">
                    <?php echo $i ?></a>
                    <?php endfor ?>
                    <a class="pagina <?php echo $pagina+1>$numero_de_paginas? 'desactivado': '' ?>" 
                    href="<?php echo 'buscar.php?'.$queryUrl.'&pagina='.($pagina+1) ?>"><b>></b></a>
                </div>
            </section>
            <!-- FIN CAJA PRINCIPAL -->
        </div>
        
    </main>
    <script src="js/menuCategorias2.js"></script>
</body>
</html>