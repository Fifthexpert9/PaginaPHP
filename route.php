<?php

$method = $_SERVER["REQUEST_METHOD"];

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

try {
    switch ($method) {
        case 'GET':
            switch ($request) {
                case '/':
                    require 'views/home.php';
                    break;
                case '/property-details':
                    require 'controllers/PropertyDetails.php';
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
                case '/manager':
                    require 'views/manager.php';
                    break;
                case '/new-property':
                    require 'views/new-property.php';
                    break;
                case '/new-advert':
                    require 'views/new-advert.php';
                    break;
                case '/favorites':
                    require 'views/favorites.php';
                    break;
                case '/user-menu':
                    require 'views/user-menu.php';
                    break;
                case '/my-properties':
                    require 'views/my-properties.php';
                    break;
                case '/delete-property':
                    require 'controllers/DeleteProperty.php';
                    break;
                case '/my-adverts':
                    require 'views/my-adverts.php';
                    break;
                case '/edit-profile':
                    require 'views/edit-profile.php';
                    break;
                case '/delete-account':
                    require 'controllers/DeleteAccount.php';
                    break;
                case '/terms-of-use':
                    require 'views/terms-of-use.php';
                    break;
                case '/privacy-policy':
                    require 'views/privacy-policy.php';
                    break;
                case '/about':
                    require 'views/about.php';
                    break;
                case '/logout':
                    session_start();
                    session_unset();
                    session_destroy();
                    session_start();
                    $_SESSION['message'] = "Has cerrado sesión correctamente.";
                    header("Location: /message");
                    break;
                default:
                    http_response_code(404);
                    require 'views/home.php';
                    break;
            }

            break;

        case 'POST':
            switch ($request) {
                case '/delete-property':
                    require 'controllers/DeleteProperty.php';
                    break;
                case '/delete-advert':
                    require 'controllers/DeleteAdvert.php';
                    break;
                default:
                    echo "Error, ruta POST no permitida";
                    break;
            }

        default:
            echo "Error, método no permitido";
            break;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
