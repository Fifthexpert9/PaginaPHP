<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

use facades\AddressFacade;
use converters\AddressConverter;

$addressFacade = new AddressFacade(new AddressConverter());

$property_id = $_POST['id'];
$result = $addressFacade->deleteAddressByPropertyId($property_id);

if ($result) {
    $_SESSION['message'] = 'La propiedad ha sido eliminada correctamente.';
    header('Location: /message');
    exit();
} else {
    $_SESSION['message'] = 'No se pudo eliminar la propiedad. Por favor, inténtalo de nuevo más tarde.';
    header('Location: /message');
    exit();
}
