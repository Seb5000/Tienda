<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Categoria.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Subcategoria.php';
$actual = 'productos';

$bd = new DataBase();

$conn = $bd->conectar();
$categoria = new Categoria($conn);
$subcategoria = new Subcategoria($conn);

if(isset($_GET['cantidad']) and isset($_GET['pagina'])){
    $catidad_x_pagina = $_GET['cantidad'];
    $pagina = $_GET['pagina'];
}else{
    header('Location: productos.php?pagina=1&cantidad=10');
    die();
}

$arrCat = $categoria->listaCategorias();
$arrSubcat = $subcategoria->listaSubcategorias();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/loginProductos.css">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>
<body>
<div class="contenedor-principal">
    <?php include('compartido/barra_lateral.php');?>
    <div class="contenedor">
        <h2>Productos</h2>
        <div id="contenedorAuxiliar">
        <?php
            include('querys/productos/tabla_productos.php');
        ?>
        </div>
    </div>

    <!-- Backdrop -->
    <div id="covertor"></div>
    <!-- Backdrop -->
    <!-- Modal agregar Producto INICIO-->
    <div id="agregarModal" class="contenedorModal">
        <div class="modal">
            <div id="cabeceraModalAgregar" class="cabeceraModal">
                <h2>Agregar Producto</h2>
                <p id="mensaje_agregar"></p>
                <button class="boton-cerrar" onclick="cerrar_modal('agregarModal')">x</button>
            </div>
            <form id="formulario_agregar" action="" onsubmit="event.preventDefault(); agregarPorAxios();">
                <div class="cuerpoModal">
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="id">Id del producto</label>
                        <span class="mensaje_form" id="form_agregar_mensaje_id"></span>
                        <input class="entradaForm" name="id" type="text">
                    </div>
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="nombre">Nombre del producto</label>
                        <span class="mensaje_form" id="form_agregar_mensaje_nombre"></span>
                        <input class="entradaForm" name="nombre" type="text">
                    </div>
                    
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="categoria">Pertenece a la Categoria...</label>
                        <span class="mensaje_form" id="form_agregar_mensaje_categoria"></span>
                        <select class="entradaForm" name="categoria" id="selectCategoria" onchange="llenarSubcategorias()">
                            <option value="" hidden>Elige una opcion...</option>
                            <?php
                            foreach($arrCat as $categoria){
                            ?>
                                <option value="<?php echo $categoria["id"] ?>"><?php echo $categoria["nombre"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="categoria">Pertenece a la Subcategoria...</label>
                        <span class="mensaje_form" id="form_agregar_mensaje_subcategoria"></span>
                        <select class="entradaForm" name="subcategoria" id="selectSubcategoria">
                            <option value="" hidden>Elige una opcion...</option>
                        </select>
                    </div>

                    <div class="dragArea">
                        <input type="file" name="imagenes[]" id="imagenes" data-multiple-caption="{count} files selected" multiple>
                        <label for="imagenes"><strong>Elige las imagenes</strong> o jalalas hasta aqui!</label>
                        <div id="contenedorImagenes">
                        </div>
                    </div>
                    
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="nombre">Marca del producto</label>
                        <span class="mensaje_form" id="form_agregar_mensaje_marca"></span>
                        <input class="entradaForm" name="marca" type="text">
                    </div>
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="nombre">Precio del producto</label>
                        <span class="mensaje_form" id="form_agregar_mensaje_precio"></span>
                        <input class="entradaForm" name="precio" type="number">
                    </div>
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="descripcion">Descripcion</label>
                        <textarea class="entradaForm" name="descripcion"></textarea>
                    </div>
                </div>
                <div class="pieModal">
                    <button>Cancelar</button>
                    <button type="submit">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal agregar sub categoria FIN   -->

    <!-- Modal editar sub categoria INICIO-->
    <div id="editarModal" class="contenedorModal">
        <div class="modal">
            <div id="cabeceraModalEditar" class="cabeceraModal">
                <h2>Editar el Producto</h2>
                <p id="mensaje_editar"></p>
                <button class="boton-cerrar" onclick="cerrar_modal('editarModal')">x</button>
            </div>
            <form id="formulario_editar" action="" onsubmit="event.preventDefault(); guardarCambios();">
                <div class="cuerpoModal">
                    <input type="hidden" id="editar_id" name="id">
                    <input type="hidden" id="editar_caminoImagen" name="caminoImagen">
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="editar_nombre">Nombre del producto</label>
                        <span class="mensaje_form" id="editar_mensaje_nombre"></span>
                        <input class="entradaForm" name="nombre" id="editar_nombre" type="text">
                    </div>
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="categoria">Pertenece a la Categoria...</label>
                        <span class="mensaje_form" id="editar_mensaje_categoria"></span>
                        <select class="entradaForm" name="categoria" id="editarSelectCategoria" onchange="llenarSubcategoriasE()">
                            <option value="-1" hidden>Sin Categoria</option>
                            <?php
                            foreach($arrCat as $categoria){
                            ?>
                                <option value="<?php echo $categoria["id"] ?>"><?php echo $categoria["nombre"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="grupoInput">
                        <label class="etiquetaForm">Pertenece a la Subcategoria...</label>
                        <span class="mensaje_form" id="editar_mensaje_subcategoria"></span>
                        <select class="entradaForm" name="subcategoria" id="editarSelectSubcategoria">
                            <option value="" hidden>Elige una opcion...</option>
                        </select>
                    </div>
                    <div class="grupoInput">
                        <label for="editar_imagen">Imagen de la Subcategoria
                            <div class="contenedor_vista_previa">
                                <img id="vista_previa_imagen" src="" alt="">
                            </div>
                        </label>
                        <span class="mensaje_form" id="editar_mensaje_imagen"></span>
                        <input class="entradaForm" name="imagen" 
                        type="file" id="editar_imagen">
                    </div>
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="editar_marca">Marca del producto</label>
                        <input class="entradaForm" name="marca" id="editar_marca" type="text">
                    </div>
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="editar_precio">Precio del producto</label>
                        <span class="mensaje_form" id="editar_mensaje_precio"></span>
                        <input class="entradaForm" name="precio" id="editar_precio" type="number">
                    </div>
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="edita_descripcion">Descripcion</label>
                        <textarea class="entradaForm" name="descripcion" id="edita_descripcion"></textarea>
                    </div>
                </div>
                <div class="pieModal">
                    <button>Cancelar</button>
                    <button type="submit">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal editar sub categoria FIN   -->

    <!-- Modal borrar sub categoria INICIO-->
    <div id="borrarModal" class="contenedorModal">
        <div class="modal">
            <div id="cabeceraModalBorrar" class="cabeceraModal">
                <h2>Borrar Subcategoria</h2>
                <p id="mensaje_borrar"></p>
                <button class="boton-cerrar" onclick="cerrar_modal('borrarModal')">x</button>
            </div>
            <div class="cuerpoModal" id="modalBorrarCuerpo">
                
            </div>
            <div class="pieModal">
                <button type="button" onclick="cerrar_modal('borrarModal')">Cancelar</button>
                <button type="button" onclick="borrarProductos()">Aceptar</button>
            </div>
        </div>
    </div>
    <script src="js/modales.js"></script>
    <script src="js/axios_productos.js"></script>
    <script src="js/previsualizar_imgProducto.js"></script>
    <script src="js/dragDropv2.js"></script>
</body>
</html>