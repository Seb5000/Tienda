const contenedorTabla = document.getElementById("contenedorAuxiliar");

//Para la parte de Filtros
const filtroSubcategoria = document.getElementById("filtroSubcategoria");
const sugerenciasNombre = document.getElementById("sugerenciasNombre");
const filtroCategoria = document.getElementById('filtroCategoria');
const filtroNombre = document.getElementById("filtroNombre");
//Para subcategoria
//const tablaPrincipal = document.getElementById("tablaPrincipal");
const formAgregar = document.getElementById("formulario_agregar");
const formEditar = document.getElementById("formulario_editar");
//const formBorrar = document.getElementById("formulario_borrar");
var seleccionados = {
    "ids":Array(),
    "nombres":Array()
};

//Para las opciones Categoria y subcategoria en modal AGREGAR
const sCategoria = document.getElementById('selectCategoria');
const sSubcategoria = document.getElementById('selectSubcategoria');

//Para el formulario agregar
const agregarCabecera = document.getElementById("cabeceraModalAgregar");
const agregarMensajePrincipal = document.getElementById("mensaje_agregar");
const agregarMensajeNombre = document.getElementById("form_agregar_mensaje_nombre");
const agregarMensajeCategoria = document.getElementById("form_agregar_mensaje_categoria");
const agregarMensajeSubcategoria = document.getElementById("form_agregar_mensaje_subcategoria");
const agregarMensajeImagen = document.getElementById("form_agregar_mensaje_imagen");
const agregarMensajeMarca = document.getElementById("form_agregar_mensaje_marca");
const agregarMensajePrecio = document.getElementById("form_agregar_mensaje_precio");

//PARA EL MODAL BORRAR
const borrarCabecera = document.getElementById('cabeceraModalBorrar');
const borrarCuerpo = document.getElementById('modalBorrarCuerpo');
const borrarMensaje = document.getElementById('mensaje_borrar');

//para el formulario editar
const editarCabecera = document.getElementById("cabeceraModalEditar");
const editarMensaje = document.getElementById("mensaje_editar");
const editarId = document.getElementById("editar_id");
const editarNombre = document.getElementById("editar_nombre");
const editarMensajeNombre = document.getElementById("editar_mensaje_nombre"); //El mensaje
const editarCategoria = document.getElementById("editarSelectCategoria");
const editarMensajeCategoria = document.getElementById("editar_mensaje_categoria"); //El mensaje
const editarSubcategoria = document.getElementById("editarSelectSubcategoria");
const editarMensajeSubcategoria = document.getElementById("editar_mensaje_subcategoria"); //El mensaje
const vistaPreviaImagen = document.getElementById("vista_previa_imagen");
const editarCaminoImagen = document.getElementById("editar_caminoImagen");
const editarImagen = document.getElementById("editar_imagen");
const editarMensajeImagen = document.getElementById("editar_mensaje_imagen");
const editarMarca = document.getElementById("editar_marca");
const editarPrecio = document.getElementById("editar_precio");
const editarMensajePrecio = document.getElementById("editar_mensaje_precio"); //El mensaje
const editarDescripcion = document.getElementById("edita_descripcion");

function actualizarTabla(){
    axios.get('/tio/login/querys/productos/tabla_productos.php')
    .then(response=>{
        contenedorTabla.innerHTML = response.data;
        checkBoxes();
    })
    .catch(err=>{
        contenedorTabla.innerHTML = "Error al cargar la tabla: "+err;
    });
}

function ajustarCantidad(cantidad){
    //let camino = window.location.path;
    let parametros = new URLSearchParams(window.location.search.substring(1));
    //for(const [key, value] of params){ console.log(key+" - "+value)}
    parametros.set("cantidad", cantidad);
    //let nuevaUrl = camino+parametros.toString();
    window.location.search =  parametros.toString();
}

function checkBoxes(){
    let checkboxes = document.getElementsByName('opciones[]');
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
}
checkBoxes();


document.addEventListener('DOMContentLoaded', (event) => {
    llenarSubcategorias();
    llenarSubcategoriasE();
});
function llenarSubcategorias(){
    let val = sCategoria.value;
    axios.post("/tio/login/querys/productos/select_subcategorias.php",{id:val})
    .then(response =>{
        var subcategorias = response.data.subcategorias;
        var textoHtml = "<option value='' hidden>Elige una opcion...</option>";
        subcategorias.forEach(element => {
            textoHtml += `<option value="${element.id}">${element.nombre}</option>`;
        });
        sSubcategoria.innerHTML = textoHtml;
    })
    .catch(err =>{
        editarCabecera.style.backgroundColor = "lightcoral";
        editarMensaje.innerHTML = "Ocurrio un error, "+err;
    });
}

