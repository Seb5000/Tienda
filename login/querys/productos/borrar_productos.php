<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Subcategoria.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Imagen.php';

$bd = new DataBase();

$conn = $bd->conectar();

$producto = new Producto($conn);
$subcategoria = new Subcategoria($conn);
$imagen = new Imagen($conn);

$respuesta = array();
$err = false;

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if($data['ids']){
    $ids = $data['ids'];
    //print_r($ids);
    $arr_imgs = $imagen->obtenerImagenes($ids);
    $arr_subs = $producto->contarIdsSubcategorias($ids);
    //print_r($arr_imgs);
    //print_r($arr_subs);
    foreach($arr_imgs as $imagen){
        //echo $imagen;
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
    foreach($arr_subs as $nSub){
        $subcategoria->modificarCantidadProductos($nSub["id"], -$nSub["veces"]);
    }
}else{
    $respuesta["exito"]= false;
    $respuesta["mensaje"]= "Error: ".$producto->error;
}

echo json_encode($respuesta);

?>