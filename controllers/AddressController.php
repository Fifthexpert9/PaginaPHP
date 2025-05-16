<?php

namespace controllers;

use services\AddressService;
use models\AddressModel;

class AddressController {
    private $addressService;

    public function __construct(AddressService $addressService) {
        $this->addressService = $addressService;
    }

    /**
     * Crea una nueva dirección en la base de datos.
     * @param array $data Datos de la dirección (street, city, province, postal_code, country, latitude, longitude)
     * @return int ID de la dirección creada
     */
    public function createAddress($data) {
        $address = new AddressModel(
            null,
            $data['street'],
            $data['city'],
            $data['province'],
            $data['postal_code'],
            $data['country'],
            $data['latitude'],
            $data['longitude']
        );
        return $this->addressService->createAddress($address);
    }

    /**
     * Obtiene una dirección por su ID.
     * @param int $id ID de la dirección
     * @return AddressModel|null Dirección encontrada o null si no existe
     */
    public function getAddressById($id) {
        return $this->addressService->getAddressById($id);
    }
    
    /**
     * Actualiza los campos de una dirección existente.
     * @param int $id ID de la dirección
     * @param array $fields Campos a actualizar (clave => valor)
     * @return bool True si se actualizó correctamente, false en caso contrario
     */
    /*
    public function updateAddress($id, $fields) {
        return $this->addressService->updateAddress($id, $fields);
    }
    */

    /**
     * Elimina una dirección por su ID.
     * @param int $id ID de la dirección
     * @return bool True si se eliminó correctamente, false en caso contrario
     */
    public function deleteAddress($id) {
        return $this->addressService->deleteAddress($id);
    }

    /**
     * Obtiene todas las direcciones almacenadas.
     * @return AddressModel[] Array de direcciones
     */
    /*
    public function getAllAddresses() {
        return $this->addressService->getAllAddresses();
    }
    */
}