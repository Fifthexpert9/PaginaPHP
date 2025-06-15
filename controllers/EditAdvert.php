<?php

namespace controllers;

/**
 * Controlador para editar un anuncio existente.
 *
 * Este script:
 * - Verifica que el usuario haya iniciado sesión.
 * - Recibe los datos del formulario por POST (ID del anuncio y campos a actualizar).
 * - Instancia el AdvertFacade necesario para la operación.
 * - Llama al método updateAdvert para actualizar el anuncio con los nuevos datos.
 * - Gestiona los mensajes de éxito o error en la sesión.
 * - Redirige a la página de propiedades del usuario o a una página de mensaje tras la operación.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use facades\AdvertFacade;
use converters\AdvertConverter;
use converters\PropertyConverter;
use converters\AddressConverter;

session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user']) || !isset($_SESSION['user']->id)) {
    $_SESSION['message'] = 'Debes iniciar sesión para editar un anuncio.';
    header('Location: /message');
    exit();
}

try {
    // Obtener el ID del anuncio a editar
    $advertId = $_POST['id'] ?? null;
    if (!$advertId) {
        throw new \Exception('ID de anuncio no especificado.');
    }

    // Recoger los campos a actualizar desde el formulario
    $fields = [
        'action' => $_POST['action'] ?? '',
        'price' => $_POST['price'] ?? '',
        'description' => $_POST['description'] ?? ''
    ];

    // Instanciar el AdvertFacade con los converters necesarios
    $advertFacade = new AdvertFacade(
        new AdvertConverter(),
        new PropertyConverter(),
        new AddressConverter()
    );

    // Actualizar el anuncio
    $result = $advertFacade->updateAdvert($advertId, $fields);

    // Gestionar el resultado y guardar el mensaje en la sesión
    if (is_array($result) && isset($result['success']) && !$result['success']) {
        $_SESSION['message'] = $result['message'];
    } elseif (is_string($result)) {
        $_SESSION['message'] = $result;
    } else {
        $_SESSION['message'] = 'Anuncio actualizado correctamente.';
    }

    // Redirigir a la página de propiedades del usuario
    header('Location: /my-properties');
    exit();
} catch (\Throwable $e) {
    // Manejo de errores: guardar el mensaje en la sesión y redirigir
    $_SESSION['message'] = 'Error al actualizar el anuncio: ' . $e->getMessage();
    header('Location: /message');
    exit();
}