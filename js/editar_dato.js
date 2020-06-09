//let idCategoriaEditar;
console.log("Cargo editar datoooo");
let elem2;
function editar_dato(elem){
    console.log(elem);
    elem2 = elem;
    console.log(elem2);
    let element = elem.closest("tr");
    console.log(element);
    // https://stackoverflow.com/questions/14460421/get-the-contents-of-a-table-row-with-a-button-click
    let id=element.cells[1].innerHTML;
    console.log("id :"+id);
    //idCategoriaEditar = id;
    // obtener datos ...
    $.ajax({
        url : "obtener_dato.php",
        type: "POST",
        data : {id: id},
        dataType: 'JSON',
        beforeSend: function(){
            $('#guardar_cambios').attr("disabled","disabled");
            $('#form_editar_categoria').css("opacity",".5");
        },
        success:function(response){
            // vaciar los campos si estan llenos
            $('#form_editar_categoria')[0].reset();
            const imgen = document.getElementById("vista_previa_imagen");
            const logo = document.getElementById("vista_previa_logo");
            $("#respuesta_editar_logo").hide();
            $("#respuesta_editar_imagen").hide();
            imgen.src = "";
            logo.src = "";

            $('#id_editar').val(id);
            $('#nombre_editar').val(response.nombre); 
            $('#vista_previa_imagen').attr("src", response.imagen);
            $('#vista_previa_logo').attr("src", response.logo);
            $('#descripcion_editar').val(response.descripcion);
            console.log("el nombre :"+response.nombre);
            console.log("la imagen :"+response.imagen);
            console.log("el logo :"+response.logo);
            console.log("la descripccion :"+response.descripcion);
            $('#form_editar_categoria').css("opacity","");
            $("#guardar_cambios").removeAttr("disabled");
        }
    });
}