<div class="barraLogin">
    <div class="menuHamburgesa">
        <div class="linea1"></div>
        <div class="linea2"></div>
        <div class="linea3"></div>
    </div>
    <p class="nombreUsuario"><?php echo $_SESSION['usuario']?></p>
    <form action="compartido/logout.inc.php" method="POST">
    <button class="linkCerrarSesion" type="submit" name="logout-submit">Cerrar Sesion</button>
    </form>
</div>