<?php
include("../../../compartidos/conexion_bd.php");
$respuesta = [];
$respuesta["error"] = false;
$cambioDeImagen = false;
$idSub = $_POST["id"];
$idCat = $_POST["categoria"];
if(isset($_POST["nombre"])){
    $nombre = $_POST["nombre"];
}else{
    $respuesta["error"] = true;
    $respuesta["nombre"] = "Debe introducir un nombre a la subcategoria";
}

$descripcion = $_POST["descripcion"];
/*
print_r($_POST);
print_r($_FILES);
echo ("Existe el archivo :".$_FILES['imagen']['name']);
*/
$camino_imagen = $_POST["caminoImagen"];
$extensiones_permitidas= ["jpg", "jpeg", "png", "gif", "tiff", "svg", "webp"];
if(is_uploaded_file($_FILES['imagen']['tmp_name'])){
    $nombre_imagen = $_FILES['imagen']['name'];
    $antiguo_nombre_imagen = pathinfo($camino_imagen, PATHINFO_FILENAME);
    $extension_imagen = pathinfo($nombre_imagen, PATHINFO_EXTENSION);
    $extension_imagen= strtolower($extension_imagen);
    if(in_array($extension_imagen, $extensiones_permitidas)){
        $camino_imagen = "/tio/imagenes/sub_categorias/s$idSub.$extension_imagen";
        $camino_relativo_imagen = "../../../imagenes/sub_categorias/s$idSub.$extension_imagen";
        $cambioDeImagen = true;
    }else{
        $respuesta["error"] = true;
        $respuesta["imagen"] = "El formato del archivo no es permitido";
    }
}else{
    $respuesta["imagen"] = "No se subio ningun archivo";
}

if(!$respuesta["error"]){ //Si no hay error
    $sql = "UPDATE SUBCATEGORIA SET ID_CATEGORIA=$idCat, NOMBRE_SUBCATEGORIA='$nombre',
    IMAGEN_SUBCATEGORIA='$camino_imagen', DESCRIPCION_SUBCATEGORIA='$descripcion' 
    WHERE ID_SUBCATEGORIA=$idSub";
    if($conn->query($sql) === TRUE) {
        $respuesta["mensaje"] = "El registro fue actualizado!";
    }else{
        $respuesta["error"]=true;
        $respuesta["mensaje"] .= "<br>Error al editar el registro ".$conn->error;
    }
}

if(!$respuesta["error"] && $cambioDeImagen){ //si no hay error y hubo un cambio de imagen
    move_uploaded_file($_FILES['imagen']['tmp_name'], $camino_relativo_imagen);
}

echo json_encode($respuesta);
?>