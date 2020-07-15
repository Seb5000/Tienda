const dragBoxes = document.getElementsByClassName("dragArea");
const container = document.getElementsByClassName("container");
const dragAgregar = document.getElementById("dragAreaAgregar");
const dragEditar = document.getElementById("dragAreaEditar");
const containerAgregar = document.getElementById("containerAgregar");
const containerEditar = document.getElementById("containerEditar");

const inputImagenAgregar = document.getElementById("imagenes");
const inputImagenEditar = document.getElementById("imagenesE");

let contImg = document.querySelectorAll(".contImg");
let files;
let objFiles = {cont:0};
let imagenesBD = {};
let imagenesOrden = [];

for(const dragBox of dragBoxes){
    dragBox.addEventListener("dragover", dragover);
    dragBox.addEventListener("dragleave", dragleave);
    dragBox.addEventListener("drop", drop);
}

function dragover(e){
    e.preventDefault();
    console.log("dragover");
    //this.className += " archivoDragOver";
    this.classList.add("archivoDragOver");
}

function dragleave(e){
    e.preventDefault();
    console.log("dragleave");
    //this.className = "dragArea";
    this.classList.remove("archivoDragOver");
}

function drop(e){
    e.preventDefault();
    console.log("drop");
    this.classList.remove("archivoDragOver");
}

dragAgregar.addEventListener("drop", dropAgregar);
dragEditar.addEventListener("drop", dropEditar);
function dropAgregar(e){
    files = e.dataTransfer.files;
    let formatosPermitidos = ["image/jpeg", "image/png", "image/webp", "image/svg+xml", "image/gif"];
    for(let file of files){
        if(formatosPermitidos.includes(file.type)){
            //crear un dragable con el archivo 'file' y con el nombre objFiles.cont
            let elem = crearDraggable(file, objFiles.cont, borrarElementoPadre);
            objFiles[objFiles.cont] = file;
            objFiles.cont++;
            containerAgregar.appendChild(elem);
            getDragables(containerAgregar);
        }
    }
}

function dropEditar(e){
    files = e.dataTransfer.files;
    let formatosPermitidos = ["image/jpeg", "image/png", "image/webp", "image/svg+xml", "image/gif"];
    for(let file of files){
        if(formatosPermitidos.includes(file.type)){
            //crear un dragable con el archivo 'file' y con el nombre objFiles.cont
            let elem = crearDraggable(file, objFiles.cont, borrarElementoPadre);
            objFiles[objFiles.cont] = file;
            objFiles.cont++;
            containerEditar.appendChild(elem);
            getDragables(containerEditar);
        }
    }
}

function borrarElementoPadre(){
    let elemPadre = this.parentNode;
    let nombrePadre = elemPadre.getAttribute("nombre");
    let nuevo = elemPadre.getAttribute("nuevo");
    if(nuevo == "true"){
        delete objFiles[nombrePadre];
        console.log("borrando objfiles");
    }else if(nuevo == "false"){
        imagenesBD[nombrePadre] = -1;
        console.log("borrando imagenesBD");
    }
    elemPadre.remove();
}

function crearDraggable(fileImg, nombre, callbackBorrar){
    let cont = document.createElement("div");
    cont.classList.add("contImg");
    cont.classList.add("draggable");
    cont.setAttribute("draggable", "true");
    cont.setAttribute("nombre", nombre);
    cont.setAttribute("nuevo", "true");
    let btnCerrar = document.createElement("div");
    btnCerrar.classList.add("botonCerrar");
    btnCerrar.innerHTML = "&#10005;";
    btnCerrar.addEventListener("click", callbackBorrar);
    cont.appendChild(btnCerrar);
    let img = document.createElement("img");
    cont.appendChild(img);
    let reader = new FileReader();
    reader.onload = event => {
        img.src = event.target.result;
    };
    reader.readAsDataURL(fileImg);
    return cont;
}

function getDragables(contenedor){
    contImg = contenedor.querySelectorAll(".contImg");

    contImg.forEach(cont =>{
        cont.addEventListener("dragstart", ()=>{
            cont.classList.add("dragging");
            console.log("dragingstart");
        });
    });

    contImg.forEach(cont =>{
        cont.addEventListener("dragend", ()=>{
            cont.classList.remove("dragging");
            console.log("end draa");
        });
    });
}

