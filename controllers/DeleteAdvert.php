<?php

namespace controllers;

/**
 * Controlador para eliminar un anuncio.
 *
 * Este script:
 * - Recibe el ID del anuncio a eliminar por POST.
 * - Instancia el AdvertFacade necesario para la operación.
 * - Llama al método deleteAdvert para eliminar el anuncio.
 * - Gestiona los mensajes de éxito o error en la sesión.
 * - Redirige a la página de mensaje tras la operación.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use facades\AdvertFacade;
use converters\PropertyConverter;
use converters\AdvertConverter;
use converters\AddressConverter;

session_start();

// Instanciar el AdvertFacade con los converters necesarios
$advertFacade = new AdvertFacade(
    new AdvertConverter(),
    new PropertyConverter(),
    new AddressConverter()
);

// Obtener el ID del anuncio a eliminar desde POST
$advert_id = $_POST['id'];

// Intentar eliminar el anuncio
$result = $advertFacade->deleteAdvert($advert_id);

// Gestionar el resultado y redirigir con el mensaje correspondiente
if ($result) {
    $_SESSION['message'] = 'El anuncio ha sido eliminado correctamente.';
    header('Location: /message');
    exit();
} else {
    $_SESSION['message'] = 'No se pudo eliminar el anuncio. Por favor, inténtalo de nuevo más tarde.';
    header('Location: /message');
    exit();
}
