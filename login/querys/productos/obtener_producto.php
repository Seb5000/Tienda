<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';

$bd = new DataBase();

$conn = $bd->conectar();

$producto = new Producto($conn);

$respuesta = array();
$respuesta["exito"] = true;
$err = false;

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if(isset($data['id'])){
    $producto->id = $data['id'];
    $exito = $producto->obtenerProducto();
    if($exito){
        $respuesta["producto"]["id"] = $producto->id;
        $respuesta["producto"]["nombre"] = $producto->nombre;
        $respuesta["producto"]["idCat"] = $producto->id_categoria;
        $respuesta["producto"]["nomCat"] = $producto->nombre_categoria;
        $respuesta["producto"]["idSub"] = $producto->id_subcategoria;
        $respuesta["producto"]["nomSub"] = $producto->nombre_subcategoria;
        $respuesta["producto"]["imagen"] = $producto->imagen;
        $respuesta["producto"]["marca"] = $producto->marca;
        $respuesta["producto"]["precio"] = $producto->precio;
        $respuesta["producto"]["descripcion"] = $producto->descripcion;
    }else{
        $respuesta['exito']=false;
        $respuesta["mensaje"]=$producto->error;
    }
}else{
    $respuesta['exito']=false;
    $respuesta['mensaje']="No se introdujo un id, se debe pasar este por post con el nombre de (id)";
}

echo json_encode($respuesta);

