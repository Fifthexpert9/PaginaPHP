<?php

namespace controllers;

/**
 * Controlador para crear un nuevo anuncio.
 *
 * Este script:
 * - Recibe los datos del formulario por POST.
 * - Instancia un objeto AdvertDto con los datos recibidos.
 * - Llama al AdvertFacade para crear el anuncio en la base de datos.
 * - Gestiona los mensajes de éxito o error en la sesión.
 * - Redirige a la página de mensaje tras la operación.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use facades\AdvertFacade;
use converters\PropertyConverter;
use converters\AdvertConverter;
use converters\AddressConverter;
use dtos\AdvertDto;

session_start();

try {
    // Instanciar el facade necesario para crear el anuncio
    $advertFacade = new AdvertFacade(
        new AdvertConverter(),
        new PropertyConverter(),
        new AddressConverter()
    );

    // Crear el DTO del anuncio con los datos del formulario
    $advertDto = new AdvertDto(
        null,
        $_POST['property_id'],
        $_SESSION['user']->id,
        $_POST['price'],
        $_POST['action'],
        $_POST['description'],
        null,
        null
    );

    // Llamar al facade para crear el anuncio
    $result = $advertFacade->createAdvert($advertDto);

    // Guardar el mensaje de resultado en la sesión y redirigir
    $_SESSION['message'] = $result;
    header('Location: /message');
    exit();
} catch (\Throwable $e) {
    // Manejo de errores: guardar el mensaje en la sesión y redirigir
    $_SESSION['message'] = 'Error al crear el anuncio: ' . $e->getMessage();
    header('Location: /message');
    exit();
}
