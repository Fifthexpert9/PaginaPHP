<?php

namespace controllers;

/**
 * Controlador para registrar un nuevo usuario.
 *
 * Este script:
 * - Recibe los datos del formulario de registro por POST (nombre, apellido, email y contraseña).
 * - Instancia el UserFacade necesario para la operación.
 * - Crea un objeto UserDto con los datos recibidos.
 * - Llama al método userRegister del UserFacade para registrar el usuario en la base de datos.
 * - Guarda el mensaje de resultado y el estado de registro en la sesión.
 * - Redirige a la página de mensaje tras la operación.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use converters\AdvertConverter;
use facades\UserFacade;
use converters\UserConverter;
use dtos\UserDto;

session_start();

// Instanciar el UserFacade con el UserConverter y AdvertConverter necesarios
$userFacade = new UserFacade(new UserConverter(new AdvertConverter()));

// Crear el DTO del usuario con los datos del formulario
$userDto = new UserDto(
    null,
    $_POST['name'],
    $_POST['last_name'],
    'username', // El nombre de usuario se puede generar o pedir en el formulario
    $_POST['email'],
    'user', // Rol por defecto
    date('Y-m-d H:i:s') // Fecha de registro
);

// Registrar el usuario llamando al facade
$result = $userFacade->userRegister($userDto, $_POST['password']);

// Guardar el mensaje de resultado y el estado de registro en la sesión
$_SESSION['message'] = $result['message'];
$_SESSION['registered'] = true;

// Redirigir a la página de mensaje
header('Location: /message');
exit();
