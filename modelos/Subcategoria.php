<?php
class Subcategoria{
    // variables base de datos
    private $conn;

    //Atributos Producto
    public $id;
    public $id_categoria;
    public $nombre;
    public $imagen;
    public $descripcion;

    //El constructor de la clase
    public function __construct($bd){
        $this->conn = $bd;
    }

    public function listaSubcategorias(){
        $query = 'SELECT ID_SUBCATEGORIA, NOMBRE_SUBCATEGORIA 
                    FROM SUBCATEGORIA';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $num = $stmt->rowCount();

        //Crear un array respuesta
        $arr_Subcat = array();
        //Si existe algun producto
        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id'=>$fila['ID_SUBCATEGORIA'],
                    'nombre'=>$fila['NOMBRE_SUBCATEGORIA'],
                );
                array_push($arr_Subcat, $item);
            }
        }
        return $arr_Subcat;
    }

    public function getSubcategorias($id_categoria){
        $query = 'SELECT ID_SUBCATEGORIA, NOMBRE_SUBCATEGORIA 
                    FROM SUBCATEGORIA
                    WHERE ID_CATEGORIA = '.$id_categoria;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $num = $stmt->rowCount();

        //Crear un array respuesta
        $arr_Subcat = array();
        //Si existe algun producto
        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id'=>$fila['ID_SUBCATEGORIA'],
                    'nombre'=>$fila['NOMBRE_SUBCATEGORIA'],
                );
                array_push($arr_Subcat, $item);
            }
        }
        return $arr_Subcat;
    }
}