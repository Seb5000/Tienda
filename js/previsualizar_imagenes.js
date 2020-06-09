const lectorImagen = new FileReader();
const lectorLogo = new FileReader();
const inputImagen = document.getElementById("imagen_editar");
const inputLogo = document.getElementById("logo_editar");
const imgen = document.getElementById("vista_previa_imagen");
const logo = document.getElementById("vista_previa_logo");
let file;

lectorImagen.onload = e => {
    imgen.src = e.target.result;
};

inputImagen.addEventListener('change', e => {
    const f = e.target.files[0];
    file = f;
    lectorImagen.readAsDataURL(f);
});

lectorLogo.onload = e => {
    console.log("cargo el logo");
    logo.src = e.target.result;
};
  
inputLogo.addEventListener('change', e => {
    const f = e.target.files[0];
    file = f;
    lectorLogo.readAsDataURL(f);
});
