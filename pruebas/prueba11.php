<pre>
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';

$bd = new DataBase();

$conn = $bd->conectar();

$producto = new Producto($conn);


$json = file_get_contents('php://input');
$cadenaids = json_decode($json, true);
//$cadenaids = "{8, 9, 2, 11}";

$data = explode(',', $cadenaids["ids"]); 


$arrSub = $producto->contarIdsSubcategorias($data);

echo "La cadena";
print_r($data);
echo PHP_EOL."array de subcategorias";
print_r($arrSub);

//print_r($data2);
?>
</pre>