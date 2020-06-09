function abrir_modal(id_modal){
    let el = document.getElementById(id_modal);
    el.style.display = "block";
    console.log("abrir");
}

function cerrar_modal(id_modal){
    let el = document.getElementById(id_modal);
    el.style.display = "none";
    console.log("cerrar");
}

