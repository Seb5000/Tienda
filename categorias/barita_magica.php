<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/menu_categorias.css">
</head>

<body>
    <?php include('../compartidos/menu_categorias.php'); ?>
    <?php include('../compartidos/conexion_bd.php'); ?>
    <?php
    $sql = "SELECT NOMBRE_SUBCATEGORIA FROM `subcategorias` WHERE `CATEGORIA_SUBCATEGORIA` LIKE 'barita magica' ";
    $result = $conn->query($sql);
    $lista_subcategorias = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($lista_subcategorias, $row["NOMBRE_SUBCATEGORIA"]);
        }
    }
    print_r($lista_subcategorias);

    if(isset($_GET['sub_categoria'])){
        $sub_categoria = $_GET['sub_categoria'];
    }else{
        $sub_categoria = "defecto";
    }
    ?>

    <section class="barraDirecciones">
        <div class="contenedor2">
            <ul class="breadcrumbs">
                <li class="breadcrumbs__item">
                    <a href="" class="breadcrumbs__link">Inicio</a>
                </li>
                <li class="breadcrumbs__item">
                    <a href="" class="breadcrumbs__link">Nuestros Productos</a>
                </li>
                <li class="breadcrumbs__item">
                    <a href="" class="breadcrumbs__link breadcrumbs__link--active">Barita Magica</a>
                </li>
                <?php 
                    if($sub_categoria!="defecto"){
                        echo '<li class="breadcrumbs__item">
                            <a href="" class="breadcrumbs__link breadcrumbs__link--active">'.$sub_categoria.'</a>
                            </li>';
                    }
                ?>
            </ul>
        </div>
    </section>

    <section id="contenedorPrincipal">
        <div class="contenedor3">
            <div class="caja3">
                Barita Magica
            </div>
            <div class="caja4">
                <div class="barraLateral hidden">
                </div>
                <div class="contenedorProductos">
                    <div class="caja_Productos">
                        <div class="titulo_Producto">
                            <h2>Producto numero 1 bla bla bla!</h2>
                        </div>
                        <ul class="cuadrilla_Productos">
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