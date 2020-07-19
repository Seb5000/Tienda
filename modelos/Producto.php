<?php
class Producto{
    // variables base de datos
    private $conn;

    //Atributos Producto
    public $antiguoId;
    public $id;
    public $id_categoria;
    public $nombre_categoria; // no existe en la base de datos se usara join
    public $id_subcategoria;
    public $nombre_subcategoria; // no existe en la base de datos se usara join
    public $nombre;
    public $marca;
    public $precio;
    public $imagenes = array();
    public $descripcion;

    public $queryE;
    //En caso de error
    public $error;
    public $numero_filas;

    //El constructor de la clase
    public function __construct($bd){
        $this->conn = $bd;
    }

    public function obtenerNombre($id){
        $query = 'SELECT NOMBRE_PRODUCTO FROM PRODUCTO WHERE ID_PRODUCTO = :id';

        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $num = $stmt->rowCount();

        if($num>0){
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $nombre = $fila['NOMBRE_PRODUCTO'];
            return $nombre;
        }

        return 'No se encontro el registro : '.$id;
    }

    public function leer(){
        $query = 'SELECT
                p.ID_PRODUCTO,
                p.ID_CATEGORIA,
                c.NOMBRE_CATEGORIA,
                p.ID_SUBCATEGORIA,
                s.NOMBRE_SUBCATEGORIA,
                p.NOMBRE_PRODUCTO,
                p.MARCA_PRODUCTO,
                p.PRECIO_PRODUCTO,
                p.DESCRIPCION_PRODUCTO
                FROM PRODUCTO p
                    INNER JOIN CATEGORIA c ON p.ID_CATEGORIA = c.ID_CATEGORIA
                    INNER JOIN SUBCATEGORIA s ON p.ID_SUBCATEGORIA = s.ID_SUBCATEGORIA';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function leer2(){
        $query = 'SELECT
                p.ID_PRODUCTO,
                p.ID_CATEGORIA,
                c.NOMBRE_CATEGORIA,
                p.ID_SUBCATEGORIA,
                s.NOMBRE_SUBCATEGORIA,
                p.NOMBRE_PRODUCTO,
                p.MARCA_PRODUCTO,
                p.PRECIO_PRODUCTO,
                p.DESCRIPCION_PRODUCTO
                FROM PRODUCTO p
                    LEFT OUTER JOIN CATEGORIA c ON p.ID_CATEGORIA = c.ID_CATEGORIA
                    LEFT OUTER JOIN SUBCATEGORIA s ON p.ID_SUBCATEGORIA = s.ID_SUBCATEGORIA
                ORDER BY p.ID_PRODUCTO';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $num = $stmt->rowCount();

        //Crear un array respuesta
        $arr_prod = array();
        //Si existe algun producto
        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $producto = array(
                    'id_producto'=>$fila['ID_PRODUCTO'],
                    'nombre_producto'=>$fila['NOMBRE_PRODUCTO'],
                    'id_categoria'=>$fila['ID_CATEGORIA'],
                    'nombre_categoria'=>$fila['NOMBRE_CATEGORIA'],
                    'id_subcategoria'=>$fila['ID_SUBCATEGORIA'],
                    'nombre_subcategoria'=>$fila['NOMBRE_SUBCATEGORIA'],
                    'marca'=>$fila['MARCA_PRODUCTO'],
                    'precio'=>$fila['PRECIO_PRODUCTO'],
                    'descripcion'=>$fila['DESCRIPCION_PRODUCTO']
                );
                array_push($arr_prod, $producto);
            }
        }
        return $arr_prod;
    }

    public function numeroFilas(){
        $query = "SELECT count(*) FROM PRODUCTO";
        
        $numero_de_filas = $this->conn->query($query)->fetchColumn();

        $this->numero_filas = $numero_de_filas;

        return $numero_de_filas;
    }

    public function siguienteId(){
        $query = "SELECT `AUTO_INCREMENT`
                    FROM  INFORMATION_SCHEMA.TABLES
                    WHERE TABLE_SCHEMA = 'CASADEARTE'
                    AND   TABLE_NAME   = 'PRODUCTO'";
        
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $num = $stmt->rowCount();

        $id = "0";
        if($num>0){
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $id = $fila['AUTO_INCREMENT'];
        }
        return $id;
    }

    public function existeId($id){
        $query = 'SELECT NOMBRE_PRODUCTO FROM PRODUCTO WHERE ID_PRODUCTO = :id';
        $stmt = $this->conn->prepare($query);
        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num>0){
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $nombre = $fila['NOMBRE_PRODUCTO'];
            return array(true, $nombre);
        }
        return array(false, '');
    }

    public function agregar(){
        $query = "INSERT INTO PRODUCTO
                    SET
                        ID_PRODUCTO = :id_producto,
                        ID_CATEGORIA = :id_categoria,
                        ID_SUBCATEGORIA = :id_subcategoria,
                        NOMBRE_PRODUCTO = :nombre_producto,
                        MARCA_PRODUCTO = :marca_producto,
                        PRECIO_PRODUCTO = :precio_producto,
                        DESCRIPCION_PRODUCTO = :descripcion_producto";
        
        $stmt = $this->conn->prepare($query);

        //Limpiar los datos

        //$this->id_categoria = htmlspecialchars(strip_tags($this->id_categoria));
        //$this->id_subcategoria = htmlspecialchars(strip_tags($this->id_subcategoria));

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->marca = htmlspecialchars(strip_tags($this->marca));
        //$this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        
        //Relacionar los datos
        //$this->id_categoria = null;
        //$this->id_subcategoria = null;

        $stmt->bindValue(':id_producto', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':id_categoria', $this->id_categoria, PDO::PARAM_INT);
        $stmt->bindValue(':id_subcategoria', $this->id_subcategoria, PDO::PARAM_INT);

        $stmt->bindParam(':nombre_producto', $this->nombre);
        $stmt->bindParam(':marca_producto', $this->marca);
        $stmt->bindValue(':precio_producto', $this->precio, PDO::PARAM_INT);
        $stmt->bindParam(':descripcion_producto', $this->descripcion);
        
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

    public function borrarProductos(){
        //$query = 'DELETE FROM PRODUCTO WHERE ID_PRODUCTO in (:ids)';
        $query = 'DELETE FROM PRODUCTO WHERE ID_PRODUCTO in ('.$this->id.')';

        $stmt = $this->conn->prepare($query);
        /*
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->queryE = 'DELETE FROM PRODUCTO WHERE ID_PRODUCTO in ('.$this->id.')';
        $stmt->bindParam(':ids', $this->id);
        */
        if($stmt->execute()){
            return true;
        }

        $this->error = $stmt->error;
        return false;
    }

    public function obtenerProducto(){
        $query = "SELECT
                    p.ID_PRODUCTO,
                    p.NOMBRE_PRODUCTO,
                    p.ID_CATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    p.ID_SUBCATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    p.MARCA_PRODUCTO,
                    p.PRECIO_PRODUCTO,
                    p.DESCRIPCION_PRODUCTO
                    FROM PRODUCTO p
                        LEFT OUTER JOIN CATEGORIA c ON p.ID_CATEGORIA = c.ID_CATEGORIA
                        LEFT OUTER JOIN SUBCATEGORIA s ON p.ID_SUBCATEGORIA = s.ID_SUBCATEGORIA
                    WHERE p.ID_PRODUCTO = :id";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        $num = $stmt->rowCount();

        if($num>0){
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->nombre = $fila['NOMBRE_PRODUCTO'];
            $this->id_categoria = $fila['ID_CATEGORIA'];
            $this->nombre_categoria = $fila['NOMBRE_CATEGORIA'];
            $this->id_subcategoria = $fila['ID_SUBCATEGORIA'];
            $this->nombre_subcategoria = $fila['NOMBRE_SUBCATEGORIA'];
            $this->marca = $fila['MARCA_PRODUCTO'];
            $this->precio = $fila['PRECIO_PRODUCTO'];
            $this->descripcion = $fila['DESCRIPCION_PRODUCTO'];
            return true;
        }

        $this->error = "No se encontro el producto seleccionado, ".$stmt->error;
        return false;
    }

    public function contarIdsSubcategorias($ids){
        if(is_array($ids)){
            $ids = implode(",", $ids);
        }
        $ids = htmlspecialchars(strip_tags($ids));
        $arr_sub = array();
        if($ids==''){
            return $arr_sub;
        }
        $query = "SELECT ID_SUBCATEGORIA, COUNT(ID_SUBCATEGORIA) 
                    FROM producto 
                    WHERE ID_PRODUCTO in (".$ids.") 
                    GROUP BY ID_SUBCATEGORIA";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $sub = array();
                $sub["id"] = $fila["ID_SUBCATEGORIA"];
                $sub["veces"] = $fila["COUNT(ID_SUBCATEGORIA)"];
                array_push($arr_sub, $sub);
            }
        }
        return $arr_sub;
    }

    public function obtenerProductoArr($id, $imagenesDefecto=false){
        $query = "SELECT
                    p.ID_PRODUCTO,
                    p.NOMBRE_PRODUCTO,
                    p.ID_CATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    p.ID_SUBCATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    p.MARCA_PRODUCTO,
                    p.PRECIO_PRODUCTO,
                    p.DESCRIPCION_PRODUCTO
                    FROM PRODUCTO p
                        LEFT OUTER JOIN CATEGORIA c ON p.ID_CATEGORIA = c.ID_CATEGORIA
                        LEFT OUTER JOIN SUBCATEGORIA s ON p.ID_SUBCATEGORIA = s.ID_SUBCATEGORIA
                    WHERE p.ID_PRODUCTO = :id";

        $stmt = $this->conn->prepare($query);
        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $num = $stmt->rowCount();
        $err = false;
        $producto = array();
        if($num>0){
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            $producto['id'] = $fila['ID_PRODUCTO'];
            $producto['nombre'] = $fila['NOMBRE_PRODUCTO'];
            $producto['id_categoria'] = $fila['ID_CATEGORIA'];
            $producto['nombre_categoria'] = $fila['NOMBRE_CATEGORIA'];
            $producto['id_subcategoria'] = $fila['ID_SUBCATEGORIA'];
            $producto['nombre_subcategoria'] = $fila['NOMBRE_SUBCATEGORIA'];
            $producto['marca'] = $fila['MARCA_PRODUCTO'];
            $producto['precio'] = $fila['PRECIO_PRODUCTO'];
            $producto['descripcion'] = $fila['DESCRIPCION_PRODUCTO'];
            $producto['imagenes'] = array();
        }else{
            $this->error = "No se encontro el producto seleccionado, ".$stmt->error;
            $err = true;
        }

        if(!$err){
            $query = "SELECT
                    ID_IMAGEN,
                    ID_PRODUCTO,
                    CAMINO_IMAGEN,
                    CAMINO_SM_IMAGEN,
                    PRINCIPAL_IMAGEN,
                    ORDEN_IMAGEN
                    FROM IMAGENES
                    WHERE ID_PRODUCTO = :id
                    ORDER BY ORDEN_IMAGEN ASC";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $num = $stmt->rowCount();
            if($num>0){
                while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $imagen = array(
                        'id'=>$fila['ID_IMAGEN'],
                        'id_producto'=>$fila['ID_PRODUCTO'],
                        'camino_imagen'=>$fila['CAMINO_IMAGEN'],
                        'camino_sm_imagen'=>$fila['CAMINO_SM_IMAGEN'],
                        'principal'=>$fila['PRINCIPAL_IMAGEN'],
                        'orden'=>$fila['ORDEN_IMAGEN'],
                    );
                    $nombreimg = pathinfo($imagen['camino_imagen'], PATHINFO_FILENAME);
                    if($nombreimg != "defecto" || $imagenesDefecto){
                        array_push($producto['imagenes'], $imagen);
                    }
                }
            }
        }
        return $producto;
    }

    public function guardarCambios(){
        $query = "UPDATE PRODUCTO
                    SET
                        ID_PRODUCTO = :id,
                        NOMBRE_PRODUCTO = :nombre,
                        ID_CATEGORIA = $this->id_categoria,
                        ID_SUBCATEGORIA = $this->id_subcategoria,
                        MARCA_PRODUCTO = :marca,
                        PRECIO_PRODUCTO = :precio,
                        DESCRIPCION_PRODUCTO = :descripcion
                    WHERE 
                        ID_PRODUCTO = :antiguoId";
        $stmt = $this->conn->prepare($query);

        //Limpiar los datos
        $this->antiguoId = htmlspecialchars(strip_tags($this->antiguoId));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->marca = htmlspecialchars(strip_tags($this->marca));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        //$this->imagen = htmlspecialchars(strip_tags($this->imagen));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        
        //Relacionar los datos
        $stmt->bindParam(':antiguoId', $this->antiguoId);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':marca', $this->marca);
        $stmt->bindParam(':precio', $this->precio);
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

    public function obtenerProductos3($iniciar, $numFilas, $nombre, $idCategoria, $idSubcategoria){
        //PARAMETROS QUE SON LIMPIADOS
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
            $idCategoria = ($idCategoria == '*')? null: $idCategoria;
        }
        if($idSubcategoria!=null){
            $idSubcategoria = htmlspecialchars(strip_tags($idSubcategoria));
            $idSubcategoria = ($idSubcategoria == '*')? null: $idSubcategoria;
        }

        // ESTA ES LA QUERY BASE A LA CUAL SE VAN A AGREGAR 
        //CONDICION EN FUNCION DE LOS PARAMETROS
        $queryBase = "SELECT
                    p.ID_PRODUCTO,
                    p.NOMBRE_PRODUCTO,
                    p.ID_CATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    p.ID_SUBCATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    p.MARCA_PRODUCTO,
                    p.PRECIO_PRODUCTO,
                    p.DESCRIPCION_PRODUCTO,
                    i.CAMINO_IMAGEN,
                    i.CAMINO_SM_IMAGEN
                    FROM PRODUCTO p
                        LEFT OUTER JOIN CATEGORIA c ON p.ID_CATEGORIA = c.ID_CATEGORIA
                        LEFT OUTER JOIN SUBCATEGORIA s ON p.ID_SUBCATEGORIA = s.ID_SUBCATEGORIA
                        LEFT OUTER JOIN IMAGENES i ON p.ID_PRODUCTO = i.ID_PRODUCTO";
        //CONDICION LIMITES DE LA QUERY
        $condicionLimites = "LIMIT $iniciar , $numFilas";
        //CONDICION DE CATEGORIA
        $condicionCategoria = "p.ID_CATEGORIA = $idCategoria";
        //CONDICION DE CATEGORIA NULA
        $condicionCategoriaNula = "p.ID_CATEGORIA IS null";
        //CONDICION DE SUBCATEGORIA
        $condicionSubcategoria = "p.ID_SUBCATEGORIA = $idSubcategoria";
        //CONDICION DE SUBCATEGORIA NULA
        $condicionSubcategoriaNula = "p.ID_SUBCATEGORIA IS null";
        //CONDICIO DE NOMBRE
        $condicionNombre = "p.NOMBRE_PRODUCTO REGEXP '$regexp'";

        $query = $queryBase;
        $union = "";
        $condiciones = " WHERE (i.PRINCIPAL_IMAGEN = 1 OR i.PRINCIPAL_IMAGEN IS NULL)";
        $condicionAgregada = true;

        //SI EXISTE ALGUNCA CONDICION... ya existe con lo de las imagenes
        /*
        if($nombre != null or $idCategoria != null or $idSubcategoria != null){
            $condiciones = " WHERE ";
        }
        */

        if($nombre != null){
            $union = ($condicionAgregada)? " AND " : "";
            $condiciones = $condiciones.$union.$condicionNombre;
            $condicionAgregada = true;
        }

        if($idCategoria != null){
            $union = ($condicionAgregada)? " AND " : "";
            
            if($idCategoria == "0"){
                $condiciones = $condiciones.$union.$condicionCategoriaNula;
                $condicionAgregada = true;
            }else{
                $condiciones = $condiciones.$union.$condicionCategoria;
                $condicionAgregada = true;
            }
        }

        if($idSubcategoria != null){
            $union = ($condicionAgregada)? " AND " : "";
            if($idSubcategoria == "0"){
                $condiciones = $condiciones.$union.$condicionSubcategoriaNula;
                $condicionAgregada = true;
            }else{
                $condiciones = $condiciones.$union.$condicionSubcategoria;
                $condicionAgregada = true;
            }
        }
        $query = $query.$condiciones;
        $query = $query." ".$condicionLimites;
        //$this->queryE = $query;
        //echo $query;
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->execute();
        }catch (PDOException $e) {
            echo 'El error .. '. $e->getMessage();
        }
        $num = $stmt->rowCount();
        $arr_prod = array();

        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $producto = array(
                    'id' => $fila['ID_PRODUCTO'],
                    'nombre' => $fila['NOMBRE_PRODUCTO'],
                    'idC' => $fila['ID_CATEGORIA'],
                    'nombreC' => $fila['NOMBRE_CATEGORIA'],
                    'idS' => $fila['ID_SUBCATEGORIA'],
                    'nombreS' => $fila['NOMBRE_SUBCATEGORIA'],
                    'marca' => $fila['MARCA_PRODUCTO'],
                    'precio' => $fila['PRECIO_PRODUCTO'],
                    'descripcion' => $fila['DESCRIPCION_PRODUCTO'],
                    'imagen' => $fila['CAMINO_IMAGEN'],
                    'imagen_s' => $fila['CAMINO_SM_IMAGEN']
                );
                array_push($arr_prod, $producto);
            }
        }
        
        $queryNFilas = "SELECT COUNT(p.ID_PRODUCTO)
                        FROM PRODUCTO p
                        LEFT OUTER JOIN IMAGENES i ON p.ID_PRODUCTO = i.ID_PRODUCTO";
        $queryNFilas = $queryNFilas.$condiciones;
        $this->numero_filas = $this->conn->query($queryNFilas)->fetchColumn();
        
        return $arr_prod;
    }

    public function obtenerProductos2($iniciar, $numFilas){
        $query = "SELECT
                    p.ID_PRODUCTO,
                    p.NOMBRE_PRODUCTO,
                    p.ID_CATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    p.ID_SUBCATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    p.MARCA_PRODUCTO,
                    p.PRECIO_PRODUCTO,
                    p.DESCRIPCION_PRODUCTO
                    FROM PRODUCTO p
                        LEFT OUTER JOIN CATEGORIA c ON p.ID_CATEGORIA = c.ID_CATEGORIA
                        LEFT OUTER JOIN SUBCATEGORIA s ON p.ID_SUBCATEGORIA = s.ID_SUBCATEGORIA
                    LIMIT :iniciar, :numFilas";

        $stmt = $this->conn->prepare($query);

        $iniciar = htmlspecialchars(strip_tags($iniciar));
        $numFilas = htmlspecialchars(strip_tags($numFilas));

        $stmt->bindParam(':iniciar', $iniciar, PDO::PARAM_INT);
        $stmt->bindParam(':numFilas', $numFilas, PDO::PARAM_INT);

        $stmt->execute();

        $num = $stmt->rowCount();

        $arr_prod = array();

        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $producto = array(
                    'id' => $fila['ID_PRODUCTO'],
                    'nombre' => $fila['NOMBRE_PRODUCTO'],
                    'idC' => $fila['ID_CATEGORIA'],
                    'nombreC' => $fila['NOMBRE_CATEGORIA'],
                    'idS' => $fila['ID_SUBCATEGORIA'],
                    'nombreS' => $fila['NOMBRE_SUBCATEGORIA'],
                    'marca' => $fila['MARCA_PRODUCTO'],
                    'precio' => $fila['PRECIO_PRODUCTO'],
                    'descripcion' => $fila['DESCRIPCION_PRODUCTO'],
                );
                array_push($arr_prod, $producto);
            }
        }
        return $arr_prod;
    }

    public function obtenerProductos($idCat, $idSub){
        $query = "SELECT
                    p.ID_PRODUCTO,
                    p.NOMBRE_PRODUCTO,
                    p.ID_CATEGORIA,
                    c.NOMBRE_CATEGORIA,
                    p.ID_SUBCATEGORIA,
                    s.NOMBRE_SUBCATEGORIA,
                    p.MARCA_PRODUCTO,
                    p.PRECIO_PRODUCTO,
                    p.DESCRIPCION_PRODUCTO
                    FROM PRODUCTO p
                        LEFT OUTER JOIN CATEGORIA c ON p.ID_CATEGORIA = c.ID_CATEGORIA
                        LEFT OUTER JOIN SUBCATEGORIA s ON p.ID_SUBCATEGORIA = s.ID_SUBCATEGORIA
                    WHERE 
                        p.ID_CATEGORIA = :idC AND
                        p.ID_SUBCATEGORIA = :idS";

        $stmt = $this->conn->prepare($query);

        $idCat = htmlspecialchars(strip_tags($idCat));
        $idSub = htmlspecialchars(strip_tags($idSub));

        $stmt->bindParam(':idC', $idCat);
        $stmt->bindParam(':idS', $idSub);

        $stmt->execute();

        $num = $stmt->rowCount();

        $arr_prod = array();

        if($num>0){
            while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
                $producto = array(
                    'id' => $fila['ID_PRODUCTO'],
                    'nombre' => $fila['NOMBRE_PRODUCTO'],
                    'idC' => $fila['ID_CATEGORIA'],
                    'nombreC' => $fila['NOMBRE_CATEGORIA'],
                    'idS' => $fila['ID_SUBCATEGORIA'],
                    'nombreS' => $fila['NOMBRE_SUBCATEGORIA'],
                    'marca' => $fila['MARCA_PRODUCTO'],
                    'precio' => $fila['PRECIO_PRODUCTO'],
                    'descripcion' => $fila['DESCRIPCION_PRODUCTO'],
                );
                array_push($arr_prod, $producto);
            }
        }
        return $arr_prod;
    }

    public function buscarSugerenciasNombre($palabras){
        $query = "SELECT
                    NOMBRE_PRODUCTO
                    FROM PRODUCTO 
                    WHERE NOMBRE_PRODUCTO REGEXP :pal
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
                array_push($arr_sub, $fila['NOMBRE_PRODUCTO']);
            }
        }
        return $arr_sub;
    } 
}