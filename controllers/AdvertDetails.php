<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

use facades\AdvertFacade;
use facades\PropertyFacade;
use converters\AdvertConverter;
use converters\PropertyConverter;
use converters\RoomConverter;
use converters\StudioConverter;
use converters\ApartmentConverter;
use converters\HouseConverter;
use converters\AddressConverter;
use converters\ImageConverter;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['message'] = 'Anuncio no encontrado.';
    header('Location: /message');
    exit();
}

$propertyConverter = new PropertyConverter();
$advertFacade = new AdvertFacade(new AdvertConverter(), $propertyConverter);
$propertyFacade = new PropertyFacade($propertyConverter, new RoomConverter(), new StudioConverter(), new ApartmentConverter(), new HouseConverter(), new AddressConverter(), new ImageConverter());

$advertAux = $advertFacade->getAdvertById($_GET['id']);

if (!$advertAux) {
    $_SESSION['message'] = 'Anuncio no encontrado.';
    header('Location: /message');
    exit();
}

$title = $advertAux['title'] ?? 'Detalles del Anuncio';
$advertDto = $advertAux['advert'] ?? null;
$propertyDto = $propertyFacade->getCompletePropertyById($advertDto->property_id ?? null);

require __DIR__ . '/../views/advert-details.php';
