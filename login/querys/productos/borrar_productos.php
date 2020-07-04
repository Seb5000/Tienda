<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Imagen.php';

$bd = new DataBase();

$conn = $bd->conectar();

$producto = new Producto($conn);
$imagen = new Imagen($conn);

$respuesta = array();
$err = false;

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if($data['ids']){
    $ids = $data['ids'];
    $arr_imgs = $imagen->obtenerImagenes($ids);
    foreach($arr_imgs as $imagen){
        $nombreimg = pathinfo($imagen, PATHINFO_FILENAME);
        if($nombreimg != "defecto"){
            unlink($_SERVER['DOCUMENT_ROOT'].$imagen);
        }
    }
    $producto->id = $ids;
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