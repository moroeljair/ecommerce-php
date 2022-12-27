<?php 
    include_once '../Models/Usuario.php';
    $usuario = new Usuario();

    if($_POST['funcion']=='login'){
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $usuario->loguearse($user,$pass);
    }

    if($_POST['funcion']=='listar_usuario'){
        echo 'hola';
    }
?>