for(const cont of container){
    cont.addEventListener("dragleave", dragleaveContainer);
    cont.addEventListener("drop", dropContainer);
    cont.addEventListener("dragover", function(e){
        dragoverContainer(e, cont);
    });
}
function dropContainer (event){
    event.preventDefault();
}
function dragleaveContainer (event){
    event.preventDefault();
}

function dragoverContainer(e, contenedor){
    e.preventDefault();
    let dt = e.dataTransfer;
    if(dt.types != null && ((dt.types.length && dt.types[0] === 'Files') || dt.types.includes('application/x-moz-file'))){
        return false;
    }
    const closestElement = getClosest(contenedor, e.clientX, e.clientY);
    const draggable = document.querySelectorAll(".dragging")[0];

    if(closestElement.element != null){
        if(closestElement.insertar == 'antes'){
            contenedor.insertBefore(draggable, closestElement.element);
        }else{
            if(closestElement.element.nextSibling == null){
                contenedor.appendChild(draggable);
            }else{
                contenedor.insertBefore(draggable, closestElement.element.nextSibling);
            }
        }
    }else{
        contenedor.appendChild(draggable);
    }
    //console.log(afterElement);
}

function getClosest(container, x, y){
    const draggableElements = [...container.querySelectorAll(".draggable")];

    return draggableElements.reduce((closest, child) =>{
        const box = child.getBoundingClientRect();
        const centroDraggable = {x:0,y:0};
        centroDraggable.x = box.right - box.width/2;
        centroDraggable.y = box.bottom - box.height/2;
        const dist = ((centroDraggable.x - x)**2 + (centroDraggable.y - y)**2)**(0.5);
        let insertar = '';
        if(dist < closest.distancia){
            let distx = centroDraggable.x-x;
            let disty = centroDraggable.y-y;
            if(disty<0){
                if(Math.abs(distx)<box.width/2){
                    insertar = 'antes';
                }else{
                    insertar = 'despues';
                }
            }else{
                if(Math.abs(distx)<box.width/2){
                    insertar = 'despues';
                }else{
                    insertar = 'antes';
                }
            }
            return {distancia: dist, insertar:insertar, element: child};//closest
        }else{
            return closest;
        }
    }, {distancia: Number.POSITIVE_INFINITY});

}


inputImagenAgregar.addEventListener('change', e => {
    let files = e.target.files;
    let formatosPermitidos = ["image/jpeg", "image/png", "image/webp", "image/svg+xml", "image/gif"];
    for(let file of files){
        if(formatosPermitidos.includes(file.type)){
            let elem = crearDraggable(file, objFiles.cont, borrarElementoPadre);
            objFiles[objFiles.cont] = file;
            objFiles.cont++;
            containerAgregar.appendChild(elem);
            getDragables(containerAgregar);
        }
    }
});

inputImagenEditar.addEventListener('change', e => {
    let files = e.target.files;
    let formatosPermitidos = ["image/jpeg", "image/png", "image/webp", "image/svg+xml", "image/gif"];
    for(let file of files){
        if(formatosPermitidos.includes(file.type)){
            let elem = crearDraggable(file, objFiles.cont, borrarElementoPadre);
            objFiles[objFiles.cont] = file;
            objFiles.cont++;
            containerEditar.appendChild(elem);
            getDragables(containerEditar);
        }
    }
});

function cargarImagenes(listaImagenes){
    dragDropReset();
    containerEditar.innerHTML = "";
    listaImagenes.forEach(imagen =>{
        // Crear una tarjeta y agregarlo al contenedor
        let cont = document.createElement("div");
        cont.classList.add("contImg");
        cont.classList.add("draggable");
        cont.setAttribute("draggable", "true");
        cont.setAttribute("nombre", imagen.id);
        cont.setAttribute("nuevo", "false");
        let btnCerrar = document.createElement("div");
        btnCerrar.classList.add("botonCerrar");
        btnCerrar.innerHTML = "&#10005;";
        btnCerrar.addEventListener("click", borrarElementoPadre);
        cont.appendChild(btnCerrar);
        let img = document.createElement("img");
        img.src = imagen.path;
        cont.appendChild(img);
        imagenesBD[imagen.id]=imagen.orden;
        //objFiles[objFiles.cont] = imagen;
        //objFiles.cont++;
        containerEditar.appendChild(cont);
        getDragables(containerEditar);
    });
}

function dragDropReset(){
    objFiles = {cont:0};
    imagenesBD = {};
    imagenesOrden = [];
}

