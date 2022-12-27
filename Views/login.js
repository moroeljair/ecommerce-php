$(document).ready(function(){
    var funcion;
    $('#form-login').submit(e=>{
        funcion='login';
        let user = $('#user').val();
        let pass = $('#pass').val();
        $.post('../Controllers/UsuarioController.php', {funcion,user,pass}, (response)=>{
            console.log(response);
        })

        //console.log(user+' '+pass);
        //para que al dar click en el boton submit no se reinicie la pagina
        e.preventDefault();
    })
});

