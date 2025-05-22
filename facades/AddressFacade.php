<?php

namespace facades;

use services\AddressService;
use converters\AddressConverter;
use dtos\AddressDto;

/**
 * Facade para la gestión de direcciones.
 * Orquesta la lógica de negocio relacionada con direcciones y su conversión entre modelos y DTOs.
 */
class AddressFacade
{
    private $addressService;
    private $addressConverter;

    /**
     * Constructor de AddressFacade.
     *
     * @param AddressService $addressService Servicio de direcciones.
     * @param AddressConverter $addressConverter Conversor de direcciones.
     */
    public function __construct(AddressService $addressService, AddressConverter $addressConverter)
    {
        $this->addressService = $addressService;
        $this->addressConverter = $addressConverter;
    }

    /**
     * Crea una nueva dirección.
     *
     * @param AddressDto $addressDto DTO con los datos de la dirección.
     * @return int ID de la dirección creada.
     */
    public function createAddress(AddressDto $addressDto)
    {
        $addressModel = $this->addressConverter->dtoToModel($addressDto);
        return $this->addressService->createAddress($addressModel);
    }

    /**
     * Obtiene una dirección por su ID.
     *
     * @param int $id ID de la dirección.
     * @return AddressDto|null DTO de la dirección o null si no existe.
     */
    public function getAddressById($id)
    {
        $addressModel = $this->addressService->getAddressById($id);
        if (!$addressModel) {
            return null;
        }
        return $this->addressConverter->modelToDto($addressModel);
    }

    /**
     * Obtiene la dirección asociada a una propiedad.
     *
     * @param int $propertyId ID de la propiedad.
     * @return AddressDto|null DTO de la dirección o null si no existe.
     */
    public function getAddressByPropertyId($propertyId)
    {
        $addressModel = $this->addressService->getAddressByPropertyId($propertyId);
        if (!$addressModel) {
            return null;
        }
        return $this->addressConverter->modelToDto($addressModel);
    }

    /**
     * Actualiza una dirección existente.
     *
     * @param int $id ID de la dirección a actualizar.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function updateAddress($id, $fields)
    {
        return $this->addressService->updateAddress($id, $fields);
    }

    /**
     * Elimina una dirección por su ID.
     *
     * @param int $id ID de la dirección a eliminar.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteAddress($id)
    {
        return $this->addressService->deleteAddress($id);
    }
}
