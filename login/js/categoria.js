//MODAL AGREGAR
const formAgregar = document.getElementById("formulario_agregar");
const agregarCabecera = document.getElementById("cabeceraModalAgregar");
const agregarMensajePrincipal = document.getElementById("mensaje_agregar");
const agregarMensajeNombre = document.getElementById("form_agregar_mensaje_nombre");
const agregarMensajeImagen = document.getElementById("form_agregar_mensaje_imagen");
const agregarMensajeLogo = document.getElementById("form_agregar_mensaje_logo");

//MODAL EDITAR
const formEditar = document.getElementById("formulario_editar");
const editarCabecera = document.getElementById("cabeceraModalEditar");
const editarMensaje = document.getElementById("mensaje_editar");
const editarId = document.getElementById("editar_id");
const editarNombre = document.getElementById("editar_nombre");
const editarMensajeNombre = document.getElementById("editar_mensaje_nombre");
//imagen
const editarImagen = document.getElementById("editar_imagen");
const editarCaminoImagen = document.getElementById("editar_caminoImagen");
const editarCaminoImagenS = document.getElementById("editar_caminoImagenS");
const vistaPreviaImagen = document.getElementById("vista_previa_imagen");
const editarMensajeImagen = document.getElementById("editar_mensaje_imagen");
//logo
const editarLogo = document.getElementById("editar_logo");
const editarCaminoLogo = document.getElementById("editar_caminoLogo");
const vistaPreviaLogo = document.getElementById("vista_previa_logo");
const editarMensajeLogo = document.getElementById("editar_mensaje_logo");
//Descripcion
const editarDescripcion = document.getElementById("editar_descripcion");

//BORRAR
const borrarCabecera = document.getElementById('cabeceraModalBorrar');
const borrarCuerpo = document.getElementById('modalBorrarCuerpo');
const borrarMensaje = document.getElementById('mensaje_borrar');
var seleccionados = {
    "ids":Array(),
    "nombres":Array()
};

//CHECKBOXES
const checkboxes = document.getElementsByName('opciones[]');
document.getElementById('selecionarTodos').onclick = function(){
    if(this.checked){
        checkboxes.forEach(function(elem) {
            elem.checked = true;
        });
    }else{
        checkboxes.forEach(function(elem) {
            elem.checked = false;
        });
    }
};
checkboxes.forEach(elem => {
    elem.onclick = function(){
        if(!this.checked){
            document.getElementById("selecionarTodos").checked = false;
        }
    };
});

function agregarCategoria(){
    let formData = new FormData(formAgregar);
    axios.post("/tio/login/querys/categorias/agregar.php", formData)
    .then(response =>{
        let resp = response.data;
        console.log(resp);
        agregarMensajePrincipal.innerHTML = resp.mensaje;
        agregarMensajeNombre.innerHTML = resp.nombre;
        agregarMensajeImagen.innerHTML = resp.imagen;
        agregarMensajeLogo.innerHTML = resp.logo;

        if(resp.error){
            agregarCabecera.style.backgroundColor = "lightcoral";
        }else{
            formAgregar.reset();
            //actualizarTabla(); // actualizar la tabla
            agregarCabecera.style.backgroundColor = "lightgreen";
            setTimeout(() => {
                location.reload();
            }, 500);
        }
    });
}


//response = JSON.stringify(response);
//response = JSON.parse(response);
function editarCategoria(elem){
    var fila = elem.closest("tr");
    var id = fila.cells[1].innerHTML;
    console.log("Editar categoria "+id);
    axios.post("/tio/login/querys/categorias/obtenerCategoria.php", {"id": id})
    .then(response => {
        let categoria = response.data;
        editarId.value = categoria.id;
        editarNombre.value = categoria.nombre;
        vistaPreviaImagen.src = categoria.imagen;
        editarCaminoImagen.value = categoria.imagen;
        editarCaminoImagenS.value = categoria.imagenSM;
        vistaPreviaLogo.src = categoria.logo;
        editarCaminoLogo.value = categoria.logo;
        editarDescripcion.value = categoria.descripcion;
        abrir_modal('editarModal'); 
    })
    .catch(err =>{
        //err = JSON.stringify(err);
        console.log(err);
        console.log(err.response);
    });
}

