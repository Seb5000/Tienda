<pre>
<?php
    
    $path = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/categorias/c18.jpg";
    //$path = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/categorias/c18.jpg";
    echo("hola\n");
    echo "path : ".$path.PHP_EOL;
    echo "PATHINFO_DIRNAME  : ".pathinfo($path, PATHINFO_DIRNAME ).PHP_EOL;
    echo "PATHINFO_BASENAME  : ".pathinfo($path, PATHINFO_BASENAME ).PHP_EOL;
    echo "PATHINFO_EXTENSION  : ".pathinfo($path, PATHINFO_EXTENSION ).PHP_EOL;
    echo "PATHINFO_FILENAME  : ".pathinfo($path, PATHINFO_FILENAME ).PHP_EOL;
    echo getcwd();
    /*
    if(unlink($path)){
        echo("Se borro exitosamente el archivo");
    }else{
        echo("No se pudo borrar el archivo");
    }
    */
    $respuesta = [
        "error" =>false,
        "mensaje"=>"o"
    ];
    echo "este es el nombre del archivo..... :".PHP_EOL;
    echo pathinfo($path, PATHINFO_FILENAME);
    echo "<br>";
    if($respuesta["mensaje"]){
        echo "es True";
    }else{
        echo "es False";
    }
    echo "esto es la prueba del dirname(__FILE__)".PHP_EOL;
    echo (dirname(__FILE__));
    echo ("La nueva prueba: ".PHP_EOL);
    include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';

    $bd = new DataBase();

    $conn = $bd->conectar();
    $producto = new Producto($conn);

    $arrProd = $producto->leer2();
    print_r($arrProd);
?>
</pre>