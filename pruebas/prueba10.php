<pre>
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Categoria.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Subcategoria.php';

$bd = new DataBase();

$conn = $bd->conectar();
/*
$CATEGORIA = new Categoria($conn);
$arr_cat = $CATEGORIA->listaCategorias2();
print_r(($arr_cat))
*/

$sub = new Subcategoria($conn);
$num = $sub->modificarCantidadProductos(20, -8);
echo $num;
?>
</pre>