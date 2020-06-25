<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Subcategoria.php';

$bd = new DataBase();

$conn = $bd->conectar();

$subcategoria = new Subcategoria($conn);

$respuesta = array();
$exito = false;

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if($data['palabra']){
    $palabra = $data['palabra'];
    $array_sugerencias = $subcategoria->buscarSugerenciasNombre($palabra);
    $respuesta["sugerencias"] = $array_sugerencias;
}else{
    
}

echo json_encode($respuesta);
?>
