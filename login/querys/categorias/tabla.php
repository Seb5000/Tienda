<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Categoria.php';

$bd = new DataBase();
$conn = $bd->conectar();
$objCat = new Categoria($conn);

$catidad_x_pagina = $_GET['cantidad']?? 10;
$pagina = $_GET['pagina']?? 1;
$offset = ($pagina-1)*$catidad_x_pagina;

//echo "Cantidad ".$catidad_x_pagina.PHP_EOL;
//echo "Pagina ".$pagina.PHP_EOL;

$arrCategoria = $objCat->getCategorias($offset, $catidad_x_pagina);

$total_categorias = $objCat->numeroFilas();
$numero_de_paginas = ceil($total_categorias/$catidad_x_pagina);
//echo "total_categorias ".$total_categorias.PHP_EOL;
//echo "#Paginas ".$numero_de_paginas.PHP_EOL;
?>

<div id="contenedorTabla">
    <div id="cabeceraTabla">
        <h2>Administrar <b>Categorias</b></h2>
        <div class="botonesTabla">
            <button onclick="confirmarBorrar2()">Borrar</button>
            <button onclick="abrir_modal('agregarModal')">Agregar</button>
        </div>
    </div>
    
    <div class="tabla">
        <table id="tablaPrincipal">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="selecionarTodos">
                    </th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Descripcion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($arrCategoria as $cat){
                ?>
                <tr>
                    <td>
                        <input type="checkbox" name="opciones[]">
                    </td>
                    <td><?php echo $cat['id']?></td>
                    <td><?php echo $cat['nombre']?></td>
                    <td>
                        <div class="contenedor_imagen">
                            <img src="<?php echo $cat['imagenS']?>" alt="">
                        </div>
                    </td>
                    <td><?php echo $cat['descripcion']?></td>
                    <td>
                        <button onclick="confirmarBorrar(this)">Borrar</button>
                        <button onclick="editarCategoria(this)">Editar</button>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php 
        if(count($arrCategoria)==0):
    ?>
        <div style="padding-left:5em;background-color: hsla(219, 79%, 66%, 0.2);font-size: 20px;">
            <br>
            <?php echo " &nbsp; No se encontraron Datos"; ?>
            <br><br>
        </div>
    <?php 
        endif;
    ?>
    <div class="pieTabla">
        <div class="contenedorCantidad">
            <select name="cantidad" id="cantidadPaginacion" onchange="ajustarCantidad(this.value)">
                <option <?php echo $catidad_x_pagina==10 ? 'selected': '' ?> value="10">10</option>
                <option <?php echo $catidad_x_pagina==20 ? 'selected': '' ?> value="20">20</option>
                <option <?php echo $catidad_x_pagina==30 ? 'selected': '' ?> value="30">30</option>
                <option <?php echo $catidad_x_pagina==50 ? 'selected': '' ?> value="50">50</option>
            </select>
        </div>
        <div class="paginacion">
            <a class="pagina <?php echo $pagina-1<=0? 'desactivado': '' ?>" 
            onclick="cambiarPagina(<?php echo ($pagina-1) ?>)">Anterior</a>
            <?php for($i = 1; $i<= $numero_de_paginas; $i++):?>
            <a class="pagina <?php echo $pagina==$i? 'activo': '' ?>" 
            onclick="cambiarPagina(<?php echo ($i) ?>)">
            <?php echo $i ?></a>
            <?php endfor ?>
            <a class="pagina <?php echo $pagina+1>$numero_de_paginas? 'desactivado': '' ?>" onclick="cambiarPagina(<?php echo ($pagina+1) ?>)">Siguiente</a>
        </div>
    </div>
</div>