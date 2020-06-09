<?php
    include('../compartidos/conexion_bd.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/subcategoria.css">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    
</head>
<body>
    <div class="contenedor-principal">
        <?php include('compartido/barra_lateral.php');?>
        <div class="contenedor">
            <h2>Subcategorias</h2>
            <div id="contenedorTabla">
                <div id="cabeceraTabla">
                    <h2>Administrar <b>Subcategorias</b></h2>
                    <div class="botonesTabla">
                        <button onclick="obtenerIds()">Borrar</button>
                        <button onclick="abrir_modal('agregarModal')">Agregar</button>
                    </div>
                </div>
                <table id="tablaPrincipal">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selecionarTodos">
                            </th>
                            <th>ID Subcategoria</th>
                            <th>Nombre SubCategoria</th>
                            <th>Pertenece a<br>Categoria</th>
                            <th>Imagen Subcategoria</th>
                            <th>Descripcion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" name="opciones[]">
                            </td>
                            <td>id Sub</td>
                            <td>Nombre de la sub</td>
                            <td>Categoria 123</td>
                            <td>
                                <div class="contenedor_imagen">
                                    <img src="/tio/imagenes/categorias/7.jpg" alt="">
                                </div>
                            </td>
                            <td>
                                Esta es una descripccion bien pendeja
                            </td>
                            <td>
                                <button onclick="borrarId(this)">Borrar</button>
                                <button onclick="llenarFormEditar(1)">Editar</button>
                            </td>
                        </tr>
                        
                        <?php 
                            $sql = "SELECT * FROM `SUBCATEGORIA`";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="opciones[]">
                            </td>
                            <td><?php echo $row["ID_SUBCATEGORIA"] ?></td>
                            <td><?php echo $row["NOMBRE_SUBCATEGORIA"] ?></td>
                            <td><?php echo $row["ID_CATEGORIA"] ?></td>
                            <td>
                                <div class="contenedor_imagen">
                                    <img src="<?php echo $row["IMAGEN_SUBCATEGORIA"] ?>" alt="">
                                </div>
                            </td>
                            <td>
                                <?php echo $row["DESCRIPCION_SUBCATEGORIA"] ?>
                            </td>
                            <td>
                                <button onclick="borrarId(this)">Borrar</button>
                                <button onclick="llenarFormEditar(<?php echo $row['ID_SUBCATEGORIA'] ?>)">Editar</button>
                            </td>
                        </tr>
                        <?php 
                                }
                            }else{
                            echo "No se encontraron datos";
                            }
                        ?>
                    </tbody>
                </table>
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
                            $sql = "SELECT ID_CATEGORIA, NOMBRE_CATEGORIA FROM `CATEGORIA`";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $row["ID_CATEGORIA"] ?>"><?php echo $row["NOMBRE_CATEGORIA"] ?></option>
                            <?php
                                }
                            }
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
            <div class="cabeceraModal">
                <h2>Editar Subcategoria</h2>
                <button class="boton-cerrar" onclick="cerrar_modal('editarModal')">x</button>
            </div>
            <form id="formulario_editar" action="" onsubmit="event.preventDefault(); enviarFormEditar();">
                <div class="cuerpoModal">
                    <input type="hidden" id="modal_editar_id" name="id">
                    <input type="hidden" id="modal_editar_caminoImagen" name="caminoImagen">
                    <div class="grupoInput">
                        <label for="">Nombre de la Subcategoria</label>
                        <input class="entradaForm" name="nombre" 
                        type="text" id="modal_editar_nombre" >
                    </div>
                    <div class="grupoInput">
                        <label for="">Pertenece a la Categoria...</label>
                        <select class="entradaForm" name="categoria" id="modal_editar_categoria">
                        <?php 
                            $sql = "SELECT ID_CATEGORIA, NOMBRE_CATEGORIA FROM `CATEGORIA`";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $row["ID_CATEGORIA"] ?>"><?php echo $row["NOMBRE_CATEGORIA"] ?></option>
                            <?php
                                }
                            }
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
            <div class="cabeceraModal">
                <h2>Borrar Subcategoria</h2>
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
<script src="../js/subcategoria_modal.js"></script>
<script src="/tio/login/js/axios_subcategoria.js"></script>
<script src="/tio/login/js/subcategoria_checkbox.js" id="scriptCheckBox"></script>
<script src="/tio/login/js/previsualizar_imagen.js"></script>
</html>