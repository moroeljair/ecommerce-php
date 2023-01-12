function cambiarIdioma($idioma){
    localStorage.setItem('lenguaje',$idioma);
    $direccion='./Layouts/lang.php?l='+$idioma;
    location.href=$direccion;
}

function identificarIdioma(){
    let idioma = localStorage.getItem('lenguaje');
        if(idioma===null){
            idioma='es'
        }
    return idioma;
}


    
