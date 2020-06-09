$(document).ready(function(){
    $("#form_agregar_categoria").submit(function(event){
        event.preventDefault();
        /*
        let nombre = $("#agregar_categoria_nombre").val();
        let imagen = $("#agregar_categoria_imagen")[0];
        let logo = $("#agregar_categoria_logo")[0];
        let descripccion = $("#agregar_categoria_descripccion").val();
        */

        let formData = new FormData(this);
        //let formData = new FormData();
        /*
        formData.append("nombre", nombre);
        formData.append("imagen", imagen);
        formData.append("logo", logo);
        formData.append("descripccion", descripccion);
        */

        /* Antigua forma de hacer
            se necesita cambiar porque el $.post no permite subir archivos
            se va trabajar con el $.ajax
        $.post("insertar_dato.php", formData, function(data, status){
            console.log("se recibio una respuesta");
            $("#message").html(data);
            console.log(status);
        });
        */
        $.ajax({
            url : "insertar_dato.php",
            type: "POST",
            data : formData,
            dataType: 'JSON',
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $('#guardar_categoria').attr("disabled","disabled");
                $('#form_agregar_categoria').css("opacity",".5");
            },
            success:function(response, status){
            //success:function(response){
                console.log("respuesta en success"+status);
                console.log(response);

                if(response.nombre.error){
                    $("#respuesta_nombre").show();
                    $("#respuesta_nombre").html(response.nombre.mensaje);
                }else{
                    $("#respuesta_nombre").hide();
                }

                if(response.descripcion.error){
                    $("#respuesta_descripcion").show();
                    $("#respuesta_descripcion").html(response.descripcion.mensaje);
                }else{
                    $("#respuesta_descripcion").hide();
                }

                console.log("imagen error "+response.imagen.error);
                if(response.imagen.error){
                    $("#respuesta_imagen").show();
                    $("#respuesta_imagen").html(response.imagen.mensaje);
                }else{
                    $("#respuesta_imagen").hide();
                }

                console.log(response);
                if(response.logo.error){
                    $("#respuesta_logo").show();
                    $("#respuesta_logo").html(response.logo.mensaje);
                }else{
                    $("#respuesta_logo").hide();
                }

                $("#mensaje").show();
                $("#mensaje").html(response.insertar_bd.mensaje);
                $('#form_agregar_categoria').css("opacity","");
                $("#guardar_categoria").removeAttr("disabled");
                console.log("response.insertar_bd.error: "+response.insertar_bd.error);
                if(response.insertar_bd.error){
                    console.log("el if es true");
                }else{
                    $('#form_agregar_categoria')[0].reset();
                    console.log("antes de actualizar tabla");
                    $("#tabla").load("/tio/login/actualizar_tabla.php", console.log("se llamo a load23"));
                    console.log("despues de actualizar tabla");
                }
                setTimeout(() => {
                    $("#mensaje").hide();
                }, 3000);
                console.log("success ajax function");
            }
        });
    });
});