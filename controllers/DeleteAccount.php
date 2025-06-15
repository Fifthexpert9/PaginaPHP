<?php

namespace controllers;

/**
 * Controlador para eliminar la cuenta de usuario.
 *
 * Este script:
 * - Verifica que el usuario haya iniciado sesión.
 * - Instancia el UserFacade necesario para la operación.
 * - Llama al método deleteUser para eliminar la cuenta del usuario actual.
 * - Si la eliminación es exitosa, destruye la sesión y muestra un mensaje de éxito.
 * - Si ocurre un error, muestra el mensaje correspondiente y redirige al menú de usuario.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use facades\UserFacade;
use facades\AdvertFacade;
use converters\AddressConverter;
use converters\PropertyConverter;
use converters\UserConverter;
use converters\AdvertConverter;

session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user']) || !isset($_SESSION['user']->id)) {
    $_SESSION['message'] = 'Debes iniciar sesión para eliminar tu cuenta.';
    header('Location: /user-menu.php');
    exit();
}

// Instanciar el UserFacade con los converters necesarios
$userFacade = new UserFacade(
    new UserConverter(
        new AdvertFacade(
            new AdvertConverter(),
            new PropertyConverter(),
            new AddressConverter()
        )
    )
);

$user_id = $_SESSION['user']->id;
$result = $userFacade->deleteUser($user_id);

// Si la eliminación fue exitosa, destruir la sesión y mostrar mensaje
if ($result['success']) {
    session_destroy();
    session_start();
    $_SESSION['message'] = $result['message'];
    header('Location: /message');
    exit();
} else {
    // Si hubo error, mostrar mensaje y redirigir al menú de usuario
    $_SESSION['message'] = $result['message'];
    header('Location: /user-menu');
    exit();
}
