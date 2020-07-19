<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Categoria.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/redim2.php';
header('Content-Type: application/json');

$bd = new DataBase();
$conn = $bd->conectar();
$categoria = new Categoria($conn);
$err = false;
$respuesta = array();

if(!isset($_POST["id"]) or !isset($_POST["nombre"]) or 
!isset($_POST["caminoImagen"]) or !isset($_POST["descripcion"])){
    $respuesta["mensaje"]="No se introdujeron bien los datos id, nombre, 
    caminoImagen, caminoLogo, descripcion.";
    echo json_encode($respuesta);
    http_response_code(400);
    return;
}

$id = $_POST["id"];
$nombre = $_POST["nombre"];
$caminoImagen = $_POST["caminoImagen"];
$caminoImagenS = $_POST["caminoImagenS"];
$descripcion = $_POST["descripcion"];

$categoria->id = $id;
// VALIDACION PARA EL NOMBRE
if($nombre == ""){
    $respuesta['nombre']="Debe introducir un nombre";
    $err = true;
}else{
    $categoria->nombre = $nombre;
}

$extensiones_permitidas= ["jpg", "jpeg", "png", "gif", "svg", "webp"];
// VERIFICAR SI UNA IMAGEN FUE CARGADA
$cargoImagen = false;
$imagenPorDefecto = false;
if(is_uploaded_file($_FILES['imagen']['tmp_name'])){
    $cargoImagen = true;
    // VERIFICAR EL FORMATO DE LA IMAGEN
    $imagen_cargada = $_FILES['imagen']["name"];
    $extension_imagen = strtolower(pathinfo($imagen_cargada, PATHINFO_EXTENSION));
    $carpeta_imagen = pathinfo($caminoImagen, PATHINFO_DIRNAME);
    $nombre_imagen = pathinfo($caminoImagen, PATHINFO_FILENAME);
    $nombre_imagenS = pathinfo($caminoImagenS, PATHINFO_FILENAME);
    if(in_array($extension_imagen, $extensiones_permitidas)){
        if($nombre_imagen == "defecto"){
            $imagenPorDefecto = true;
            $nombre_imagen = uniqid("C", true);
            $nombre_imagenS = "S".$nombre_imagen;
            $carpeta_imagen = "/tio/imagenes/categorias";
        }
        $categoria->imagen = $carpeta_imagen."/".$nombre_imagen.".".$extension_imagen;
        $categoria->imagenSM = $carpeta_imagen."/".$nombre_imagenS.".".$extension_imagen;
        $path_completo_imagen = $_SERVER['DOCUMENT_ROOT'].$categoria->imagen;
        $path_completo_imagenS = $_SERVER['DOCUMENT_ROOT'].$categoria->imagenSM;
    }else{
        $respuesta['imagen'] = "El formato del archivo no esta permitido";
        $err = true;
    } 
}else{
    $categoria->imagen = $caminoImagen;
}

$categoria->descripcion = $descripcion;

//SI NO HAY NINGUN ERROR .... EJECUTAR LA CONSULTA
if(!$err){ 
    $exito = $categoria->guardarCategoria();
    if($exito and $cargoImagen){ //SI LA QUERY FUE EXITOSA Y SE CARGO UNA IMAGEN
        if($imagenPorDefecto == false){
            unlink($_SERVER['DOCUMENT_ROOT'].$caminoImagen);
            unlink($_SERVER['DOCUMENT_ROOT'].$caminoImagenS);
        }
        move_uploaded_file($_FILES['imagen']['tmp_name'], $path_completo_imagen);  
        redimensionar($path_completo_imagen, $path_completo_imagenS, 320, 320, 70);
        redimensionar($path_completo_imagen, $path_completo_imagen, 800, 600, 80);
    }
    if($exito){
        $respuesta["mensaje"] = "Se actualizo el registro";
        echo json_encode($respuesta);
        return;
    }else{
        $respuesta["mensaje"] = "Ocurrio un error".$categoria->getError();
        echo json_encode($respuesta);
        http_response_code(500);
        return;
    }
}else{
    $respuesta["mensaje"] = "Valide los campos";
    echo json_encode($respuesta);
    http_response_code(400);
    return;
}