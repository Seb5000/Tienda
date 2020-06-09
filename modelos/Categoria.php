<?php
class Categoria{
    // variables base de datos
    private $conn;

    //Atributos Producto
    public $id;
    public $nombre;
    public $imagen;
    public $logo;
    public $descripcion;

    //El constructor de la clase
    public function __construct($bd){
        $this->conn = $bd;
    }

    public function listaCategorias(){
        $query = 'SELECT ID_CATEGORIA, NOMBRE_CATEGORIA 
                    FROM CATEGORIA';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $num = $stmt->rowCount();

        //Crear un array respuesta
        $arr_cat = array();
        //Si existe algun producto
        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id'=>$fila['ID_CATEGORIA'],
                    'nombre'=>$fila['NOMBRE_CATEGORIA'],
                );
                array_push($arr_cat, $item);
            }
        }
        return $arr_cat;
    }
}