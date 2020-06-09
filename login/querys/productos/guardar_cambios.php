<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';

$bd = new DataBase();

$conn = $bd->conectar();

$producto = new Producto($conn);

$respuesta = array();
$err = false;
$exito = false;

if(isset($_POST["id"]) and isset($_POST["nombre"]) and 
    isset($_POST["categoria"]) and isset($_POST["subcategoria"]) and
    isset($_POST["marca"]) and isset($_POST["caminoImagen"]) and
    isset($_POST["precio"]) and isset($_POST["descripcion"])){

    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $categoria = $_POST["categoria"];
    $subcategoria = $_POST["subcategoria"];
    $caminoImagen = $_POST["caminoImagen"];
    $marca = $_POST["marca"];
    $precio = $_POST["precio"];
    $descripcion = $_POST["descripcion"];
}else{
    header('HTTP/1.1 400 Bad Request');
}

$producto->id = $id;
// VALIDACION PARA EL NOMBRE
if($nombre == ""){
    $respuesta['nombre']="Debe introducir un nombre";
    $err = true;
}else{
    $producto->nombre = $nombre;
}
// ARREGLAR LA CATEGORIA
if($categoria == '' or $categoria ==-1){
    $producto->id_categoria = "NULL";
}else{
    $producto->id_categoria = $categoria;
}
// ARREGLAR LA SUBCATEGORIA
if($subcategoria == '' or $subcategoria ==-1){
    $producto->id_subcategoria = "NULL";
}else{
    $producto->id_subcategoria = $subcategoria;
}
// VERIFICAR SI UNA IMAGEN FUE CARGADA
$seCargoImagen = false;
if(is_uploaded_file($_FILES['imagen']['tmp_name'])){
    $seCargoImagen = true;
    // VERIFICAR EL FORMATO DE LA IMAGEN
    $imagen_cargada = $_FILES['imagen']["name"];
    $extensiones_permitidas= ["jpg", "jpeg", "png", "gif", "tiff", "svg", "webp"];
    $extension_imagen = strtolower(pathinfo($imagen_cargada, PATHINFO_EXTENSION));
    $carpeta_imagen = pathinfo($caminoImagen, PATHINFO_DIRNAME);
    $nombre_imagen = pathinfo($caminoImagen, PATHINFO_FILENAME);
    if(in_array($extension_imagen, $extensiones_permitidas)){
        $producto->imagen = $carpeta_imagen.$nombre_imagen.$extension_imagen;
        $path_completo_imagen = $_SERVER['DOCUMENT_ROOT'].$producto->imagen;
    }else{
        $respuesta['imagen'] = "El formato del archivo no esta permitido";
        $err = true;
    } 
}else{
    $producto->imagen = $caminoImagen;
}

$producto->marca = $marca;
$producto->precio = $precio;
$producto->descripcion = $descripcion;

if(!$err){ //SI NO HAY NINGUN ERROR .... EJECUTAR LA CONSULTA
    $exito = $producto->guardarProducto();
    if($exito and $seCargoImagen){ //SI LA QUERY FUE EXITOSA Y SE CARGO UNA IMAGEN
        move_uploaded_file($_FILES['imagen']['tmp_name'], $path_completo_imagen);
    }
    if($exito){
        $respuesta["mensaje"] = "Se actualizo el registro";
    }else{
        $respuesta["mensaje"] = "Ocurrio un error".$producto->error;
    }
}else{
    $respuesta["mensaje"] = "Valide los campos";
}

$respuesta["success"] = $exito;

echo json_encode($respuesta);
?>
