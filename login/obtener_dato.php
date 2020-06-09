<?php
    include("../compartidos/conexion_bd.php");
    $respuesta = [];
    $respuesta["id"]=0;
    $respuesta["error"]=false;
    $respuesta["mensaje"]="";
    $respuesta["nombre"]="";
    $respuesta["imagen"]="";
    $respuesta["logo"]="";
    $respuesta["descripcion"]="";
    if(isset($_POST["id"])){
        $id = $_POST["id"];
        $respuesta["id"]=$id;
        $sql = "SELECT * FROM `CATEGORIA` WHERE ID_CATEGORIA = $id";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $respuesta["nombre"]=$row["NOMBRE_CATEGORIA"];
            $respuesta["imagen"]=$row["IMAGEN_CATEGORIA"];
            $respuesta["logo"]=$row["LOGO_CATEGORIA"];
            $respuesta["descripcion"]=$row["DESCRIPCION_CATEGORIA"];
        }else{
            $respuesta["error"]=true;
            $respuesta["mensaje"]="Ocurrio un error al consultar la base de datos".$conn->error;
        }
    }
    echo json_encode($respuesta);
?>