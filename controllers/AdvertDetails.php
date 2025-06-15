<?php

namespace controllers;

/**
 * Controlador para mostrar los detalles de un anuncio.
 *
 * Este script:
 * - Recibe el ID del anuncio por GET.
 * - Recupera los datos completos del anuncio, la propiedad asociada y el usuario propietario.
 * - Si no encuentra el anuncio, redirige a una página de mensaje de error.
 * - Carga la vista 'advert-details.php' con los datos obtenidos.
 */

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

// Validar que se recibe un ID de anuncio válido por GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['message'] = 'Anuncio no encontrado.';
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
$userFacade = new UserFacade(
    new UserConverter(
        new AdvertFacade(new AdvertConverter(), new PropertyConverter(), new AddressConverter())
    )
);

// Obtener los datos del anuncio
$advertAux = $advertFacade->getAdvertById($_GET['id']);

// Si no existe el anuncio, mostrar mensaje de error
if (!$advertAux) {
    $_SESSION['message'] = 'Anuncio no encontrado.';
    header('Location: /message');
    exit();
}

// Preparar datos para la vista
$title = $advertAux['title'] ?? 'Detalles del Anuncio';
$advertDto = $advertAux['advert'] ?? null;
$propertyDto = $propertyFacade->getCompletePropertyById($advertDto->property_id ?? null);
$propietaryUsername = $userFacade->getUserById($advertDto->user_id ?? null)
    ? $userFacade->getUserById($advertDto->user_id ?? null)->username
    : 'usuario no existente';

// Cargar la vista de detalles del anuncio
require __DIR__ . '/../views/advert-details.php';
