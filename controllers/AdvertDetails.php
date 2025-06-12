<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';

use facades\AdvertFacade;
use facades\PropertyFacade;
use facades\UserFacade;
use converters\AdvertConverter;
use converters\PropertyConverter;
use converters\RoomConverter;
use converters\StudioConverter;
use converters\ApartmentConverter;
use converters\HouseConverter;
use converters\AddressConverter;
use converters\ImageConverter;
use converters\UserConverter;

session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['message'] = 'Anuncio no encontrado.';
    header('Location: /message');
    exit();
}

$propertyConverter = new PropertyConverter();
$advertFacade = new AdvertFacade(new AdvertConverter(), $propertyConverter, new AddressConverter());
$propertyFacade = new PropertyFacade($propertyConverter, new RoomConverter(), new StudioConverter(), new ApartmentConverter(), new HouseConverter(), new AddressConverter(), new ImageConverter());
$userFacade = new UserFacade(new UserConverter(new AdvertFacade(new AdvertConverter(), new PropertyConverter(), new AddressConverter())));

$advertAux = $advertFacade->getAdvertById($_GET['id']);

if (!$advertAux) {
    $_SESSION['message'] = 'Anuncio no encontrado.';
    header('Location: /message');
    exit();
}

$title = $advertAux['title'] ?? 'Detalles del Anuncio';
$advertDto = $advertAux['advert'] ?? null;
$propertyDto = $propertyFacade->getCompletePropertyById($advertDto->property_id ?? null);
$propietaryUsername = $userFacade->getUserById($advertDto->user_id ?? null) ? $userFacade->getUserById($advertDto->user_id ?? null)->username : 'usuario no existente';

require __DIR__ . '/../views/advert-details.php';