function llenarSubcategoriasE(){
    let val = editarCategoria.value;
    return axios.post("/tio/login/querys/productos/select_subcategorias.php",{id:val})
    .then(response =>{
        var subcategorias = response.data.subcategorias;
        var textoHtml = "<option value='' selected hidden>Elige una opcion...</option>";
        textoHtml += "<option value='-1' hidden>Sin Subcategoria</option>";
        subcategorias.forEach(element => {
            textoHtml += `<option value="${element.id}">${element.nombre}</option>`;
        });
        editarSubcategoria.innerHTML = textoHtml;
        console.log("Termino de llenar");
        return true;
    })
    .catch(err =>{
        editarCabecera.style.backgroundColor = "lightcoral";
        editarMensaje.innerHTML = "Ocurrio un error, "+err;
        return false;
    });
}

function obtenerListaImagenes(){
    const contenedorImagenes = document.getElementById("contenedorImagenes");
    let contImg = contenedorImagenes.querySelectorAll(".contImg");
    let lista = [];
    contImg.forEach(cont =>{
        let nom = cont.getAttribute("nombre");
        lista.push(nom);
    });
    return lista;
}

function agregarPorAxios(){
    let formData = new FormData(formAgregar);
    //borramos las imagenes ingresadas por el input
    formData.delete("imagenes[]");
    //agregammos las imagenes que estan dentro del drag and drop
    let lis = obtenerListaImagenes();
    // Nota objFiles esta declarado en el archivo dragDropv2.js
    lis.forEach(elem =>{
        formData.append("imagenesDD[]", objFiles[elem]);
    });
    
    axios.post("/tio/login/querys/productos/agregar_producto.php", formData)
    .then(response =>{
        let resp = response.data;
        console.log(resp);
        agregarMensajePrincipal.innerHTML = resp.mensaje;
        agregarMensajeNombre.innerHTML = resp.nombre;
        agregarMensajeImagen.innerHTML = resp.imagen;

        if(resp.error){
            agregarCabecera.style.backgroundColor = "lightcoral";
        }else{
            formAgregar.reset();
            llenarSubcategorias(); //actualizar la lista desplegable de subcategorias
            actualizarTabla(); // actualizar la tabla
            agregarCabecera.style.backgroundColor = "lightgreen";
            setTimeout(() => {
                agregarMensajePrincipal.style.display = "none";
                agregarCabecera.style.backgroundColor = "white";
            }, 1000);
            console.log("success ajax function");
        }
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
    let checkboxes = document.getElementsByName('opciones[]');
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

function borrarProductos(){
    var ids = seleccionados.ids.join();
    console.log("los ids "+ids);
    axios.post("/tio/login/querys/productos/borrar_productos.php", {"ids": ids})
    .then(respuesta =>{
        console.log(respuesta.data.mensaje);
        if(respuesta.data.exito){
            actualizarTabla(); // actualizar la tabla
            borrarCabecera.style.backgroundColor = "lightgreen";
            borrarMensaje.innerHTML = respuesta.data.mensaje;
            setTimeout(() => {
                borrarMensaje.innerHTML = "";
                borrarCabecera.style.backgroundColor = "white";
                cerrar_modal("borrarModal");
            }, 1000);
        }else{
            borrarCabecera.style.backgroundColor = "lightcoral";
            borrarMensaje.innerHTML = respuesta.data.mensaje;
        }
    })
    .catch(err => {
        borrarCabecera.style.backgroundColor = "lightcoral";
        borrarMensaje.innerHTML = err;
    });
}

function editar(id){
    axios.post("/tio/login/querys/productos/obtener_producto.php", {"id": id})
    .then(respuesta =>{
        let objResp = respuesta.data;
        console.log(objResp);
        if(objResp.exito){
            console.log(objResp);
            let producto = objResp.producto;
            editarId.value = producto.id;
            editarNombre.value = producto.nombre;
            if(producto.idCat == "NULL"){
                editarCategoria.value = -1;
            }else{
                editarCategoria.value = producto.idCat;
            }
            // Primera promesa de mi vida
            // NO FUNCIONO
            /*
            let promesa = new Promise((resolve, reject) =>{
                let respuesta = llenarSubcategoriasE();
                if(respuesta==true){
                    resolve("Esto funciono");
                }else{
                    resolve("Esto nooo funcionoo");
                }
            });
            promesa.then(respuesta =>{
                console.log(respuesta);
                if(producto.idSub == "NULL"){
                    console.log("va cambia el select de subcategorias");
                    editarSubcategoria.value = -1;
                }else{
                    console.log("va cambia el select de subcategorias");
                    editarSubcategoria.value = producto.idSub;
                }
            });
            */
            llenarSubcategoriasE().then(resp =>{
                console.log("la respuesta...: "+resp);
                if(producto.idSub == "NULL"){
                    console.log("va cambia el select de subcategorias");
                    editarSubcategoria.value = -1;
                }else{
                    console.log("va cambia el select de subcategorias");
                    editarSubcategoria.value = producto.idSub;
                }
            });
            editarCaminoImagen.value = producto.imagen;
            vistaPreviaImagen.src = producto.imagen;
            editarMarca.value = producto.marca;
            editarPrecio.value = producto.precio;
            editarDescripcion.value = producto.descripcion;
            abrir_modal('editarModal');        
        }else{
            editarCabecera.style.backgroundColor = "lightcoral";
            editarMensaje.innerHTML = objResp.mensaje;
            abrir_modal("editarModal");
        }

    })
    .catch(err => {
        editarCabecera.style.backgroundColor = "lightcoral";
        editarMensaje.innerHTML = err;
        abrir_modal("editarModal");
    });
}

function guardarCambios(){
    let formData = new FormData(formEditar);
    axios.post("/tio/login/querys/productos/guardar_cambios.php", formData)
    .then(respuesta => {
        let resp = respuesta.data;
        editarMensaje.innerHTML = (resp.mensaje == null) ? '' : resp.mensaje;
        editarMensajeNombre.innerHTML = (resp.nombre == null) ? '' : resp.nombre;
        editarMensajeImagen.innerHTML = (resp.imagen == null) ? '' : resp.imagen;
        if(resp.success){
            formEditar.reset();
            editarImagen.src = '';
            llenarSubcategoriasE(); //actualizar la lista desplegable de subcategorias editar
            actualizarTabla(); // actualizar la tabla
            editarCabecera.style.backgroundColor = "lightgreen";
            setTimeout(() => {
                editarMensaje.innerHTML = "";
                editarCabecera.style.backgroundColor = "white";
                cerrar_modal('editarModal'); 
            }, 500);          
        }else{
            editarCabecera.style.backgroundColor = "lightcoral";
        }
    })
    .catch(err => {
        editarCabecera.style.backgroundColor = "lightcoral";
        editarMensaje.innerHTML = err.respuesta;
    });
}

function ajustarSelectSubcategoria(valor){
    axios.post("/tio/login/querys/productos/selectSubcategoria.php", {"valor": valor})
    .then(respuesta =>{
        let contenido = respuesta.data;
        filtroSubcategoria.innerHTML = contenido;
    })
    .catch(err=>{
        console.log(err);
        console.log(err.response);
    });
}

function buscarSugerencias(palabras){
    if(palabras!=''){
        axios.post('/tio/login/querys/productos/buscarPalabras.php', {'palabras':palabras})
        .then(respuesta =>{
            console.log(respuesta.data);
            let sugerencias = respuesta.data.sugerencias;
            sugerenciasNombre.innerHTML = "";
            sugerencias.forEach(elem =>{
                sugerenciasNombre.innerHTML += `<li onclick="selecionarPalabra(this.innerHTML)">${elem}</li>`;
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

function selecionarPalabra(valor){
    filtroNombre.value = valor;
}

document.addEventListener("click", function(event){
    if(event.target.closest(".sugerenciaInput")){
        sugerenciasNombre.classList.remove("ocultar");
        console.log("se muestra");
        return;
    }
    sugerenciasNombre.classList.add("ocultar");
    console.log("se oculta");
});

function cambiarPagina(pagina){
    let parametros = new URLSearchParams(window.location.search.substring(1));
    parametros.set("pagina", pagina);
    window.location.search =  parametros.toString();
}

function aplicarFiltros(){
    let parametros = new URLSearchParams(window.location.search.substring(1));
    let categoria = filtroCategoria.value;
    let subcategoria = filtroSubcategoria.value;
    let nombre = filtroNombre.value;

    if(categoria == "none"){
        parametros.delete("categoria");
    }else{
        parametros.set("categoria", categoria);
    }

    if(subcategoria == "none"){
        parametros.delete("subcategoria");
    }else{
        parametros.set("subcategoria", subcategoria);
    }

    if(nombre == ""){
        parametros.delete("nombre");
    }else{
        parametros.set("nombre", nombre);
    }

    window.location.search =  parametros.toString();
}


