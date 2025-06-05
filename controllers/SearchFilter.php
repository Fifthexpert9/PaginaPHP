<?php
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use facades\AdvertFacade;
use converters\AdvertConverter;
use converters\PropertyConverter;
use converters\AddressConverter;

$advertFacade = new AdvertFacade(
    new AdvertConverter(),
    new PropertyConverter(),
    new AddressConverter()
);

// Recoger filtros del formulario
$filters = [];
if (!empty($_GET['action'])) {
    $filters['action'] = $_GET['action'];
}
if (!empty($_GET['property_types'])) {
    $filters['property_types'] = $_GET['property_types'];
}
if (!empty($_GET['price'])) {
    $filters['advert_price_max'] = $_GET['price'];
}
if (!empty($_GET['city'])) {
    $filters['city'] = $_GET['city'];
}
if (!empty($_GET['province'])) {
    $filters['province'] = $_GET['province'];
}
if (isset($_GET['immediate_availability']) && $_GET['immediate_availability'] !== '') {
    $filters['immediate_availability'] = $_GET['immediate_availability'];
}
if (!empty($_GET['status'])) {
    $filters['status'] = $_GET['status'];
}

// Obtener anuncios filtrados o todos si no hay filtros
if (!empty($filters)) {
    $adverts = $advertFacade->searchAdverts($filters);
    if (is_string($adverts)) {
        $adverts = [];
    }
} else {
    $adverts = $advertFacade->getAllAdverts();
}