<?php
include("../../../compartidos/conexion_bd.php");
//include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/redim2.php';
$respuesta = [];
$respuesta["error"] = false;
$cambioDeImagen = false;
$imagenPorDefecto = false;
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
$camino_imagenS = $_POST["caminoImagenS"];
$path_parcial_imagen = $camino_imagen;
$path_parcial_imagenS = $camino_imagenS;
$extensiones_permitidas= ["jpg", "jpeg", "png", "gif", "svg", "webp"];
if(is_uploaded_file($_FILES['imagen']['tmp_name'])){
    $nombre_imagen_cargada = $_FILES['imagen']['name'];
    $nombre_imagen = pathinfo($camino_imagen, PATHINFO_FILENAME);
    $nombre_imagenS = pathinfo($camino_imagenS, PATHINFO_FILENAME);
    $carpeta_imagen = pathinfo($camino_imagen, PATHINFO_DIRNAME);
    $extension_imagen = strtolower(pathinfo($nombre_imagen_cargada, PATHINFO_EXTENSION));
    if(in_array($extension_imagen, $extensiones_permitidas)){
        if($nombre_imagen == "defecto"){
            $imagenPorDefecto = true;
            $nombre_imagen = uniqid("SUB", true);
            $nombre_imagenS = "S".$nombre_imagen;
            $carpeta_imagen = "/tio/imagenes/subcategorias";
        }
        $path_parcial_imagen = $carpeta_imagen."/".$nombre_imagen.".".$extension_imagen;
        $path_parcial_imagenS = $carpeta_imagen."/".$nombre_imagenS.".".$extension_imagen;
        $path_completo_imagen = $_SERVER['DOCUMENT_ROOT'].$path_parcial_imagen;
        $path_completo_imagenS = $_SERVER['DOCUMENT_ROOT'].$path_parcial_imagenS;

        //$camino_imagen = "/tio/imagenes/sub_categorias/s$idSub.$extension_imagen";
        //$camino_relativo_imagen = "../../../imagenes/sub_categorias/s$idSub.$extension_imagen";
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
    IMAGEN_SUBCATEGORIA='$path_parcial_imagen', IMAGEN_SM_SUBCATEGORIA='$path_parcial_imagenS',
    DESCRIPCION_SUBCATEGORIA='$descripcion'
    WHERE ID_SUBCATEGORIA=$idSub";
    if($conn2->query($sql) === TRUE) {
        $respuesta["mensaje"] = "El registro fue actualizado!";
    }else{
        $respuesta["error"]=true;
        $respuesta["mensaje"] .= "<br>Error al editar el registro ".$conn2->error;
    }
}

if(!$respuesta["error"] && $cambioDeImagen){ //si no hay error y hubo un cambio de imagen
    if($imagenPorDefecto == false){
        unlink($_SERVER['DOCUMENT_ROOT'].$camino_imagen);
        unlink($_SERVER['DOCUMENT_ROOT'].$camino_imagenS);
    }
    move_uploaded_file($_FILES['imagen']['tmp_name'], $path_completo_imagen);
    redimensionar($path_completo_imagen, $path_completo_imagenS, 320, 320, 70);
    redimensionar($path_completo_imagen, $path_completo_imagen, 800, 600, 80);
    //move_uploaded_file($_FILES['imagen']['tmp_name'], $camino_relativo_imagen);
}

echo json_encode($respuesta);
?>