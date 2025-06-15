<?php

namespace controllers;

/**
 * Controlador para añadir o quitar un anuncio de los favoritos del usuario (AJAX).
 *
 * Este script:
 * - Verifica que el usuario haya iniciado sesión.
 * - Recibe el ID del anuncio por POST.
 * - Instancia los facades necesarios para anuncios y favoritos.
 * - Obtiene la lista de favoritos actual del usuario y la guarda en la sesión.
 * - Determina si el anuncio ya es favorito:
 *     - Si es favorito, lo elimina de favoritos.
 *     - Si no es favorito, lo añade a favoritos.
 * - Actualiza la lista de favoritos en la sesión.
 * - Devuelve una respuesta JSON con el nuevo estado de favorito.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use facades\AdvertFacade;
use facades\FavoritesFacade;
use converters\AdvertConverter;
use converters\PropertyConverter;
use converters\AddressConverter;
use converters\FavoritesConverter;

session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user'])) {
    echo json_encode(['redirect' => '/login']);
    exit;
}

$userId = $_SESSION['user']->id;
$advertId = $_POST['advert_id'] ?? null;

// Instanciar los facades necesarios
$advertFacade = new AdvertFacade(
    new AdvertConverter(),
    new PropertyConverter(),
    new AddressConverter()
);
$favoritesFacade = new FavoritesFacade(new FavoritesConverter());

// Obtener y guardar los IDs de los anuncios favoritos del usuario en la sesión
$_SESSION['userFavoriteIds'] = array_map(function ($fav) {
    return is_object($fav) ? $fav->advert_id : $fav['advert_id'];
}, $favoritesFacade->getFavoritesByUserId($userId));

// Obtener y guardar los anuncios favoritos completos en la sesión
$_SESSION['userFavorites'] = [];
foreach ($_SESSION['userFavoriteIds'] as $favAdvertId) {
    if (is_numeric($favAdvertId)) {
        $_SESSION['userFavorites'][] = $advertFacade->getAdvertById($favAdvertId);
    }
}

// Comprobar si el anuncio ya es favorito
$isFavorite = in_array($advertId, $_SESSION['userFavoriteIds'] ?? []);

// Añadir o quitar el favorito según corresponda
if ($isFavorite) {
    $favoritesFacade->removeFavorite($userId, $advertId);
} else {
    $favoritesFacade->addFavorite($userId, $advertId);
}

// Actualizar la lista de favoritos en la sesión tras el cambio
$_SESSION['userFavoriteIds'] = array_map(function ($fav) {
    return is_object($fav) ? $fav->advert_id : $fav['advert_id'];
}, $favoritesFacade->getFavoritesByUserId($userId));

// Devolver respuesta JSON con el nuevo estado de favorito
echo json_encode([
    'success' => true,
    'is_favorite' => !$isFavorite
]);
