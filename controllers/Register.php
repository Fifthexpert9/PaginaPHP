<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';

use facades\UserFacade;
use converters\UserConverter;
use dtos\UserDto;

session_start();

$userFacade = new UserFacade(new UserConverter());

$userDto = new UserDto(
    null,
    $_POST['name'],
    $_POST['last_name'],
    'username',
    $_POST['email'],
    'user',
    date('Y-m-d H:i:s')
);

$result = $userFacade->userRegister($userDto, $_POST['password']);

$_SESSION['message'] = $result['message'];

header('Location: /message');
exit();
