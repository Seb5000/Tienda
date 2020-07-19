<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Subcategoria.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Imagen.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/redim2.php';

//header('Content-Type: application/json');
$bd = new DataBase();

$conn = $bd->conectar();

$producto = new Producto($conn);
$subcategoria = new Subcategoria($conn);
$ImagenC = new Imagen($conn);

$respuesta = array();
$err = false;

// VALIDACION PARA EL ID
$respuesta['id']="";
$id =1;
if(isset($_POST['id'])){
    $id = $_POST['id'];
    if(empty($id)){
        $err = true;
        $respuesta['id']="El id esta vacio";
    }elseif(!is_numeric($id)){
        $err = true;
        $respuesta['id']="El id debe ser numerico";
    }else{
        //consultar si el id ya existe
        list($existe, $nombreProducto) = $producto->existeId($id);
        if($existe){
            //Ya existe ese id
            $respuesta['id']="Ya existe el id: $id, esta asociado al producto: $nombreProducto";
            $err=true;
        }
    }
}else{
    $err = true;
    $respuesta['id']="Debe ingresar un id";
}
//FIN VALIDACION NOMBRE

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

//$id_categoria = isset($_POST['categoria']) ? $_POST['categoria'] : "NULL"; //ternary op long
$id_categoria =null;
if(isset($_POST['categoria'])){
    if($_POST['categoria']=='') $id_categoria = null;
    else{
        $id_categoria = $_POST['categoria'];
    }
}else{
    $id_categoria = null;
}
//$id_subcategoria = $_POST['subcategoria'] ?? "NULL"; // ternary op php 7
$id_subcategoria = null;
if(isset($_POST['subcategoria'])){
    if($_POST['subcategoria']=='') $id_subcategoria = null;
    else{
        $id_subcategoria = $_POST['subcategoria'];
    }
}else{
    $id_subcategoria = null;
}


//$marca = isset($_POST['marca']) ?: ""; // ternary op php 5.3
$marca = "";
if(isset($_POST['marca'])){
    $marca = $_POST['marca'];
}
//$precio = $_POST['precio'] ?? 5;
$precio;
if(isset($_POST['precio'])){
    $precio = $_POST['precio'];
}else{
    $precio = null;
}

// VALIDACION PARA IMAGEN
$respuesta['imagen']="";
$cargoImagen=false;
$orden = 1;
$principal = 1;
$imagenes = array();
$arrayAux = array();
if(isset($_FILES['imagenesDD'])){
    $cargoImagen = true;
    $archivos = reArray($_FILES['imagenesDD']);
    foreach($archivos as $imagen){
        if($imagen['error']){
            $respuesta['imagen'] .= "Error al subir el archivo ".$imagen['name']." ER".$imagen["error"]." - ";
        }else{
            $nombreImg = $imagen['name'];
            $extensiones_permitidas= ["jpg", "jpeg", "png", "gif", "svg", "webp"];
            $extension_imagen = strtolower(pathinfo($nombreImg, PATHINFO_EXTENSION));
            if(in_array($extension_imagen, $extensiones_permitidas)){
                $img = array();
                $subArrAux = array();
                $img["id_producto"] = $id;
                $img["principal"] = $principal;
                $subArrAux["principal"] = $principal;
                if($principal == 1){
                    $principal = 0;
                }
                $img["orden"] = $orden;
                $orden++;
                $nomImagen = uniqid("P", true);
                $nomImagen = $nomImagen.".".$extension_imagen;
                $nomImagenS = "sm".$nomImagen;
                $path_completo_imagen = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/productos/".$nomImagen;
                $path_completo_imagenS = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/productos/".$nomImagenS;
                $path_parcial_imagen = "/tio/imagenes/productos/".$nomImagen;
                $path_parcial_imagenS = "/tio/imagenes/productos/".$nomImagenS;
                $img["camino_imagen"]=$path_parcial_imagen;
                $img["camino_sm_imagen"]=$path_parcial_imagenS;
                $subArrAux["camino"] = $path_completo_imagen;
                $subArrAux["camino_s"] = $path_completo_imagenS;
                $subArrAux["tmp_name"] = $imagen["tmp_name"];
                array_push($imagenes, $img);
                array_push($arrayAux, $subArrAux);
            }else{
                $respuesta['imagen'] .= "Extension del archivo ".$imagen['name']."no permitida - ";
            }
        }
    } 
}else{
    $nomImagen = "defecto.svg";
    $path_parcial_imagen = "/tio/imagenes/".$nomImagen;
    $img["id_producto"] = $id;
    $img["principal"] = true;
    $img["orden"] = 1;
    $img["camino_imagen"]=$path_parcial_imagen;
    $img["camino_sm_imagen"]=$path_parcial_imagen;
    array_push($imagenes, $img);
    //$respuesta["mensaje"] = "No se realizo la peticion correctamente...";
    //echo json_encode($respuesta);
    //http_response_code(400);
    //return;
}

/*
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
*/
$descripcion = $_POST['descripcion'] ?? "";

if(!$err){ //SI NO OCURRIO NINGUN ERROR EN LA VALIDACION
    $producto->id = $id;
    $producto->nombre = $nombre;
    $producto->id_categoria = $id_categoria;
    $producto->id_subcategoria = $id_subcategoria;
    $producto->marca = $marca;
    $producto->precio = $precio;
    //$producto->imagen = $path_parcial_imagen; //pasamos el camino hacia la imagen
    $producto->descripcion = $descripcion;

    $query = $producto->agregar();

    if($query){ //SI LA QUERY FUE EXITOSA
        //MOVER EL ARCHIVO DENTRO DE LA CARPETA SI SE CARGO UNA IMAGEN
        /*
        if($cargoImagen){
            move_uploaded_file($_FILES['imagen']['tmp_name'], $path_completo_imagen);
        }
        */
        $respuesta["mensaje"] = "Se agrego existosamente el registro";
        $respQueryImg = $ImagenC->insertarImagenes($imagenes);
        if($respQueryImg){
            if($cargoImagen){
                foreach($arrayAux as $subA){
                    if(isset($subA["camino"])){
                        move_uploaded_file($subA['tmp_name'], $subA["camino"]);
                        redimensionar($subA["camino"], $subA["camino_s"], 320, 320, 70);
                        redimensionar($subA["camino"], $subA["camino"], 800, 600, 80);
                    }
                }   
            }
        }else{
            $err = true;
            $respuesta["error"] = $ImagenC->getError();
            //$respuesta["query"] = $ImagenC->getQuery();
            $respuesta["mensaje"] = "Ocurrio un error al agregar las imagenes";
        }

        //Modificar la cantidad de productos en subcategoria
        $subcategoria->modificarCantidadProductos($id_subcategoria, 1);
        // NUEVOOOO

        //$respuesta["arrimg"]= $imagenes;
        //$respuesta["arr2IMG"]= $arrayAux;
    }else{
        $err = true;
        $respuesta["mensaje"] = "Ocurrio un error: ".$producto->error;
    }
}else{
    $respuesta["mensaje"] = "Valide los campos del formulario";
}

$respuesta["error"] = $err;

echo json_encode($respuesta);

function reArray($file_post){
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);
    for($i=0; $i<$file_count; $i++){
        foreach($file_keys as $key){
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }
    return $file_ary;
}
?>