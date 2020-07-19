//Para subcategoria
const tablaPrincipal = document.getElementById("tablaPrincipal");
const contenedorTabla = document.getElementById("contenedorTabla");
const sugerenciasNombre = document.getElementById("sugerenciasNombre");
const listaSugerencias = document.querySelector(".listaSugerencias");
const formAgregar = document.getElementById("formulario_agregar");
const formEditar = document.getElementById("formulario_editar");
const formBorrar = document.getElementById("formulario_borrar");
var seleccionados = [];

//para el formulario editar
const editarId = document.getElementById("modal_editar_id");
const editarNombre = document.getElementById("modal_editar_nombre");
const editarCategoria = document.getElementById("modal_editar_categoria");
const vistaPreviaImagen = document.getElementById("vista_previa_imagen");
const editarCaminoImagen = document.getElementById("modal_editar_caminoImagen");
const editarCaminoImagenS = document.getElementById("modal_editar_caminoImagenS");
const editarImagen = document.getElementById("modal_editar_imagen");
const editarDescripcion = document.getElementById("modal_editar_descripcion");
const editarMensaje = document.getElementById("mensaje_editar");
const editarCabecera = document.getElementById("cabeceraEditar");

//PARA BORRAR MODAL
const modalBorrar = document.getElementById("borrarModal");
const cuerpoBorrar = modalBorrar.getElementsByClassName("cuerpoModal")[0];
const borrarMensaje = document.getElementById("mensaje_borrar");
const borrarCabecera = document.getElementById("cabeceraBorrar");

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
            //formAgregar.reset();
            //actualizar_tabla();
            cabecera.style.backgroundColor = "lightgreen";
            setTimeout(() => {
                //mensaje_principal.innerHTML = "";
                //cabecera.style.backgroundColor = "white";
                location.reload();
            }, 500);
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
        if(response.data.status){
            let mensaje = response.data.data.mensaje;
            borrarMensaje.innerHTML = mensaje;
            borrarCabecera.style.backgroundColor = "lightgreen";
            setTimeout(() => {
                location.reload();
            }, 500);
        }else{
            borrarMensaje.innerHTML = response.data;
            borrarCabecera.style.backgroundColor = "lightcoral";
        }
    }).catch(err =>{
        console.log("Hubo un error");
        borrarMensaje.innerHTML = err.response;
        borrarCabecera.style.backgroundColor = "lightcoral";
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
            editarCaminoImagenS.value = data.subcategoria.imagenS; 
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
        //var scriptC = document.getElementById("scriptCheckBox");
        //scriptC.remove();
        //document.body.append(scriptC);
        editarMensaje.innerHTML = response.data.mensaje;
        if(response.data.error==false){
            editarCabecera.style.backgroundColor = "lightgreen";
            setTimeout(() => {
                location.reload();
            }, 500);
        }else{
            editarCabecera.style.backgroundColor = "lightcoral";
        }
        //cerrar_modal('editarModal');
    })
    .catch(err => {
        console.log("Hubo un error"+err);
        editarMensaje.innerHTML = err.response.data;
        editarCabecera.style.backgroundColor = "lightcoral";
    });
}
//function editar()

function actualizar_tabla(){
    contenedorTabla.innerHTML = "";
    axios.get("/tio/login/querys/subcategoria/cargar_tabla.php")
    .then(response =>{
        contenedorTabla.innerHTML = response.data;
    })
    .catch(error =>{
        contenedorTabla.innerHTML = "No se pudo cargar la tabla. <br/>"+error;
    });
}

function ajustarCantidad(cantidad){
    //let camino = window.location.path;
    let parametros = new URLSearchParams(window.location.search.substring(1));
    //for(const [key, value] of params){ console.log(key+" - "+value)}
    parametros.set("cantidad", cantidad);
    parametros.set("pagina", 1);
    //let nuevaUrl = camino+parametros.toString();
    window.location.search =  parametros.toString();
}

function ajustarCategoria(idCat){
    let parametros = new URLSearchParams(window.location.search.substring(1));
    let valorNombre = document.getElementById("filtroNombre").value;
    parametros.set("categoria", idCat);
    if(valorNombre!=""){
        parametros.set("nombre", valorNombre);
    }else{
        parametros.delete("nombre");
    }
    console.log("cambio");
    window.location.search =  parametros.toString();
}

function buscarSugerencias(palabra){
    if(palabra!=''){
        axios.post('/tio/login/querys/subcategoria/buscar_palabra.php', {'palabra':palabra})
        .then(respuesta =>{
            let sugerencias = respuesta.data.sugerencias;
            sugerenciasNombre.innerHTML = "";
            sugerencias.forEach(elem =>{
                sugerenciasNombre.innerHTML += `<li onclick="buscarPalabra(this.innerHTML)">${elem}</li>`;
            });
        })
        .catch(err =>{
            console.log(err);
            console.log(err.response);
        });
    }else{
        sugerenciasNombre.innerHTML = "";
    }
}

function buscarPalabra(palabra){
    let parametros = new URLSearchParams(window.location.search.substring(1));
    parametros.set("nombre", palabra);
    parametros.set("pagina", 1);
    window.location.search =  parametros.toString();
}

function buscarNombre(){
    let valorNombre = document.getElementById("filtroNombre").value;
    if(valorNombre != ""){
        let parametros = new URLSearchParams(window.location.search.substring(1));
        parametros.set("nombre", valorNombre);
        parametros.set("pagina", 1);
        window.location.search =  parametros.toString();
    }else{
        console.log("Se reseteo nombre");
        let parametros = new URLSearchParams(window.location.search.substring(1));
        parametros.delete("nombre");
        parametros.set("pagina", 1);
        window.location.search =  parametros.toString();
    }
}
/*
function abrirSugerencias(){
    sugerenciasNombre.style.display = "block";
    console.log("abrir");
}

function cerrarSugerencias(){
    sugerenciasNombre.style.display = "none";
    console.log("cerrar");
}
*/
document.addEventListener("click", function(event){
    if(event.target.closest(".sugerenciaInput")){
        listaSugerencias.classList.remove("ocultar");
        console.log("se muestra");
        return;
    }

    listaSugerencias.classList.add("ocultar");
    console.log("se oculta");
});

function cambiarPagina(pagina){
    let parametros = new URLSearchParams(window.location.search.substring(1));
    parametros.set("pagina", pagina);
    window.location.search =  parametros.toString();
}