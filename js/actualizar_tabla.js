$(document).ready(function(){
    $("#updateButton").click(function(){
        $("#tabla").load("/tio/login/actualizar_tabla.php", {
            "nombre": "sebas"
        }, console.log("se llamo a load"));
    });

    function insertar_dato(){
        
    }
});