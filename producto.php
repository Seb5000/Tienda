<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';
$bd = new DataBase();
$conn = $bd->conectar();
$Producto = new Producto($conn);

$id = $_GET["id"];
$arrProd = $Producto->obtenerProductoArr($id, true);

//<img src="<?php $img["camino_sm_imagen"] ? >" alt="">
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/mostrar_producto.css">
    <link rel="stylesheet" href="css/menuTop.css">
    <link rel="stylesheet" href="css/menuCategorias2.css">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@300;400;600;700;900&family=Merienda:wght@400;700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="menu">
            <?php include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/menuTop.php'; ?>
            <?php include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/menuCategorias2.php'; ?>
        </div>
    </header>

    <main>
        <section class="contenedor__breadcrumbs">
            <ul class="breadcrumbs">
                <li class="breadcrumbs__item">
                    <a href="" class="breadcrumbs__link">Inicio</a>
                </li>
                <li class="breadcrumbs__item">
                    <a href="buscar.php?categoria=<?=$arrProd['id_categoria']?>" class="breadcrumbs__link"><?=$arrProd['nombre_categoria']?></a>
                </li>
                <li class="breadcrumbs__item">
                    <a href="buscar.php?categoria=<?=$arrProd['id_categoria']?>&subcategoria=<?=$arrProd['id_subcategoria']?>" class="breadcrumbs__link"><?=$arrProd['nombre_subcategoria']?></a>
                </li>
                <li class="breadcrumbs__item">
                    <a class="breadcrumbs__link breadcrumbs__link--active"><?=$arrProd['nombre']?></a>
                </li>
                
            </ul>
        </section>
        <div class="contenedor_principal">
            <div class="contenedor_imagenes">
                <div class="imagen_grande">
                    <img id="imagenGrande" src="<?php echo $arrProd["imagenes"][0]["camino_imagen"]?>" alt="">
                </div>
                <ul class="miniaturas">
                <?php
                foreach($arrProd["imagenes"] as $img):
                ?>
                    <li>
                        <div class="contenedor_miniatura">
                            <a href="<?php echo $img["camino_imagen"]?>" target="imagen_grande">
                                <img src="<?php echo $img["camino_sm_imagen"]?>" alt="">
                            </a>
                        </div>
                    </li>
                <?php    
                endforeach;
                ?>
                </ul>
            </div>
            <div class="contenedor_descripcion">
                <h1> <?php echo $arrProd["nombre"] ?></h1>
                <p>ID : <?php echo $arrProd["id"] ?></p>
                <?php
                    if($arrProd["precio"]!=0){
                        echo "<p>".$arrProd['precio']."</p>";
                    }
                ?>
                <p><?php echo $arrProd["descripcion"] ?></p>
                
            </div>
        </div>
    </main>
    <script type="text/javascript" src="js/miniaturas.js"></script>
    <script src="js/menuCategorias2.js"></script>
</body>
</html>