<?php

namespace controllers;

use services\HouseService;
use models\HouseModel;

class HouseController {
    private $houseService;

    public function __construct(HouseService $houseService) {
        $this->houseService = $houseService;
    }

    /**
     * Crea los detalles de una casa.
     * @param int $property_id ID de la propiedad principal
     * @param array $data Datos específicos de la casa
     * @return bool True si se creó correctamente
     */
    public function createHouse($property_id, $data) {
        $house = new HouseModel(
            $property_id,
            $data['house_type'],
            $data['garden_size'],
            $data['num_floors'],
            $data['num_rooms'],
            $data['num_bathrooms'],
            $data['private_garage'],
            $data['private_pool'],
            $data['furnished'],
            $data['terrace'],
            $data['storage_room'],
            $data['air_conditioning'],
            $data['pets_allowed']
        );
        return $this->houseService->createHouse($house);
    }

    /**
     * Obtiene los detalles de una casa por property_id.
     * @param int $property_id
     * @return HouseModel|null
     */
    public function getHouseByPropertyId($property_id) {
        return $this->houseService->getHouseByPropertyId($property_id);
    }

    /**
     * Actualiza los detalles de una casa.
     * @param int $property_id
     * @param array $fields Campos a actualizar
     * @return bool
     */
    public function updateHouse($property_id, $fields) {
        return $this->houseService->updateHouse($property_id, $fields);
    }

    /**
     * Elimina los detalles de una casa por property_id.
     * @param int $property_id
     * @return bool
     */
    public function deleteHouse($property_id) {
        return $this->houseService->deleteHouse($property_id);
    }
}