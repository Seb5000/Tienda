<?php
class Producto{
    // variables base de datos
    private $conn;

    //Atributos Producto
    public $id;
    public $id_categoria;
    public $nombre_categoria; // no existe en la base de datos se usara join
    public $id_subcategoria;
    public $nombre_subcategoria; // no existe en la base de datos se usara join
    public $nombre;
    public $marca;
    public $precio;
    public $imagen;
    public $descripcion;

    public $queryE;
    //En caso de error
    public $error;

    //El constructor de la clase
    public function __construct($bd){
        $this->conn = $bd;
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
                p.IMAGEN_PRODUCTO,
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
                p.IMAGEN_PRODUCTO,
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
                    'imagen'=>$fila['IMAGEN_PRODUCTO'],
                    'descripcion'=>$fila['DESCRIPCION_PRODUCTO']
                );
                array_push($arr_prod, $producto);
            }
        }
        return $arr_prod;
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

    public function agregar(){
        $query = "INSERT INTO PRODUCTO
                    SET
                        ID_CATEGORIA = $this->id_categoria,
                        ID_SUBCATEGORIA = $this->id_subcategoria,
                        NOMBRE_PRODUCTO = :nombre_producto,
                        MARCA_PRODUCTO = :marca_producto,
                        PRECIO_PRODUCTO = :precio_producto,
                        IMAGEN_PRODUCTO = :imagen_producto,
                        DESCRIPCION_PRODUCTO = :descripcion_producto";
        
        $stmt = $this->conn->prepare($query);

        //Limpiar los datos
        /*
        $this->id_categoria = htmlspecialchars(strip_tags($this->id_categoria));
        $this->id_subcategoria = htmlspecialchars(strip_tags($this->id_subcategoria));
        */
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->marca = htmlspecialchars(strip_tags($this->marca));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->imagen = htmlspecialchars(strip_tags($this->imagen));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        
        //Relacionar los datos
        /*
        $stmt->bindParam(':id_categoria', $this->id_categoria);
        $stmt->bindParam(':id_subcategoria', $this->id_subcategoria);
        */
        $stmt->bindParam(':nombre_producto', $this->nombre);
        $stmt->bindParam(':marca_producto', $this->marca);
        $stmt->bindParam(':precio_producto', $this->precio);
        $stmt->bindParam(':imagen_producto', $this->imagen);
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
                    p.IMAGEN_PRODUCTO,
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
            $this->imagen = $fila['IMAGEN_PRODUCTO'];
            $this->descripcion = $fila['DESCRIPCION_PRODUCTO'];
            return true;
        }

        $this->error = "No se encontro el producto seleccionado, ".$stmt->error;
        return false;
    }

    public function guardarProducto(){
        $query = "UPDATE PRODUCTO
                    SET
                        NOMBRE_PRODUCTO = :nombre,
                        ID_CATEGORIA = $this->id_categoria,
                        ID_SUBCATEGORIA = $this->id_subcategoria,
                        MARCA_PRODUCTO = :marca,
                        PRECIO_PRODUCTO = :precio,
                        IMAGEN_PRODUCTO = :imagen,
                        DESCRIPCION_PRODUCTO = :descripcion
                    WHERE 
                        ID_PRODUCTO = :id";
        $stmt = $this->conn->prepare($query);

        //Limpiar los datos
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->marca = htmlspecialchars(strip_tags($this->marca));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->imagen = htmlspecialchars(strip_tags($this->imagen));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        
        //Relacionar los datos
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':marca', $this->marca);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':imagen', $this->imagen);
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
}