<?php
/**
 * Controlador AJAX para alternar el estado de favorito de un anuncio para el usuario actual.
 *
 * - Si el usuario no está autenticado, redirige a /login.
 * - Si el anuncio ya es favorito, lo elimina de favoritos.
 * - Si no es favorito, lo añade a favoritos.
 * - Actualiza la lista de IDs de favoritos en la sesión.
 * - Devuelve un JSON con el nuevo estado.
 */

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use facades\AdvertFacade;
use facades\FavoritesFacade;
use converters\AdvertConverter;
use converters\PropertyConverter;
use converters\AddressConverter;
use converters\FavoritesConverter;

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user'])) {
    echo json_encode(['redirect' => '/login']);
    exit;
}

$userId = $_SESSION['user']->id;
$advertId = $_POST['advert_id'] ?? null;

$advertFacade = new AdvertFacade(
    new AdvertConverter(),
    new PropertyConverter(),
    new AddressConverter()
);
$favoritesFacade = new FavoritesFacade(new FavoritesConverter());

// Obtiene y guarda en sesión los IDs de anuncios favoritos del usuario
$_SESSION['userFavoriteIds'] = array_map(function($fav) {
    return is_object($fav) ? $fav->advert_id : $fav['advert_id'];
}, $favoritesFacade->getFavoritesByUserId($userId)); // extraer los id de los favoritos

$_SESSION['userFavorites'] = [];
// Carga los anuncios favoritos en la sesión
foreach ($_SESSION['userFavoriteIds'] as $favAdvertId) {
    if (is_numeric($favAdvertId)) {
        $_SESSION['userFavorites'][] = $advertFacade->getAdvertById($favAdvertId);
    }
}


// Comprueba si el anuncio ya es favorito
$isFavorite = in_array($advertId, $_SESSION['userFavoriteIds'] ?? []);

// Alterna el estado de favorito
if ($isFavorite) {
    $favoritesFacade->removeFavorite($userId, $advertId);
} else {
    $favoritesFacade->addFavorite($userId, $advertId);
}

// Actualiza la lista de favoritos en sesión tras el cambio
$_SESSION['userFavoriteIds'] = array_map(function($fav) {
    return is_object($fav) ? $fav->advert_id : $fav['advert_id'];
}, $favoritesFacade->getFavoritesByUserId($userId));

// Devuelve el resultado en JSON
echo json_encode([
    'success' => true,
    'is_favorite' => !$isFavorite
]);
