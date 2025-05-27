<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';

use facades\UserFacade;
use converters\UserConverter;

session_start();

$userFacade = new UserFacade(new UserConverter());

$result = $userFacade->userLogin($_POST['email'], $_POST['password']);

if (is_null($result)) { // si accede y no encuentra el usuario
    echo 'error';
} else { // si sí encuentra al usuario
    $_SESSION['user'] = $result['user'];
    $_SESSION['logged'] = true;
    $_SESSION['message'] = $result['message'];
    header('Location: /message');
}