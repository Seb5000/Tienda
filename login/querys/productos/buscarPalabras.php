<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';

$bd = new DataBase();
$conn = $bd->conectar();
$producto = new Producto($conn);

$respuesta = array();
$exito = false;

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if(isset($data['palabras'])){
    $palabra = $data['palabras'];
    $array_sugerencias = $producto->buscarSugerenciasNombre($palabra);
    $respuesta["sugerencias"] = $array_sugerencias;
    echo json_encode($respuesta);
}else{
    echo "Hubo un error, debe introducir una palabra en post";
    http_response_code(404);
}

return;
?>