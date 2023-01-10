<?php
    include_once 'Conexion.php';

    class Usuario{
        //variable global
        var $objetos;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }
        
        function loguearse($user,$passwd){
            $sql="SELECT * FROM usuario
                WHERE user=:user and pass=:passwd";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':user'=>$user, ':passwd'=>$passwd));
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        }

        function verificar_usuario($user){
            $sql="SELECT * FROM usuario
                WHERE user=:user;";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':user'=>$user));
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        }

        function registrar_usuario($username,$pass,$nombres,$apellidos,$dni,$email,$telefono){
            try{
                $sql="
                INSERT INTO usuario(user,pass,nombres,apellidos,dni,email,telefono,id_tipo) VALUES(:user,:pass,:nombres,:apellidos,:dni,:email,:telefono,:id_tipo);
                ";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':user'=>$username,':pass'=>$pass,':nombres'=>$nombres,':apellidos'=>$apellidos,
                                        ':dni'=>$dni,':email'=>$email,':telefono'=>$telefono,':id_tipo'=>2));
                }
            catch(Exception $e){
                echo $e-> getMessage();
                return "CARGA FALLIDA";
            }
        }

        function obtener_datos($user){
            $sql="SELECT * FROM usuario
                    JOIN tipo_usuario ON usuario.id_tipo = tipo_usuario.id
                    WHERE usuario.id=:user";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':user'=>$user));
            $this->objetos = $query->fetchAll();
            return $this->objetos;
        }
    }

?>