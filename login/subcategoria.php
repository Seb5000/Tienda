<?php
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("Location: index.php?error=redireccion");
        die();
    }
    if(isset($_GET['cantidad']) and isset($_GET['pagina'])){
        $catidad_x_pagina = $_GET['cantidad'];
        $pagina = $_GET['pagina'];
    }else{
        header('Location: subcategoria.php?pagina=1&cantidad=10');
        die();
    }

    include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Categoria.php';
    $actual = 'subcategorias';
    
    $bd = new DataBase();
    
    $conn = $bd->conectar();
    $categoria = new Categoria($conn);
    $arrCat = $categoria->listaCategorias();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/layoutBase.css">
    <link rel="stylesheet" href="css/barraLogin.css">
    <link rel="stylesheet" href="css/barraLateral.css">
    <link rel="stylesheet" href="css/tablaCRUD.css">
    <link rel="stylesheet" href="css/modales.css">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    
</head>
<body>
    <div class="contenedor-principal">
        <?php include('compartido/barra_lateral.php');?>
        <div class="contenedor">
            <?php include('compartido/barraLogin.php');?>
            <div id="contenedorTabla">
                <h2>Subcategorias</h2>
                <?php include('querys/subcategoria/cargar_tabla.php') ?>
            </div>
        </div>
    </div>

    <!-- Backdrop -->
    <div id="covertor"></div>
    <!-- Backdrop -->
    <!-- Modal agregar sub categoria INICIO-->
    <div id="agregarModal" class="contenedorModal">
        <div class="modal">
            <div id="cabeceraModalAgregar" class="cabeceraModal">
                <h2>Agregar Subcategoria</h2>
                <p id="mensaje_agregar"></p>
                <button class="boton-cerrar" onclick="cerrar_modal('agregarModal')">x</button>
            </div>
            <form id="formulario_agregar" action="" onsubmit="event.preventDefault(); agregarPorAxios();">
                <div class="cuerpoModal">
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="nombre">Nombre de la Subcategoria</label>
                        <span class="mensaje_form" id="form_agregar_mensaje_nombre"></span>
                        <input class="entradaForm" name="nombre" type="text">
                        
                    </div>
                    
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="categoria">Pertenece a la Categoria...</label>
                        <span class="mensaje_form" id="form_agregar_mensaje_categoria"></span>
                        <select class="entradaForm" name="categoria">
                        <?php 
                            foreach($arrCat as $cat):
                        ?>
                            <option value="<?php echo $cat["id"] ?>"><?php echo $cat["nombre"] ?></option>
                        <?php
                            endforeach;
                        ?>
                        </select>
                        
                    </div>
                    <div class="grupoInput">
                        <label class="etiquetaForm" for="imagen">Imagen de la Subcategoria</label>
                        <span class="mensaje_form" id="form_agregar_mensaje_imagen"></span>
                        <input class="entradaForm" name="imagen" type="file">
                        
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
            <div class="cabeceraModal" id="cabeceraEditar">
                <h2>Editar Subcategoria</h2>
                <p id="mensaje_editar"></p>
                <button class="boton-cerrar" onclick="cerrar_modal('editarModal')">x</button>
            </div>
            <form id="formulario_editar" action="" onsubmit="event.preventDefault(); enviarFormEditar();">
                <div class="cuerpoModal">
                    <input type="hidden" id="modal_editar_id" name="id">
                    <input type="hidden" id="modal_editar_caminoImagen" name="caminoImagen">
                    <input type="hidden" id="modal_editar_caminoImagenS" name="caminoImagenS">
                    <div class="grupoInput">
                        <label for="">Nombre de la Subcategoria</label>
                        <input class="entradaForm" name="nombre" 
                        type="text" id="modal_editar_nombre" >
                    </div>
                    <div class="grupoInput">
                        <label for="">Pertenece a la Categoria...</label>
                        <select class="entradaForm" name="categoria" id="modal_editar_categoria">
                        <?php 
                            foreach($arrCat as $cat):
                        ?>
                            <option value="<?php echo $cat["id"] ?>"><?php echo $cat["nombre"] ?></option>
                        <?php
                            endforeach;
                        ?>
                        </select>
                    </div>
                    <div class="grupoInput">
                        <label for="modal_editar_imagen">Imagen de la Subcategoria
                            <div class="contenedor_vista_previa">
                                <img id="vista_previa_imagen" src="" alt="">
                            </div>
                        </label>
                        <input class="entradaForm" name="imagen" 
                        type="file" id="modal_editar_imagen">
                    </div>
                    <div class="grupoInput">
                        <label for="">Descripccion</label>
                        <textarea class="entradaForm" name="descripcion" 
                        id="modal_editar_descripcion"></textarea>
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
            <div class="cabeceraModal" id="cabeceraBorrar">
                <h2>Borrar Subcategoria</h2>
                <p id="mensaje_borrar"></p>
                <button class="boton-cerrar" onclick="cerrar_modal('borrarModal')">x</button>
            </div>
            <form id="formulario_borrar" action="">
                <div class="cuerpoModal">
                    
                </div>
                <div class="pieModal">
                    <button>Cancelar</button>
                    <button type="button" onclick="borrarPorAxios()">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal borrar sub categoria FIN   -->

</body>
<script type="text/javascript" src="js/burger.js"></script>
<script src="js/modales.js"></script>
<script src="/tio/login/js/axios_subcategoria.js"></script>
<script src="/tio/login/js/subcategoria_checkbox.js" id="scriptCheckBox"></script>
<script src="/tio/login/js/previsualizar_imagen.js"></script>
</html>