<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';

$bd = new DataBase();

$conn = $bd->conectar();

$producto = new Producto($conn);

$id = $_POST["id"] ?? 1;

$producto->id = $id;
$exito = $producto->obtenerProducto();
if($exito){
    echo json_encode($producto);
}else{
    echo "Error";
}
?>
