let checkboxes = document.getElementsByName('opciones[]');

document.getElementById('selecionarTodos').onclick = function(){
    if(this.checked){
        checkboxes.forEach(function(elem) {
            elem.checked = true;
        });
    }else{
        checkboxes.forEach(function(elem) {
            elem.checked = false;
        });
    }
};

checkboxes.forEach(elem => {
    elem.onclick = function(){
        if(!this.checked){
            document.getElementById("selecionarTodos").checked = false;
        }
    };
});
