<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';


use facades\AdvertFacade;
use facades\FavoritesFacade;
use converters\AdvertConverter;
use converters\PropertyConverter;
use converters\AddressConverter;
use converters\FavoritesConverter;

session_start();

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

$_SESSION['userFavoriteIds'] = array_map(function ($fav) {
    return is_object($fav) ? $fav->advert_id : $fav['advert_id'];
}, $favoritesFacade->getFavoritesByUserId($userId)); // extraer los id de los favoritos

$_SESSION['userFavorites'] = [];
foreach ($_SESSION['userFavoriteIds'] as $favAdvertId) {
    if (is_numeric($favAdvertId)) {
        $_SESSION['userFavorites'][] = $advertFacade->getAdvertById($favAdvertId);
    }
}


$isFavorite = in_array($advertId, $_SESSION['userFavoriteIds'] ?? []);

if ($isFavorite) {
    $favoritesFacade->removeFavorite($userId, $advertId);
} else {
    $favoritesFacade->addFavorite($userId, $advertId);
}

$_SESSION['userFavoriteIds'] = array_map(function ($fav) {
    return is_object($fav) ? $fav->advert_id : $fav['advert_id'];
}, $favoritesFacade->getFavoritesByUserId($userId));

echo json_encode([
    'success' => true,
    'is_favorite' => !$isFavorite
]);
