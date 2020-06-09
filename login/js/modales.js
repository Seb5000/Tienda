function abrir_modal(id_modal){
    let el = document.getElementById(id_modal);
    el.style.display = "block";
    let cov =document.getElementById('covertor');
    cov.style.display = "block";
    console.log("abrir");
}

function cerrar_modal(id_modal){
    let el = document.getElementById(id_modal);
    el.style.display = "none";
    let cov =document.getElementById('covertor');
    cov.style.display = "none";
    console.log("cerrar");
}