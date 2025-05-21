<?php

namespace facades;

use services\AdvertService;
use converters\AdvertConverter;
use dtos\AdvertDto;

/**
 * Facade para la gestión de anuncios (advert).
 * Orquesta la lógica de negocio relacionada con anuncios y su conversión entre modelos y DTOs.
 */
class AdvertFacade {
    private $advertService;
    private $advertConverter;

    /**
     * Constructor de AdvertFacade.
     *
     * @param AdvertService $advertService Servicio de anuncios.
     * @param AdvertConverter $advertConverter Conversor de anuncios.
     */
    public function __construct(AdvertService $advertService, AdvertConverter $advertConverter) {
        $this->advertService = $advertService;
        $this->advertConverter = $advertConverter;
    }

    /**
     * Crea un nuevo anuncio.
     *
     * @param AdvertDto $advertDto DTO con los datos del anuncio.
     * @return array Resultado de la operación (success, message)
     */
    public function createAdvert(AdvertDto $advertDto) {
        $advertModel = $this->advertConverter->dtoToModel($advertDto);
        if ($this->advertService->createAdvert($advertModel)) {
            return ['success' => true, 'message' => 'Anuncio creado correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al crear el anuncio.'];
        }
    }

    /**
     * Obtiene un anuncio por su ID, devolviendo el título generado y el DTO correspondiente.
     *
     * El título sigue la estructura:
     * "(property_type, de property) en (action, de advert) en (street, de address), (city, de address)"
     *
     * @param int $id ID del anuncio.
     * @return array|null Array con 'title' y 'advert' (AdvertDto), o null si no existe.
     */
    public function getAdvertById($id) {
        $advertModel = $this->advertService->getAdvertById($id);

        if (!$advertModel) return null;

        // Obtener la propiedad asociada
        $propertyService = new \services\PropertyService(new \models\DatabaseModel());
        $propertyData = $propertyService->getPropertyById($advertModel->getPropertyId());

        if (!$propertyData) return null;

        // Obtener la dirección asociada
        $addressService = new \services\AddressService(new \models\DatabaseModel());
        $addressModel = $addressService->getAddressById($propertyData['address_id']);

        // Construir el título
        $propertyType = $propertyData['property_type'] ?? '';
        $action = strtolower($advertModel->getAction() ?? '');
        $street = $addressModel ? $addressModel->getStreet() : '';
        $city = $addressModel ? $addressModel->getCity() : '';

        $title = "{$propertyType} en {$action} en {$street}, {$city}";

        return [
            'title' => $title,
            'advert' => $this->advertConverter->modelToDto($advertModel)
        ];
    }

    /**
     * Elimina un anuncio por su ID.
     *
     * @param int $id ID del anuncio a eliminar.
     * @return array Resultado de la operación (success, message)
     */
    public function deleteAdvert($id) {
        if ($this->advertService->deleteAdvert($id)) {
            return ['success' => true, 'message' => 'Anuncio eliminado correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar el anuncio.'];
        }
    }
}