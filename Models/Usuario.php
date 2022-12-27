<?php
    include_once 'Conexion.php';

    class Usuario{
        //variable global
        var $objetos;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }
        function loguearse($user,$pass){
            echo 'hola.';
        }
    }



?>