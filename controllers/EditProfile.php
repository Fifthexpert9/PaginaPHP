<?php

namespace controllers;

/**
 * Controlador para editar el perfil de usuario.
 *
 * Este script:
 * - Verifica que el usuario haya iniciado sesión.
 * - Recibe los datos del formulario por POST (nombre, apellido y email).
 * - Instancia el UserFacade necesario para la operación.
 * - Llama al método updateUser para actualizar los datos del usuario.
 * - Si la actualización es exitosa, destruye la sesión, la reinicia y muestra un mensaje de éxito.
 * - Si ocurre un error, muestra el mensaje correspondiente y redirige al menú de usuario.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use facades\UserFacade;
use converters\UserConverter;

session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user']) || !isset($_SESSION['user']->id)) {
    $_SESSION['message'] = 'Debes iniciar sesión para eliminar tu cuenta.';
    header('Location: /user-menu.php');
    exit();
}

// Instanciar el UserFacade
$userFacade = new UserFacade(new UserConverter());

// Recoger los campos a actualizar desde el formulario
$user_id = $_SESSION['user']->id;
$fields = [
    'name' => $_POST['name'] ?? '',
    'last_name' => $_POST['last_name'] ?? '',
    'email' => $_POST['email'] ?? ''
];

// Actualizar el usuario
$result = $userFacade->updateUser($user_id, $fields);

// Gestionar el resultado y redirigir con el mensaje correspondiente
if ($result['success']) {
    session_destroy();
    session_start();
    $_SESSION['user_edited'] = true;
    $_SESSION['message'] = $result['message'];
    header('Location: /message');
    exit();
} else {
    $_SESSION['message'] = $result['message'];
    header('Location: /user-menu');
    exit();
}
