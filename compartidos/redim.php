<?php

//calida de 0 a 100, 100 la mejor calidad.. 0 la peor
function redimJPG($filename, $nombreDestino, $max_width, $max_height, $calidad){
    list($orig_width, $orig_height) = getimagesize($filename);
    $width = $orig_width;
    $height = $orig_height;
    # taller
    if ($height > $max_height) {
        $width = ($max_height / $height) * $width;
        $height = $max_height;
    }
    # wider
    if ($width > $max_width) {
        $height = ($max_width / $width) * $height;
        $width = $max_width;
    }
    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefromjpeg($filename);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
    imagejpeg($image_p, $nombreDestino, $calidad);
    return true;
}

//$camino = $_SERVER['DOCUMENT_ROOT']."/tio/pruebas/portada.jpg";
//$destino = $_SERVER['DOCUMENT_ROOT']."/tio/pruebas/portada2.jpg";
//echo redimJPG($camino, $destino, 320, 320, 80);

//calidad 0 sin compresion 9 con mucha compresion
function redimPNG($filename, $nombreDestino, $max_width, $max_height, $calidad){
    list($orig_width, $orig_height) = getimagesize($filename);
    $width = $orig_width;
    $height = $orig_height;
    # taller
    if ($height > $max_height) {
        $width = ($max_height / $height) * $width;
        $height = $max_height;
    }
    # wider
    if ($width > $max_width) {
        $height = ($max_width / $width) * $height;
        $width = $max_width;
    }
    //$image_p = imagecreate($width, $height);
    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefrompng($filename);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
    imagepng($image_p, $nombreDestino, $calidad);
    return true;
}
/*
$camino = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/categorias/imagenes/c10.png";
$destino = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/categorias/imagenes/otro2smc10.png";
echo redimPNG($camino, $destino, 320, 320, 5);
*/

//calidad de 0 a 100, 0 la peor calidad y 100 la mejor
function redimWEBP($filename, $nombreDestino, $max_width, $max_height, $calidad){
    list($orig_width, $orig_height) = getimagesize($filename);
    $width = $orig_width;
    $height = $orig_height;
    # taller
    if ($height > $max_height) {
        $width = ($max_height / $height) * $width;
        $height = $max_height;
    }
    # wider
    if ($width > $max_width) {
        $height = ($max_width / $width) * $height;
        $width = $max_width;
    }
    //$image_p = imagecreate($width, $height);
    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefromwebp($filename);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
    imagewebp($image_p, $nombreDestino, $calidad);
    return true;
}
//$camino = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/categorias/imagenes/3.webp";
//$destino = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/categorias/imagenes/3c70.webp";
//echo redimWEBP($camino, $destino, 320, 320, 70);

//no tiene calidad
function redimGIF($filename, $nombreDestino, $max_width, $max_height){
    list($orig_width, $orig_height) = getimagesize($filename);
    $width = $orig_width;
    $height = $orig_height;
    # taller
    if ($height > $max_height) {
        $width = ($max_height / $height) * $width;
        $height = $max_height;
    }
    # wider
    if ($width > $max_width) {
        $height = ($max_width / $width) * $height;
        $width = $max_width;
    }
    //$image_p = imagecreate($width, $height);
    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefromgif($filename);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
    imagegif($image_p, $nombreDestino);
    return true;
}
?>

