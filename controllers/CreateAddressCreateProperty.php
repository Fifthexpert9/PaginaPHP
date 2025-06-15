<?php

namespace controllers;

/**
 * Controlador para crear una nueva propiedad y su dirección asociada.
 *
 * Este script:
 * - Recibe los datos del formulario por POST (dirección, propiedad y campos específicos según el tipo).
 * - Instancia los DTOs correspondientes para dirección, propiedad y tipo específico.
 * - Llama al PropertyFacade para crear la propiedad, la dirección y las imágenes.
 * - Gestiona los mensajes de éxito o error en la sesión.
 * - Redirige a la página de mensaje tras la operación.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use facades\PropertyFacade;
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
    // Instanciar el PropertyFacade con todos los converters necesarios
    $propertyFacade = new PropertyFacade(
        new PropertyConverter(),
        new RoomConverter(),
        new StudioConverter(),
        new ApartmentConverter(),
        new HouseConverter(),
        new AddressConverter(),
        new ImageConverter()
    );

    $street = $_POST['street'] . ', ' . $_POST['number'];

    $addressDto = new AddressDto(
        null,
        $street,
        $_POST['city'],
        $_POST['province'],
        $_POST['postal_code'],
        $_POST['country'],
        null,
        null
    );

    // Crear DTO de propiedad con los datos generales
    $propertyDto = new PropertyDto(
        null,
        $_POST['property_type'],
        null,
        $_POST['built_size'],
        $_POST['status'],
        $_POST['immediate_availability'] === 'true' ? 1 : 0,
        $_SESSION['user']->id,
        null,
        null
    );

    $images = $_FILES['images'];

    // Crear DTO específico según el tipo de propiedad
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
                null,
                null,
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
                null,
                null,
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
                null,
                null,
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
                null,
                null,
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

    // Llama al facade para crear la propiedad, la dirección y las imágenes
    $result = $propertyFacade->createProperty($addressDto, $propertyDto, $images, $specificDto);

    // Guarda el mensaje de resultado en la sesión y redirige
    $_SESSION['message'] = $result;
    header('Location: /message');
    exit();
} catch (\Throwable $e) {
    // Manejo de errores: guarda el mensaje en la sesión y redirige
    $_SESSION['message'] = 'Error al registrar la propiedad: ' . $e->getMessage();
    header('Location: /message');
    exit();
}
