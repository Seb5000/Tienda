<?php
function redimensionar($nombreOrigen, $nombreDestino, $max_width, $max_height, $calidad = 100){
    list($orig_width, $orig_height, $tipo_imagen) = getimagesize($nombreOrigen);
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

    switch($tipo_imagen){
        case IMAGETYPE_JPEG:
            $image_p = imagecreatetruecolor($width, $height);
            $image = imagecreatefromjpeg($nombreOrigen);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
            imagejpeg($image_p, $nombreDestino, $calidad);
            break;
            case IMAGETYPE_PNG:
                $image_p = imagecreatetruecolor($width, $height);
                $image = imagecreatefrompng($nombreOrigen);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
                $pngCalidad = ($calidad - 100) / 11.111111;
                $pngCalidad = round(abs($pngCalidad));
                imagepng($image_p, $nombreDestino, $pngCalidad);
            break;
        case IMAGETYPE_WEBP:
            $image_p = imagecreatetruecolor($width, $height);
            $image = imagecreatefromwebp($nombreOrigen);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
            imagewebp($image_p, $nombreDestino, $calidad);
            break;
        case IMAGETYPE_GIF:
            $image_p = imagecreatetruecolor($width, $height);
            $image = imagecreatefromgif($nombreOrigen);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
            imagegif($image_p, $nombreDestino);
            break;
        default:
            return 0;
            break;
    }
    //imagedestroy($image_p);
    return 1;
}
?>

