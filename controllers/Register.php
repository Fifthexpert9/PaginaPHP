<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';

use converters\AdvertConverter;
use facades\UserFacade;
use converters\UserConverter;
use dtos\UserDto;

session_start();

$userFacade = new UserFacade(new UserConverter(new AdvertConverter()));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');

    $errores = [];
    if (!$email || !$password || !$name || !$lastName) {
        $errores[] = "Todos los campos son obligatorios.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Email no válido.";
    }
    if (strlen($password) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres.";
    }
    if ($errores) {
        $_SESSION['register_errors'] = $errores;
        $_SESSION['register_old'] = [
            'email' => $email,
            'name' => $name,
            'last_name' => $lastName
        ];
        header('Location: /register');
        exit;
    }

    $userDto = new UserDto(
        null,
        $name,
        $lastName,
        'username',
        $email,
        'user',
        date('Y-m-d H:i:s')
    );

    $result = $userFacade->userRegister($userDto, $password);

    $_SESSION['message'] = $result['message'];
    $_SESSION['registered'] = true;

    header('Location: /message');
    exit();
}
