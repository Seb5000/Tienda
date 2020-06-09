<?php
include('../../../compartidos/conexion_bd.php');
$respuesta = [
    "nombre"=>"",
    "categoria"=> "",
    "imagen"=>"",
    "descripcion"=>"",
    "error"=>false,
    "mensaje"=>""
]; 
if(isset($_POST["nombre"]) && isset($_POST["categoria"])){

    
    $nombre = $_POST["nombre"];
    $idCategoria = $_POST["categoria"];
    $descripcion = $_POST["descripcion"];

    if(empty($nombre)){
        $respuesta["error"] = true;
        $respuesta["nombre"] .= "Debe ingresar un nombre";
    }
    if(is_uploaded_file($_FILES['imagen']['tmp_name'])){
        $imagen = $_FILES['imagen']["name"];
        $extensiones_permitidas= ["jpg", "jpeg", "png", "gif", "tiff", "svg", "webp"];
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
        $nombre_imagen="por_defecto.jpg";
        $extension_imagen = pathinfo($imagen, PATHINFO_EXTENSION);
        $extension_imagen= strtolower($extension_imagen);
        if(in_array($extension_imagen, $extensiones_permitidas)){
            $nombre_imagen = "s".((int)$ultimo_id+1).".".$extension_imagen; 
        }else{
            $respuesta["error"] = true;
            $respuesta["imagen"] .= "El formato del archivo no es permitido";
        }

        $path_relativo_imagen = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/sub_categorias/".$nombre_imagen;
        $path_absoluto_imagen = "/tio/imagenes/sub_categorias/".$nombre_imagen;

        //Si aun no ha habido error
        if(!$respuesta["error"]){
            $sql = "INSERT INTO `subcategoria` (`ID_SUBCATEGORIA`, `ID_CATEGORIA`, `NOMBRE_SUBCATEGORIA`,
            `IMAGEN_SUBCATEGORIA`, `DESCRIPCION_SUBCATEGORIA`) 
            VALUES (NULL, '$idCategoria', '$nombre', '$path_absoluto_imagen', '$descripcion');";
            move_uploaded_file($_FILES['imagen']['tmp_name'], $path_relativo_imagen);
            if ($conn->query($sql) === TRUE) {
                $respuesta["mensaje"] = "Se inserto la Subcategoria a la base de datos";
            }else{
                $respuesta["error"] = true;
                $respuesta["mensaje"] = "Error al insertar la Subcategoria 
                a la base de datos: <br>".$conn->error;
            }
        }
    }else{
        $respuesta["error"] = true;
        $respuesta["imagen"] = "Debe seleccionar una imagen";
    }
}else{
    $respuesta["error"] = true;
    $respuesta["nombre"] .= "No se ingreso un nombre";
}
echo json_encode($respuesta);
?>

