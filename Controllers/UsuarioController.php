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

     if($_POST['funcion']=='registrar_usuario'){
        $username = $_POST['username'];
        $pass =$_POST['pass'];
        $nombres =$_POST['nombres'];
        $apellidos =$_POST['apellidos'];
        $dni =$_POST['dni'];
        $email =$_POST['email'];
        $telefono =$_POST['telefono'];

        $usuario -> registrar_usuario($username,$pass,$nombres,$apellidos,$dni,$email,$telefono);
        echo 'success';
     }

     if($_POST['funcion']=='obtener_datos'){
        try{
            $usuario->obtener_datos($_SESSION['id']);
            foreach ($usuario->objetos as $objeto) {
                $json[]=array(
                    'username'=>$objeto->user,
                    'nombres'=>$objeto->nombres,
                    'apellidos'=>$objeto->apellidos,
                    'dni'=>$objeto->dni,
                    'email'=>$objeto->email,
                    'telefono'=>$objeto->telefono,
                    'avatar'=>$objeto->avatar,
                    'tipo_usuario'=>$objeto->tipo
                );
            }
            $json_string = json_encode($json[0]);
            echo $json_string;
        }catch(Exception $e){
            echo $e-> getMessage();
            return "CARGA FALLIDA";
        }
     }

     if($_POST['funcion']=='editar_datos'){
        try{
            $id_usuario=$_SESSION['id'];
            $nombres =$_POST['nombres_mod'];
            $apellidos =$_POST['apellidos_mod'];
            $dni =$_POST['dni_mod'];
            $email =$_POST['email_mod'];
            $telefono =$_POST['telefono_mod'];

            //archivo de imagen
            $avatar = $_FILES['avatar_mod']['name'];
            if($avatar!=''){
                $nombre=uniqid().'-'.$avatar;
                $ruta='../Util/Img/Users/'.$nombre;
                //guardar un archivo
                //move_uploaded_file($_FILES[name del input]['tmp_name'],ruta donde guardar)
                move_uploaded_file($_FILES['avatar_mod']['tmp_name'],$ruta);
                $usuario->obtener_datos($id_usuario);
                foreach($usuario->objetos as $objeto){
                    $avatar_actual=$objeto->avatar;
                    if($avatar_actual!='user_default.png'){
                        //borrar un archivo
                        unlink('../Util/Img/Users/'.$avatar_actual);
                    }
                } 
                $_SESSION['avatar']=$nombre;
            }else{
                $nombre='';
            }
            $usuario -> editar_datos($id_usuario,$nombres,$apellidos,$dni,$email,$telefono,$nombre);
            echo json_encode(array('ok',$palabras['modal_datos']['ok']));
        }catch(Exception $e){
            //echo $e-> getMessage();
            echo json_encode(array('fail',$palabras['modal_datos']['fail']));
        }
     }

     if($_POST['funcion']=='cambiar_contra'){
        try{
            $id_usuario=$_SESSION['id'];
            $pass_old =$_POST['pass_old'];
            $pass_new =$_POST['pass_new'];

            $usuario->comprobar_pass($id_usuario,$pass_old);
            if(!empty($usuario->objetos)){
                $usuario->cambiar_contra($id_usuario,$pass_new);
                echo json_encode(array('ok',$palabras['mis_datos']['cambio']));
            }else{
                echo json_encode(array('error',$palabras['mis_datos']['pass_incorrecto'],$palabras['mis_datos']['ingrese_pass_corr']));
            }

        }catch(Exception $e){
            //echo $e-> getMessage();
            echo json_encode(array('fail',$palabras['modal_datos']['fail']));
        }
     }


     

    if($_POST['funcion']=='listar_usuario'){
        echo 'hola';
    }
?>