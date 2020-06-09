//Para subcategoria
const tablaPrincipal = document.getElementById("tablaPrincipal");
const formAgregar = document.getElementById("formulario_agregar");
const formEditar = document.getElementById("formulario_editar");
const formBorrar = document.getElementById("formulario_borrar");
var seleccionados = [];

const modalBorrar = document.getElementById("borrarModal");
const cuerpoBorrar = modalBorrar.getElementsByClassName("cuerpoModal")[0];

//para el formulario editar
const editarId = document.getElementById("modal_editar_id");
const editarNombre = document.getElementById("modal_editar_nombre");
const editarCategoria = document.getElementById("modal_editar_categoria");
const vistaPreviaImagen = document.getElementById("vista_previa_imagen");
const editarCaminoImagen = document.getElementById("modal_editar_caminoImagen");
const editarImagen = document.getElementById("modal_editar_imagen");
const editarDescripcion = document.getElementById("modal_editar_descripcion");

function agregarPorAxios(){
    let formData = new FormData(formAgregar);
    /*
    Verificar que el formulario esta llenado
    for (var [key, value] of formData.entries()) { 
        console.log(key, value);
    }
    */
    let mensaje_nombre = document.getElementById("form_agregar_mensaje_nombre");
    let mensaje_categoria = document.getElementById("form_agregar_mensaje_categoria");
    let mensaje_imagen = document.getElementById("form_agregar_mensaje_imagen");
    let cabecera = document.getElementById("cabeceraModalAgregar");
    let mensaje_principal = document.getElementById("mensaje_agregar");
    const config = {
    headers: { 'content-type': 'multipart/form-data' }
    };

    axios.post("/tio/login/querys/subcategoria/agregar_subcategoria.php",
    formData, config)
    .then(response =>{
        let resp = response.data;
        if(resp.nombre){
            mensaje_nombre.innerHTML=resp.nombre;
            mensaje_nombre.style.display = "inline";
        }else{
            mensaje_nombre.style.display = "none";
        }
        if(resp.categoria){
            mensaje_categoria.innerHTML=resp.categoria;
            mensaje_categoria.style.display = "inline";
        }else{
            mensaje_categoria.style.display = "none";
        }
        if(resp.imagen){
            mensaje_imagen.innerHTML=resp.imagen;
            mensaje_imagen.style.display = "inline";
        }else{
            mensaje_imagen.style.display = "none";
        }
        mensaje_principal.innerHTML = resp.mensaje;
        if(resp.error){
            cabecera.style.backgroundColor = "lightcoral";
        }else{
            formAgregar.reset();
            cabecera.style.backgroundColor = "lightgreen";
            setTimeout(() => {
                mensaje_principal.style.display = "none";
                cabecera.style.backgroundColor = "white";
            }, 2000);
            console.log("success ajax function");
        }
    });
}

function obtenerIds(){
    console.log("Obtenerids");
    seleccionados = [];
    let checkboxes = document.getElementsByName('opciones[]');
    checkboxes.forEach(elem => {
        if(elem.checked){
            //document.getElementById("selecionarTodos").checked = false;
            seleccionados.push(
                {
                    "id": parseInt(elem.closest("tr").cells[1].innerHTML),
                    "nombre": elem.closest("tr").cells[2].innerHTML
                }
            );
        }
    });
    console.log(seleccionados);
    if(seleccionados.length!=0){
        cuerpoBorrar.innerHTML="Estas seguro de borrar:<br>";
        seleccionados.forEach(elem => {
            cuerpoBorrar.innerHTML+= `<p>&emsp;${elem.id} - ${elem.nombre}</p>`;
        });
        abrir_modal("borrarModal");
    }
}

function borrarId(elem){
    console.log(elem);
    seleccionados = [];
    seleccionados.push(
        {
            "id": parseInt(elem.closest("tr").cells[1].innerHTML),
            "nombre": elem.closest("tr").cells[2].innerHTML
        }
    );
    if(seleccionados.length!=0){
        cuerpoBorrar.innerHTML="Estas seguro de borrar:<br>";
        seleccionados.forEach(elem => {
            cuerpoBorrar.innerHTML+= `<p>&emsp;${elem.id} - ${elem.nombre}</p>`;
        });
        abrir_modal("borrarModal");
    }    
}

function borrarPorAxios(){
    var ids = "";
    seleccionados.forEach(elem =>{
        ids = ids+elem.id+",";
    });
    ids = ids.slice(0, -1);
    //var arrIds = JSON.stringify(seleccionados);
    console.log("Nuevos ids "+ ids);
    let formulario = new FormData();
    formulario.append("ids", ids);
    
    axios.post(
        "/tio/login/querys/subcategoria/borrar_subcategoria.php",
        formulario
    ).then(response =>{
        console.log("respuesta: ");
        console.log(response.data);
    }).catch(err =>{
        console.log("Hubo un error");
    });
}

function llenarFormEditar(idSubcategoria){
    console.log("se llamo a llenar form editar con id: "+idSubcategoria);
    let formulario = new FormData();
    formulario.append("id", idSubcategoria);
    axios.post(
        "/tio/login/querys/subcategoria/obtener_subcategoria.php",
        formulario
    ).then(response =>{
        var data = response.data;
        if(!data.error){ //Si no hay error
            console.log(data);
            editarId.value = data.subcategoria.idSub;
            editarNombre.value = data.subcategoria.nombre;
            editarCategoria.value = data.subcategoria.idCat;
            vistaPreviaImagen.src = data.subcategoria.imagen;
            vistaPreviaImagen.src = data.subcategoria.imagen; //cambia la vista previa
            editarCaminoImagen.value = data.subcategoria.imagen; // guarda el valor del camino a la imagen
            editarDescripcion.value = data.subcategoria.descripcion;
            abrir_modal('editarModal');
        }
    }).catch(error => {
        console.log("Hubo un error");
        console.log(error);
    });
}

function enviarFormEditar(){
    let formData = new FormData(formEditar);
    axios.post("/tio/login/querys/subcategoria/editar_subcategoria.php",
    formData)
    .then(response =>{
        console.log("respuesta exitosa"+response.data);
        actualizar_tabla();
        formEditar.reset();
        vistaPreviaImagen.src = "";
        //recargar el script checkbox
        var scriptC = document.getElementById("scriptCheckBox");
        scriptC.remove();
        document.body.append(scriptC);
        cerrar_modal('editarModal');
    })
    .catch(err => {
        console.log("Hubo un error"+err);
    });
}
//function editar()

function actualizar_tabla(){
    tablaPrincipal.innerHTML = "";
    axios.get("/tio/login/querys/subcategoria/cargar_tabla.php")
    .then(response =>{
        tablaPrincipal.innerHTML = response.data;
    })
    .catch(error =>{
        tablaPrincipal.innerHTML = "No se pudo cargar la tabla. <br/>"+error;
    });
}