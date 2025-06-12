<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';

use facades\AdvertFacade;
use converters\PropertyConverter;
use converters\AdvertConverter;
use converters\AddressConverter;

session_start();

$advertFacade = new AdvertFacade(
    new AdvertConverter(),
    new PropertyConverter(),
    new AddressConverter()
);

$advert_id = $_POST['id'];
$result = $advertFacade->deleteAdvert($advert_id);

if ($result) {
    $_SESSION['message'] = 'El anuncio ha sido eliminado correctamente.';
    header('Location: /message');
    exit();
} else {
    $_SESSION['message'] = 'No se pudo eliminar el anuncio. Por favor, inténtalo de nuevo más tarde.';
    header('Location: /message');
    exit();
}
