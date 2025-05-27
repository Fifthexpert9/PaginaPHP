<?php

// index.php

$method = $_SERVER["REQUEST_METHOD"];

// Obtener la URL solicitada
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

try{
    switch ($method) {
        case 'GET':

            switch ($request) {
                case '/':
                    require 'views/home.php';
                    break;
                case '/message':
                    require 'views/message.php';
                    break;
                case '/login':
                    require 'views/login.php';
                    break;
                case '/register':
                    require 'views/register.php';
                    break;
                case '/new-advert':
                    require 'views/new-advert.php';
                    break;
                case '/favorites':
                    require 'views/favorites.php';
                    break;
                case '/about':
                    require 'views/about.php';
                    break;
                case '/logout':
                    require 'controllers/logout.php';
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