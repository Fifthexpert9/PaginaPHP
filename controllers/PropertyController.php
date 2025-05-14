<?php

namespace controllers;

use services\PropertyService;
use models\PropertyModel;

class PropertyController {
    private $propertyService;

    public function __construct(PropertyService $propertyService) {
        $this->propertyService = $propertyService;
    }

    public function createProperty($data) {
        $property = new PropertyModel(
            null,
            $data['property_type'],
            $data['address_id'],
            $data['built_size'],
            $data['price'],
            $data['status'],
            $data['immediate_availability'],
            $data['user_id']
        );

        return $this->propertyService->createProperty($property);
    }

    public function getPropertyById($id) {
        return $this->propertyService->getPropertyById($id);
    }
}