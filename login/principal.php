<?php 
    include('insert_data.php');
    include('../compartidos/conexion_bd.php');
    $actual = 'categorias';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="../js/envio_formulario.js"></script>
    <script src="../js/bootstrap.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">

</head>

<body>
    <div class="contenedor-principal">
        <?php include('compartido/barra_lateral.php');?>
        <div class="contenedor">
            <br>
            <br>
            <h3 class="text-center text-success" id="mensaje"><?php echo $mensaje;?></h3>
            <!-- COPIADO DE UNA PAGINA WEBBBB -->
            <div class="container">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-4">
                                <h2>Administrar <b>Categorias</b></h2>
                            </div>
                            <div class="col-sm-8">
                                <!-- 
                                <a href="#updateTable" class="btn btn-primary" data-toggle="modal" id="updateButton">
                                    <i class="material-icons">&#xe5d5;</i> <span>Actualizar Tabla</span>
                                </a>
                                <a href="#agregarCategoriaModal" class="btn btn-success" data-toggle="modal">
                                    <i class="material-icons">&#xE147;</i> <span>Agregar</span>
                                </a>
                                <a class="btn btn-danger" id="borrarModal">
                                    <i class="material-icons">&#xE15C;</i> <span>Borrar</span>
                                </a>
                                -->
                                <a href="#updateTable" class="btn btn-primary" data-toggle="modal" id="updateButton">
                                    <i class="material-icons">&#xe5d5;</i> <span>Actualizar Tabla</span>
                                </a>
                                <a href="#agregarCategoriaModal" class="btn btn-success" data-toggle="modal">
                                    <i class="material-icons">&#xE147;</i> <span>Agregar</span>
                                </a>
                                <a class="btn btn-danger" id="borrarModal">
                                    <i class="material-icons">&#xE15C;</i> <span>Borrar</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="selectAll">
                                        <label for="selectAll"></label>
                                    </span>
                                </th>
                                <th>ID de la categoria</th>
                                <th>Nombre de la categoria</th>
                                <th>Imagen de la categoria</th>
                                <th>Logo</th>
                                <th>Descripcion</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla">
                            <?php 
                                $sql = "SELECT * FROM `CATEGORIA`";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {?>
                                <tr>
                                    <td>
                                        <span class="custom-checkbox">
                                            <input type="checkbox" name="options[]" value="1">
                                            <label for="checkbox1"></label>
                                        </span>
                                    </td>
                                    <td><?php echo $row["ID_CATEGORIA"] ?></td>
                                    <td><?php echo $row["NOMBRE_CATEGORIA"] ?></td>
                                    <td>
                                        <div class="contenedor_imagen">
                                            <img src="<?php echo $row["IMAGEN_CATEGORIA"] ?>" alt="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contenedor_imagen">
                                            <img src="<?php echo $row["LOGO_CATEGORIA"] ?>" alt="">
                                        </div>
                                    </td>
                                    <td><?php echo $row["DESCRIPCION_CATEGORIA"] ?></td>
                                    <td>
                                        <a class="edit" onclick="editar_dato(this); abrir_modal('#editarCategoriaModal')"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                        <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                                    </td>
                                </tr>
                            <?php }
                        }else{
                            echo "No se encontraron datos";
                        }?>

                        </tbody>
                    </table>
                    <div class="clearfix">
                        <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                        <ul class="pagination">
                            <li class="page-item disabled"><a href="#">Previous</a></li>
                            <li class="page-item"><a href="#" class="page-link">1</a></li>
                            <li class="page-item"><a href="#" class="page-link">2</a></li>
                            <li class="page-item active"><a href="#" class="page-link">3</a></li>
                            <li class="page-item"><a href="#" class="page-link">4</a></li>
                            <li class="page-item"><a href="#" class="page-link">5</a></li>
                            <li class="page-item"><a href="#" class="page-link">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Add Modal HTML -->
            <div id="agregarCategoriaModal" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_agregar_categoria">
                            <div class="modal-header">
                                <h4 class="modal-title">Agregar Categoria</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nombre de la Categoria</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    <span class="text-danger" id="respuesta_nombre"></span>
                                </div>
                                <div class="form-group">
                                    <label>Imagen de la categoria</label>
                                    <input type="file" name="imagen" class="form-control" id="imagen" required>
                                    <span class="text-danger" id="respuesta_imagen"></span>
                                </div>
                                <div class="form-group">
                                    <label>Logo de la categoria</label>
                                    <input type="file" class="form-control" id="logo" name="logo" required>
                                    <span class="text-danger" id="respuesta_logo"></span>
                                </div>
                                <div class="form-group">
                                    <label>Descripcion</label>
                                    <textarea class="form-control" name="descripcion" required></textarea>
                                    <span class="text-danger" id="respuesta_descripcion"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                <input type="submit" class="btn btn-success" name="add" value="agregar" id="agregar_boton">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Modal HTML -->
            <div id="editarCategoriaModal" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="form_editar_categoria">
                            <div class="modal-header">
                                <h4 class="modal-title">Editar Categoria</h4>
                                <button type="button" class="close" onclick="cerrar_modal('#editarCategoriaModal')" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="id_editar" name="id_editar">
                                <div class="form-group">
                                    <label>Nombre de la Categoria</label>
                                    <input type="text" class="form-control" id="nombre_editar" name="nombre_editar" required>
                                    <span class="text-danger" id="respuesta_editar_nombre"></span>
                                </div>
                                <div class="form-group">
                                    <label for="imagen_editar">Imagen de la Categoria
                                        <div class="contenedor_vista_previa">
                                            <img id="vista_previa_imagen" src="" alt="">
                                        </div>
                                    </label>   
                                    <input type="file" name="imagen_editar" class="form-control" id="imagen_editar" accept="image/*">
                                    <span class="text-danger" id="respuesta_editar_imagen"></span>
                                </div>
                                <div class="form-group">
                                    <label for="logo_editar">Logo de la Categoria
                                        <div class="contenedor_vista_previa">
                                            <img id="vista_previa_logo" src="" alt="">
                                        </div>
                                    </label>
                                    <input type="file" class="form-control" id="logo_editar" name="logo_editar" accept="image/*">
                                    <span class="text-danger" id="respuesta_editar_logo"></span>
                                </div>
                                <div class="form-group">
                                    <label>Descripcion</label>
                                    <textarea class="form-control" id="descripcion_editar" name="descripcion_editar" required></textarea>
                                    <span class="text-danger" id="respuesta_editar_descripcion"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" onclick="cerrar_modal('#editarCategoriaModal')" value="Cancelar">
                                <input type="submit" class="btn btn-info" value="Guardar" id="guardar_cambios">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Delete Modal HTML -->
            <div id="eliminarCategoriaModal" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form>
                            <div class="modal-header">
                                <h4 class="modal-title">Eliminar categoria</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>Estas seguro que quieres eliminar estas categorias?</p>
                                <p class="text-warning" id="categoriasSeleccionadas"></p>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                                <input type="button" class="btn btn-danger" value="Delete" id="borrarBoton">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- COPIADO DE UNA PAGINA WEBBBB -->

            <div id="user-data">

            </div>
        </div>
    </div>

    
    <script src="../js/actualizar_tabla.js"></script>
    <script>
        function load_data() {
            $.ajax({
                url: "fetch.php",
                method: "POST",
                success: function(data) {
                    $("#user-data").html(data);
                }
            })
        }
        function erase_data(){
            $("#user-data").html("");
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Activate tooltip
            //$('[data-toggle="tooltip"]').tooltip();
            // http://localhost/tio/login/principal.php
            // Select/Deselect checkboxes
            var checkbox = $('table tbody input[type="checkbox"]');
            $("#selectAll").click(function() {
                console.log("click en select all");
                if (this.checked) {
                    checkbox.each(function() {
                        this.checked = true;
                    });
                } else {
                    checkbox.each(function() {
                        this.checked = false;
                    });
                }
            });
            checkbox.click(function() {
                if (!this.checked) {
                    $("#selectAll").prop("checked", false);
                }
            });
        });
    </script>
    <script src="../js/borrar_dato.js"></script>
    <script src="../js/editar_dato.js"></script>
    <script src="../js/guardar_cambios.js"></script>
    <script src="../js/previsualizar_imagenes.js"></script>
    <script src="../js/acciones_modals.js"></script>
</body>

</html>