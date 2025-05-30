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
use dtos\PropertyDto;
use dtos\RoomDto;
use dtos\StudioDto;
use dtos\ApartmentDto;
use dtos\HouseDto;
use dtos\AddressDto;

session_start();

try {
    // Instanciar las facades
    $propertyFacade = new PropertyFacade(
        new PropertyConverter(),
        new RoomConverter(),
        new StudioConverter(),
        new ApartmentConverter(),
        new HouseConverter(),
        new AddressConverter(),
        new ImageConverter()
    );

    // Recoger datos de dirección
    $addressDto = new AddressDto(
        null,
        $_POST['street'],
        $_POST['city'],
        $_POST['province'],
        $_POST['postal_code'],
        $_POST['country']
    );

    // Recoger datos generales de la propiedad
    $propertyDto = new PropertyDto(
        null,
        $_POST['property_type'],
        null, // address_id, se asignará tras crear la dirección
        $_POST['built_size'],
        $_POST['status'],
        $_POST['immediate_availability'] === 'true' ? 1 : 0,
        $_SESSION['user_id'] ?? 1 // Cambia esto por el id real del usuario logueado
    );

    // Recoger datos específicos según el tipo de propiedad
    $specificDto = null;
    switch ($_POST['property_type']) {
        case 'Habitación':
            $specificDto = new RoomDto(
                $propertyDto->id,
                $propertyDto->property_type,
                $propertyDto->address_id,
                $propertyDto->built_size,
                $propertyDto->status,
                $propertyDto->immediate_availability,
                $propertyDto->user_id,
                $_POST['private_bathroom'] === 'true' ? 1 : 0,
                $_POST['max_roommates'],
                $_POST['pets_allowed'] === 'true' ? 1 : 0,
                $_POST['furnished'] === 'true' ? 1 : 0,
                $_POST['students_only'] === 'true' ? 1 : 0,
                $_POST['gender_restriction']
            );
            break;
        case 'Estudio':
            $specificDto = new StudioDto(
                $propertyDto->id,
                $propertyDto->property_type,
                $propertyDto->address_id,
                $propertyDto->built_size,
                $propertyDto->status,
                $propertyDto->immediate_availability,
                $propertyDto->user_id,
                $_POST['furnished'] === 'true' ? 1 : 0,
                $_POST['balcony'] === 'true' ? 1 : 0,
                $_POST['air_conditioning'] === 'true' ? 1 : 0,
                $_POST['pets_allowed'] === 'true' ? 1 : 0
            );
            break;
        case 'Piso':
            $specificDto = new ApartmentDto(
                $propertyDto->id,
                $propertyDto->property_type,
                $propertyDto->address_id,
                $propertyDto->built_size,
                $propertyDto->status,
                $propertyDto->immediate_availability,
                $propertyDto->user_id,
                $_POST['apartment_type'],
                $_POST['num_rooms'],
                $_POST['num_bathrooms'],
                $_POST['furnished'] === 'true' ? 1 : 0,
                $_POST['balcony'] === 'true' ? 1 : 0,
                $_POST['floor'],
                $_POST['elevator'] === 'true' ? 1 : 0,
                $_POST['air_conditioning'] === 'true' ? 1 : 0,
                $_POST['garage'] === 'true' ? 1 : 0,
                $_POST['pets_allowed'] === 'true' ? 1 : 0
            );
            break;
        case 'Casa':
            $specificDto = new HouseDto(
                $propertyDto->id,
                $propertyDto->property_type,
                $propertyDto->address_id,
                $propertyDto->built_size,
                $propertyDto->status,
                $propertyDto->immediate_availability,
                $propertyDto->user_id,
                $_POST['house_type'],
                $_POST['garden_size'],
                $_POST['num_floors'],
                $_POST['num_rooms'],
                $_POST['num_bathrooms'],
                $_POST['private_garage'] === 'true' ? 1 : 0,
                $_POST['private_pool'] === 'true' ? 1 : 0,
                $_POST['furnished'] === 'true' ? 1 : 0,
                $_POST['terrace'] === 'true' ? 1 : 0,
                $_POST['storage_room'] === 'true' ? 1 : 0,
                $_POST['air_conditioning'] === 'true' ? 1 : 0,
                $_POST['pets_allowed'] === 'true' ? 1 : 0
            );
            break;
    }

    $images = [];
    $result = $propertyFacade->createProperty($specificDto, $images);

    $_SESSION['message'] = $result['message'];
    header('Location: /message');
    exit();
} catch (\Throwable $e) {
    $_SESSION['message'] = 'Error al registrar la propiedad: ' . $e->getMessage();
    header('Location: /message');
    exit();
}