<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Imagen.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/redim2.php';

$bd = new DataBase();

$conn = $bd->conectar();

$producto = new Producto($conn);
$cImagen = new Imagen($conn);

$respuesta = array();
$err = false;
$exito = false;

//print_r($_POST);
//print_r($_FILES);

if(isset($_POST["categoria"]) and isset($_POST["subcategoria"]) and
isset($_POST["marca"]) and isset($_POST["precio"]) and
isset($_POST["descripcion"]) and isset($_POST["imagenesEditadas"]) and
isset($_POST["imagenesOrden"]) and isset($_POST["antiguoId"])){

    $antiguoId = $_POST["antiguoId"];
    $producto->antiguoId = $antiguoId;
    $categoria = $_POST["categoria"];
    $subcategoria = $_POST["subcategoria"];
    $marca = $_POST["marca"];
    $precio = $_POST["precio"];
    $descripcion = $_POST["descripcion"];
    $imagenesEditadas = json_decode($_POST["imagenesEditadas"], true);
    $nuevasImagenesOrden = json_decode($_POST["imagenesOrden"], true);
    
    //print_r($imagenesEditadas);
    //print_r($nuevasImagenesOrden);
}else{
    header('HTTP/1.1 400 Bad Request');
    $respuesta["mensaje"] = "Mala peticion";
    return;
}

if(isset($_POST["id"])){
    $id= $_POST["id"];
    if(empty($id)){
        $err = true;
        $respuesta['id']="El id esta vacio";
    }elseif(!is_numeric($id)){
        $err = true;
        $respuesta['id']="El id debe ser numerico";
    }else{
        if($id != $antiguoId){
            //consultar si el id ya existe
            list($existe, $nombreProducto) = $producto->existeId($id);
            if($existe){
                //Ya existe ese id
                $respuesta['id']="Ya existe el id: $id, esta asociado al producto: $nombreProducto";
                $err=true;
            }else{
                $producto->id = $id;
            }
        }else{
            $producto->id = $id;
        }
    }
}else{
    $err = true;
    $respuesta['id']="Debe introducir un ID";
}

if(isset($_POST["nombre"])){
    $nombre = $_POST["nombre"];
    if($nombre == ""){
        $respuesta['nombre']="Debe introducir un nombre";
        $err = true;
    }else{
        $producto->nombre = $nombre;
    }
}else{
    $respuesta['nombre']="Debe introducir un nombre";
    $err = true;
}

// ARREGLAR LA CATEGORIA
if($categoria == '' or $categoria ==-1){
    $producto->id_categoria = "NULL";
}else{
    $producto->id_categoria = $categoria;
}
// ARREGLAR LA SUBCATEGORIA
if($subcategoria == '' or $subcategoria ==-1){
    $producto->id_subcategoria = "NULL";
}else{
    $producto->id_subcategoria = $subcategoria;
}

// VERIFICAR SI UNA IMAGEN FUE CARGADA
$nEditadas = count($imagenesEditadas);
$nNuevas = count($nuevasImagenesOrden);
$seCargoImagen = false;

$imagenesSubidas = array();
if(isset($_FILES['imagenesDD'])){
    $archivos = reArray($_FILES['imagenesDD']);
    $nArchivos = count($archivos);
    if($nNuevas != $nArchivos){
        header('HTTP/1.1 400 Bad Request');
        $respuesta["mensaje"] = "Error en el numero de archivos subidos";
        return;
    }
    for($i=0; $i<$nArchivos; $i++){
        if($archivos[$i]['error']){
            $respuesta['imagen'] .= "Error al subir el archivo ".$archivos[$i]['name']." ER".$archivos[$i]["error"]." - ";
        }else{
            $nombreImg = $archivos[$i]['name'];
            $extensiones_permitidas= ["jpg", "jpeg", "png", "gif", "svg", "webp"];
            $extension_imagen = strtolower(pathinfo($nombreImg, PATHINFO_EXTENSION));
            if(in_array($extension_imagen, $extensiones_permitidas)){
                $seCargoImagen = true;
                $img = array();
                $img["id_producto"] = $id;
                if($nuevasImagenesOrden[$i] == 1){
                    $img["principal"] = 1;
                }else{
                    $img["principal"] = 0;
                }
                $img["orden"] = $nuevasImagenesOrden[$i];
                $nomImagen = uniqid("P", true);
                $nomImagen = $nomImagen.".".$extension_imagen;
                $nomImagenS = "sm".$nomImagen;
                $path_completo_imagen = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/productos/".$nomImagen;
                $path_completo_imagenS = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/productos/".$nomImagenS;
                $path_parcial_imagen = "/tio/imagenes/productos/".$nomImagen;
                $path_parcial_imagenS = "/tio/imagenes/productos/".$nomImagenS;
                $img["camino_imagen"]=$path_parcial_imagen;
                $img["camino_sm_imagen"]=$path_parcial_imagenS;
                $img["camino_completo"] = $path_completo_imagen;
                $img["camino_completo_s"] = $path_completo_imagenS;
                $img["tmp_name"] = $archivos[$i]["tmp_name"];
                array_push($imagenesSubidas, $img);
            }else{
                $respuesta['imagen'] .= "Extension del archivo ".$archivos[$i]['name']."no permitida - ";
            }
        }
    }

}


