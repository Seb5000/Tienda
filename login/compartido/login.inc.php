<?php
if(isset($_POST["login-submit"])){
    
    include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Usuario.php';
    $bd = new DataBase();
    $conn = $bd->conectar();
    $usuario = new Usuario($conn);

    $idUsuario = $_POST["usuario"];
    $clave = $_POST["clave"];

    if(empty($idUsuario) || empty($clave)){
        header("Location: ../index.php?error=camposVacios");
        exit();
    }else{
        if($usuario->obtenerUsuario($idUsuario)){
            if($usuario->verificarPassword($clave)){
                session_start();
                $_SESSION["idUsuario"]= $usuario->idUsuario;
                $_SESSION["usuario"]= $usuario->usuario;
                $_SESSION["email"]= $usuario->email;
                header("Location: ../categorias.php");
                exit();

            }else{
                header("Location: ../index.php?error=claveIncorrecta");
                exit();
            }
        }else{
            header("Location: ../index.php?error=noSeEncontroUSUARIO_SQLERROR");
            exit();
        }
    }
}else{
    header("Location: ../index.php");
    exit();
}