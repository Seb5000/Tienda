const contenedorImagenes = document.getElementById("contenedorImagenes");
const dragBoxes = document.getElementsByClassName("dragArea");
let contImg = document.querySelectorAll(".contImg");
let files;

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

    let cont = document.createElement("div");
    cont.classList.add("contImg");
    cont.classList.add("draggable");
    cont.setAttribute("draggable", "true");
    let img = document.createElement("img");
    cont.appendChild(img);
    let reader = new FileReader();
    reader.onload = e => {
        img.src = e.target.result;
        document.getElementById("contenedorImagenes").appendChild(cont);
        getDragables();
    };
    reader.readAsDataURL(files[0]);
    //imgDrop.src = files[0];
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
    const closestElement = getDragAfterElement(contenedorImagenes, e.clientX, e.clientY);
    const draggable = document.querySelectorAll(".dragging")[0];
    console.log("closestElement");
    console.log(closestElement);
    console.log("dragable");
    console.log(draggable);
    console.log("closest");
    console.log(closestElement.element);
    console.log("---------------------------");
    if(closestElement.element == null){
        contenedorImagenes.appendChild(draggable);
    }else{
        contenedorImagenes.insertBefore(draggable, closestElement.element);
    }
    //console.log(afterElement);
});

function getDragAfterElement(container, x, y){
    const draggableElements = [...container.querySelectorAll(".draggable")];

    return draggableElements.reduce((closest, child) =>{
        const box = child.getBoundingClientRect();
        distX = Math.min(Math.abs(box.left-x), Math.abs(box.right - x));
        distY = Math.min(Math.abs(box.top-y), Math.abs(box.bottom - y));
        distU = distX+distY;
        if(distU < closest.distancia){
            return {distancia:distU, element: child};//closest
        }else{
            return closest;
        }
    }, {distancia: Number.POSITIVE_INFINITY});

}

