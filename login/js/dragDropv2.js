const contenedorImagenes = document.getElementById("contenedorImagenes");
const dragBoxes = document.getElementsByClassName("dragArea");
let contImg = document.querySelectorAll(".contImg");
let files;
let objFiles = {cont:0};
//let contadorImagenes = 0;

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
    files = e.dataTransfer.files;
    console.log(files);
    this.classList.remove("archivoDragOver");
    let formatosPermitidos = ["image/jpeg", "image/png", "image/webp", "image/svg+xml", "image/gif"];
    for(let file of files){
        if(formatosPermitidos.includes(file.type)){
            objFiles[objFiles.cont] = file;
            let cont = document.createElement("div");
            cont.classList.add("contImg");
            cont.classList.add("draggable");
            cont.setAttribute("draggable", "true");
            cont.setAttribute("nombre", objFiles.cont);
            objFiles.cont++;
            //let numeracion = document.createElement("div");
            //numeracion.classList.add("botonNumeracion");
            //numeracion.innerHTML = (contadorImagenes == 0)? "Principal" : contadorImagenes;
            //cont.appendChild(numeracion);
            //contadorImagenes++;
            let btnCerrar = document.createElement("div");
            btnCerrar.classList.add("botonCerrar");
            btnCerrar.innerHTML = "&#10005;";
            btnCerrar.addEventListener("click", borrarElementoPadre);
            cont.appendChild(btnCerrar);
            let img = document.createElement("img");
            cont.appendChild(img);
            let reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                document.getElementById("contenedorImagenes").appendChild(cont);
                getDragables();
            };
            reader.readAsDataURL(file);
        }
    }
    //imgDrop.src = files[0];
}

function borrarElementoPadre(){
    let elemPadre = this.parentNode;
    let nombrePadre = elemPadre.getAttribute("nombre");
    delete objFiles[nombrePadre]
    elemPadre.remove();
    console.log(elemPadre);
    //contadorImagenes--;
}

function crearContenedorImg(){
    let cont = document.createElement("div");
    cont.classList.add("contImg");
    let img = document.createElement("img");
    cont.appendChild(img);
}

function getDragables(){
    contImg = document.querySelectorAll(".contImg");

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

contenedorImagenes.addEventListener("drop", event =>{
    event.preventDefault();
});
contenedorImagenes.addEventListener("dragover", e=>{
    e.preventDefault();
    let dt = e.dataTransfer;
    if(dt.types != null && ((dt.types.length && dt.types[0] === 'Files') || dt.types.includes('application/x-moz-file'))){
        return false;
    }
    const closestElement = getClosest(contenedorImagenes, e.clientX, e.clientY);
    const draggable = document.querySelectorAll(".dragging")[0];
    /*
    console.log("closestElement");
    console.log(closestElement);
    console.log("dragable");
    console.log(draggable);
    console.log("closest");
    console.log(closestElement.element);
    console.log("---------------------------");
    */
    if(closestElement.element != null){
        if(closestElement.insertar == 'antes'){
            contenedorImagenes.insertBefore(draggable, closestElement.element);
        }else{
            if(closestElement.element.nextSibling == null){
                contenedorImagenes.appendChild(draggable);
            }else{
                contenedorImagenes.insertBefore(draggable, closestElement.element.nextSibling);
            }
        }
    }else{
        contenedorImagenes.appendChild(draggable);
    }
    //console.log(afterElement);
});

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
            /*
            if(disty>0){
                if(Math.abs(disty)<box.height/2){
                    insertar = 'despues';
                }else{
                    insertar = 'antes';
                }
            }else{
                if(Math.abs(disty)<box.width/2){
                    insertar = 'despues';
                }else{
                    insertar = 'antes';
                }
            }
            */
            return {distancia: dist, insertar:insertar, element: child};//closest
        }else{
            return closest;
        }
    }, {distancia: Number.POSITIVE_INFINITY});

}

const inputImagen2 = document.getElementById("imagenes");
inputImagen2.addEventListener('change', e => {
    //const f = e.target.files[0];
    let files = e.target.files;
    //lectorImagen2.readAsDataURL(f);
    //console.log(f);
    //console.log(img);
    //document.getElementById("contenedorImagenes").appendChild(img);
    let formatosPermitidos = ["image/jpeg", "image/png", "image/webp", "image/svg+xml", "image/gif"];
    for(let file of files){
        if(formatosPermitidos.includes(file.type)){
            objFiles[objFiles.cont] = file;
            let cont = document.createElement("div");
            cont.classList.add("contImg");
            cont.classList.add("draggable");
            cont.setAttribute("draggable", "true");
            cont.setAttribute("nombre", objFiles.cont);
            objFiles.cont++;
            //let numeracion = document.createElement("div");
            //numeracion.classList.add("botonNumeracion");
            //numeracion.innerHTML = (contadorImagenes == 0)? "Principal" : contadorImagenes;
            //cont.appendChild(numeracion);
            //contadorImagenes++;
            let btnCerrar = document.createElement("div");
            btnCerrar.classList.add("botonCerrar");
            btnCerrar.innerHTML = "&#10005;";
            btnCerrar.addEventListener("click", borrarElementoPadre);
            cont.appendChild(btnCerrar);
            let img = document.createElement("img");
            cont.appendChild(img);
            let reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                document.getElementById("contenedorImagenes").appendChild(cont);
                getDragables();
            };
            reader.readAsDataURL(file);
        }
    }
});

