<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';

use facades\PropertyFacade;
use converters\PropertyConverter;
use converters\RoomConverter;
use converters\StudioConverter;
use converters\ApartmentConverter;
use converters\HouseConverter;
use converters\AddressConverter;
use converters\ImageConverter;
use facades\AddressFacade;

session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user']->id)) {
    $_SESSION['message'] = 'Debes iniciar sesión para editar una propiedad.';
    header('Location: /message');
    exit();
}

try {
    $propertyFacade = new PropertyFacade(
        new PropertyConverter(),
        new RoomConverter(),
        new StudioConverter(),
        new ApartmentConverter(),
        new HouseConverter(),
        new AddressConverter(),
        new ImageConverter()
    );
    $addressFacade = new AddressFacade(new AddressConverter());


    $propertyId = $_POST['id'] ?? null;
    if (!$propertyId) {
        throw new \Exception('ID de propiedad no especificado.');
    }

    // 1. Actualizar dirección
    $addressFields = [
        'street' => $_POST['street'] ?? '',
        'city' => $_POST['city'] ?? '',
        'province' => $_POST['province'] ?? '',
        'postal_code' => $_POST['postal_code'] ?? '',
        'country' => $_POST['country'] ?? ''
    ];

    $addressDto = $addressFacade->getAddressByPropertyId($propertyId);
    if ($addressDto) {
        $addressFacade->updateAddress($addressDto->id, $addressFields);
    }

    // 2. Actualizar datos genéricos de la propiedad
    $propertyFields = [
        'built_size' => $_POST['built_size'] ?? '',
        'status' => $_POST['status'] ?? '',
        'immediate_availability' => isset($_POST['immediate_availability']) ? intval($_POST['immediate_availability']) : 0
    ];

    // 3. Actualizar datos específicos según tipo
    $propertyType = $_POST['property_type'] ?? '';
    $specificFields = [];
    switch ($propertyType) {
        case 'Habitación':
            $specificFields = [
                'private_bathroom' => isset($_POST['private_bathroom']) ? intval($_POST['private_bathroom']) : 0,
                'max_roommates' => $_POST['max_roommates'] ?? '',
                'pets_allowed' => isset($_POST['pets_allowed']) ? intval($_POST['pets_allowed']) : 0,
                'furnished' => isset($_POST['furnished']) ? intval($_POST['furnished']) : 0,
                'students_only' => isset($_POST['students_only']) ? intval($_POST['students_only']) : 0,
                'gender_restriction' => $_POST['gender_restriction'] ?? ''
            ];
            break;
        case 'Estudio':
            $specificFields = [
                'furnished' => isset($_POST['furnished']) ? intval($_POST['furnished']) : 0,
                'balcony' => isset($_POST['balcony']) ? intval($_POST['balcony']) : 0,
                'air_conditioning' => isset($_POST['air_conditioning']) ? intval($_POST['air_conditioning']) : 0,
                'pets_allowed' => isset($_POST['pets_allowed']) ? intval($_POST['pets_allowed']) : 0
            ];
            break;
        case 'Piso':
            $specificFields = [
                'apartment_type' => $_POST['apartment_type'] ?? '',
                'num_rooms' => $_POST['num_rooms'] ?? '',
                'num_bathrooms' => $_POST['num_bathrooms'] ?? '',
                'furnished' => isset($_POST['furnished']) ? intval($_POST['furnished']) : 0,
                'balcony' => isset($_POST['balcony']) ? intval($_POST['balcony']) : 0,
                'floor' => $_POST['floor'] ?? '',
                'elevator' => isset($_POST['elevator']) ? intval($_POST['elevator']) : 0,
                'air_conditioning' => isset($_POST['air_conditioning']) ? intval($_POST['air_conditioning']) : 0,
                'garage' => isset($_POST['garage']) ? intval($_POST['garage']) : 0,
                'pets_allowed' => isset($_POST['pets_allowed']) ? intval($_POST['pets_allowed']) : 0
            ];
            break;
        case 'Casa':
            $specificFields = [
                'house_type' => $_POST['house_type'] ?? '',
                'garden_size' => $_POST['garden_size'] ?? '',
                'num_floors' => $_POST['num_floors'] ?? '',
                'num_rooms' => $_POST['num_rooms'] ?? '',
                'num_bathrooms' => $_POST['num_bathrooms'] ?? '',
                'private_garage' => isset($_POST['private_garage']) ? intval($_POST['private_garage']) : 0,
                'private_pool' => isset($_POST['private_pool']) ? intval($_POST['private_pool']) : 0,
                'furnished' => isset($_POST['furnished']) ? intval($_POST['furnished']) : 0,
                'terrace' => isset($_POST['terrace']) ? intval($_POST['terrace']) : 0,
                'storage_room' => isset($_POST['storage_room']) ? intval($_POST['storage_room']) : 0,
                'air_conditioning' => isset($_POST['air_conditioning']) ? intval($_POST['air_conditioning']) : 0,
                'pets_allowed' => isset($_POST['pets_allowed']) ? intval($_POST['pets_allowed']) : 0
            ];
            break;
    }

    // Usar el método de PropertyFacade para actualizar todo
    $success = $propertyFacade->updateProperty($propertyId, $propertyFields, $specificFields);

    if ($success) {
        $_SESSION['message'] = 'Propiedad actualizada correctamente.';
    } else {
        $_SESSION['message'] = 'Error al actualizar la propiedad.';
    }
} catch (\Throwable $e) {
    $_SESSION['message'] = 'Error al actualizar la propiedad: ' . $e->getMessage();
}

header('Location: /message');
exit();
