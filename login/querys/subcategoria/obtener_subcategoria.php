<?php
include("../../../compartidos/conexion_bd.php");
$ids = $_POST['id'];
$respuesta = [];
$respuesta["error"] = false;
$respuesta["mensaje"] = "";
if(isset($_POST['id'])){
    $id = $_POST['id'];
    if(is_numeric($id)){
        $sql = "SELECT * FROM SUBCATEGORIA WHERE ID_SUBCATEGORIA = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $respuesta["subcategoria"]["idSub"]=$row["ID_SUBCATEGORIA"];
            $respuesta["subcategoria"]["idCat"]=$row["ID_CATEGORIA"];
            $respuesta["subcategoria"]["nombre"]=$row["NOMBRE_SUBCATEGORIA"];
            $respuesta["subcategoria"]["imagen"]=$row["IMAGEN_SUBCATEGORIA"];
            $respuesta["subcategoria"]["imagenS"]=$row["IMAGEN_SM_SUBCATEGORIA"];
            $respuesta["subcategoria"]["descripcion"]=$row["DESCRIPCION_SUBCATEGORIA"];
        }else{
            $respuesta["error"] = true;
            $respuesta["mensaje"] .= "Error al acceder a la base de datos";
        }
    }else{
        $respuesta["error"] = true;
        $respuesta["mensaje"] .= "Se debe ingresar un id numerico";
    }
}else{
    $respuesta["error"] = true;
    $respuesta["mensaje"] .= "No se ha ingresado el id de la subcategoria";
}

echo json_encode($respuesta);