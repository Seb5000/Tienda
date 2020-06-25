<pre>
<?php

$precio;
if(isset($_POST['precio'])){
    $precio = $_POST['precio'];
}else{
    $precio = "NULL";
}

$marca = $_POST['marca'] ?? 5;

echo "Este es el precio ".$precio.PHP_EOL;
echo " Esta es la marca ".$marca.PHP_EOL;

$var = "<a> frfr</a>";
echo "Este es la variable var: $var ---".($var===null)."---".PHP_EOL;
$var2 = htmlspecialchars($var);
echo "Este es la variable despues de htmlspecialchars(var): $var2---".($var2===null)."---".PHP_EOL;
$var3 = strip_tags($var);
echo "Este es la variable despues de strip_tags(var): $var3---".($var3===null)."---".PHP_EOL;
$var4 = htmlspecialchars(strip_tags($var));
echo "Este es la variable despues de htmlspecialchars(strip_tags(var)): $var4---".($var4===null)."---".PHP_EOL;


?>
</pre>