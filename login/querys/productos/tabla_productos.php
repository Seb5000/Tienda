<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Categoria.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Subcategoria.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';

$bd = new DataBase();

$conn = $bd->conectar();
$subcategoria = new Subcategoria($conn);
$categoria = new Categoria($conn);
$producto = new Producto($conn);

$nombre = $_GET['nombre'] ?? null;
$idCategoria = $_GET['categoria'] ?? null;
$idSubcategoria = $_GET['subcategoria'] ?? null;
$catidad_x_pagina = $_GET['cantidad']?? 10;
$pagina = $_GET['pagina']?? 1;

$arrCat = $categoria->listaCategorias();
$arrSub = $subcategoria->listaSubcategorias2();

//$pagina = $pagina==-1 ? $numero_de_paginas : $pagina;
$offset = ($pagina-1)*$catidad_x_pagina;

echo "Cantidad ".$catidad_x_pagina.PHP_EOL;
echo "Pagina ".$pagina.PHP_EOL;

//$arrProd = $producto->leer2();

//$arrProd = $producto->obtenerProductos2($offset, $catidad_x_pagina);
$arrProd = $producto->obtenerProductos3($offset, $catidad_x_pagina, $nombre, $idCategoria, $idSubcategoria);

//$total_productos = $producto->numeroFilas();
$total_productos = $producto->numero_filas;
$numero_de_paginas = ceil($total_productos/$catidad_x_pagina);
echo "total_productos ".$total_productos.PHP_EOL;
echo "#Paginas ".$numero_de_paginas.PHP_EOL;
?>

<div id="contenedorTabla">
    <div id="cabeceraTabla">
        <h2>Administrar <b>Productos</b></h2>
        <div class="botonesTabla">
            <button onclick="confirmarBorrar2()">Borrar</button>
            <button onclick="abrir_modal('agregarModal')">Agregar</button>
        </div>
    </div>
    <div class="filtros">
        <div class="grupo">
            <label for="">Pertenece a la Categoria</label>
            <select class="entradaForm" name="categoria" 
            onchange="ajustarSelectSubcategoria(this.value)" id="filtroCategoria">
                <option value="none" <?php echo ($idCategoria == null)? "selected":"" ?> disabled hidden>&#128586; Selecione una opcion</option>
                <option value="*" <?php echo ($idCategoria == "*")? "selected":"" ?> >&#128106; Mostrar todos</option>
                <option value="0" <?php echo ($idCategoria == "0")? "selected":"" ?> >&#128100; Sin Categoria</option>
            <?php
                foreach($arrCat as $cat):
            ?>
                <option value="<?php echo $cat["id"] ?>" <?php echo ($idCategoria == $cat["id"])? "selected":"" ?> >&#9657; <?php echo $cat["nombre"] ?></option>
            <?php
                endforeach;
            ?>
            </select>
        </div>
        <div class="grupo">
            <label for="">Pertenece a la Subcategoria</label>
            <select class="entradaForm" name="subcategoria" id="filtroSubcategoria">
                <option value="none" <?php echo ($idSubcategoria == null)? "selected":"" ?> disabled hidden>&#128586; Selecione una opcion</option>
                <option value="*" <?php echo ($idSubcategoria == "*")? "selected":"" ?> >&#128049; Mostrar todos</option>
                <option value="0" <?php echo ($idSubcategoria == "0")? "selected":"" ?> >&#9932; Sin Subcategoria</option>
            <?php
                foreach($arrSub as $sub):
            ?>
                <optgroup label="<?php echo $sub["nombre"] ?>">
                <?php
                    foreach($sub["subcategorias"] as $itemSub):
                ?>
                    <option value="<?php echo $itemSub["id"] ?>" <?php echo ($idSubcategoria == $itemSub["id"])? "selected":"" ?>> &#9657; <?php echo $itemSub["nombre"] ?></option>
                <?php
                    endforeach;
                ?>
            <?php
                endforeach;
            ?>
            </select>
        </div>
        <div class="grupo">
            <label for="filtroNombre">Buscar por nombre...</label>
            <div class="sugerenciaInput">
                <input type="text" id="filtroNombre" value="<?php echo $nombre?>" placeholder="Nombre..." 
                onkeyup="buscarSugerencias(this.value)">
                <ul class="listaSugerencias ocultar" id="sugerenciasNombre">
                </ul>
            </div>
        </div>
        <div class="grupo">
            <button id="botonBuscarNombre" onclick="aplicarFiltros()">Buscar</button>
        </div>
    </div>
    <table id="tablaPrincipal">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="selecionarTodos">
                </th>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>SubCategoria</th>
                <th>Imagen</th>
                <th>Marca</th>
                <th>Precio</th>
                <th>Descripcion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($arrProd as $prod){
            ?>
            <tr>
                <td>
                    <input type="checkbox" name="opciones[]">
                </td>
                <td><?php echo $prod['id']?></td>
                <td><?php echo $prod['nombre']?></td>
                <td><?php echo $prod['nombreC']?></td>
                <td><?php echo $prod['nombreS']?></td>
                <td>
                    <div class="contenedor_imagen">
                        <img src="<?php echo $prod['imagen_s']?>" alt="">
                    </div>
                </td>
                <td><?php echo $prod['marca']?></td>
                <td><?php echo $prod['precio']?></td>
                <td><?php echo $prod['descripcion']?></td>
                <td>
                    <button onclick="confirmarBorrar(this)">Borrar</button>
                    <button onclick="editar(<?php echo $prod['id']?>)">Editar</button>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <?php 
        if(count($arrProd)==0):
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
