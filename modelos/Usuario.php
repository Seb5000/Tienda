<?php
class Usuario{
    // variables base de datos
    private $conn;

    //Atributos Producto
    public $idUsuario;
    public $usuario;
    public $email;
    private $password;

    //El constructor de la clase
    public function __construct($bd){
        $this->conn = $bd;
    }

    public function obtenerUsuario($mailUid){
        $query = "SELECT * FROM USUARIOS WHERE UID_USUARIO = :idu OR EMAIL_USUARIO = :idu";
        $stmt = $this->conn->prepare($query);
        $mailUid = htmlspecialchars(strip_tags($mailUid));
        $stmt->bindParam(':idu', $mailUid);
        if($stmt->execute()){
            if($resultado = $stmt->fetch(PDO::FETCH_ASSOC)){
                $this->idUsuario = $resultado["ID_USUARIO"];
                $this->usuario = $resultado["UID_USUARIO"];
                $this->email = $resultado["EMAIL_USUARIO"];
                $this->password = $resultado["PASSWORD_USUARIO"];
                return true;
            }
        }
        return false;
    }

    public function verificarPassword($password){
        $pwdCheck = password_verify($password, $this->password);
        if($pwdCheck == true){
            return true;
        }
        return false;
    }

    public function crearUsuario($uid, $email, $password){
        $query = "INSERT INTO USUARIOS (UID_USUARIO, EMAIL_USUARIO, PASSWORD_USUARIO) VALUES (:idu, :email, :pwd)";
        $stmt = $this->conn->prepare($query);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':idu', $uid);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pwd', $hashedPassword);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}