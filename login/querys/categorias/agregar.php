<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Categoria.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/redim2.php';
$bd = new DataBase();
$conn = $bd->conectar();
$categoria = new Categoria($conn);
$respuesta = array();
$respuesta["mensaje"] = "";
$err = false;

// VALIDACION PARA NOMBRE
$respuesta['nombre']="";
if(isset($_POST['nombre'])){
    $nombre = $_POST['nombre'];
    if(empty($nombre)){
        $err = true;
        $respuesta['nombre']="El nombre esta vacio";
    }
}else{
    $err = true;
    $respuesta['nombre']="Debe ingresar un nombre";
}
//FIN VALIDACION NOMBRE

// VALIDACION PARA IMAGEN Y LOGO
$extensiones_permitidas= ["jpg", "jpeg", "png", "gif", "svg", "webp"];
$respuesta['imagen']="";
$cargoImagen=false;
//$sigId = $categoria->siguienteId();
//PARA LA IMAGEN
if(is_uploaded_file($_FILES['imagen']['tmp_name'])){ //SE SUBIO ALGUN ARCHIVO
    $cargoImagen = true;
    $imagen = $_FILES['imagen']["name"];
    $imagenTmpName = $_FILES['imagen']["tmp_name"];
    $imagenSize = $_FILES['imagen']["size"];
    $imagenError = $_FILES['imagen']["error"];
    $imagenType = $_FILES['imagen']["type"];

    $extension_imagen = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
    //$nomImagen = "ci".$sigId; //concatenamos el nombre de la siguiente imagen con una p
    //$nomImagen = "ci".$sigId; //concatenamos el nombre de la siguiente imagen con una p
    if(in_array($extension_imagen, $extensiones_permitidas)){ //verificamos que la extension este permitida
        if($imagenError === 0){
            if($imagenSize < 15000000){
                $nomImagen = uniqid("C", true);
                $nomImagen = $nomImagen.".".$extension_imagen; // concatenamos el nombre con la extension
                $path_completo_imagen = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/categorias/".$nomImagen;
                $path_completo_imagenS = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/categorias/S".$nomImagen;
                $path_parcial_imagen = "/tio/imagenes/categorias/".$nomImagen;
                $path_parcial_imagenS = "/tio/imagenes/categorias/S".$nomImagen;
            }else{
                $err = true;
                $respuesta['imagen'] .= "Imagen demasiado grande debe ser menor a 15Mb";
            }
        }else{
            $err = true;
            $respuesta['imagen'] .= "Ocurrio un error cargando la imagen";
        }
        
    }else{
        $err = true;
        $respuesta['imagen'] .= "El formato de la imagen no es permitido / ";
    }
}else{
    $nomImagen = "defecto.svg";
    $path_parcial_imagen = "/tio/imagenes/".$nomImagen;
    $path_parcial_imagenS = "/tio/imagenes/".$nomImagen;
}

//PARA LA DESCRIPCION
$descripcion = $_POST['descripcion'] ?? "";

//SI NO OCURRIO NINGUN ERROR EN LA VALIDACION
if(!$err){
    $categoria->nombre = $nombre;
    $categoria->imagen = $path_parcial_imagen; //pasamos el camino hacia la imagen
    $categoria->imagenSM = $path_parcial_imagenS; //pasamos el camino hacia la imagen
    $categoria->descripcion = $descripcion;

    $query = $categoria->agregar();
    //SI LA QUERY FUE EXITOSA
    if($query){ 
        //MOVER EL ARCHIVO DENTRO DE LA CARPETA SI SE CARGO UNA IMAGEN
        if($cargoImagen){
            move_uploaded_file($_FILES['imagen']['tmp_name'], $path_completo_imagen);  
            redimensionar($path_completo_imagen, $path_completo_imagenS, 320, 320, 70);
            redimensionar($path_completo_imagen, $path_completo_imagen, 800, 600, 80);
        }
        $respuesta["mensaje"] = "Se agrego existosamente el registro";
    }else{
        $err = true;
        $respuesta["mensaje"] = "Ocurrio un error: ".$categoria->getError();
    }
}else{
    $respuesta["mensaje"] = "Valide los campos del formulario";
}

$respuesta["error"] = $err;

echo json_encode($respuesta);