$producto->marca = $marca;
$producto->precio = $precio;
$producto->descripcion = $descripcion;
//print_r($imagenesSubidas);
//print_r($producto);

if(!$err){ //SI NO HAY NINGUN ERROR .... EJECUTAR LA CONSULTA
    $exito = $producto->guardarCambios();
    if($exito){ //SI LA QUERY FUE EXITOSA Y SE CARGO UNA IMAGEN
        //Borrar la imagen por defecto si es que existe y se subieron nuevas imagenes
        if($nEditadas == 0 && $nNuevas != 0){
            //Significa que solo esta la imagen por defecto y se ingresaron nuevas imagenes
            //se debe borrar la imagen por defecto
            $cImagen->borrarImagenePrincipalProd($id);
        }

        //Actualizar el orden de las imagenes existenetes o borrar las que fueron eliminadas
        $imagenesABorrar = array();
        foreach ($imagenesEditadas as $key => $value) {
            if($value == 1){
                //actualiza la imagen idImagen principal Orden
                $cImagen->actualizarImagen($key, 1, $value);
            }else if($value == -1){
                array_push($imagenesABorrar, $key);
                //echo "Se va borrar la imagen $key, con valor $value";
            }else{
                $cImagen->actualizarImagen($key, 0, $value);
            }
        }
        $arrImsBorrar = $cImagen->obtenerImagenes($imagenesABorrar);
        foreach($arrImsBorrar as $imgB){
            $nombreimgB = pathinfo($imgB, PATHINFO_FILENAME);
            if($nombreimgB != "defecto"){
                unlink($_SERVER['DOCUMENT_ROOT'].$imgB);
            }
        }
        $cImagen->borrarImagenes($imagenesABorrar);

        //INSERTAR LAS NUEVAS IMAGENES SUBIDAS
        $respQueryImg = $cImagen->insertarImagenes($imagenesSubidas);
        //MOVER LOS ARCHIVOS Y REDIMENSIONARLOS
        if($respQueryImg){
            $respuesta["mensaje"] = "Se guardaron los cambios exitosamente!";
            foreach($imagenesSubidas as $imagenSub){
                if(isset($imagenSub["camino_completo"])){
                    move_uploaded_file($imagenSub['tmp_name'], $imagenSub["camino_completo"]);
                    redimensionar($imagenSub["camino_completo"], $imagenSub["camino_completo_s"], 320, 320, 70);
                    redimensionar($imagenSub["camino_completo"], $imagenSub["camino_completo"], 800, 600, 80);
                }
            }  
        }

        //VERIFICAR SI EXISTE 1 O MAS IMAGENES PARA EL PRODUCTO
        //CASO CONTRARIO INSERTAR UNA IMAGEN POR DEFECTO
        //HACER 
        $numImgs = $cImagen->contarImagenes($id);
        if($numImgs == 0){
            $cImagen->agregarImagenPorDefecto($id);
        }
    }else{
        $respuesta["mensaje"] = $producto->error;
    }
}else{
    $respuesta["mensaje"] = "Valide los campos";
}

$respuesta["success"] = $exito;

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
