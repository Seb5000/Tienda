<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "CASAARTE";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn->connect_error){
        echo $conn->connect_error;
        //header('Refresh: 10; URL=http://yoursite.com/page.php');
    }
?>
<section class="menu_categorias">
    <ul id="menu">
        <li class="item_menu">
            <a href="/tio/categorias/pinturas.php">
                <img src="/tio/imagenes/iconos/artist.png" class="icono" alt="">
                <div class="descripcion">Pinturas</div>
                <div class="sub_menu menu_pinturas">
                    <div class="fondo">PINTURAS</div>
                    <div class="contenedor">
                        <div class="titulo">
                            PINTURAS
                        </div>
                        <div class="gridDescripcion">
                            <?php 
                                $sql = "SELECT NOMBRE_SUBCATEGORIA FROM `subcategorias` WHERE `CATEGORIA_SUBCATEGORIA` LIKE 'Pinturas' ";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<div class='item-grid'>
                                                <a href='pinturas.php?sub_categoria=".$row["NOMBRE_SUBCATEGORIA"]."'>".$row["NOMBRE_SUBCATEGORIA"]."</a>
                                              </div>";
                                    }
                                }
                            ?>
                            
                            <div class="item-grid">
                                <a href="pinturas.php?sub_categoria=elemento 1">elemento 1</a>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="item_menu">
            <a href="/tio/categorias/tijeras.php">
                <img src="/tio/imagenes/iconos/cut.png" class="icono" alt="">
                <div class="descripcion">Tijeras</div>
                <div class="sub_menu">
                    <div class="fondo">TIJERAS</div>
                    <div class="contenedor">
                        <div class="titulo">
                            TIJERAS
                        </div>
                        <div class="gridDescripcion">
                            <?php 
                                $sql = "SELECT NOMBRE_SUBCATEGORIA FROM `subcategorias` WHERE `CATEGORIA_SUBCATEGORIA` LIKE 'tijeras' ";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<div class='item-grid'>
                                                <a href='tijeras.php?sub_categoria=".$row["NOMBRE_SUBCATEGORIA"]."'>".$row["NOMBRE_SUBCATEGORIA"]."</a>
                                              </div>";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="item_menu">
            <a href="/tio/categorias/papeles.php">
                <img src="/tio/imagenes/iconos/graffiti.png" class="icono" alt="">
                <div class="descripcion">Papeles</div>
                <div class="sub_menu">
                    <div class="fondo">PAPELES</div>
                    <div class="contenedor">
                        <div class="titulo">
                            PAPELES
                        </div>
                        <div class="gridDescripcion">
                            <?php 
                                $sql = "SELECT NOMBRE_SUBCATEGORIA FROM `subcategorias` WHERE `CATEGORIA_SUBCATEGORIA` LIKE 'Papeles' ";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<div class='item-grid'>
                                                <a href='papeles.php?sub_categoria=".$row["NOMBRE_SUBCATEGORIA"]."'>".$row["NOMBRE_SUBCATEGORIA"]."</a>
                                              </div>";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="item_menu">
            <a href="/tio/categorias/barita_magica.php">
                <img src="/tio/imagenes/iconos/magic-wand.png" class="icono" alt="">
                <div class="descripcion">Barita Magica</div>
                <div class="sub_menu">
                    <div class="fondo">BARITA MAGICA</div>
                    <div class="contenedor">
                        <div class="titulo">
                            BARITA MAGICA
                        </div>
                        <div class="gridDescripcion">
                            <?php 
                                $sql = "SELECT NOMBRE_SUBCATEGORIA FROM `subcategorias` WHERE `CATEGORIA_SUBCATEGORIA` LIKE 'barita magica' ";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<div class='item-grid'>
                                                <a href='barita_magica.php?sub_categoria=".$row["NOMBRE_SUBCATEGORIA"]."'>".$row["NOMBRE_SUBCATEGORIA"]."</a>
                                              </div>";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="item_menu">
            <a href="/tio/categorias/libreta.php">
                <img src="/tio/imagenes/iconos/notebook.png" class="icono" alt="">
                <div class="descripcion">Libreta</div>
                <div class="sub_menu">
                    <div class="fondo">LIBRETA</div>
                    <div class="contenedor">
                        <div class="titulo">
                            LIBRETA
                        </div>
                        <div class="gridDescripcion">
                            <?php 
                                $sql = "SELECT NOMBRE_SUBCATEGORIA FROM `subcategorias` WHERE `CATEGORIA_SUBCATEGORIA` LIKE 'libreta' ";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<div class='item-grid'>
                                                <a href='libreta.php?sub_categoria=".$row["NOMBRE_SUBCATEGORIA"]."'>".$row["NOMBRE_SUBCATEGORIA"]."</a>
                                              </div>";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="item_menu">
            <a href="/tio/categorias/pintura.php">
                <img src="/tio/imagenes/iconos/paint.png" class="icono" alt="">
                <div class="descripcion">Pintura</div>
                <div class="sub_menu">
                    <div class="fondo">PINTURA</div>
                    <div class="contenedor">
                        <div class="titulo">
                            PINTURA
                        </div>
                        <div class="gridDescripcion">
                            <?php 
                                $sql = "SELECT NOMBRE_SUBCATEGORIA FROM `subcategorias` WHERE `CATEGORIA_SUBCATEGORIA` LIKE 'pintura' ";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<div class='item-grid'>
                                                <a href='pintura.php?sub_categoria=".$row["NOMBRE_SUBCATEGORIA"]."'>".$row["NOMBRE_SUBCATEGORIA"]."</a>
                                              </div>";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="item_menu">
            <a href="/tio/categorias/lapiz.php">
                <img src="/tio/imagenes/iconos/pencil.png" class="icono" alt="">
                <div class="descripcion">Lapiz</div>
                <div class="sub_menu">
                    <div class="fondo">LAPIZ</div>
                    <div class="contenedor">
                        <div class="titulo">
                            LAPIZ
                        </div>
                        <div class="gridDescripcion">
                            <?php 
                                $sql = "SELECT NOMBRE_SUBCATEGORIA FROM `subcategorias` WHERE `CATEGORIA_SUBCATEGORIA` LIKE 'lapiz' ";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<div class='item-grid'>
                                                <a href='lapiz.php?sub_categoria=".$row["NOMBRE_SUBCATEGORIA"]."'>".$row["NOMBRE_SUBCATEGORIA"]."</a>
                                              </div>";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="item_menu">
            <a href="/tio/categorias/material_escolar.php">
                <img src="/tio/imagenes/iconos/school-material.png" class="icono" alt="">
                <div class="descripcion">Material Escolar</div>
                <div class="sub_menu">
                    <div class="fondo">MATERIAL ESCOLAR</div>
                    <div class="contenedor">
                        <div class="titulo">
                            MATERIAL ESCOLAR
                        </div>
                        <div class="gridDescripcion">
                            <?php 
                                $sql = "SELECT NOMBRE_SUBCATEGORIA FROM `subcategorias` WHERE `CATEGORIA_SUBCATEGORIA` LIKE 'material escolar' ";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<div class='item-grid'>
                                                <a href='material_escolar.php?sub_categoria=".$row["NOMBRE_SUBCATEGORIA"]."'>".$row["NOMBRE_SUBCATEGORIA"]."</a>
                                              </div>";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="item_menu">
            <a href="/tio/categorias/brocha.php">
                <img src="/tio/imagenes/iconos/brush.svg" alt="" class="icono">
                <div class="descripcion">Brocha</div>
                <div class="sub_menu">
                    <div class="fondo">BROCHA</div>
                    <div class="contenedor">
                        <div class="titulo">
                            BROCHA
                        </div>
                        <div class="gridDescripcion">
                            <?php 
                                $sql = "SELECT NOMBRE_SUBCATEGORIA FROM `subcategorias` WHERE `CATEGORIA_SUBCATEGORIA` LIKE 'brocha' ";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<div class='item-grid'>
                                                <a href='brocha.php?sub_categoria=".$row["NOMBRE_SUBCATEGORIA"]."'>".$row["NOMBRE_SUBCATEGORIA"]."</a>
                                              </div>";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <li class="item_menu more hidden">
            <svg class="icono" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                style="enable-background:new 0 0 512 512;" xml:space="preserve">
                <g>
                    <g>
                        <g>
                            <path d="M256,0C114.615,0,0,114.615,0,256s114.615,256,256,256s256-114.615,256-256S397.385,0,256,0z M256,480
				C132.288,480,32,379.712,32,256S132.288,32,256,32s224,100.288,224,224S379.712,480,256,480z" />
                            <circle cx="256" cy="256" r="32" />
                            <circle cx="368" cy="256" r="32" />
                            <circle cx="144" cy="256" r="32" />
                        </g>
                    </g>
                </g>
            </svg>
            <div class="descripcion">Otras Opciones</div>
            <ul class="menu_Lateral">
            </ul>
        </li>
    </ul>
</section>