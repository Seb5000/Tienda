<pre>
<?php
/*
function prueba($nombre=3, $idcat){
    if($nombre == null){
        echo "El nombre es nulo".PHP_EOL;
    }else{
        echo "El nombre tiene un valor".PHP_EOL;
    }
    if($idcat == null){
        echo "La categoria es nula".PHP_EOL;
    }else{
        echo "La categoria tiene un valor".PHP_EOL;
    }
}
*/
//$arr_sub = array();
//array_push($arr_sub, array());
//$arr_sub[1]=array();
/*
if(isset($arr_sub[1])){
    echo "esta seteado".PHP_EOL;
}else{
    echo "no no isset".PHP_EOL;
}
$item = array(
    'id'=>"val id 1",
    'nombre'=>"nombre id 1",
);
if(isset($arr_sub[1])){
    echo "esta seteado".PHP_EOL;
    array_push($arr_sub[1], $item);
}else{
    echo "no no isset".PHP_EOL;
    $arr_sub[1] = array();
    array_push($arr_sub[1], $item);
}
$item = array(
    'id'=>"val id 2",
    'nombre'=>"nombre id 2",
);
if(isset($arr_sub[1])){
    echo "esta seteado".PHP_EOL;
    array_push($arr_sub[1], $item);
}else{
    echo "no no isset".PHP_EOL;
    $arr_sub[1] = array();
    array_push($arr_sub[1], $item);
}
print_r($arr_sub);
*/
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Subcategoria.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';
$bd = new DataBase();
$conn = $bd->conectar();
$prod = new Producto($conn);
$iniciar = 0;
$numFilas= 10;
$nombre = null;
$idCategoria = null;
$idSubcategoria = null;
$arrresp = $prod->obtenerProductos3($iniciar, $numFilas, $nombre, $idCategoria, $idSubcategoria);
print_r($arrresp);
//print_r($arrresp["parametros"]);
/*
echo "el tipo de  arr[4][idc] es".gettype($arr_sub[4]["idC"]).PHP_EOL;
echo "el valor de  arr[4][idc] es ---".$arr_sub[4]["idC"]."----".PHP_EOL;
echo "es igual a null ? ";
echo ($arr_sub[4]["idC"] == null )? "SI ":"NOP";
*/
?>
</pre>
