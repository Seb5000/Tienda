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

        $query = "INSERT INTO IMAGENES
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
        if(is_array($ids)){
            $ids = implode(",", $ids);
        }
        $ids = htmlspecialchars(strip_tags($ids));
        $arr_imgs = array();
        if($ids==''){
            return $arr_imgs;
        }
        $query = "SELECT CAMINO_IMAGEN, CAMINO_SM_IMAGEN FROM IMAGENES WHERE ID_PRODUCTO in (".$ids.")";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
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

    public function borrarImagenePrincipalProd($id){
        $id = htmlspecialchars(strip_tags($id));
        $query = 'DELETE FROM IMAGENES WHERE ID_PRODUCTO = :id AND ORDEN_IMAGEN = 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        try{
            if($stmt->execute()){
                return true;
            }
            $this->error = $stmt->error;
            return false;
        }catch(Exception $e){
            $this->error = $e->getMessage();
            return false;
        }
        $this->error = "Algun error ocurrio lol";
        return false;
    }

    public function borrarImagenes($idImagenes){
        if(is_array($idImagenes)){
            $idImagenes = implode(",", $idImagenes);
        }
        $idImagenes = htmlspecialchars(strip_tags($idImagenes));
        $query = "DELETE FROM IMAGENES WHERE ID_IMAGEN IN ($idImagenes)";
        $stmt = $this->conn->prepare($query);
        try{
            if($stmt->execute()){
                return true;
            }
            $this->error = $stmt->error;
            return false;
        }catch(Exception $e){
            $this->error = $e->getMessage();
            return false;
        }
        $this->error = "Algun error ocurrio lol";
        return false;
    }

    public function actualizarImagen($idImagen, $principal, $orden){
        $query = "UPDATE IMAGENES
                    SET
                        PRINCIPAL_IMAGEN = :principal,
                        ORDEN_IMAGEN = :orden
                    WHERE 
                        ID_IMAGEN = :id";
        $stmt = $this->conn->prepare($query);
        $idImagen = htmlspecialchars(strip_tags($idImagen));
        $principal = htmlspecialchars(strip_tags($principal));
        $orden = htmlspecialchars(strip_tags($orden));
        $stmt->bindParam(':id', $idImagen);
        $stmt->bindParam(':principal', $principal);
        $stmt->bindParam(':orden', $orden);
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

    public function contarImagenes($idProducto){
        $query = "SELECT COUNT(ID_PRODUCTO) FROM IMAGENES WHERE ID_PRODUCTO = :id";
        $stmt = $this->conn->prepare($query);
        $idProducto = htmlspecialchars(strip_tags($idProducto));
        $stmt->bindParam(':id', $idProducto);
        $stmt->execute();
        $numero_filas = $stmt->fetchColumn();
        return $numero_filas;
    }

    public function agregarImagenPorDefecto($idProducto){
        $query = "INSERT INTO IMAGENES
                    SET
                        ID_PRODUCTO = :idProducto,
                        CAMINO_IMAGEN = :cImagen,
                        CAMINO_SM_IMAGEN = :cImagen,
                        PRINCIPAL_IMAGEN = 1,
                        ORDEN_IMAGEN = 1";
        $stmt = $this->conn->prepare($query);
        $idProducto = htmlspecialchars(strip_tags($idProducto));
        $camino = "/tio/imagenes/defecto.svg";
        $stmt->bindParam(':idProducto', $idProducto);
        $stmt->bindParam(':cImagen', $camino);
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

    public function getError(){
        return $this->error;
    }

    public function getQuery(){
        return $this->queryE;
    }
}
?>