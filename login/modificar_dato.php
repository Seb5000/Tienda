<?php
    include("../compartidos/conexion_bd.php");
    $respuesta = array();
    $respuesta["nombre"]["error"] = false;
    $respuesta["nombre"]["mensaje"] = "";
    $respuesta["descripcion"]["error"] = false;
    $respuesta["descripcion"]["mensaje"] = "";
    $respuesta["imagen"]["error"] = false;
    $respuesta["imagen"]["mensaje"] = "";
    $respuesta["logo"]["error"] = false;
    $respuesta["logo"]["mensaje"] = "";
    $respuesta["sql"]["error"] = false;
    $respuesta["sql"]["mensaje"] = "";
    $respuesta["error"] = false;

    if(isset($_POST["id_editar"]) && isset($_POST["nombre_editar"]) && isset($_POST["descripcion_editar"])){
        $id = $_POST["id_editar"];
        $nombre = $_POST["nombre_editar"];
        $descripcion = $_POST["descripcion_editar"];
        $imagen_modificada = false;
        $logo_modificado = false;
        $nombre_imagen_cargada = "";
        $path_imagen_absoluto = "";
        $path_imagen_relativo = "";
        $nombre_logo_cargado = "";
        $path_logo_absoluto = "";
        $path_logo_relativo = "";
        $extension_nueva_imagen = "";
        $extension_nuevo_logo = "";
        $respuesta["nombre"]["mensaje"] = " nombre: $nombre";
        $respuesta["descripcion"]["mensaje"] = " nombre: $descripcion";
        
        $extensiones_permitidas= ["jpg", "jpeg", "png", "gif", "tiff", "svg", "webp"];

        $sql = "SELECT * FROM `CATEGORIA` WHERE ID_CATEGORIA = $id";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $path_imagen_absoluto = $row["IMAGEN_CATEGORIA"];
            $path_logo_absoluto = $row["LOGO_CATEGORIA"];
        }else{
            $respuesta["sql"]["error"]= true;
            $respuesta["sql"]["mensaje"]= "Ocurrio un error al editar el registro (Select): ".$id."<br>".$conn->error;
        }


        if(is_uploaded_file($_FILES['imagen_editar']['tmp_name'])){
            $imagen_modificada = true;
            //"La imagen fue modificada";
            $nombre_imagen_cargada = $_FILES['imagen_editar']['name'];
            $extension_imagen_cargada = pathinfo($nombre_imagen_cargada, PATHINFO_EXTENSION);
            $extension_imagen_cargada= strtolower($extension_imagen_cargada);
            if(in_array($extension_imagen_cargada, $extensiones_permitidas)){
                $nombre_imagen = pathinfo($path_imagen_absoluto, PATHINFO_FILENAME);
                $nombre_imagen = $nombre_imagen.".".$extension_imagen_cargada;
                $path_imagen_absoluto = "/tio/imagenes/categorias/".$nombre_imagen;
                $path_imagen_relativo = "../imagenes/categorias/".$nombre_imagen;
            }else{
                $respuesta["imagen"]["error"] = true;
                $respuesta["imagen"]["mensaje"] = "El formato elegido no es permitido";
            }
        }else{
            //"La imagen no fue modificada";
        }

        if(is_uploaded_file($_FILES['logo_editar']['tmp_name'])){
            $logo_modificado = true;
            //"El logo fue modificado";
            $nombre_logo_cargado = $_FILES['logo_editar']['name'];
            $extension_logo_cargado = pathinfo($nombre_logo_cargado, PATHINFO_EXTENSION);
            $extension_logo_cargado= strtolower($extension_logo_cargado);
            if(in_array($extension_logo_cargado, $extensiones_permitidas)){
                $nombre_logo = pathinfo($path_logo_absoluto, PATHINFO_FILENAME);
                $nombre_logo = $nombre_logo.".".$extension_logo_cargado;
                $path_logo_absoluto = "/tio/imagenes/categorias/".$nombre_logo;
                $path_logo_relativo = "../imagenes/categorias/".$nombre_logo;
            }else{
                $respuesta["logo"]["error"] = true;
                $respuesta["logo"]["mensaje"] = "El formato elegido no es permitido";
            }
        }else{
            //"El logo no fue modificado";
        }

        if($imagen_modificada && !$respuesta["imagen"]["error"]){
            move_uploaded_file($_FILES['imagen_editar']['tmp_name'], $path_imagen_relativo);
        }

        if($logo_modificado && !$respuesta["logo"]["error"]){
            move_uploaded_file($_FILES['logo_editar']['tmp_name'], $path_logo_relativo);
        }
        
        if(!$respuesta["sql"]["error"] && !$respuesta["imagen"]["error"] &&
        !$respuesta["logo"]["error"]){
            $sql = "UPDATE CATEGORIA SET NOMBRE_CATEGORIA='$nombre',
            IMAGEN_CATEGORIA='$path_imagen_absoluto', LOGO_CATEGORIA='$path_logo_absoluto',
            DESCRIPCION_CATEGORIA='$descripcion' WHERE ID_CATEGORIA=$id";
            if($conn->query($sql) === TRUE) {
                $respuesta["sql"]["mensaje"] = "El Registro fue actualizado correctamente";
            }else{
                $respuesta["sql"]["error"]=true;
                $respuesta["sql"]["mensaje"] .= "<br>Error al editar el registro ".$conn->error;
            }
        }

        if($respuesta["nombre"]["error"] || $respuesta["logo"]["error"]
         || $respuesta["imagen"]["error"] || $respuesta["sql"]["error"]){
             $respuesta["error"]=true;
         }
        

    }

    echo json_encode($respuesta);
?>