<?php
include("../../../compartidos/conexion_bd.php");
$respuesta = [];
$ids = $_POST['ids'];
$respuesta["status"]= "success";
$respuesta["data"]["mensaje"]="";

if(isset($_POST['ids'])){
    $caminoCarpeta = $_SERVER['DOCUMENT_ROOT'];
    $sql = "SELECT IMAGEN_SUBCATEGORIA, IMAGEN_SM_SUBCATEGORIA FROM `SUBCATEGORIA` WHERE ID_SUBCATEGORIA in ($ids)";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $imagen = $caminoCarpeta.$row["IMAGEN_SUBCATEGORIA"];
            $imagenS = $caminoCarpeta.$row["IMAGEN_SM_SUBCATEGORIA"];
            $nombre_imagen = pathinfo($imagen, PATHINFO_FILENAME);
            if($nombre_imagen != "defecto"){
                unlink($imagen);
                unlink($imagenS);
            }
        }
    }
    else{
        $respuesta["status"]= "error";
        $respuesta["data"]["mensaje"]= "No se encontraron los registros especificados ".$ids."<br/>".$conn->error;;
    }
    $sql = "DELETE FROM `SUBCATEGORIA` WHERE ID_SUBCATEGORIA in ($ids)";

    if($conn->query($sql) === TRUE ){
        $respuesta["status"]= "success";
        $respuesta["data"]["mensaje"]= "Se borro correctamente el(los) registro(s): ".$ids;
    }else{
        $respuesta["status"]= "error";
        $respuesta["data"]["mensaje"]= "Ocurrio un error al borrar el(los) registro(s): ".$ids."<br>".$conn->error;
    }
}

echo json_encode($respuesta);
?>
