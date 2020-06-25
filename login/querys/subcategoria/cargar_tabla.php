<?php
//include($_SERVER['DOCUMENT_ROOT']."/tio/compartidos/conexion_bd.php");
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Categoria.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Subcategoria.php';

$bd = new DataBase();

$conn = $bd->conectar();
$subcategoria = new Subcategoria($conn);
$categoria = new Categoria($conn);

$nombre = $_GET['nombre'] ?? null;
$idCategoria = $_GET['categoria'] ?? null;
$catidad_x_pagina = $_GET['cantidad']?? 10;
$pagina = $_GET['pagina']?? 1;

$arrCat = $categoria->listaCategorias();
//Para la paginacion

$total_subcategorias = $subcategoria->numeroFilas();
$numero_de_paginas = ceil($total_subcategorias/$catidad_x_pagina);
$pagina = $pagina==-1 ? $numero_de_paginas : $pagina;
$offset = ($pagina-1)*$catidad_x_pagina;
$arrSub = $subcategoria->obtenerProductos2($offset, $catidad_x_pagina, $nombre, $idCategoria);

?>

<div id="cabeceraTabla">
    <h2>Administrar <b>Subcategorias</b></h2>
    <div class="botonesTabla">
        <button onclick="obtenerIds()">Borrar</button>
        <button onclick="abrir_modal('agregarModal')">Agregar</button>
    </div>
</div>
<div class="filtros">
    <div class="grupo">
        <label for="filtroNombre">Buscar por nombre...</label>
        <div class="sugerenciaInput">
            <input type="text" id="filtroNombre" value="<?php echo $nombre?>" placeholder="Nombre..." 
            onkeyup="buscarSugerencias(this.value)">
            <ul class="listaSugerencias ocultar" id="sugerenciasNombre">
            </ul>
            <button id="botonBuscarNombre" onclick="buscarNombre()">Buscar</button>
        </div>
    </div>
    <div class="grupo">
        <label for="">Pertenece a la Categoria</label>
        <select class="entradaForm" name="categoria" onchange="ajustarCategoria(this.value)">
            <option value="todas" <?php echo ($idCategoria == null)? "Selected" : "" ?>>Mostrar todos</option>
            <option value="sinCategoria" <?php echo ($idCategoria == "sinCategoria")? "Selected" : "" ?>>Sin Categoria</option>
        <?php
            foreach($arrCat as $cat):
        ?>
            <option value="<?php echo $cat["id"] ?>" <?php echo ($idCategoria == $cat["id"])? "Selected" : "" ?>><?php echo $cat["nombre"] ?></option>
        <?php
            endforeach;
        ?>
        </select>
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
            <th>Pertenece a<br>Categoria</th>
            <th>Imagen</th>
            <th>Descripcion</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($arrSub as $sub):
        ?>
        <tr>
            <td>
                <input type="checkbox" name="opciones[]">
            </td>
            <td><?php echo $sub["id"] ?></td>
            <td><?php echo $sub["nombre"] ?></td>
            <td><?php echo $sub["nombreC"] ?></td>
            <td>
                <div class="contenedor_imagen">
                    <img src="<?php echo $sub["imagen"] ?>" alt="">
                </div>
            </td>
            <td>
                <?php echo $sub["descripcion"] ?>
            </td>
            <td>
                <button onclick="borrarId(this)">Borrar</button>
                <button onclick="llenarFormEditar(<?php echo $sub['id'] ?>)">Editar</button>
            </td>
        </tr>
        <?php 
            endforeach;
        ?>
    </tbody>
    
</table>
<?php 
    if(count($arrSub)==0):
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
        href="<?php echo 'subcategoria.php?cantidad='.$catidad_x_pagina.'&pagina='.($pagina-1) ?>">Anterior</a>
        <?php for($i = 1; $i<= $numero_de_paginas; $i++):?>
        <a class="pagina <?php echo $pagina==$i? 'activo': '' ?>" 
        href="subcategoria.php?cantidad=<?php echo $catidad_x_pagina ?>&pagina=<?php echo ($i) ?>">
        <?php echo $i ?></a>
        <?php endfor ?>
        <a class="pagina <?php echo $pagina+1>$numero_de_paginas? 'desactivado': '' ?>" href="<?php echo 'subcategoria.php?cantidad='.$catidad_x_pagina.'&pagina='.($pagina+1) ?>">Siguiente</a>
    </div>
</div>
