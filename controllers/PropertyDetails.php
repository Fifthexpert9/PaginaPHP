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
    $_SESSION['message'] = 'Propiedad no encontrada.';
    header('Location: /message');
    exit();
}

$propertyConverter = new PropertyConverter();
$advertFacade = new AdvertFacade(new AdvertConverter(), $propertyConverter, new AddressConverter());
$propertyFacade = new PropertyFacade($propertyConverter, new RoomConverter(), new StudioConverter(), new ApartmentConverter(), new HouseConverter(), new AddressConverter(), new ImageConverter());

$propertyDto = $propertyFacade->getCompletePropertyById($_GET['id']);

if (!$propertyDto) {
    $_SESSION['message'] = 'Propiedad no encontrada.';
    header('Location: /message');
    exit();
}

$title = $propertyDto->property_id . ' - ' . $propertyDto->property_type . ' en ' . $propertyDto->address->city;
$numAdverts = count($advertFacade->getAdvertsByPropertyId($_GET['id']));

require __DIR__ . '/../views/property-details.php';
