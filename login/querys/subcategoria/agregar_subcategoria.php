<?php
include('../../../compartidos/conexion_bd.php');
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/redim2.php';
$respuesta = [
    "nombre"=>"",
    "categoria"=> "",
    "imagen"=>"",
    "descripcion"=>"",
    "error"=>false,
    "mensaje"=>""
]; 
$cargoImg = false;
if(isset($_POST["nombre"]) && isset($_POST["categoria"])){

    $nombre = $_POST["nombre"];
    $idCategoria = $_POST["categoria"];
    $descripcion = $_POST["descripcion"];

    if(empty($nombre)){
        $respuesta["error"] = true;
        $respuesta["nombre"] .= "Debe ingresar un nombre";
    }
    if(is_uploaded_file($_FILES['imagen']['tmp_name'])){
        $cargoImg = true;
        $imagen = $_FILES['imagen']["name"];
        $extensiones_permitidas= ["jpg", "jpeg", "png", "gif", "svg", "webp"];
        /*
        $sql = "SELECT MAX(ID_SUBCATEGORIA) FROM `SUBCATEGORIA`";
        $result = $conn->query($sql);
        if($result->num_rows == 0){
            $ultimo_id = 1;
        }else{
            $row = mysqli_fetch_assoc($result);
            //echo("row en id.. <br>"); producia error al devolver un json
            //print_r($row);
            $ultimo_id = $row['MAX(ID_SUBCATEGORIA)'];
        }
        */
        $nombre_imagen="defecto.svg";
        $extension_imagen = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
        if(in_array($extension_imagen, $extensiones_permitidas)){
            $nombre_imagen = uniqid("SUB", true);
            $nombre_imagen = $nombre_imagen.".".$extension_imagen;
            $path_completo_imagen = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/subcategorias/".$nombre_imagen;
            $path_completo_imagenS = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/subcategorias/S".$nombre_imagen;
            $path_parcial_imagen = "/tio/imagenes/subcategorias/".$nombre_imagen;
            $path_parcial_imagenS = "/tio/imagenes/subcategorias/S".$nombre_imagen;
            //$nombre_imagen = "s".((int)$ultimo_id+1).".".$extension_imagen; 
        }else{
            $respuesta["error"] = true;
            $respuesta["imagen"] .= "El formato del archivo no es permitido";
        }
    }else{
        $nombre_imagen="defecto.svg";
        $path_parcial_imagen = "/tio/imagenes/".$nombre_imagen;
        $path_parcial_imagenS = $path_parcial_imagen;
        //$respuesta["error"] = true;
        //$respuesta["imagen"] = "Debe seleccionar una imagen";
    }
    //$path_relativo_imagen = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/sub_categorias/".$nombre_imagen;
    //$path_absoluto_imagen = "/tio/imagenes/sub_categorias/".$nombre_imagen;
    
    //Si aun no ha habido error
    if(!$respuesta["error"]){
        $sql = "INSERT INTO `subcategoria` (`ID_SUBCATEGORIA`, `ID_CATEGORIA`, `NOMBRE_SUBCATEGORIA`,
        `IMAGEN_SUBCATEGORIA`, `IMAGEN_SM_SUBCATEGORIA`, `DESCRIPCION_SUBCATEGORIA`) 
        VALUES (NULL, '$idCategoria', '$nombre', '$path_parcial_imagen', '$path_parcial_imagenS', '$descripcion');";
        
        if ($conn->query($sql) === TRUE) {
            if($cargoImg){
                move_uploaded_file($_FILES['imagen']['tmp_name'], $path_completo_imagen);  
                redimensionar($path_completo_imagen, $path_completo_imagenS, 320, 320, 70);
                redimensionar($path_completo_imagen, $path_completo_imagen, 800, 600, 80);
            }
            $respuesta["mensaje"] = "Se inserto la Subcategoria a la base de datos";
        }else{
            $respuesta["error"] = true;
            $respuesta["mensaje"] = "Error al insertar la Subcategoria 
            a la base de datos: <br>".$conn->error;
        }
    }
}else{
    $respuesta["error"] = true;
    $respuesta["nombre"] .= "No se ingreso un nombre";
}
echo json_encode($respuesta);
?>

