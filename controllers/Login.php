<?php

namespace controllers;

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

$userFacade = new UserFacade(new UserConverter());
$advertFacade = new AdvertFacade(
    new AdvertConverter(),
    new PropertyConverter(),
    new AddressConverter()
);
$favoritesFacade = new FavoritesFacade(new FavoritesConverter());

$result = $userFacade->userLogin($_POST['email'], $_POST['password']);

if (!empty($result['success']) && $result['success']) {
    $_SESSION['user'] = $result['user'];
    $_SESSION['logged'] = true;
    $_SESSION['message'] = $result['message'];

    $_SESSION['userFavoriteIds'] = array_map(function ($fav) {
        return is_object($fav) ? $fav->advert_id : $fav['advert_id'];
    }, $favoritesFacade->getFavoritesByUserId($_SESSION['user']->id)); // extraer los id de los favoritos

    $_SESSION['userFavorites'] = [];
    foreach ($_SESSION['userFavoriteIds'] as $favAdvertId) {
        if (is_numeric($favAdvertId)) {
            $_SESSION['userFavorites'][] = $advertFacade->getAdvertById($favAdvertId);
        }
    }
} else {
    $_SESSION['logged'] = false;
    $_SESSION['message'] = $result['message'];
}

header('Location: /message');
exit();
