<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';

use facades\AdvertFacade;
use converters\AdvertConverter;
use converters\PropertyConverter;
use converters\AddressConverter;

session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['user']->id)) {
    $_SESSION['message'] = 'Debes iniciar sesión para editar un anuncio.';
    header('Location: /message');
    exit();
}

try {
    $advertId = $_POST['id'] ?? null;
    if (!$advertId) {
        throw new \Exception('ID de anuncio no especificado.');
    }

    $fields = [
        'action' => $_POST['action'] ?? '',
        'price' => $_POST['price'] ?? '',
        'description' => $_POST['description'] ?? ''
    ];

    $advertFacade = new AdvertFacade(
        new AdvertConverter(),
        new PropertyConverter(),
        new AddressConverter()
    );

    $result = $advertFacade->updateAdvert($advertId, $fields);

    if (is_array($result) && isset($result['success']) && !$result['success']) {
        $_SESSION['message'] = $result['message'];
    } elseif (is_string($result)) {
        $_SESSION['message'] = $result;
    } else {
        $_SESSION['message'] = 'Anuncio actualizado correctamente.';
    }

    header('Location: /my-properties');
    exit();
} catch (\Throwable $e) {
    $_SESSION['message'] = 'Error al actualizar el anuncio: ' . $e->getMessage();
    header('Location: /message');
    exit();
}