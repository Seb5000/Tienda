const dragBoxes = document.getElementsByClassName("dragArea");
//const dragBoxes = document.querySelectorAll("dragArea");
const contImg = document.querySelectorAll(".contImg");
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

    /*
    let imgDrop = document.createElement("img");
    let reader = new FileReader();
    reader.onload = e => {
        imgDrop.src = e.target.result;
        document.getElementById("contenedorImagenes").appendChild(imgDrop);
    };
    reader.readAsDataURL(files[0]);
    */
    let cont = document.createElement("div");
    cont.classList.add("contImg");
    cont.setAttribute("draggable", "true");
    let img = document.createElement("img");
    cont.appendChild(img);
    let reader = new FileReader();
    reader.onload = e => {
        img.src = e.target.result;
        document.getElementById("contenedorImagenes").appendChild(cont);
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

let img = document.createElement("img");

const lectorImagen2 = new FileReader();
const inputImagen2 = document.getElementById("imagenes");
//const imgen = document.getElementById("vista_previa_imagen");

lectorImagen2.onload = e => {
    img.src = e.target.result;
};

inputImagen2.addEventListener('change', e => {
    const f = e.target.files[0];
    lectorImagen2.readAsDataURL(f);
    console.log(f);
    console.log(img);
    document.getElementById("contenedorImagenes").appendChild(img);
});

document.addEventListener("click", e =>{
    console.log(e.target);
    console.log("click");
});

/*
for (let i = 0; i < dragBoxes.length; i++) {
    dragBoxes[i].addEventListener("dragover", function(event){
        dragBoxes[i].classList.add("archivoDragOver");
        return false;
    });
    dragBoxes[i].addEventListener("dragleave", function(event){
        dragBoxes[i].classList.remove("archivoDragOver");
        return false;
    });
    dragBoxes[i].addEventListener("drop", function(event){
        event.preventDefault();
        console.log("dopeadooo");
        //dragBoxes[i].classList.remove("archivoDragOver");
        //let lista_archivos = event.dataTransfer.files;
        //console.log(lista_archivos);
        return false;
    });
}
*/