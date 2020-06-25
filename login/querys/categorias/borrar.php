<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Categoria.php';
header('Content-Type: application/json');
$bd = new DataBase();
$conn = $bd->conectar();
$categoria = new Categoria($conn);
$respuesta = array();
$err = false;

$json = file_get_contents('php://input');
$data = json_decode($json, true);
if($data['ids']){
    $ids = $data['ids'];
    $arr_imgs = $categoria->seleccionarImagenes($ids);
    $exito = $categoria->borrarCategorias($ids);
}else{
    http_response_code(400);
    $respuesta["mensaje"]= "No se ingresaron bien los datos";
}

if($exito){
    foreach($arr_imgs as $img){
        $nombreimg = pathinfo($caminoLogo, PATHINFO_FILENAME);
        if($nombreimg != "defecto"){
            unlink($_SERVER['DOCUMENT_ROOT'].$img);
        }
    }
    $respuesta["mensaje"]= "Se eliminaron correctamente el(los) registro(s) <br/>";
}else{
    $respuesta["mensaje"]= "Error: no se pudo eliminar el(los) registro(s), ".$categoria->getError();
    http_response_code(500);
}
echo json_encode($respuesta);