<?php


class BBDD {
    
    private $cadenaConexion = 'mysql:dbname=examen1eval;host=localhost';
    private $usuario = 'root' ;
    private $password = '' ;
    
    public $db ;

    public function __construct() {
        
        try
        {
            $this->db = new PDO($this->cadenaConexion, $this->usuario, $this->password) ;
//            echo "La conexión se ha realizado correctamente";
            
        } catch (Exception $ex) {
            
            echo $ex->getMessage() ;
        }
    }
    
    function getIdiomas() {
        
        $sql = "SELECT * FROM `idioma`" ;
        
        $idiomas = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC) ;
        
        return $idiomas;
    }

    function getEmail($email){
        
        $sql = "SELECT * FROM `usuario` WHERE email = '$email'" ;	
        
        $email = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC) ;
        
        return $email;
    }

    function getUserByEmail($email){
        $sql = "SELECT nombre, email, contrasena FROM usuario WHERE email = ?" ;	
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            return [
                'nombre' => $user['nombre'],
                'email' => $user['email'],
                'contrasena' => $user['contrasena']
            ];
        }
        
        return null;
    }   
    
    function getUsuarios() {
        
        $sql = "SELECT * FROM `usuario`" ;
        
        $usuarios = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC) ;
        
        return $usuarios;
    }
    
    function insertarUsuario($email, $nombre, $contrasena, $id=null) {
        
        // Hacemos la query
        
        $sql = "INSERT INTO `usuario` "
                . "(`id_usuario`, `email`, `nombre`, `contrasena`)"
                . " VALUES (:id, :email, :nombre, :contrasena)" ;
        
        // La preparamos
        
        $stmt = $this->db->prepare($sql) ;
        
        // Lo ejecutamos. Igualamos las referencias de la query con los parámetros
        
        $stmt->execute([
            
            ':id' => $id,
            ':email' => $email,
            ':nombre' => $nombre,
            ':contrasena' => $contrasena
        ]) ;
        
        if($stmt)
        {
            return true ;
        }
        else
        {
            return false ;
        }
        
    }
    
    function actualizarUsuario() {
        
        // Hacemos la query
        
        $sql = "UPDATE usuario SET email = :email WHERE id_usuario = 1";
        
        // La preparamos
        
        $stmt = $this->db->prepare($sql) ;
        
        // Lo ejecutamos. Igualamos las referencias de la query con los parámetros
        
        $stmt->execute([
            
            'email' => "armandojaleo@yahoo.es"
        ]) ;
        
        if($stmt)
        {
            echo "Se ha actualizado correctamente" ;
        }
        else
        {
            echo "Se ha roto" ;
        }
        
    }
    
    function eliminarUsuario() {
        
        // Hacemos la query
        
        $sql = "DELETE FROM usuario WHERE id_usuario = 13 ";
        
        // La preparamos
        
        $stmt = $this->db->prepare($sql) ;
        
        // Lo ejecutamos. Igualamos las referencias de la query con los parámetros
        
        $stmt->execute() ;
        
        if($stmt)
        {
            echo "Se ha actualizado correctamente" ;
        }
        else
        {
            echo "Se ha roto" ;
        }
        
    }

    function getProductos() {
        
        $sql = "SELECT * FROM `producto`" ;
        
        $productos = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC) ;
        
        return $productos;
    }  

    function getOneProduct($id){
        
        $sql = "SELECT * FROM `producto` WHERE id_producto = $id" ;
        
        $producto = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC) ;
        
        return $producto;
    }

    function eliminarProducto($id){
        
        $sql = "DELETE FROM producto WHERE id_producto = $id";
        
        $stmt = $this->db->prepare($sql) ;
        
        $stmt->execute() ;
        
        if($stmt)
        {
            echo "Se ha actualizado correctamente" ;
        }
        else
        {
            echo "Se ha roto" ;
        }
    }

    function insertarProducto($nombre, $imagen){

        $sql = "INSERT INTO `producto` "
                . "(`nombre`, `imagen_path`)"
                . " VALUES (:nombre,:imagen_path)" ;
        
        // La preparamos
        
        $stmt = $this->db->prepare($sql) ;
        
        // Lo ejecutamos. Igualamos las referencias de la query con los parámetros
        
        $stmt->execute([
            ':nombre' => $nombre,
            ':imagen_path' => $imagen
        ]) ;
        
        if($stmt)
        {
            echo "Se ha actualizado correctamente" ;
        }
        else
        {
            echo "Se ha roto" ;
        }

    }

    function editarProducto($id, $nombre, $imagen){
        
        $sql = "UPDATE producto SET nombre = :nombre, imagen_path = :imagen_path WHERE id_producto = :id";
        
        // La preparamos
        
        $stmt = $this->db->prepare($sql) ;
        
        // Lo ejecutamos. Igualamos las referencias de la query con los parámetros
        
        $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':imagen_path' => $imagen
        ]) ;
        
        if($stmt)
        {
            echo "Se ha actualizado correctamente" ;
        }
        else
        {
            echo "Se ha roto" ;
        }
    }
}


 