<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use facades\UserFacade;
use facades\AdvertFacade;
use converters\AddressConverter;
use converters\PropertyConverter;
use converters\UserConverter;
use converters\AdvertConverter;

if (!isset($_SESSION['user']) || !isset($_SESSION['user']->id)) {
    $_SESSION['message'] = 'Debes iniciar sesión para eliminar tu cuenta.';
    header('Location: /user-menu.php');
    exit();
}

$userFacade = new UserFacade(new UserConverter(new AdvertFacade(new AdvertConverter(), new PropertyConverter(), new AddressConverter())));

$user_id = $_SESSION['user']->id;
$result = $userFacade->deleteUser($user_id);

if ($result['success']) {
    session_destroy();
    session_start();
    $_SESSION['message'] = $result['message'];
    header('Location: /message');
    exit();
} else {
    $_SESSION['message'] = $result['message'];
    header('Location: /user-menu');
    exit();
}
