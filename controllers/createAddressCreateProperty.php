<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';

use facades\PropertyFacade;
use facades\ImageFacade;
use converters\PropertyConverter;
use converters\ImageConverter;
use converters\RoomConverter;
use converters\StudioConverter;
use converters\ApartmentConverter;
use converters\HouseConverter;
use converters\AddressConverter;
use dtos\PropertyDto;
use dtos\RoomDto;
use dtos\StudioDto;
use dtos\ApartmentDto;
use dtos\HouseDto;
use dtos\AddressDto;

session_start();

try {
    $propertyFacade = new PropertyFacade(
        new PropertyConverter(),
        new RoomConverter(),
        new StudioConverter(),
        new ApartmentConverter(),
        new HouseConverter(),
        new AddressConverter(),
    );

    $imageFacade = new ImageFacade(new ImageConverter());

    $addressDto = new AddressDto(
        null,
        $_POST['street'],
        $_POST['city'],
        $_POST['province'],
        $_POST['postal_code'],
        $_POST['country'],
        null,
        null
    );

    $propertyDto = new PropertyDto(
        null,
        $_POST['property_type'],
        null,
        $_POST['built_size'],
        $_POST['status'],
        $_POST['immediate_availability'] === 'true' ? 1 : 0,
        $_SESSION['user']->id
    );

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

    $images = $_FILES['images'];

    $resultPropertyFacade = $propertyFacade->createProperty($addressDto, $propertyDto, $specificDto);

    if (is_numeric($resultPropertyFacade)) {
        $imageDtos = $imageFacade->transformImagesToArrayDto($images, $resultPropertyFacade);
        if (!empty($imageDtos)) {
            $resultImageFacade = $imageFacade->addImages($imageDtos);
            if ($resultImageFacade === true) {
                $_SESSION['message'] = 'Propiedad registrada correctamente. ID de propiedad: ' . $resultPropertyFacade;
            } else {
                $_SESSION['message'] = 'Error al registrar las imágenes de la propiedad';
            }
        }
    } else {
        $_SESSION['message'] = $resultPropertyFacade;
    }

    header('Location: /message');
    exit();
} catch (\Throwable $e) {
    $_SESSION['message'] = 'Error al registrar la propiedad: ' . $e->getMessage();
    header('Location: /message');
    exit();
}
