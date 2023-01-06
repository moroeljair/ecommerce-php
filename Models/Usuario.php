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
    }

?>