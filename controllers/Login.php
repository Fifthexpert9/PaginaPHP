<?php

namespace controllers;

/**
 * Controlador para gestionar el inicio de sesión de usuario.
 *
 * Este script:
 * - Recibe los datos del formulario de login por POST (email y contraseña).
 * - Instancia los facades necesarios para usuarios, anuncios y favoritos.
 * - Llama al método userLogin del UserFacade para autenticar al usuario.
 * - Si el login es exitoso:
 *     - Guarda el usuario, el estado de login y el mensaje en la sesión.
 *     - Obtiene los IDs de los anuncios favoritos del usuario y los guarda en la sesión.
 *     - Obtiene los anuncios favoritos completos y los guarda en la sesión.
 * - Si el login falla:
 *     - Guarda el estado de login como falso y el mensaje de error en la sesión.
 * - Redirige a la página de mensaje tras la operación.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use facades\UserFacade;
use facades\AdvertFacade;
use facades\FavoritesFacade;
use converters\UserConverter;
use converters\PropertyConverter;
use converters\AdvertConverter;
use converters\AddressConverter;
use converters\FavoritesConverter;

session_start();

// Instanciar los facades necesarios
$userFacade = new UserFacade(new UserConverter());
$advertFacade = new AdvertFacade(
    new AdvertConverter(),
    new PropertyConverter(),
    new AddressConverter()
);
$favoritesFacade = new FavoritesFacade(new FavoritesConverter());

// Intentar iniciar sesión con los datos recibidos por POST
$result = $userFacade->userLogin($_POST['email'], $_POST['password']);

if (!empty($result['success']) && $result['success']) {
    // Login exitoso: guardar usuario y estado en la sesión
    $_SESSION['user'] = $result['user'];
    $_SESSION['logged'] = true;
    $_SESSION['message'] = $result['message'];

    // Obtener y guardar los IDs de los anuncios favoritos del usuario
    $_SESSION['userFavoriteIds'] = array_map(function ($fav) {
        return is_object($fav) ? $fav->advert_id : $fav['advert_id'];
    }, $favoritesFacade->getFavoritesByUserId($_SESSION['user']->id)); // extraer los id de los favoritos

    // Obtener y guardar los anuncios favoritos completos
    $_SESSION['userFavorites'] = [];
    foreach ($_SESSION['userFavoriteIds'] as $favAdvertId) {
        if (is_numeric($favAdvertId)) {
            $_SESSION['userFavorites'][] = $advertFacade->getAdvertById($favAdvertId);
        }
    }
} else {
    // Login fallido: guardar estado y mensaje de error en la sesión
    $_SESSION['logged'] = false;
    $_SESSION['message'] = $result['message'];
}

// Redirigir a la página de mensaje
header('Location: /message');
exit();
