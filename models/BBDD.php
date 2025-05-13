<?php


class BBDD
{

    private $cadenaConexion = 'mysql:dbname=tfg;host=localhost';
    private $usuario = 'root';
    private $password = '';

    public $db;

    public function __construct()
    {

        try {
            $this->db = new PDO($this->cadenaConexion, $this->usuario, $this->password);
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }

    function insertarUsuario($email, $nombre, $contrasena, $id = null)
    {

        $sql = "INSERT INTO `usuario` "
            . "(`id_usuario`, `email`, `nombre`, `contrasena`)"
            . " VALUES (:id, :email, :nombre, :contrasena)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id,
            ':email' => $email,
            ':nombre' => $nombre,
            ':contrasena' => $contrasena
        ]);

        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    function actualizarUsuario()
    {

        $sql = "UPDATE usuario SET email = :email WHERE id_usuario = 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'email' => "armandojaleo@yahoo.es"
        ]);

        if ($stmt) {
            echo "Se ha actualizado correctamente";
        } else {
            echo "Se ha roto";
        }
    }

    function eliminarUsuario()
    {

        $sql = "DELETE FROM usuario WHERE id_usuario = 13 ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute();

        if ($stmt) {
            echo "Se ha actualizado correctamente";
        } else {
            echo "Se ha roto";
        }
    }

    function getProductos()
    {

        $sql = "SELECT * FROM `producto`";

        $productos = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        return $productos;
    }

    function getOneProduct($id)
    {

        $sql = "SELECT * FROM `producto` WHERE id_producto = $id";

        $producto = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        return $producto;
    }

    function eliminarProducto($id)
    {

        $sql = "DELETE FROM producto WHERE id_producto = $id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute();

        if ($stmt) {
            echo "Se ha actualizado correctamente";
        } else {
            echo "Se ha roto";
        }
    }

    function insertarProducto($nombre, $imagen)
    {

        $sql = "INSERT INTO `producto` "
            . "(`nombre`, `imagen_path`)"
            . " VALUES (:nombre,:imagen_path)";

        // La preparamos

        $stmt = $this->db->prepare($sql);

        // Lo ejecutamos. Igualamos las referencias de la query con los parámetros

        $stmt->execute([
            ':nombre' => $nombre,
            ':imagen_path' => $imagen
        ]);

        if ($stmt) {
            echo "Se ha actualizado correctamente";
        } else {
            echo "Se ha roto";
        }
    }

    function editarProducto($id, $nombre, $imagen)
    {

        $sql = "UPDATE producto SET nombre = :nombre, imagen_path = :imagen_path WHERE id_producto = :id";

        // La preparamos

        $stmt = $this->db->prepare($sql);

        // Lo ejecutamos. Igualamos las referencias de la query con los parámetros

        $stmt->execute([
            ':id' => $id,
            ':nombre' => $nombre,
            ':imagen_path' => $imagen
        ]);

        if ($stmt) {
            echo "Se ha actualizado correctamente";
        } else {
            echo "Se ha roto";
        }
    }


    public function getProductosFiltrados($nombre = '', $categoria = '', $precioMax = '')
    {
        $sql = "SELECT id, nombre, imagen FROM productosPrueba WHERE 1=1";
        $params = [];

        if (!empty($nombre)) {
            $sql .= " AND nombre LIKE ?";
            $params[] = '%' . $nombre . '%';
        }

        if (!empty($categoria)) {
            $sql .= " AND categoria = ?";
            $params[] = $categoria;
        }

        if (!empty($precioMax)) {
            $sql .= " AND precio <= ?";
            $params[] = $precioMax;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getCategorias()
    {
        $sql = "SELECT DISTINCT categoria FROM productosPrueba WHERE categoria IS NOT NULL AND categoria != ''";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $categorias = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categorias[] = $row['categoria'];
        }

        return $categorias;
    }
}
