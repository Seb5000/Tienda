<pre>
<?php
include_once 'compartidos/baseDatos.php';
include_once 'modelos/Producto.php';

$bd = new DataBase();

$conn = $bd->conectar();
$producto = new Producto($conn);

$nar = $producto->leer2();
print_r($nar);

?>
</pre>