<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Usuario.php';
$bd = new DataBase();
$conn = $bd->conectar();
$usuario = new Usuario($conn);
$boo = $usuario->crearUsuario("sebas", "sebastian.villarpando@gmail.com", "baton123");


if($boo){
    echo "se creo el usuario";
}else{
    echo "Hubo un error";
}

?>