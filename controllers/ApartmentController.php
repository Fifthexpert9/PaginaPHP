<?php

namespace controllers;

use services\ApartmentService;
use models\ApartmentModel;

class ApartmentController {
    private $apartmentService;

    public function __construct(ApartmentService $apartmentService) {
        $this->apartmentService = $apartmentService;
    }

    /**
     * Crea los detalles de un apartamento.
     * @param int $property_id ID de la propiedad principal
     * @param array $data Datos específicos del apartamento
     * @return bool True si se creó correctamente
     */
    public function createApartment($property_id, $data) {
        $apartment = new ApartmentModel(
            $property_id,
            $data['apartment_type'],
            $data['num_rooms'],
            $data['num_bathrooms'],
            $data['furnished'],
            $data['balcony'],
            $data['floor'],
            $data['elevator'],
            $data['air_conditioning'],
            $data['garage'],
            $data['pool'],
            $data['pets_allowed']
        );
        return $this->apartmentService->createApartment($apartment);
    }

    /**
     * Obtiene los detalles de un apartamento por property_id.
     * @param int $property_id
     * @return ApartmentModel|null
     */
    public function getApartmentByPropertyId($property_id) {
        return $this->apartmentService->getApartmentByPropertyId($property_id);
    }

    /**
     * Actualiza los detalles de un apartamento.
     * @param int $property_id
     * @param array $fields Campos a actualizar
     * @return bool
     */
    public function updateApartment($property_id, $fields) {
        return $this->apartmentService->updateApartment($property_id, $fields);
    }

    /**
     * Elimina los detalles de un apartamento por property_id.
     * @param int $property_id
     * @return bool
     */
    public function deleteApartment($property_id) {
        return $this->apartmentService->deleteApartment($property_id);
    }
}