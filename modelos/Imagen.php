<?php
class Imagen{
    // variables base de datos
    private $conn;

    //Atributos Producto
    public $id;
    public $id_producto;
    public $imagen;
    public $imagen_s;
    public $principal;
    public $orden;

    private $error = false;
    private $queryE;
    //El constructor de la clase
    public function __construct($bd){
        $this->conn = $bd;
    }

    public function insertarImagenes($array_imagenes){
        if(!is_array($array_imagenes)){
            $this->error = "Se esperaba un array";
            return false;
        }
        foreach($array_imagenes as $imagen){
            if(!isset($imagen["id_producto"]) || !isset($imagen["camino_imagen"]) ||
            !isset($imagen["camino_sm_imagen"]) || !isset($imagen["principal"]) ||
            !isset($imagen["orden"])){
                $this->error = "El o los arrays introducidos no tienen los datos requeridos";
                return false;
            }
        }

        $query = "INSERT INTO imagenes
                    (ID_PRODUCTO,
                    CAMINO_IMAGEN,
                    CAMINO_SM_IMAGEN,
                    PRINCIPAL_IMAGEN,
                    ORDEN_IMAGEN)";

        $valores = " VALUES";
        foreach($array_imagenes as $imagen){
            $id = htmlspecialchars(strip_tags($imagen["id_producto"]));
            $camino = $imagen["camino_imagen"];
            $camino_s = $imagen["camino_sm_imagen"];
            $principal = $imagen["principal"];
            $orden = $imagen["orden"];
            $valores .= " ($id, '$camino', '$camino_s', $principal, $orden),";
        }
        //Quitamos la ultima coma
        $valores = substr($valores, 0, -1);
        $valores .= ";";

        $query = $query.$valores;

        $stmt = $this->conn->prepare($query);
        $this->queryE = $query;
        try{
            if($stmt->execute()){
                return true;
            }
            $this->error = $stmt->error;
            return false;
        }catch(Exception $e){
            $this->error = $e;
            return false;
        }
    }

    public function obtenerImagenes($ids){
        $ids = htmlspecialchars(strip_tags($ids));
        $query = "SELECT CAMINO_IMAGEN, CAMINO_SM_IMAGEN FROM IMAGENES WHERE ID_PRODUCTO in (".$ids.")";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        $arr_imgs = array();
        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $caminoImagen = $fila["CAMINO_IMAGEN"];
                array_push($arr_imgs, $caminoImagen);
                $caminoImagenSmall = $fila["CAMINO_SM_IMAGEN"];
                array_push($arr_imgs, $caminoImagenSmall);
            }
        }
        return $arr_imgs;
    }

    public function getError(){
        return $this->error;
    }

    public function getQuery(){
        return $this->queryE;
    }
}
?>