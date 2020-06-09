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

    $respuesta["insertar_bd"]["error"] = false;
    $respuesta["insertar_bd"]["mensaje"] = "";

    if(isset($_POST["nombre"]) && isset($_POST["descripcion"])){

        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];

        /*
        $logo = $_POST["logo"];
        $descripccion = $_POST["descripccion"];
        $sql = "INSERT INTO `categoria` (`ID_CATEGORIA`, `NOMBRE_CATEGORIA`, `IMAGEN_CATEGORIA`,
         `LOGO_CATEGORIA`, `DESCRIPCION_CATEGORIA`) 
         VALUES (NULL, '$nombre', '$imagen', '$logo', '$descripccion');";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        */
    }

    /*
    echo("nombre de la imagen files ".$_FILES['agregar_categoria_imagen']['name']); //no funciona
    echo("nombre de la imagen files ".$_POST['agregar_categoria_imagen']['name']); // undefined
    echo("solo imagen");
    move_uploaded_file($_FILES['agregar_categoria_imagen'], "sebas.jpg"); //undefined agregar categoria...
    */
    //print_r($_FILES['imagen']);
    //move_uploaded_file($_FILES['imagen']['tmp_name'], "sebas.jpg");
    $imagen = $_FILES['imagen']["name"];
    $logo = $_FILES['logo']["name"];
    $extensiones_permitidas= ["jpg", "jpeg", "png", "gif", "tiff", "svg", "webp"];
    //obtener el ultimo id de categorias
    $sql = "SELECT MAX(ID_CATEGORIA) FROM `CATEGORIA`";
    $result = $conn->query($sql);
    if($result->num_rows == 0){
        $ultimo_id = 1;
    }else{
        $row = mysqli_fetch_assoc($result);
        //echo("row en id.. <br>"); producia error al devolver un json
        //print_r($row);
        $ultimo_id = $row['MAX(ID_CATEGORIA)'];
    }
    // verificar la extension de la imagen y ponerle un nombre para guardarla
    $nombre_imagen="por_defecto.jpg";
    $nombre_logo="por_defecto.jpg";
    $extension_imagen = pathinfo($imagen, PATHINFO_EXTENSION);
    $extension_imagen= strtolower($extension_imagen);
    if(in_array($extension_imagen, $extensiones_permitidas)){
        $nombre_imagen = "c".((int)$ultimo_id+1).".".$extension_imagen; 
    }else{
        $respuesta["imagen"]["error"] = true;
        $respuesta["imagen"]["mensaje"] = "El formato elegido no es permitido";
    }
    
    //verificar la extension del logo y ponerle un nombre para guardarlo
    $extension_logo = pathinfo($logo, PATHINFO_EXTENSION);
    $extension_logo= strtolower($extension_logo);
    if(in_array($extension_logo, $extensiones_permitidas)){
        $nombre_logo = "l".((int)$ultimo_id+1).".".$extension_logo;
    }else{
        $respuesta["logo"]["error"] = true;
        $respuesta["logo"]["mensaje"] = "El formato elegido no es permitido";
    }

    // crear los path para las imagenes y los logos
    $path_relativo_imagen = "../imagenes/categorias/".$nombre_imagen;
    $path_relativo_logo = "../imagenes/iconos/".$nombre_logo;
    $path_absoluto_imagen = "/tio/imagenes/categorias/".$nombre_imagen;
    $path_absoluto_logo = "/tio/imagenes/iconos/".$nombre_logo;
    
    
    if(!$respuesta["nombre"]["error"] && !$respuesta["descripcion"]["error"]
    && !$respuesta["imagen"]["error"] && !$respuesta["logo"]["error"]){
        
        $sql = "INSERT INTO `categoria` (`ID_CATEGORIA`, `NOMBRE_CATEGORIA`, `IMAGEN_CATEGORIA`,
        `LOGO_CATEGORIA`, `DESCRIPCION_CATEGORIA`) 
        VALUES (NULL, '$nombre', '$path_absoluto_imagen', '$path_absoluto_logo', '$descripcion');";
        //mover los archivos cargados a sus respectivas carpetas
        move_uploaded_file($_FILES['imagen']['tmp_name'], $path_relativo_imagen);
        move_uploaded_file($_FILES['logo']['tmp_name'], $path_relativo_logo);

        if ($conn->query($sql) === TRUE) {
            $respuesta["insertar_bd"]["error"] = false;
            $respuesta["insertar_bd"]["mensaje"] = "Se inserto la categoria a la base de datos";
        } else {
            $respuesta["insertar_bd"]["error"] = true;
            $respuesta["insertar_bd"]["mensaje"] = "Error al insertar la categoria 
            a la base de datos: <br>".$conn->error;
        }
    }else{
        $respuesta["insertar_bd"]["error"] = true;
        $respuesta["insertar_bd"]["mensaje"] = "Ocurrio un error al agregar la categoria, mire los detalles en el formulario agregar";
    }
    /*
    $logo = $_POST["logo"];
    $descripccion = $_POST["descripccion"];
    $sql = "INSERT INTO `categoria` (`ID_CATEGORIA`, `NOMBRE_CATEGORIA`, `IMAGEN_CATEGORIA`,
        `LOGO_CATEGORIA`, `DESCRIPCION_CATEGORIA`) 
        VALUES (NULL, '$nombre', '$imagen', '$logo', '$descripccion');";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    print_r("nombre: ".$nombre."<br>");
    print_r("imagen: ".$imagen."<br>");
    print_r("logo: ".$logo."<br>");
    print_r("descripccion: ".$descripcion."<br>");
    print_r($respuesta);
    
    print_r($respuesta);
    echo("ultimo id: ".$ultimo_id);
    */
    echo json_encode($respuesta);

?>

