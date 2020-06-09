<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';

$bd = new DataBase();

$conn = $bd->conectar();

$producto = new Producto($conn);

$respuesta = array();
$err = false;

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if($data['ids']){
    $producto->id = $data['ids'];
    $exito = $producto->borrarProductos();
}

if($exito){
    $respuesta["exito"]= true;
    $respuesta["mensaje"]= "Se elimino correctamente el registro <br/>".$producto->queryE;
}else{
    $respuesta["exito"]= false;
    $respuesta["mensaje"]= "Error: ".$producto->error;
}

echo json_encode($respuesta);