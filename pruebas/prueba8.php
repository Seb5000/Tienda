<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Imagen.php';

$bd = new DataBase();

$conn = $bd->conectar();

$cImagen = new Imagen($conn);

if($cImagen->borrarImagenesIdProd(1)){
    echo "Borro";
}else{
    echo "No borro";
}
?>