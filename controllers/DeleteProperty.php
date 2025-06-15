<?php

namespace controllers;

/**
 * Controlador para eliminar una propiedad.
 *
 * Este script:
 * - Recibe el ID de la propiedad a eliminar por POST.
 * - Instancia el AddressFacade necesario para la operación.
 * - Llama al método deleteAddressByPropertyId para eliminar la dirección y la propiedad asociada.
 * - Gestiona los mensajes de éxito o error en la sesión.
 * - Redirige a la página de mensaje tras la operación.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use facades\AddressFacade;
use converters\AddressConverter;

session_start();

// Instanciar el AddressFacade con el converter necesario
$addressFacade = new AddressFacade(new AddressConverter());

// Obtener el ID de la propiedad a eliminar desde POST
$property_id = $_POST['id'];

// Intentar eliminar la propiedad y su dirección asociada
$result = $addressFacade->deleteAddressByPropertyId($property_id);

// Gestionar el resultado y redirigir con el mensaje correspondiente
if ($result) {
    $_SESSION['message'] = 'La propiedad ha sido eliminada correctamente.';
    header('Location: /message');
    exit();
} else {
    $_SESSION['message'] = 'No se pudo eliminar la propiedad. Por favor, inténtalo de nuevo más tarde.';
    header('Location: /message');
    exit();
}
