// requiere de la variable idCategoriaEditar que es definida en editar_dato.js
$(document).ready(function(){
    $("#form_editar_categoria").submit(function(event){
        event.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url : "modificar_dato.php",
            type: "POST",
            data : formData,
            dataType: 'JSON',
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $('#guardar_cambios').attr("disabled","disabled");
                $('#form_editar_categoria').css("opacity",".5");
            },
            success:function(response){
                console.log("respuesta exitosa de guardar cambios");
                console.log(response);

                //Si no existe un error cerrar el modal
                if(!response.error){
                    $('#form_editar_categoria')[0].reset(); // ressetear el formulario
                    $('#form_editar_categoria').css("opacity",""); //quitar la opacidad del formulario
                    $("#guardar_cambios").removeAttr("disabled"); // Habilitar el boton guardar
                    //actualizar la tabla de categorias
                    $("#tabla").load("/tio/login/actualizar_tabla.php", console.log("se llamo a load234"));
                    $("#editarCategoriaModal").fadeToggle();
                }else{
                    if(response.imagen.error){
                        $("#respuesta_editar_imagen").html(response.imagen.mensaje);
                        $("#respuesta_editar_imagen").show();
                    }else{
                        $("#respuesta_editar_imagen").hide();
                    }
                    if(response.logo.error){
                        $("#respuesta_editar_logo").html(response.logo.mensaje);
                        $("#respuesta_editar_logo").show();
                    }else{
                        $("#respuesta_editar_logo").hide();
                    }
                    if(response.sql.error){
                        $("#editarCategoriaModal").fadeToggle();
                    }
                    $('#form_editar_categoria').css("opacity","");
                    $("#guardar_cambios").removeAttr("disabled");
                }
                $("#mensaje").show();
                $("#mensaje").html(response.sql.mensaje);
                setTimeout(() => {
                    $("#mensaje").hide();
                }, 3000);
            }
        });
    });
});