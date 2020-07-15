const menu = () =>{
    const menu = document.querySelector('.menuHamburgesa');
    const nav = document.querySelector('.navbar');
    let menuLateral = window.localStorage.getItem('menu');
    if(menuLateral == "cerrado"){
        cerrarMenu();
    }else{
        abrirMenu();
    }
    menu.addEventListener('click', ()=>{
        //console.log("clickk");
        if(nav.classList.contains("hide")){
            abrirMenu();
        }else{
            cerrarMenu();
        }
    });

    function cerrarMenu(){
        menu.classList.remove("rotar");
        nav.classList.add("hide");
        window.localStorage.setItem('menu', 'cerrado');
    }

    function abrirMenu(){
        menu.classList.add("rotar");
        nav.classList.remove("hide");
        window.localStorage.setItem('menu', 'abierto');
    }
};

menu();