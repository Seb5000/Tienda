<?php
include("../../../compartidos/conexion_bd.php");
?>
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