//previsualizador de imagen se actualiza cuando se seleciona un archivo en input
const lectorImagen = new FileReader();
lectorImagen.onload = e => {
    vistaPreviaImagen.src = e.target.result;
};
editarImagen.addEventListener('change', e => {
    const f = e.target.files[0];
    lectorImagen.readAsDataURL(f);
});
//PARA EL LOGO
const lectorLogo = new FileReader();
lectorLogo.onload = e => {
    vistaPreviaLogo.src = e.target.result;
};
editarLogo.addEventListener('change', e => {
    const f = e.target.files[0];
    lectorLogo.readAsDataURL(f);
});

function guardarCambios(){
    let formData = new FormData(formEditar);
    axios.post("/tio/login/querys/categorias/guardarCategoria.php", formData)
    .then(respuesta => {
        let resp = respuesta.data;
        editarCabecera.style.backgroundColor = "lightgreen";
        editarMensaje.innerHTML = (resp.mensaje == null) ? '' : resp.mensaje;
        setTimeout(() => {
            //location.reload();
        }, 500);
    })
    .catch(err =>{
        let resp = err.response.data;
        editarCabecera.style.backgroundColor = "lightcoral";
        editarMensaje.innerHTML = (resp.mensaje == null) ? '' : resp.mensaje;
        editarMensajeNombre.innerHTML = (resp.nombre == null) ? '' : resp.nombre;
        editarMensajeImagen.innerHTML = (resp.imagen == null) ? '' : resp.imagen;
        editarMensajeLogo.innerHTML = (resp.logo == null) ? '' : resp.logo;
    });
}

function confirmarBorrar(elem){
    var fila = elem.closest("tr");
    var id = fila.cells[1].innerHTML;
    var nombre = fila.cells[2].innerHTML;
    seleccionados.ids = [id];
    seleccionados.nombres = [nombre];
    mostrarBorrar();
}

function confirmarBorrar2(){
    seleccionados.ids = [];
    seleccionados.nombres = [];
    checkboxes.forEach(elem => {
        if(elem.checked){
            seleccionados.ids.push(elem.closest("tr").cells[1].innerHTML);
            seleccionados.nombres.push(elem.closest("tr").cells[2].innerHTML);
        }
    });
    mostrarBorrar();
}

function mostrarBorrar(){
    borrarCuerpo.innerHTML = "Estas seguro de borrar : <br/>";
    var i;
    for(i = 0; i<seleccionados.ids.length; i++){
        borrarCuerpo.innerHTML += seleccionados.ids[i]+" "+seleccionados.nombres[i]+"<br/>";
    }
    abrir_modal("borrarModal");
}

function borrar(){
    let ids = seleccionados.ids.join();
    axios.post("/tio/login/querys/categorias/borrar.php", {"ids": ids})
    .then(respuesta =>{
        let resp = respuesta.data;
        borrarCabecera.style.backgroundColor = "lightgreen";
        borrarMensaje.innerHTML = resp.mensaje;
        setTimeout(() => {
            //location.reload();
        }, 500);
    })
    .catch(err => {
        let resp = err.response.data;
        borrarCabecera.style.backgroundColor = "lightcoral";
        borrarMensaje.innerHTML = resp.mensaje;
    });
}

function cambiarPagina(pagina){
    let parametros = new URLSearchParams(window.location.search.substring(1));
    parametros.set("pagina", pagina);
    window.location.search =  parametros.toString();
}

function ajustarCantidad(cantidad){
    let parametros = new URLSearchParams(window.location.search.substring(1));
    parametros.set("cantidad", cantidad);
    window.location.search =  parametros.toString();
}

