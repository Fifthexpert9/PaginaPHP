<?php
require_once 'models/BBDD.php';
require_once 'models/producto.php';

class ProductoController {


    public function getProductos() {

        $db = new BBDD();

        $productosDB = $db->getProductos();
        $productos = [];
        
        foreach($productosDB as $prod) {
            $productos[] = new Producto(
                $prod['id_producto'],
                $prod['nombre'],
                $prod['imagen_path']
            );
        }
        
        return $productos;
    }

    public function getOneProduct($id){
        
        $db = new BBDD();
        
        $productoDB = $db->getOneProduct($id);
        
        $producto = new Producto(
            $productoDB[0]['id_producto'],
            $productoDB[0]['nombre'],
            $productoDB[0]['imagen_path']
        );
        
        return $producto;
    }


    public function getProductosFiltrados($nombre = '', $categoria = '', $precioMax = '')
    {
        // Conectarse a la base de datos
        $conexion = Database::connect();
        $sql = "SELECT * FROM productos WHERE 1=1";

        if (!empty($nombre)) {
            $sql .= " AND nombre LIKE '%" . $conexion->real_escape_string($nombre) . "%'";
        }

        if (!empty($categoria)) {
            $sql .= " AND categoria LIKE '%" . $conexion->real_escape_string($categoria) . "%'";
        }

        if (!empty($precioMax)) {
            $sql .= " AND precio <= " . floatval($precioMax);
        }

        $result = $conexion->query($sql);
        $productos = [];

        while ($row = $result->fetch_object('Producto')) {
            $productos[] = $row;
        }

        return $productos;
    }

}