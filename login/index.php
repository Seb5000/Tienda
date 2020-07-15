<?php
session_start();
if(isset($_SESSION['usuario'])){
    header("Location: categorias.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&display=swap" rel="stylesheet"> 
</head>
<body>
    <div class="contenedor-principal">
        <form action="compartido/login.inc.php" method="post">
            <div class="contenedor-titulo">
                <h2>Login <br> Casa de Arte</h2>
            </div>
            
            <div class="contenedor-campo">
                <input type="text" name="usuario" autocomplete="off" required>
                <label for="usuario" class="etiqueta">
                    <span class="contenido-label">Usuario</span>
                </label>
            </div>
            <div class="contenedor-campo">
                <input type="password" name="clave" autocomplete="off" required>
                <label for="clave" class="etiqueta">
                    <span class="contenido-label">Contrase&ntilde;a</span>
                </label>
            </div>
            <button type="submit" name="login-submit" class="boton">Ingresar</button>
            
        </form>
    </div>
    
</body>
</html>