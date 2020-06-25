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

    public function numeroFilas(){
        $query = "SELECT count(*) FROM SUBCATEGORIA";
        
        $numero_de_filas = $this->conn->query($query)->fetchColumn();

        $this->numero_filas = $numero_de_filas;

        return $numero_de_filas;
    }

    public function obtenerNombre($id){
        $query = 'SELECT NOMBRE_SUBCATEGORIA FROM SUBCATEGORIA WHERE ID_SUBCATEGORIA = :id';

        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $num = $stmt->rowCount();

        if($num>0){
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $nombre = $fila['NOMBRE_SUBCATEGORIA'];
            return $nombre;
        }
        return 'No se encontro el registro : '.$id;
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

    public function listaSubcategorias2(){
        $query = 'SELECT s.ID_SUBCATEGORIA,
                         s.ID_CATEGORIA,
                         s.NOMBRE_SUBCATEGORIA,
                         c.NOMBRE_CATEGORIA 
                    FROM SUBCATEGORIA s
                    LEFT OUTER JOIN CATEGORIA c ON s.ID_CATEGORIA = c.ID_CATEGORIA';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $num = $stmt->rowCount();

        //Crear un array respuesta
        $arr_Subcat = array();
        //Si existe alguna Subcategoria
        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id'=>$fila['ID_SUBCATEGORIA'],
                    'nombre'=>$fila['NOMBRE_SUBCATEGORIA']
                );
                $idCat = ($fila['ID_CATEGORIA'] == null)? "sinCategoria" : $fila['ID_CATEGORIA'];
                $nomCat = ($fila['NOMBRE_CATEGORIA'] == null)? "Sin Categoria" : $fila['NOMBRE_CATEGORIA'];
                //Verificamos si existe alguna categoria en arr_Subcat
                if(isset($arr_Subcat[$idCat])){
                    array_push($arr_Subcat[$idCat]["subcategorias"], $item);
                }else{
                    $arr_Subcat[$idCat] = array(
                        'id'=>$idCat,
                        'nombre'=>$nomCat,
                        'subcategorias'=>array()
                    );
                    array_push($arr_Subcat[$idCat]["subcategorias"], $item);
                }
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

    public function existeId($idQuery){
        if(!is_numeric($idQuery)) return false; //SI NO ES NUMERICO DEVUELVE FALSO

        $query = 'SELECT ID_SUBCATEGORIA FROM SUBCATEGORIA WHERE ID_SUBCATEGORIA = :id';

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

    public function existeIdCategoria($idQuery){
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

    //Existe EL ID ($idQuery) de la subcategoria en la categoria dada ($idCategoria)
    public function existeIdEnCategoria($idQuery, $idCategoria){
        if(!is_numeric($idQuery)) return false; //SI NO ES NUMERICO DEVUELVE FALSO

        $query = 'SELECT ID_SUBCATEGORIA FROM SUBCATEGORIA 
                    WHERE ID_SUBCATEGORIA = :idS AND ID_CATEGORIA = :idC';

        $stmt = $this->conn->prepare($query);

        $idQuery = htmlspecialchars(strip_tags($idQuery));
        $idCategoria = htmlspecialchars(strip_tags($idCategoria));

        $stmt->bindParam(':idS', $idQuery);
        $stmt->bindParam(':idC', $idCategoria);

        $stmt->execute();

        $num = $stmt->rowCount();

        if($num>0){
            return true;
        }
        return false;
    }

    public function obtenerSubcategorias($idCategoria){
        $query = "SELECT
                    s.ID_SUBCATEGORIA,
                    s.ID_CATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    s.IMAGEN_SUBCATEGORIA,
                    s.DESCRIPCION_SUBCATEGORIA
                    FROM SUBCATEGORIA s
                        LEFT OUTER JOIN CATEGORIA c ON s.ID_CATEGORIA = c.ID_CATEGORIA
                    WHERE 
                        s.ID_CATEGORIA = :idC";

        $stmt = $this->conn->prepare($query);

        $idCategoria = htmlspecialchars(strip_tags($idCategoria));

        $stmt->bindParam(':idC', $idCategoria);

        $stmt->execute();

        $num = $stmt->rowCount();

        $arr_sub = array();

        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $subcategoria = array(
                    'id' => $fila['ID_SUBCATEGORIA'],
                    'nombre' => $fila['NOMBRE_SUBCATEGORIA'],
                    'idC' => $fila['ID_CATEGORIA'],
                    'nombreC' => $fila['NOMBRE_CATEGORIA'],
                    'imagen' => $fila['IMAGEN_SUBCATEGORIA'],
                    'descripcion' => $fila['DESCRIPCION_SUBCATEGORIA'],
                );
                array_push($arr_sub, $subcategoria);
            }
        }
        return $arr_sub;
    }

    public function obtenerProductos2($iniciar, $numFilas, $nombre, $idCategoria){
        //parametros
        $iniciar = htmlspecialchars(strip_tags($iniciar));
        $numFilas = htmlspecialchars(strip_tags($numFilas));
        $regexp = "";
        if($nombre != null){
            $nombre = htmlspecialchars(strip_tags($nombre));
            $arr_pal = explode(" ", $nombre);
            $regexp = ($arr_pal[0] != "")? "($arr_pal[0]" : "(";
            for($i=1; $i<count($arr_pal); $i++){
                $regexp .= ($arr_pal[$i] != "")? "|$arr_pal[$i]" : "";
            }
            $regexp .= ".*)";
        }
        if($idCategoria!=null){
            $idCategoria = htmlspecialchars(strip_tags($idCategoria));
        }
        
        // SE INTRODUJO UN NOMBRE PERO NO UNA CATEGORIA QUERY 1
        if($nombre!=null and $idCategoria ==null){
            $query = "SELECT
                    s.ID_SUBCATEGORIA,
                    s.ID_CATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    s.IMAGEN_SUBCATEGORIA,
                    s.DESCRIPCION_SUBCATEGORIA
                    FROM SUBCATEGORIA s
                        LEFT OUTER JOIN CATEGORIA c ON s.ID_CATEGORIA = c.ID_CATEGORIA
                    WHERE s.NOMBRE_SUBCATEGORIA REGEXP :regexp
                    LIMIT :iniciar, :numFilas";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':iniciar', $iniciar, PDO::PARAM_INT);
            $stmt->bindParam(':numFilas', $numFilas, PDO::PARAM_INT);
            $stmt->bindParam(':regexp', $regexp);
        }elseif($nombre==null and $idCategoria !=null){
            if($idCategoria == "sinCategoria"){
                $query = "SELECT
                    s.ID_SUBCATEGORIA,
                    s.ID_CATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    s.IMAGEN_SUBCATEGORIA,
                    s.DESCRIPCION_SUBCATEGORIA
                    FROM SUBCATEGORIA s
                        LEFT OUTER JOIN CATEGORIA c ON s.ID_CATEGORIA = c.ID_CATEGORIA
                    WHERE s.ID_CATEGORIA IS :idC
                    LIMIT :iniciar, :numFilas";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':iniciar', $iniciar, PDO::PARAM_INT);
                $stmt->bindParam(':numFilas', $numFilas, PDO::PARAM_INT);
                $stmt->bindValue(':idC', null, PDO::PARAM_INT);
            }elseif($idCategoria == "todas"){
                $query = "SELECT
                    s.ID_SUBCATEGORIA,
                    s.ID_CATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    s.IMAGEN_SUBCATEGORIA,
                    s.DESCRIPCION_SUBCATEGORIA
                    FROM SUBCATEGORIA s
                        LEFT OUTER JOIN CATEGORIA c ON s.ID_CATEGORIA = c.ID_CATEGORIA
                    LIMIT :iniciar, :numFilas";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':iniciar', $iniciar, PDO::PARAM_INT);
                $stmt->bindParam(':numFilas', $numFilas, PDO::PARAM_INT);
            }else{
                $query = "SELECT
                    s.ID_SUBCATEGORIA,
                    s.ID_CATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    s.IMAGEN_SUBCATEGORIA,
                    s.DESCRIPCION_SUBCATEGORIA
                    FROM SUBCATEGORIA s
                        LEFT OUTER JOIN CATEGORIA c ON s.ID_CATEGORIA = c.ID_CATEGORIA
                    WHERE s.ID_CATEGORIA = :idC
                    LIMIT :iniciar, :numFilas";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':iniciar', $iniciar, PDO::PARAM_INT);
                $stmt->bindParam(':numFilas', $numFilas, PDO::PARAM_INT);
                $stmt->bindValue(':idC', $idCategoria, PDO::PARAM_INT);
            }
        }elseif($nombre!=null and $idCategoria !=null){
            if($idCategoria == "sinCategoria"){
                $query = "SELECT
                    s.ID_SUBCATEGORIA,
                    s.ID_CATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    s.IMAGEN_SUBCATEGORIA,
                    s.DESCRIPCION_SUBCATEGORIA
                    FROM SUBCATEGORIA s
                        LEFT OUTER JOIN CATEGORIA c ON s.ID_CATEGORIA = c.ID_CATEGORIA
                    WHERE s.ID_CATEGORIA IS :idC AND
                        s.NOMBRE_SUBCATEGORIA REGEXP :regexp
                    LIMIT :iniciar, :numFilas";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':iniciar', $iniciar, PDO::PARAM_INT);
                $stmt->bindParam(':numFilas', $numFilas, PDO::PARAM_INT);
                $stmt->bindValue(':idC', null, PDO::PARAM_INT);
                $stmt->bindParam(':regexp', $regexp);
            }elseif($idCategoria == "todas"){
                $query = "SELECT
                    s.ID_SUBCATEGORIA,
                    s.ID_CATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    s.IMAGEN_SUBCATEGORIA,
                    s.DESCRIPCION_SUBCATEGORIA
                    FROM SUBCATEGORIA s
                        LEFT OUTER JOIN CATEGORIA c ON s.ID_CATEGORIA = c.ID_CATEGORIA
                    WHERE s.NOMBRE_SUBCATEGORIA REGEXP :regexp
                    LIMIT :iniciar, :numFilas";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':iniciar', $iniciar, PDO::PARAM_INT);
                $stmt->bindParam(':numFilas', $numFilas, PDO::PARAM_INT);
                $stmt->bindParam(':regexp', $regexp);
            }else{
                $query = "SELECT
                    s.ID_SUBCATEGORIA,
                    s.ID_CATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    s.IMAGEN_SUBCATEGORIA,
                    s.DESCRIPCION_SUBCATEGORIA
                    FROM SUBCATEGORIA s
                        LEFT OUTER JOIN CATEGORIA c ON s.ID_CATEGORIA = c.ID_CATEGORIA
                    WHERE s.ID_CATEGORIA = :idC AND 
                            s.NOMBRE_SUBCATEGORIA REGEXP :regexp
                    LIMIT :iniciar, :numFilas";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':iniciar', $iniciar, PDO::PARAM_INT);
                $stmt->bindParam(':numFilas', $numFilas, PDO::PARAM_INT);
                $stmt->bindValue(':idC', $idCategoria, PDO::PARAM_INT);
                $stmt->bindParam(':regexp', $regexp);
            }
        }else{
            $query = "SELECT
                    s.ID_SUBCATEGORIA,
                    s.ID_CATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    s.IMAGEN_SUBCATEGORIA,
                    s.DESCRIPCION_SUBCATEGORIA
                    FROM SUBCATEGORIA s
                        LEFT OUTER JOIN CATEGORIA c ON s.ID_CATEGORIA = c.ID_CATEGORIA
                    LIMIT :iniciar, :numFilas";

                $stmt = $this->conn->prepare($query);

                $stmt->bindParam(':iniciar', $iniciar, PDO::PARAM_INT);
                $stmt->bindParam(':numFilas', $numFilas, PDO::PARAM_INT);
        }

        $stmt->execute();

        $num = $stmt->rowCount();

        $arr_sub = array();

        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $subcategoria = array(
                    'id' => $fila['ID_SUBCATEGORIA'],
                    'nombre' => $fila['NOMBRE_SUBCATEGORIA'],
                    'idC' => $fila['ID_CATEGORIA'],
                    'nombreC' => $fila['NOMBRE_CATEGORIA'],
                    'imagen' => $fila['IMAGEN_SUBCATEGORIA'],
                    'descripcion' => $fila['DESCRIPCION_SUBCATEGORIA'],
                );
                array_push($arr_sub, $subcategoria);
            }
        }
        return $arr_sub;
    }

    public function leer(){
        $query = "SELECT
                    s.ID_SUBCATEGORIA,
                    s.ID_CATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    s.IMAGEN_SUBCATEGORIA,
                    s.DESCRIPCION_SUBCATEGORIA
                    FROM SUBCATEGORIA s
                        LEFT OUTER JOIN CATEGORIA c ON s.ID_CATEGORIA = c.ID_CATEGORIA";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $num = $stmt->rowCount();

        $arr_sub = array();

        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $subcategoria = array(
                    'id' => $fila['ID_SUBCATEGORIA'],
                    'nombre' => $fila['NOMBRE_SUBCATEGORIA'],
                    'idC' => $fila['ID_CATEGORIA'],
                    'nombreC' => $fila['NOMBRE_CATEGORIA'],
                    'imagen' => $fila['IMAGEN_SUBCATEGORIA'],
                    'descripcion' => $fila['DESCRIPCION_SUBCATEGORIA']
                );
                array_push($arr_sub, $subcategoria);
            }
        }
        return $arr_sub;
    }
    
    public function buscarSugerenciasNombre($palabras){
        $query = "SELECT
                    NOMBRE_SUBCATEGORIA
                    FROM SUBCATEGORIA 
                    WHERE NOMBRE_SUBCATEGORIA REGEXP :pal
                    LIMIT 7";

        $stmt = $this->conn->prepare($query);

        $arr_pal = explode(" ", $palabras);
        $pal = ($arr_pal[0] != "")? "($arr_pal[0]" : "(";
        for($i=1; $i<count($arr_pal); $i++){
            $pal .= ($arr_pal[$i] != "")? "|$arr_pal[$i]" : "";
        }
        $pal .= ".*)";

        $stmt->bindParam(':pal', $pal);

        $stmt->execute();

        $num = $stmt->rowCount();

        $arr_sub = array();

        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                array_push($arr_sub, $fila['NOMBRE_SUBCATEGORIA']);
            }
        }
        return $arr_sub;
    }
}