<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Casa de Arte</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/indexProductos.css">
	<link rel="stylesheet" href="css/menuCategorias2.css">
	<link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@300;400;600;700;900&family=Merienda:wght@400;700&display=swap" rel="stylesheet">

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
				<li><a href="#inicio">Inicio</a></li>
				<li><a href="#quienes">Quienes somos</a></li>
				<li><a href="#productos">Nuestros productos</a></li>
				<li><a href="#contacto">Contactanos</a></li>
			</ul>
			<div class="burger">
				<div class="linea1"></div>
				<div class="linea2"></div>
				<div class="linea3"></div>
			</div>
		</div>
		<div class="contenedor" id="inicio">
			<div class="titulo">
				<h1>Casa de Arte</h1>
				<p>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				</p>
			</div>
		</div>
	</header>
	<main>

		<section class="productos" id="productos">
			<div class="contenedor-productos">
				<h2 id="titulo-productos">Nuestros Productos</h2>
				<?php include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/menuCategorias2.php'; ?>
				<ul class="lista-productos">
					<?php
					include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
					include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Categoria.php';
					$bd = new DataBase();
					$conn = $bd->conectar();
					$categorias = new Categoria($conn);
					$arrCategorias = $categorias->getCategorias(0, 12);
					foreach($arrCategorias as $cat):
					?>
						<li>
							<div class="container">
								<div class="cardWrap">
									<a href="/tio/buscar.php?categoria=<?php echo $cat['id'] ?>">
										<div class="card">
											<div class="cardBg" style="background-image: url(<?php echo $cat['imagenS']; ?>);"></div>
											<div class="cardInfo">
												<h3 class="cardTitle">
													<?php echo $cat['nombre']; ?>
												</h3>
												<p><?php echo $cat['descripcion']; ?></p>
											</div>
										</div>
									</a>
								</div>
							</div>
						</li>
					<?php
					endforeach;
					?>
				</ul>
			</div>

		</section>
		
		<section class="quienes" id="quienes">
			<div class="titulo">
				<h2>Quienes Somos</h2>
			</div>
			<div class="contenedor">
				<div class="texto">
					<p>
						Curabitur vel risus eget tellus euismod eleifend eu at metus. Vivamus non eleifend felis, at tristique purus. Integer commodo dui non urna congue scelerisque. Phasellus suscipit vehicula metus, molestie porttitor odio porttitor nec. Aliquam vel mattis odio. Vivamus quis pretium elit, ac volutpat ante. Nam quis finibus mauris. In finibus feugiat tincidunt.
					</p>
				</div>

				<div class="contenedor-imagen">
					<img src="imagenes/personal.jpg">
				</div>
			</div>

		</section>
		<!--
		<section class="contacto" id="contacto">
			<div class="titulo">
				<h2>Contactanos</h2>
			</div>
			<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1295.2838510339052!2d-66.15422005354164!3d-17.390333885332655!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2sbo!4v1571237536234!5m2!1ses-419!2sbo" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
		</section>
		-->
	</main>
	<footer>
		<div class="contenedor">
			<div class="logo">
				<img src="imagenes/logo.png" size="60x60">
				<div class="descripcion">
					<h2>Casa de Arte</h2>
					<p>Direccion : Calle antezana entre Calama y La Dislao Cabrera #550</p>
					<p>Telefono : 4429211</p>
				</div>

			</div>
			<div class="redes-sociales">

				<a href=""><img src="imagenes/whatsapp.png"></a>
				<a href=""><img src="imagenes/facebook.png"></a>
				<a href=""><img src="imagenes/carta.png"></a>

			</div>
			
		</div>
		<h5><a href="login/index.php" style="margin: 10px 20px;">Login</a></h5>
		
	</footer>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/burger.js"></script>
	<script type="text/javascript" src="js/menu.js"></script>
	<script type="text/javascript" src="js/indexProductos.js"></script>
	<script src="js/menuCategorias2.js"></script>
</body>

</html>