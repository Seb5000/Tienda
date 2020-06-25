<?php include('../compartidos/conexion_bd.php');?>
<?php
$id_categoria = -1;
$id_sub_categoria = -1;
$nombre_categoria = "";
$nombre_sub_categoria = "";
$bandera_sub_categoria = false;
$lista_sub_categorias = [];

if(isset($_GET['categoria'])){
    $id_categoria = $_GET['categoria'];
    if(!is_numeric($id_categoria)){
        //echo "no es numerico";
        $id_categoria = -1;
    }
    $sql = "SELECT `ID_CATEGORIA`, `NOMBRE_CATEGORIA` FROM `CATEGORIA` WHERE `ID_CATEGORIA` = {$id_categoria}";
    $result = $conn->query($sql);
    //echo "llego antes del if";
    if ($result->num_rows > 0) {
        //echo "Entro al if";
        while($row = $result->fetch_assoc()) {
            echo "Entro al while";
            $id_categoria = $row["ID_CATEGORIA"];
            $nombre_categoria= $row["NOMBRE_CATEGORIA"];
        }
    }else{
        $sql2 = "SELECT `ID_CATEGORIA`, `NOMBRE_CATEGORIA` FROM `CATEGORIA` LIMIT 1";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            while($row2 = $result2->fetch_assoc()) {
                $id_categoria = $row2["ID_CATEGORIA"];
                $nombre_categoria= $row2["NOMBRE_CATEGORIA"];
            }
        }else{
            $id_categoria = -1;
            // ERROR NO REDIRIGE A LA PAGINA INDEX
            // Warning:  Cannot modify header information - headers already sent by 
            //(output started at D:\Programas\xampp\htdocs\tio\compartidos\menu_productos.php:29)
            // in D:\Programas\xampp\htdocs\tio\productos\index.php on line 55

            //ver https://stackoverflow.com/questions/8028957/how-to-fix-headers-already-sent-error-in-php
            header("Location: /tio/index.php");
            exit();
        }
    }
}else{
    $sql = "SELECT `ID_CATEGORIA`, `NOMBRE_CATEGORIA` FROM `CATEGORIA` LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id_categoria = $row["ID_CATEGORIA"];
            $nombre_categoria= $row["NOMBRE_CATEGORIA"];
        }
    }else{
        $id_categoria = -1;
        header("Location: /tio/index.php");
        exit();
    }
}

if(isset($_GET['subcategoria'])){
    $id_sub_categoria = $_GET['subcategoria'];
    if(!is_numeric($id_sub_categoria)){
        $id_sub_categoria = -1;
    }
    $sql = "SELECT * FROM `SUBCATEGORIA` WHERE `ID_SUBCATEGORIA` = {$id_sub_categoria}";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $bandera_sub_categoria = true;
        while($row = $result->fetch_assoc()) {
            $nombre_sub_categoria = $row["NOMBRE_SUBCATEGORIA"];
        }
    }else{
        $id_sub_categoria = -1;
        $bandera_sub_categoria = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/menu_categorias.css">
</head>

<body>
    <?php include('../compartidos/menu_productos.php'); ?>

    <section class="barraDirecciones">
        <div class="contenedor2">
            <ul class="breadcrumbs">
                <li class="breadcrumbs__item">
                    <a href="/tio/index.php" class="breadcrumbs__link">Inicio</a>
                </li>
                <li class="breadcrumbs__item">
                    <a href="/tio/index.php#productos" class="breadcrumbs__link">Nuestros Productos</a>
                </li>
                <?php 
                    if($id_sub_categoria != -1){ ?>
                        <li class="breadcrumbs__item">
                            <a href="/tio/productos/index.php?categoria=<?php echo $id_categoria;?>" class="breadcrumbs__link"><?php echo $nombre_categoria;?></a>
                        </li>
                        <li class="breadcrumbs__item">
                            <a href="" class="breadcrumbs__link breadcrumbs__link--active"><?php echo $nombre_sub_categoria; ?></a>
                        </li>
                    <?php 
                    }else{
                    ?>
                    <li class="breadcrumbs__item">
                        <a href="" class="breadcrumbs__link breadcrumbs__link--active"><?php echo $nombre_categoria ?></a>
                    </li>
                    <?php } ?>
                
            </ul>
        </div>
    </section>

    <section id="contenedorPrincipal">
        <div class="contenedor3">
            <div class="caja3">
                <?php echo $nombre_categoria; ?>
            </div>
            <div class="caja4">
                <div class="barraLateral hidden">
                </div>
                <div class="contenedorProductos">
                    <div class="caja_Productos">
                        <div class="titulo_Producto">
                            <h2>
                                <?php echo $nombre_sub_categoria;?>
                            </h2>
                        </div>
                        <ul class="cuadrilla_Productos">
                            <?php
                            /*
                                if($sub_categoria == "defecto"){
                                    $sql = "SELECT * FROM `subcategorias` WHERE `CATEGORIA_SUBCATEGORIA` LIKE 'pinturas' ";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo '
                                            <li>
                                                <div class="producto">
                                                    <div class="producto_foto">
                                                        <img src="'.$row["IMAGEN_SUBCATEGORIA"].'" alt="">
                                                    </div>
                                                    <div class="producto_nombre">
                                                        '.$row["NOMBRE_SUBCATEGORIA"].'
                                                    </div>
                                                    <div class="producto_numero">
                                                        item #456789
                                                    </div>
                                                    <div class="producto_descripcion">
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis necessitatibus, dolor, quam blanditiis possimus soluta doloribus autem, adipisci sed, suscipit a voluptatem. Sequi deserunt dolores, magnam molestias laudantium praesentium cum.
                                                    </div>
                                                    <div class="producto_precio">
                                                        18 - 20 Bs
                                                    </div>
                                                </div>
                                            </li>
                                            ';
                                        }
                                    }
                                }else{

                                }

                                <li>
                                    <div class="producto">
                                        <div class="producto_foto">
                                            <img src="https://picsum.photos/200/200" alt="">
                                        </div>
                                        <div class="producto_nombre">
                                            producto prueba 123
                                        </div>
                                        <div class="producto_numero">
                                            item #456789
                                        </div>
                                        <div class="producto_descripcion">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis necessitatibus, dolor, quam blanditiis possimus soluta doloribus autem, adipisci sed, suscipit a voluptatem. Sequi deserunt dolores, magnam molestias laudantium praesentium cum.
                                        </div>
                                        <div class="producto_precio">
                                            18 - 20 Bs
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="producto">
                                        <div class="producto_foto">
                                            <img src="https://picsum.photos/200/200" alt="">
                                        </div>
                                        <div class="producto_nombre">
                                            producto prueba 123
                                        </div>
                                        <div class="producto_numero">
                                            item #456789
                                        </div>
                                        <div class="producto_descripcion">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis necessitatibus, dolor, quam blanditiis possimus soluta doloribus autem, adipisci sed, suscipit a voluptatem. Sequi deserunt dolores, magnam molestias laudantium praesentium cum.
                                        </div>
                                        <div class="producto_precio">
                                            18 - 20 Bs
                                        </div>
                                    </div>
                                </li>
                            */
                            
                            include $_SERVER['DOCUMENT_ROOT'].'/tio/productos/cuadrilla_productos.php';
                            ?>
                            
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="../js/productos_menu.js"></script>
</body>

</html>