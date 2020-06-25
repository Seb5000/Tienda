<?php 
    include('insert_data.php');
    include('../compartidos/conexion_bd.php');
    $actual = 'categorias2';

    if(isset($_GET['cantidad']) and isset($_GET['pagina'])){
        $catidad_x_pagina = $_GET['cantidad'];
        $pagina = $_GET['pagina'];
    }else{
        header('Location: categorias.php?pagina=1&cantidad=10');
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <link rel="stylesheet" href="../css/categorias.css">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

</head>

<body>
    <div class="contenedor-principal">
        <?php include('compartido/barra_lateral.php');?>
        <div class="contenedor">
            <h2>Categorias</h2>
            <div id="contenedorAuxiliar">
            <?php
                include('querys/categorias/tabla.php');
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
                    <h2>Agregar Categoria</h2>
                    <p id="mensaje_agregar"></p>
                    <button class="boton-cerrar" onclick="cerrar_modal('agregarModal')">x</button>
                </div>
                <form id="formulario_agregar" action="" onsubmit="event.preventDefault(); agregarCategoria();">
                    <div class="cuerpoModal">
                        <div class="grupoInput">
                            <label class="etiquetaForm" for="nombre">Nombre de la categoria</label>
                            <span class="mensaje_form" id="form_agregar_mensaje_nombre"></span>
                            <input class="entradaForm" name="nombre" type="text">
                        </div>
                        <div class="grupoInput">
                            <label class="etiquetaForm" for="imagen">Imagen de la categoria</label>
                            <span class="mensaje_form" id="form_agregar_mensaje_imagen"></span>
                            <input class="entradaForm" name="imagen" type="file">
                        </div>
                        <div class="grupoInput">
                            <label class="etiquetaForm" for="logo">Logo de la categoria</label>
                            <span class="mensaje_form" id="form_agregar_mensaje_logo"></span>
                            <input class="entradaForm" name="logo" type="file">
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
                        <input type="hidden" id="editar_caminoImagenS" name="caminoImagenS">
                        <input type="hidden" id="editar_caminoLogo" name="caminoLogo">
                        <div class="grupoInput">
                            <label class="etiquetaForm" for="editar_nombre">Nombre de la categoria</label>
                            <span class="mensaje_form" id="editar_mensaje_nombre"></span>
                            <input class="entradaForm" name="nombre" id="editar_nombre" type="text">
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
                            <label for="editar_logo">Logo de la Subcategoria
                                <div class="contenedor_vista_previa">
                                    <img id="vista_previa_logo" src="" alt="">
                                </div>
                            </label>
                            <span class="mensaje_form" id="editar_mensaje_logo"></span>
                            <input class="entradaForm" name="logo" 
                            type="file" id="editar_logo">
                        </div>
                        <div class="grupoInput">
                            <label class="etiquetaForm" for="edita_descripcion">Descripcion</label>
                            <textarea class="entradaForm" name="descripcion" id="editar_descripcion"></textarea>
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
                    <button type="button" onclick="borrar()">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/modales.js"></script>
    <script src="js/categoria.js"></script>
</body>

</html>