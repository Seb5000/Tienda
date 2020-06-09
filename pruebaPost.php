<?php
    //header('Access-Control-Allow-Origin: *');
    //header('Content-Type: application/json');

    include_once 'compartidos/baseDatos.php';
    include_once 'modelos/Producto.php';

    $bd = new DataBase();
    $conn = $bd->conectar();

    //instanciar el objeto producto
    $producto = new Producto($conn);

    //realizar la query de productos
    $resultado = $producto->leer();

    //contar el numero de filas rowCount
    $num = $resultado->rowCount();

    //Si existe algun producto
    if($num>0){
        $arr_prod = array();
        $arr_prod['data'] = array();
        while($fila = $resultado->fetch(PDO::FETCH_ASSOC)){
            $post_item = array(
                'id_producto'=>$fila['ID_PRODUCTO'],
                'nombre_producto'=>$fila['NOMBRE_PRODUCTO'],
                'id_categoria'=>$fila['ID_CATEGORIA'],
                'nombre_categoria'=>$fila['NOMBRE_CATEGORIA'],
                'id_subcategoria'=>$fila['ID_SUBCATEGORIA'],
                'nombre_subcategoria'=>$fila['NOMBRE_SUBCATEGORIA'],
                'marca'=>$fila['MARCA_PRODUCTO'],
                'precio'=>$fila['PRECIO_PRODUCTO'],
                'imagen'=>$fila['IMAGEN_PRODUCTO'],
                'descripcion'=>$fila['DESCRIPCION_PRODUCTO'],
            );
            array_push($arr_prod['data'], $post_item);
        }

        echo json_encode($arr_prod);
    }else{
        echo json_encode(
            array('message'=>"No se encontro ningun producto")
        );
    }
