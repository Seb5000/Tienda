<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';

$bd = new DataBase();

$conn = $bd->conectar();

$producto = new Producto($conn);

$respuesta = array();
$err = false;


//$id_categoria = isset($_POST['categoria']) ? $_POST['categoria'] : "NULL"; //ternary op long
$id_categoria ="NULL";
if(isset($_POST['categoria'])){
    if($_POST['categoria']=='') $id_categoria = "NULL";
    else{
        $id_categoria = $_POST['categoria'];
    }
}else{
    $id_categoria = "NULL";
}
//$id_subcategoria = $_POST['subcategoria'] ?? "NULL"; // ternary op php 7
$id_subcategoria = "NULL";
if(isset($_POST['subcategoria'])){
    if($_POST['subcategoria']=='') $id_subcategoria = "NULL";
    else{
        $id_subcategoria = $_POST['subcategoria'];
    }
}else{
    $id_subcategoria = "NULL";
}

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

//$marca = isset($_POST['marca']) ?: ""; // ternary op php 5.3
$marca;
if(isset($_POST['marca'])){
    $marca = $_POST['marca'];
}
//$precio = $_POST['precio'] ?? 5;
$precio;
if(isset($_POST['precio'])){
    $precio = $_POST['precio'];
}else{
    $precio = "NULL";
}

// VALIDACION PARA IMAGEN
$respuesta['imagen']="";
$cargoImagen=false;
if(is_uploaded_file($_FILES['imagen']['tmp_name'])){ //SE SUBIO ALGUN ARCHIVO
    $cargoImagen = true;
    $imagen = $_FILES['imagen']["name"];
    $extensiones_permitidas= ["jpg", "jpeg", "png", "gif", "tiff", "svg", "webp"];
    $nomImagen = "p".$producto->siguienteId(); //concatenamos el nombre de la siguiente imagen con una p
    $extension_imagen = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
    if(in_array($extension_imagen, $extensiones_permitidas)){ //verificamos que la extension este permitida
        $nomImagen = $nomImagen.".".$extension_imagen; // concatenamos el nombre con la extension
        $path_completo_imagen = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/productos/".$nomImagen;
        $path_parcial_imagen = "/tio/imagenes/productos/".$nomImagen;
    }else{
        $err = true;
        $respuesta['imagen'] .= "El formato de la imagen no es permitido / ";
    }
}else{
    $nomImagen = "defecto.svg";
    $path_parcial_imagen = "/tio/imagenes/".$nomImagen;
}
//FIN VALIDACION IMAGEN

$descripcion = $_POST['descripcion'] ?? "";

if(!$err){ //SI NO OCURRIO NINGUN ERROR EN LA VALIDACION
    $producto->nombre = $nombre;
    $producto->id_categoria = $id_categoria;
    $producto->id_subcategoria = $id_subcategoria;
    $producto->marca = $marca;
    $producto->precio = $precio;
    $producto->imagen = $path_parcial_imagen; //pasamos el camino hacia la imagen
    $producto->descripcion = $descripcion;

    $query = $producto->agregar();

    if($query){ //SI LA QUERY FUE EXITOSA
        //MOVER EL ARCHIVO DENTRO DE LA CARPETA SI SE CARGO UNA IMAGEN
        if($cargoImagen){
            move_uploaded_file($_FILES['imagen']['tmp_name'], $path_completo_imagen);
        }
        $respuesta["mensaje"] = "Se agrego existosamente el registro";
    }else{
        $err = true;
        $respuesta["mensaje"] = "Ocurrio un error: ".$producto->error;
    }
}else{
    $respuesta["mensaje"] = "Valide los campos del formulario";
}

$respuesta["error"] = $err;

echo json_encode($respuesta);
?>