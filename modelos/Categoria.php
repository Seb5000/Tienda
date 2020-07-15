<?php
class Categoria{
    // variables base de datos
    private $conn;

    //Atributos Producto
    public $id;
    public $nombre;
    public $imagen;
    public $imagenSM;
    public $logo;
    public $descripcion;

    private $error = false;
    //El constructor de la clase
    public function __construct($bd){
        $this->conn = $bd;
    }
    //DEVUELVE EL ERROR
    public function getError(){
        return $this->error;
    }
    //DEVUELVE EL NUMERO DE FILAS DE LA TABLA CATEGORIA
    public function numeroFilas(){
        $query = "SELECT count(*) FROM CATEGORIA";
        $numero_de_filas = $this->conn->query($query)->fetchColumn();
        $this->numero_filas = $numero_de_filas;
        return $numero_de_filas;
    }
    //
    public function siguienteId(){
        $query = "SELECT `AUTO_INCREMENT`
                    FROM  INFORMATION_SCHEMA.TABLES
                    WHERE TABLE_SCHEMA = 'CASADEARTE'
                    AND   TABLE_NAME   = 'CATEGORIA'";
        $id = $this->conn->query($query)->fetchColumn();
        return $id;
    }

    public function agregar(){
        $query = "INSERT INTO CATEGORIA
                    SET
                        NOMBRE_CATEGORIA = :nombre,
                        IMAGEN_CATEGORIA = :imagen,
                        IMAGEN_SM_CATEGORIA = :imagenSM,
                        LOGO_CATEGORIA = :logo,
                        DESCRIPCION_CATEGORIA = :descripcion";
        
        $stmt = $this->conn->prepare($query);
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->imagen = htmlspecialchars(strip_tags($this->imagen));
        $this->imagenSM = htmlspecialchars(strip_tags($this->imagenSM));
        $this->logo = htmlspecialchars(strip_tags($this->logo));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':imagen', $this->imagen);
        $stmt->bindParam(':imagenSM', $this->imagenSM);
        $stmt->bindValue(':logo', $this->logo);
        $stmt->bindParam(':descripcion', $this->descripcion);
        try{
            $stmt->execute();
            return true;
        }catch(Exception $e){
            $this->error = $e;
            return false;
        }
    }

    public function obtenerCategoria($id){
        $query = "SELECT * FROM CATEGORIA WHERE ID_CATEGORIA = :id";
        $stmt = $this->conn->prepare($query);
        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        try{
            $stmt->execute();
        }catch(Exception $e){
            $this->error = $e;
            return false;
        }
        $num = $stmt->rowCount();
        if($num>0){
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $fila['ID_CATEGORIA'];
            $this->nombre = $fila['NOMBRE_CATEGORIA'];
            $this->imagen = $fila['IMAGEN_CATEGORIA'];
            $this->imagenSM = $fila['IMAGEN_SM_CATEGORIA'];
            $this->logo = $fila['LOGO_CATEGORIA'];
            $this->descripcion = $fila['DESCRIPCION_CATEGORIA'];
            return true;
        }else{
            $this->error = "No se encontro el id ".$id;
        }
        return false;
    }

    public function guardarCategoria(){
        $query = "UPDATE CATEGORIA
                    SET
                        NOMBRE_CATEGORIA = :nombre,
                        IMAGEN_CATEGORIA = :imagen,
                        IMAGEN_SM_CATEGORIA = :imagenSM,
                        LOGO_CATEGORIA = :logo,
                        DESCRIPCION_CATEGORIA = :descripcion
                    WHERE 
                        ID_CATEGORIA = :id";
        $stmt = $this->conn->prepare($query);
        //Limpiar los datos
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->imagen = htmlspecialchars(strip_tags($this->imagen));
        $this->imagenSM = htmlspecialchars(strip_tags($this->imagenSM));
        $this->logo = htmlspecialchars(strip_tags($this->logo));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        //Relacionar los datos
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':imagen', $this->imagen);
        $stmt->bindParam(':imagenSM', $this->imagenSM);
        $stmt->bindParam(':logo', $this->logo);
        $stmt->bindParam(':descripcion', $this->descripcion);
        
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

    public function seleccionarImagenes($ids){
        $ids = htmlspecialchars(strip_tags($ids));
        $query = 'SELECT IMAGEN_CATEGORIA, IMAGEN_SM_CATEGORIA, LOGO_CATEGORIA FROM CATEGORIA WHERE ID_CATEGORIA in ('.$ids.')';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        $arr_imgs = array();
        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                array_push($arr_imgs, $fila['IMAGEN_CATEGORIA']);
                array_push($arr_imgs, $fila['IMAGEN_SM_CATEGORIA']);
                array_push($arr_imgs, $fila['LOGO_CATEGORIA']);
            }
        }
        return $arr_imgs;
    }

    public function borrarCategorias($ids){
        $ids = htmlspecialchars(strip_tags($ids));
        $query = 'DELETE FROM CATEGORIA WHERE ID_CATEGORIA in ('.$ids.')';
        $stmt = $this->conn->prepare($query);
        //$stmt->bindParam(':ids', $ids);
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

    public function getCategorias($inicio, $numFilas){
        $query = 'SELECT * FROM CATEGORIA LIMIT :inicio , :numFilas';
        $inicio = htmlspecialchars(strip_tags($inicio));
        $numFilas = htmlspecialchars(strip_tags($numFilas));
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
        $stmt->bindValue(':numFilas', $numFilas, PDO::PARAM_INT);
        $stmt->execute();
        $num = $stmt->rowCount();
        $arr_cat = array();
        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $categoria = array(
                    'id' => $fila['ID_CATEGORIA'],
                    'nombre' => $fila['NOMBRE_CATEGORIA'],
                    'imagen' => $fila['IMAGEN_CATEGORIA'],
                    'imagenS' => $fila['IMAGEN_SM_CATEGORIA'],
                    'logo' => $fila['LOGO_CATEGORIA'],
                    'descripcion' => $fila['DESCRIPCION_CATEGORIA']
                );
                array_push($arr_cat, $categoria);
            }
        }
        return $arr_cat;
    }

    public function obtenerNombre($id){
        $query = 'SELECT NOMBRE_CATEGORIA FROM CATEGORIA WHERE ID_CATEGORIA = :id';

        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $num = $stmt->rowCount();

        if($num>0){
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $nombre = $fila['NOMBRE_CATEGORIA'];
            return $nombre;
        }

        return 'No se encontro el registro : '.$id;
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

    public function listaCategorias2(){
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
                    'subcategorias'=>array()
                );
                array_push($arr_cat, $item);
            }
        }

        for($i=0; $i<count($arr_cat); $i++){
            $query = 'SELECT ID_SUBCATEGORIA, NOMBRE_SUBCATEGORIA 
                    FROM SUBCATEGORIA
                    WHERE ID_CATEGORIA = '.$arr_cat[$i]["id"];
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $num = $stmt->rowCount();
            if($num>0){
                while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $item = array(
                        'id'=>$fila['ID_SUBCATEGORIA'],
                        'nombre'=>$fila['NOMBRE_SUBCATEGORIA'],
                    );
                    array_push($arr_cat[$i]["subcategorias"], $item);
                }
            }
        }
        return $arr_cat;
    }

    public function existeId($idQuery){
        if(!is_numeric($idQuery)) return false; //SI NO ES NUMERICO DEVUELVE FALSO

        $query = 'SELECT ID_CATEGORIA FROM CATEGORIA WHERE ID_CATEGORIA = :id';

        $stmt = $this->conn->prepare($query);

        $idQuery = htmlspecialchars(strip_tags($idQuery));

        $stmt->bindParam(':id', $idQuery);

        $stmt->execute();

        $num = $stmt->rowCount();

        if($num>0){
            return true;
        }

        return false;
    }
}