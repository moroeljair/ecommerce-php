<?php
    include_once 'Conexion.php';

    class UsuarioDistrito{
        //variable global
        var $objetos;

        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }
        
        function crear_direccion($id_usuario,$id_distrito,$direccion,$referencia){
            try{
                $sql="
                INSERT INTO usuario_ciudad(direccion,referencia,id_ciudad,id_usuario) 
                VALUES(:direccion,:referencia,:id_ciudad,:id_usuario);
                ";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':direccion'=>$direccion,':referencia'=>$referencia,':id_ciudad'=>$id_distrito,':id_usuario'=>$id_usuario));
                }
            catch(Exception $e){
                echo $e-> getMessage();
                return "CARGA FALLIDA";
            }
        }

        function llenar_direcciones($id_usuario){
            try{
                $sql="SELECT ud.id, ud.direccion, ud.referencia, ciudad.nombre as nciudad
                    FROM usuario_ciudad as ud 
                    JOIN ciudad ON ud.id_ciudad=ciudad.id
                    WHERE ud.id_usuario=:id;";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':id'=>$id_usuario));
                $this->objetos = $query->fetchAll();
                return $this->objetos;                    
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }


    }

?>