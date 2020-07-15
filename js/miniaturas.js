const ampliarMiniatura = () =>{
    const imagenGrande = document.getElementById("imagenGrande");
    const miniaturas = document.querySelectorAll(".contenedor_miniatura a");
    miniaturas.forEach(elem =>{
        elem.addEventListener("click", agrandar);
    });

    function agrandar(e){
        e.preventDefault();
        console.log("click en miniatura");
        //imagenGrande.src = 
        window.e = e;
        window.e2 = this;
        imagenGrande.src = this.href;
    }
}

ampliarMiniatura();