<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Producto.php';

$bd = new DataBase();

$conn = $bd->conectar();
$producto = new Producto($conn);

$arrProd = $producto->leer2();

?>

<div id="contenedorTabla">
    <div id="cabeceraTabla">
        <h2>Administrar <b>Productos</b></h2>
        <div class="botonesTabla">
            <button onclick="confirmarBorrar2()">Borrar</button>
            <button onclick="abrir_modal('agregarModal')">Agregar</button>
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
                <td><?php echo $prod['id_producto']?></td>
                <td><?php echo $prod['nombre_producto']?></td>
                <td><?php echo $prod['nombre_categoria']?></td>
                <td><?php echo $prod['nombre_subcategoria']?></td>
                <td>
                    <div class="contenedor_imagen">
                        <img src="<?php echo $prod['imagen']?>" alt="">
                    </div>
                </td>
                <td><?php echo $prod['marca']?></td>
                <td><?php echo $prod['precio']?></td>
                <td><?php echo $prod['descripcion']?></td>
                <td>
                    <button onclick="confirmarBorrar(this)">Borrar</button>
                    <button onclick="editar(<?php echo $prod['id_producto']?>)">Editar</button>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
