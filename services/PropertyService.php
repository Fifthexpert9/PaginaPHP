<?php

namespace services;

use models\PropertyModel;
use models\DatabaseModel;

class PropertyService {
    private $db;

    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    public function createProperty(PropertyModel $property) {
        $sql = "INSERT INTO property (property_type, address_id, built_size, price, status, immediate_availability, user_id)
                VALUES (:property_type, :address_id, :built_size, :price, :status, :immediate_availability, :user_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':property_type' => $property->getPropertyType(),
            ':address_id' => $property->getAddressId(),
            ':built_size' => $property->getBuiltSize(),
            ':price' => $property->getPrice(),
            ':status' => $property->getStatus(),
            ':immediate_availability' => $property->getImmediateAvailability(),
            ':user_id' => $property->getUserId()
        ]);

        return $this->db->lastInsertId(); // Devuelve el ID de la propiedad creada
    }

    public function getPropertyById($id) {
        $sql = "SELECT * FROM property WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}