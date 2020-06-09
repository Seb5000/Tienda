<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Subcategoria.php';

$bd = new DataBase();

$conn = $bd->conectar();

$subcategorias = new Subcategoria($conn);

//Obtener los datos enviados por POST en formato JSON
$json = file_get_contents('php://input');
$data = json_decode($json, true);
$respuesta = array();
$respuesta["exito"] = false;
$respuesta["subcategorias"]= array();
if($data['id']){
    $idCategoria = $data['id'];
    $arrSubcategorias = $subcategorias->getSubcategorias($idCategoria);
    $respuesta["subcategorias"]=$arrSubcategorias;
    $respuesta["exito"]=true;
}else{
    //http_response_code(400);
    $respuesta["mensaje"]="No se introdujo el id producto";
}
echo json_encode($respuesta);

