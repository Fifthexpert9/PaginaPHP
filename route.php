<?php

// index.php

$method = $_SERVER["REQUEST_METHOD"];

// Obtener la URL solicitada
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Ejemplo de enrutamiento básico con switch

try{
    switch ($method) {
        case 'GET':

            switch ($request) {
                case '/':
                    require 'views/home.php';
                    break;
                case '/productos':
                    require 'views/productos.php';
                    break;
                case '/login':
                    require 'views/inicioSesion.php';
                    break;
                case '/register':
                    require 'views/registro.php';
                    break;
                case '/agregarProducto':
                    require 'views/agregarProducto.php';
                    break;
                case '/editarProducto':
                    require 'views/editarProducto.php';
                    break;
                case '/about':
                    require 'views/about.php';
                    break;
                case '/contact':
                    require 'views/contact.php';
                    break;
                default:
                    http_response_code(404);
                    require 'views/home.php';
                    break;
            }

            break;

        case 'POST':
            case '/editarProductoControl':
                require 'controllers/controlEditar.php';
            break;

        default:
            echo "Error, método no permitido";
            break;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}