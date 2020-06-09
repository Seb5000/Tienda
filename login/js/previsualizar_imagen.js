const lectorImagen = new FileReader();
const inputImagen = document.getElementById("modal_editar_imagen");
const imgen = document.getElementById("vista_previa_imagen");

lectorImagen.onload = e => {
    imgen.src = e.target.result;
};

inputImagen.addEventListener('change', e => {
    const f = e.target.files[0];
    lectorImagen.readAsDataURL(f);
});