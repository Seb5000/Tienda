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


$existeC = $Categoria->existeId($idCat);
$existeS = $Subcategoria->existeIdEnCategoria($idSub, $idCat);

if($existeC and $existeS){
    //OBTENER LOS PRODUCTOS DE ESA CATEGORIA Y SUBCATEGORIA
    //echo "La categoria y la subcategoria existen y son correctas".PHP_EOL;
    $nCat = $Categoria->obtenerNombre($idCat);
    $nSub = $Subcategoria->obtenerNombre($idSub);
    //echo "Categoria : $idCat - $nCat".PHP_EOL;
    //echo "Subategoria : $idSub - $nSub".PHP_EOL;
    $productos = $Producto->obtenerProductos($idCat, $idSub);
    //print_r($productos);
    foreach($productos as $prod){
?>
        <li>
            <div class="producto">
                <div class="producto_foto">
                    <img src="<?=$prod['imagen']?>" alt="">
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
        </li>

<?php
    }
}elseif($existeC){
    //OBTENER LAS SUBCATEGORIAS DE ESA CATEGORIA
    //echo "Solo existe la categoria o solo esta es correcta";
    $nCat = $Categoria->obtenerNombre($idCat);
    //echo "Categoria : $idCat - $nCat".PHP_EOL;
    $subcategorias = $Subcategoria->obtenerSubcategorias($idCat);
    //print_r($subcategorias);
    foreach($subcategorias as $sub){
?>
        <li>
            <div class="producto">
                <div class="producto_foto">
                    <img src="<?=$sub['imagen']?>" alt="">
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
        </li>
<?php
    }
}else{
    //MOSTRAR UN MENSAJE QUE NO SE ENCONTRO LA CATEGORIA
    // O MOSTRAR LA PRIMERA CATEGORIA DE LA BASE DE DATOS
    echo "No existe la categoria";
}

?>