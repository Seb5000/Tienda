<?php
function resizeImage($filename, $max_width, $max_height)
{
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

    //$image = imagecreatefromjpeg($filename);
    $image = imagecreatefrompng($filename);

    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

    return $image_p;
}

$img = $_SERVER['DOCUMENT_ROOT']."/tio/imagenes/categorias/imagenes/ci14.png";
$nimg = resizeImage($img, 1918, 1918);
//imagejpeg($nimg, 'gg80.jpg', 80);
imagepng($nimg, '800p800eggsin.png');
//file_put_contents($output, file_get_contents($nimg));
echo "funciono", "yo no volvi yo no";

?>
