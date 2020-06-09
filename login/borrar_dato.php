<?php
include("../compartidos/conexion_bd.php");
$ids = $_POST['stringIds'];
$archivos_a_borrar = [];
$caminoCarpeta = $_SERVER['DOCUMENT_ROOT'];
$sql = "SELECT IMAGEN_CATEGORIA, LOGO_CATEGORIA FROM `CATEGORIA` WHERE ID_CATEGORIA in ($ids)";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $imagen = $caminoCarpeta.$row["IMAGEN_CATEGORIA"];
        $logo = $caminoCarpeta.$row["LOGO_CATEGORIA"];
        unlink($imagen);
        unlink($logo);
    }
}
//$ids = explode(',', $ids);
/*
foreach($ids as $id){
    $sql = "SELECT MAX(ID_CATEGORIA) FROM `CATEGORIA`";
    $result = $conn->query($sql);
}
*/

$sql = "DELETE FROM `CATEGORIA` WHERE ID_CATEGORIA in ($ids)";
$respuesta = [];
if($conn->query($sql) === TRUE ){
    $respuesta["error"]= false;
    $respuesta["mensaje"]= "se borro correctamente el(los) registro(s): ".$ids;
}else{
    $respuesta["error"]= true;
    $respuesta["mensaje"]= "Ocurrio un error al borrar el(los) registro(s): ".$ids."<br>".$conn->error;
}

echo json_encode($respuesta);
?>
