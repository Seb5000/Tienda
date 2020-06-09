<?php include('conexion_bd.php');?>
<section class="menu_categorias">
    
    <ul id="menu">
        <?php
            $sql = "SELECT * FROM `CATEGORIA`";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { ?>
                    <li class='item_menu'>
                        <a href='/tio/productos/index.php?categoria=<?php echo $row["ID_CATEGORIA"];?>'>
                            <img src='<?php echo $row["LOGO_CATEGORIA"]; ?>' class='icono' alt=''>
                            <div class='descripcion'><?php echo $row["NOMBRE_CATEGORIA"];?></div>
                            <div class='sub_menu menu_pinturas'>
                                <div class='fondo'><?php echo $row["NOMBRE_CATEGORIA"];?></div>
                                <div class='contenedor'>
                                    <div class='titulo'>
                                        <?php echo $row["NOMBRE_CATEGORIA"];?>
                                    </div>
                                    <div class='gridDescripcion'>
                                    <?php
                                    // Obtener las subcategorias de la categoria...
                                    $sql2 = "SELECT `ID_SUBCATEGORIA`, `NOMBRE_SUBCATEGORIA` FROM `SUBCATEGORIA` WHERE `ID_CATEGORIA` = {$row["ID_CATEGORIA"]}";
                                    $result2 = $conn->query($sql2);
                                    if ($result2->num_rows > 0) {
                                    while($row2 = $result2->fetch_assoc()) { ?>
                                        <div class='item-grid'>
                                            <a href='index.php?categoria=<?php echo $row["ID_CATEGORIA"] ?>&sub_categoria=<?php echo $row2["ID_SUBCATEGORIA"]?>'><?php echo $row2["NOMBRE_SUBCATEGORIA"]?></a>
                                        </div>
                                        <?php }
                                    }?>
                                        <div class='item-grid'>
                                            <a href='index.php?sub_categoria=elemento 1'>elemento 1</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php } 
            } ?>
        <li class="item_menu">
            <a href="/tio/productos/index.php?categoria=pinturas">
                <img src="/tio/imagenes/iconos/artist.png" class="icono" alt="">
                <div class="descripcion">Pinturas</div>
                <div class="sub_menu menu_pinturas">
                    <div class="fondo">PINTURAS</div>
                    <div class="contenedor">
                        <div class="titulo">
                            PINTURAS
                        </div>
                        <div class="gridDescripcion">
                            <div class="item-grid">
                                <a href="index.php?sub_categoria=elemento 1">elemento 1</a>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        <?php
        /*
        <li class="item_menu">
            <a href="/tio/productos/index.php?categoria=pinturas">
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
                                                <a href='index.php?sub_categoria=".$row["NOMBRE_SUBCATEGORIA"]."'>".$row["NOMBRE_SUBCATEGORIA"]."</a>
                                              </div>";
                                    }
                                }
                            ?>
                            
                            <div class="item-grid">
                                <a href="index.php?sub_categoria=elemento 1">elemento 1</a>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        */
        ?>
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