$(document).ready(function(){

    var funcion="";
    llenar_historial();

    function llenar_historial(){
        funcion="llenar_historial";
        $.post('../Controllers/HistorialController.php',{funcion},(response) =>{
            let historiales = JSON.parse(response);
            //console.log(historial);
            historiales.forEach(historial => {
                console.log(historial);
            });
        });
    }

});