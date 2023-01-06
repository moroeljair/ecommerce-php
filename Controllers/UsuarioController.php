<?php 


    include_once '../Models/Usuario.php';
    include_once 'idiomas.php';
    
    $usuario = new Usuario();
    if($_POST['funcion']=='login'){
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $usuario->loguearse($user,$pass);
        //var_dump($usuario);
        if($usuario->objetos!=null){
            foreach($usuario->objetos as $objeto ){
                //guardar datos en variables de sesion
                $_SESSION['id']=$objeto->id;
                $_SESSION['user']=$objeto->user;
                $_SESSION['tipo_usuario']=$objeto->id_tipo;
                $_SESSION['avatar']=$objeto->avatar;
            }
            echo json_encode(array('logueado',$palabras['alerta']['login']));
        }else{
            echo json_encode(array('nologueado',$palabras['alerta']['nologin']));
        }
    }

    if($_POST['funcion']=='verificar_sesion'){
       if(!empty($_SESSION['id'])){
            $json[]=array(
                'id'=>$_SESSION['id'],
                'user'=>$_SESSION['user'],
                'tipo_usuario'=>$_SESSION['tipo_usuario'],
                'avatar'=>$_SESSION['avatar']
            );
            $json_string = json_encode($json[0]);
            echo $json_string;
       }else{
            echo '';
       }
    }

    if($_POST['funcion']=='verificar_usuario'){
        $username = $_POST['value'];
        $usuario -> verificar_usuario($username);
        if($usuario->objetos!=null){
            echo 'success';
        }else{
            echo '';
        }
     }

    if($_POST['funcion']=='listar_usuario'){
        echo 'hola';
    }
?>