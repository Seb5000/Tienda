<?php 
include('../compartidos/conexion_bd.php');
$sql = "SELECT * FROM `CATEGORIA`";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {?>
<tr>
    <td>
        <span class="custom-checkbox">
            <input type="checkbox" id="checkbox1" name="options[]" value="1">
            <label for="checkbox1"></label>
        </span>
    </td>
    <td><?php echo $row["ID_CATEGORIA"]?></td>
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

<script>
    $(document).ready(function() {
    $(".edit").click(function(){
        let element = $(this).closest("tr")[0];
        // https://stackoverflow.com/questions/14460421/get-the-contents-of-a-table-row-with-a-button-click
        let id=element.cells[1].innerHTML;
        console.log("id :"+id);
    });
    });
</script>