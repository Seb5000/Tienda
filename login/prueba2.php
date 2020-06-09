<?php

$precio;
if(isset($_POST['precio'])){
    $precio = $_POST['precio'];
}else{
    $precio = "NULL";
}

$marca = $_POST['marca'] ?? 5;

echo "Este es el precio ".$precio;
echo " Esta es la marca ".$marca;
?>