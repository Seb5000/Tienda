<pre>
<?php
include "redim.php";
/*
$nombre = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/categorias/imagenes/defecto.svg";
$info   = getimagesize($nombre);
print_r($info);
if($info[2]==IMAGETYPE_WEBP){
    echo "Es de tipo WEBP";
}else{
    echo "No es WEBP";
}
$type   = exif_imagetype($nombre);
print_r($type);
*/
/*
function prueba($param1 : "unounouno", $param2 : "dosdosdos"){
    echo "Este es param1 : ".$param1;
    echo "Este es param2 : ".$param2;
}

// PARA REDIMENSIONAR PNG
$image = imagecreatefrompng($nombreOrigen);
$image_p = imagecreate($width, $height);

//$image_p = imagecreatetruecolor($width, $height);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
//Su escala de calidad va de 0 a 9 -- 0 sin compresion 9 con mucha comp
imagepng($image_p, $nombreDestino, $pngCalidad);

$pngCalidad = ($calidad - 100) / 11.111111;
$pngCalidad = round(abs($pngCalidad));
imagecopyresized($image, $image_p, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
imagepng($image_p, $nombreDestino, $pngCalidad);

// create a new image with the new width and height 
$image = imagecreatefrompng($nombreOrigen);
$temp = imagecreatetruecolor($width, $height);

 making the new image transparent 
$background = imagecolorallocate($temp, 0, 0, 0);
ImageColorTransparent($temp, $background); // make the new temp image all transparent
imagealphablending($temp, false); // turn off the alpha blending to keep the alpha channel

 Resize the PNG file 
 use imagecopyresized to gain some performance but loose some quality
imagecopyresized($temp, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
use imagecopyresampled if you concern more about the quality
//imagecopyresampled($temp, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));
imagepng($temp, $nombreDestino, 0);

*/
echo redimensionar("3.png", "3s.png", 800, 600, 80);
echo redimensionar("4.png", "4s.png", 800, 600, 80);
echo redimensionar("5.png", "5s.png", 800, 600, 80);
echo redimensionar("6.png", "6s.png", 800, 600, 80);
echo redimensionar("2.png", "2s.png", 800, 600, 80);
?>
</pre>