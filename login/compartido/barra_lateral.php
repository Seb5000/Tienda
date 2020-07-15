<?php 
$actual = (isset($actual))? $actual : null;
?>
<nav class="navbar hide">
    <a href="/tio" class="nav-logo">
        <div class="logo-icono">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="brush" class="svg-inline--fa fa-brush fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                <path fill="currentColor" d="M352 0H32C14.33 0 0 14.33 0 32v224h384V32c0-17.67-14.33-32-32-32zM0 320c0 35.35 28.66 64 64 64h64v64c0 35.35 28.66 64 64 64s64-28.65 64-64v-64h64c35.34 0 64-28.65 64-64v-32H0v32zm192 104c13.25 0 24 10.74 24 24 0 13.25-10.75 24-24 24s-24-10.75-24-24c0-13.26 10.75-24 24-24z"></path>
            </svg>
        </div>
        <div class="logo-texto">
            CASA DE ARTE
        </div>
    </a>
    <ul class="navbar-nav">
        <hr class="separador">
        <li class="nav-item <?php echo ($actual == 'categorias')? 'activo' : '' ?>" onclick="load_data()">
            <a href="categorias.php" class="nav-link">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="volleyball-ball" class="svg-inline--fa fa-volleyball-ball fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M231.39 243.48a285.56 285.56 0 0 0-22.7-105.7c-90.8 42.4-157.5 122.4-180.3 216.8a249 249 0 0 0 56.9 81.1 333.87 333.87 0 0 1 146.1-192.2zm-36.9-134.4a284.23 284.23 0 0 0-57.4-70.7c-91 49.8-144.8 152.9-125 262.2 33.4-83.1 98.4-152 182.4-191.5zm187.6 165.1c8.6-99.8-27.3-197.5-97.5-264.4-14.7-1.7-51.6-5.5-98.9 8.5A333.87 333.87 0 0 1 279.19 241a285 285 0 0 0 102.9 33.18zm-124.7 9.5a286.33 286.33 0 0 0-80.2 72.6c82 57.3 184.5 75.1 277.5 47.8a247.15 247.15 0 0 0 42.2-89.9 336.1 336.1 0 0 1-80.9 10.4c-54.6-.1-108.9-14.1-158.6-40.9zm-98.3 99.7c-15.2 26-25.7 54.4-32.1 84.2a247.07 247.07 0 0 0 289-22.1c-112.9 16.1-203.3-24.8-256.9-62.1zm180.3-360.6c55.3 70.4 82.5 161.2 74.6 253.6a286.59 286.59 0 0 0 89.7-14.2c0-2 .3-4 .3-6 0-107.8-68.7-199.1-164.6-233.4z">
                    </path>
                </svg>
                <span class="link-text">Categorias</span>
            </a>
        </li>
        <li class="nav-item <?php echo ($actual == 'subcategorias')? 'activo' : '' ?>" onclick="erase_data()">
            <a href="subcategoria.php" class="nav-link">
                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="pushed" class="svg-inline--fa fa-pushed fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 432 512">
                    <path fill="currentColor" d="M407 111.9l-98.5-9 14-33.4c10.4-23.5-10.8-40.4-28.7-37L22.5 76.9c-15.1 2.7-26 18.3-21.4 36.6l105.1 348.3c6.5 21.3 36.7 24.2 47.7 7l35.3-80.8 235.2-231.3c16.4-16.8 4.3-42.9-17.4-44.8zM297.6 53.6c5.1-.7 7.5 2.5 5.2 7.4L286 100.9 108.6 84.6l189-31zM22.7 107.9c-3.1-5.1 1-10 6.1-9.1l248.7 22.7-96.9 230.7L22.7 107.9zM136 456.4c-2.6 4-7.9 3.1-9.4-1.2L43.5 179.7l127.7 197.6c-7 15-35.2 79.1-35.2 79.1zm272.8-314.5L210.1 337.3l89.7-213.7 106.4 9.7c4 1.1 5.7 5.3 2.6 8.6z"></path>
                </svg>
                <span class="link-text">Subcategorias</span>
            </a>
        </li>
        <li class="nav-item <?php echo ($actual == 'productos')? 'activo' : '' ?>">
            <a href="productos.php" class="nav-link">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="screwdriver" class="svg-inline--fa fa-screwdriver fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M448 0L320 96v62.06l-83.03 83.03c6.79 4.25 13.27 9.06 19.07 14.87 5.8 5.8 10.62 12.28 14.87 19.07L353.94 192H416l96-128-64-64zM128 278.59L10.92 395.67c-14.55 14.55-14.55 38.15 0 52.71l52.7 52.7c14.56 14.56 38.15 14.56 52.71 0L233.41 384c29.11-29.11 29.11-76.3 0-105.41s-76.3-29.11-105.41 0z"></path>
                </svg>
                <span class="link-text">Productos</span>
            </a>
        </li>
    </ul>
</nav>