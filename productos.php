<?php
$localhost = "localhost";
$usuario = "root";
$pass = "";
$DB = "casaarte";

$conexion = mysqli_connect($localhost, $usuario, $pass, $DB);
    if (!$conexion) {
      echo "Error de conexion con la base de datos";
      die();
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Productos | Casa de Arte</title>
	<link rel="stylesheet" type="text/css" href="css/productos.css">
	<link href="https://fonts.googleapis.com/css?family=Carter+One|Merienda+One&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width, user-scalable=no">
</head>
<body>
	<header>
		<div class="menu">
			<div class="logo">
				<img src="imagenes/logo.png">
				<h2>Casa<br>de Arte</h2>
			</div>	
			<ul class="nav-links">
				<li><a href="index.html#inicio">Inicio</a></li>
				<li><a href="index.html#quienes">Quienes somos</a></li>
				<li><a href="">Nuestros productos</a></li>
				<li><a href="index.html#contacto">Contactanos</a></li>
			</ul>
			<div class="burger">
					<div class="linea1"></div>
					<div class="linea2"></div>
					<div class="linea3"></div>
			</div>
		</div>
		<div class="contenedor" id="inicio">
			<div class="titulo">
				<h1>Productos</h1>
			</div>
		</div>
	</header>
	<section class="barra-top">
		<div class="opciones-botones">
			<ul>
				<li class="filtro activo" nombre="categoria">Categoria</li>
				<li class="filtro" nombre="uso">Uso</li>
				<li class="filtro" nombre="marca">Marca</li>
			</ul>
		</div>
	</section>
	<section class="opciones-barra">
		<div class="opcion categoria">
			
				<?php 
				$consulta = "SELECT `nombre_c` FROM `categoria`";
				$respuesta = mysqli_query($conexion, $consulta);
				$categorias = mysqli_fetch_all($respuesta, MYSQLI_ASSOC);
				/*
				echo "<pre>";
				print_r($respuesta);
				echo "</pre>";
				$categorias = mysqli_fetch_all($respuesta, MYSQLI_ASSOC);
				echo "<pre>";
				print_r($categorias);
				echo "</pre>";

				foreach ($categorias as $value) {
					echo "<pre>";
					print_r($value);
					echo "</pre>";
				}

				foreach ($categorias as $clave => $valor) {
					echo "<pre>";
					print_r($valor["nombre_c"]);
					echo "</pre>";
				}
				*/
				?>
			
			<ul>
				<?php
				foreach ($categorias as $clave => $valor) {
					echo '<li onclick="subMenuCat()">'.$valor["nombre_c"].'</li>';
				}
				?>
				<li onclick="subMenuCat()">categoria 1</li>
			</ul>
			<ul class="sub-menu-cat" id="sbm-c">
				<li>sub menu categoria 1</li>
				<li>sub menu categoria 2</li>
				<li>sub menu categoria 3</li>
			</ul>
		</div>
		<div class="opcion uso">
			<ul>
				<li>Uso 1</li>
				<li>Uso 2</li>
				<li>Uso 3</li>
				<li>Uso 4</li>
				<li>Uso 5</li>
				<li>Uso 6</li>
				<li>Uso 7</li>
				<li>Uso 8</li>
				<li>Uso 9</li>
				<li>Uso 10</li>
				<li>Uso 11</li>
			</ul>
		</div>
		<div class="opcion marca">
			<ul>
				<li>Marca 1</li>
				<li>Marca 2</li>
				<li>Marca 3</li>
				<li>Marca 4</li>
				<li>Marca 5</li>
				<li>Marca 6</li>
				<li>Marca 7</li>
				<li>Marca 8</li>
				<li>Marca 9</li>
				<li>Marca 10</li>
				<li>Marca 11</li>
			</ul>
		</div>
	</section>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/productos.js"></script>
	<script type="text/javascript" src="js/burger.js"></script>
	<script type="text/javascript" src="js/productos-submenu.js"></script>
</body>
</html>