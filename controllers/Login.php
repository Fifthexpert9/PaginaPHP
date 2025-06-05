<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';

use converters\AddressConverter;
use facades\UserFacade;
use converters\UserConverter;
use converters\AdvertConverter;
use converters\PropertyConverter;
use facades\AdvertFacade;

session_start();

/**
 * Procesa el inicio de sesión del usuario.
 *
 * - Recibe el email y la contraseña por POST.
 * - Llama al UserFacade para validar las credenciales.
 * - Si el login es exitoso:
 *     - Guarda los datos del usuario y el estado de login en la sesión.
 *     - Guarda un mensaje de éxito en la sesión.
 * - Si el login falla:
 *     - Guarda el estado de login como falso en la sesión.
 *     - Guarda el mensaje de error en la sesión.
 * - Redirige a la página de mensajes para mostrar el resultado.
 */
$userFacade = new UserFacade(new UserConverter(new AdvertFacade(new AdvertConverter(), new PropertyConverter(), new AddressConverter())));

$result = $userFacade->userLogin($_POST['email'], $_POST['password']);

if (!empty($result['success']) && $result['success']) {
    $_SESSION['user'] = $result['user'];
    $_SESSION['logged'] = true;
    $_SESSION['message'] = $result['message'];
} else {
    $_SESSION['logged'] = false;
    $_SESSION['message'] = $result['message'];
}

header('Location: /message');
exit();