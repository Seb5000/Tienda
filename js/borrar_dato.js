$(document).ready(function() {
    let ids = [];
    $("#borrarModal").click(function(){
        let message="id  Nombre<br>";
        ids = [];
        let id;
        let nombre;
        $("table tbody input[type='checkbox']:checked").each(function () {
            var row = $(this).closest("tr")[0];
            id=row.cells[1].innerHTML;
            nombre=row.cells[2].innerHTML;
            message += id;
            message += "  " + nombre;
            message += "<br>";
            ids.push(id);
        });
        $("#categoriasSeleccionadas").html(message);
        if(ids.length == 0){
            mensaje = "Debe seleccionar por lo menos una categoria";
            $("#mensaje").html(mensaje);
            setTimeout(() => {$("#mensaje").hide();}, 5000);
        }else{
            $("#eliminarCategoriaModal").show();
        }
        console.log("ids: "+ids);
    });
    $("#borrarBoton").click(function(){
        console.log("borrar desde el otro boton"+ids);
        idsString = ids.join(',');
        $.ajax({
            url : "borrar_dato.php",
            type: "POST",
            data : {stringIds :idsString},
            dataType: 'JSON',
            success:function(response){
                $("#mensaje").show();
                $("#mensaje").html(response.mensaje);
                setTimeout(() => {$("#mensaje").hide();}, 5000);
                if(response.error){
                    $('#mensaje').addClass('text-danger');
                }else{
                    $('#mensaje').removeClass('text-danger');
                    $("#tabla").load("/tio/login/actualizar_tabla.php", console.log("se llamo a load23"));
                }
                $("#eliminarCategoriaModal").hide();
            }
        });
    });
});