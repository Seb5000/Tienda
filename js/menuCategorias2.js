const abrirMenu = () => {
    const botonCategorias = document.getElementById('botonCategorias');
    const dropdownContenedor = document.getElementById('dropdownContenedor');
    botonCategorias.addEventListener("click", toggleDropDown);
    //dropdownContenedor.addEventListener("mouseleave", cerrarDropDown);

    function abrirDropDown(){
        dropdownContenedor.classList.remove("oculto");
        console.log("abierto");
    }

    function toggleDropDown(){
        dropdownContenedor.classList.toggle("oculto");
        botonCategorias.classList.toggle("botonActivo");
        console.log("toggle");
    }

    function cerrarDropDown(){
        dropdownContenedor.classList.add("oculto");
        console.log("cerrado");
    }
}

abrirMenu();

const listarSubcategorias = ()=>{
    const listaCategorias = document.querySelectorAll("#listaCategorias > li > a");
    const listarSubcategorias = document.getElementById("subcategoriasPagina");
    for(const categoria of listaCategorias){
        categoria.addEventListener("mouseenter", mostrarSub);
    }
    window.e = listarSubcategorias;
    function mostrarSub(){
        for(const subcategoria of listarSubcategorias.children){
            let varCat = subcategoria.getAttribute("categoria");
            if(varCat == this.target){
                subcategoria.classList.add("activo");
            }else{
                subcategoria.classList.remove("activo");
            }
        }
        console.log("sub", this.target);
    }
};

listarSubcategorias();

/*
<?php
    foreach($arrCat as $cat):
        echo "<li><a href='' target='".$cat["id"]."'>".$cat["nombre"]."</a></li>";
    endforeach;
?>
*/