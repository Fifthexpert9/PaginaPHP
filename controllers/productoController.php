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
        $db = new BBDD();

        $productosDB = $db->getProductosFiltrados($nombre, $categoria, $precioMax);
        $productos = [];

        foreach ($productosDB as $prod) {
            $productos[] = new Producto(
                $prod['id_producto'],
                $prod['nombre'],
                $prod['imagen_path']
            );
        }

        return $productos;
    }

    public function getCategoriasDisponibles()
    {
        $db = new BBDD();

        return $db->getCategorias();
    }


}