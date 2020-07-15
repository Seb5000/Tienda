function abrir_modal(id_modal){
    let el = document.getElementById(id_modal);
    let cov = document.getElementById("covertor");
    el.style.display = "block";
    cov.style.display = "block";
    console.log("abrir");
}

function cerrar_modal(id_modal){
    let el = document.getElementById(id_modal);
    let cov = document.getElementById("covertor");
    el.style.display = "none";
    cov.style.display = "none";
    console.log("cerrar");
}