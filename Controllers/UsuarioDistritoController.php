<?php 


    include_once '../Models/UsuarioDistrito.php';
    include_once 'idiomas.php';
    
    $usuario_distrito = new UsuarioDistrito();
   
     if($_POST['funcion']=='crear_direccion'){
        try{
            $id_distrito = $_POST['id_distrito'];
            $direccion = $_POST['direccion'];
            $referencia = $_POST['referencia'];
            $id_usuario = $_SESSION['id'];

            $usuario_distrito->crear_direccion($id_usuario,$id_distrito,$direccion,$referencia);
            echo json_encode(array('ok',$palabras['crear_direccion']['ok']));
        }catch(Exception $e){
            //echo $e-> getMessage();
            echo json_encode(array('fail',$palabras['crear_direccion']['fail']));
        }
     }



     if($_POST['funcion']=='llenar_direcciones'){
        try{
            $id_usuario = $_SESSION['id'];
            $usuario_distrito->llenar_direcciones($id_usuario);
            $json=array();
            foreach ($usuario_distrito->objetos as $objeto) {
                $json[]=array(
                    'id'=>$objeto->id,
                    'direccion'=>$objeto->direccion,
                    'referencia'=>$objeto->referencia,
                    'ciudad'=>$objeto->nciudad,
                );
            }
            $json_string = json_encode($json);
            echo $json_string;
        }catch(Exception $e){
            echo $e-> getMessage();
            //echo json_encode(array('fail',$palabras['crear_direccion']['fail']));
        }
     }


     if($_POST['funcion']=='eliminar_direccion'){
        try{
            $id_direccion = $_POST['id'];
            $usuario_distrito->eliminar_direccion($id_direccion);
            echo 'success';
        }catch(Exception $e){
            //echo $e-> getMessage();
            echo 'fail';
        }
     }