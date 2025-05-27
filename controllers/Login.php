<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';

use facades\UserFacade;
use converters\UserConverter;

session_start();

$userFacade = new UserFacade(new UserConverter());

$result = $userFacade->userLogin($_POST['email'], $_POST['password']);

if (is_null($result)) { // si accede y no encuentra el usuario
    $_SESSION['message'] = 'Acceso incorrecto';
    header('Location: /message');
} else {
    if (isset($result['user'])) {
        $_SESSION['logged'] = false;
        $_SESSION['message'] = $result['message'];
        header('Location: /message');
    } else {
        $_SESSION['user'] = $result['user'];
        $_SESSION['logged'] = true;
        $_SESSION['message'] = $result['message'];
        header('Location: /message');
    }
}
