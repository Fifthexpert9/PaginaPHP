<?php

namespace controllers;

use services\PropertyService;
use models\PropertyModel;

class PropertyController {
    private $propertyService;

    public function __construct(PropertyService $propertyService) {
        $this->propertyService = $propertyService;
    }

    /**
     * Crea una nueva propiedad.
     * @param array $data Datos de la propiedad
     * @param int $user_id ID del usuario que crea la propiedad
     * @return int ID de la propiedad creada
     */
    public function createProperty($data, $user_id) {
        $property = new PropertyModel(
            null,
            $data['property_type'],
            $data['address_id'],
            $data['built_size'],
            $data['price'],
            $data['status'],
            $data['immediate_availability'],
            $user_id
        );
        return $this->propertyService->createProperty($property);
    }

    /**
     * Obtiene una propiedad por su ID.
     * @param int $id
     * @return PropertyModel|null
     */
    public function getPropertyById($id) {
        return $this->propertyService->getPropertyById($id);
    }

    /**
     * Obtiene todas las propiedades de un usuario.
     * @param int $user_id
     * @return array
     */
    public function getPropertiesByUserId($user_id) {
        return $this->propertyService->getPropertiesByUserId($user_id);
    }

    /**
     * Actualiza una propiedad existente.
     * @param int $id
     * @param array $fields Campos a actualizar
     * @return bool
     */
    public function updateProperty($id, $fields) {
        return $this->propertyService->updateProperty($id, $fields);
    }

    /**
     * Elimina una propiedad por su ID.
     * @param int $id
     * @return bool
     */
    public function deleteProperty($id) {
        return $this->propertyService->deleteProperty($id);
    }
}