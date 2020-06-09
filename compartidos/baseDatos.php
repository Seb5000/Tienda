<?php
    class DataBase {
        private $host = 'localhost';
        private $nombre_bd = 'casadearte';
        private $usuario = "root";
        private $password = "";
        private $conn;

        public function conectar(){
            $this->conn = null;

            try{
                $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->nombre_bd,
                $this->usuario, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo "Error de conexion ".$e->getMessage();
            }
            return $this->conn;
        }
    }
    