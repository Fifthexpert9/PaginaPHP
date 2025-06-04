<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';

use facades\AdvertFacade;
use converters\PropertyConverter;
use converters\AdvertConverter;
use dtos\AdvertDto;

session_start();

try {
    $advertFacade = new AdvertFacade(
        new AdvertConverter(),
        new PropertyConverter()
    );

    $advertDto = new AdvertDto(
        null,
        $_POST['property_id'],
        $_SESSION['user']->id,
        $_POST['price'],
        $_POST['action'],
        $_POST['description'],
        null,
        null
    );

    $result = $advertFacade->createAdvert($advertDto);

    $_SESSION['message'] = $result;
    header('Location: /message');
    exit();
} catch (\Throwable $e) {
    $_SESSION['message'] = 'Error al crear el anuncio: ' . $e->getMessage();
    header('Location: /message');
    exit();
}
