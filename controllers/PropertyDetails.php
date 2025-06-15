<?php

namespace controllers;

/**
 * Controlador para mostrar los detalles de una propiedad.
 *
 * Este script:
 * - Recibe el ID de la propiedad por GET.
 * - Recupera los datos completos de la propiedad y los anuncios asociados.
 * - Si no encuentra la propiedad, redirige a una página de mensaje de error.
 * - Carga la vista 'property-details.php' con los datos obtenidos.
 */

require_once __DIR__ . '/../vendor/autoload.php';

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

session_start();

// Validar que se recibe un ID de propiedad válido por GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['message'] = 'Propiedad no encontrada.';
    header('Location: /message');
    exit();
}

// Instanciar los facades y converters necesarios
$propertyConverter = new PropertyConverter();
$advertFacade = new AdvertFacade(new AdvertConverter(), $propertyConverter, new AddressConverter());
$propertyFacade = new PropertyFacade(
    $propertyConverter,
    new RoomConverter(),
    new StudioConverter(),
    new ApartmentConverter(),
    new HouseConverter(),
    new AddressConverter(),
    new ImageConverter()
);

// Obtener los datos completos de la propiedad
$propertyDto = $propertyFacade->getCompletePropertyById($_GET['id']);

// Si no existe la propiedad, mostrar mensaje de error
if (!$propertyDto) {
    $_SESSION['message'] = 'Propiedad no encontrada.';
    header('Location: /message');
    exit();
}

// Preparar datos para la vista
$title = $propertyDto->property_id . ' - ' . $propertyDto->property_type . ' en ' . $propertyDto->address->city;
$numAdverts = count($advertFacade->getAdvertsByPropertyId($_GET['id']));

// Cargar la vista de detalles de la propiedad
require __DIR__ . '/../views/property-details.php';