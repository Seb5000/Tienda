<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Categoria.php';

$bd = new DataBase();
$conn = $bd->conectar();
$categoria = new Categoria($conn);
$err = false;

$json = file_get_contents('php://input');
$data = json_decode($json, true);
header('Content-Type: application/json');
$respuesta = array();

if(isset($data['id'])){
    $exito = $categoria->obtenerCategoria($data['id']);

    if($exito){
        $respuesta = $categoria;
        echo json_encode($respuesta);
        return;
    }else{
        $respuesta["mensaje"]=$categoria->getError();
        echo json_encode($respuesta);
        http_response_code(404);
        return;
    }
}else{
    $respuesta["mensaje"]="No se introdujo un ID";
    echo json_encode($respuesta);
    http_response_code(400);
    return;
}
