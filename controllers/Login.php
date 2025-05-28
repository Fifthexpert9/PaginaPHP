<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';

use facades\UserFacade;
use converters\UserConverter;

session_start();

$userFacade = new UserFacade(new UserConverter());

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