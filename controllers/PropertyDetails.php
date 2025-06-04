<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

use facades\AdvertFacade;
use facades\PropertyFacade;
use facades\ImageFacade;
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
$imageConverter = new ImageConverter();
$imageFacade = new ImageFacade($imageConverter);
$advertFacade = new AdvertFacade($imageFacade, new AdvertConverter(), $propertyConverter, $imageConverter);
$imageFacade->setAdvertFacade($advertFacade);
$propertyFacade = new PropertyFacade($imageFacade, $propertyConverter, new RoomConverter(), new StudioConverter(), new ApartmentConverter(), new HouseConverter(), new AddressConverter());

$advertAux = $advertFacade->getAdvertById($_GET['id']);

if (!$advertAux) {
    $_SESSION['message'] = 'Anuncio no encontrado.';
    header('Location: /message');
    exit();
}

$auxImgs = $imageFacade->getImagesByAdvertId($_GET['id']);

$title = $advertAux['title'] ?? 'Detalles del Anuncio';
$advertDTO = $advertAux['advert'] ?? null;
$propertyDTO = $propertyFacade->getCompletePropertyById($advertDTO->property_id ?? null);

require __DIR__ . '/../views/property-details.php';