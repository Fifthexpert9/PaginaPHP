<?php

namespace services;

require_once __DIR__ . '/../models/PropertyModel.php';
require_once __DIR__ . '/../models/DatabaseModel.php';

use models\PropertyModel;
use models\AddressModel;
use models\DatabaseModel;
use PDO;
use PDOException;

class PropertyService {
    private $db;
/*
    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }
*/

    public function createProperty(PropertyModel $property) {

        $db = new DatabaseModel();

        $sql = "INSERT INTO property (property_type, address_id, built_size, price, status, immediate_availability, user_id)
                VALUES (:property_type, :address_id, :built_size, :price, :status, :immediate_availability, :user_id)";
        $stmt = $db->db->prepare($sql);
        $stmt->execute([
            ':property_type' => $property->getPropertyType(),
            ':address_id' => $property->getAddressId(),
            ':built_size' => $property->getBuiltSize(),
            ':price' => $property->getPrice(),
            ':status' => $property->getStatus(),
            ':immediate_availability' => $property->getImmediateAvailability(),
            ':user_id' => $property->getUserId()
        ]);
        return $db->lastInsertId();
    }
    
    public function getPropertyById($id) {

        $db = new DatabaseModel();

        $sql = "SELECT * FROM property WHERE id = :id";
        $stmt = $db->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $property = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$property) return null;
        return $property;
    }

    /*
    public function getAllProperties() {
        $sql = "SELECT * FROM property";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    */

    public function getPropertiesByUserId($userId) {

        $db = new DatabaseModel();

        $sql = "SELECT * FROM property WHERE user_id = :user_id";
        $stmt = $db->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateProperty($id, $fields) {

        $db = new DatabaseModel();

        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE property SET $setClause WHERE id = :id";
            $stmt = $db->db->prepare($sql);
            $fields['id'] = $id;
            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar propiedad: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteProperty($id) {

        $db = new DatabaseModel();

        $sql = "DELETE FROM property WHERE id = :id";
        $stmt = $db->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function getFilteredProperties($tipo, $precioMax, $habitaciones) {

        $db = new DatabaseModel();

        $query = "SELECT * FROM property WHERE 1=1";
        $params = [];

        if (!empty($tipo)) {
            $query .= " AND property_type = :tipo";
            $params[':tipo'] = $tipo;
        }
        if (!empty($precioMax)) {
            $query .= " AND price <= :precioMax";
            $params[':precioMax'] = $precioMax;
        }
        if (!empty($habitaciones)) {
            $query .= " AND status >= :habitaciones";
            $params[':habitaciones'] = $habitaciones;
        }

        $stmt = $db->db->prepare($query);
        $stmt->execute($params);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $properties = [];
        foreach ($rows as $row) {
            $properties[] = new \models\PropertyModel(
                $row['id'],
                $row['property_type'],
                $row['address_id'],
                $row['built_size'],
                $row['price'],
                $row['status'],
                $row['immediate_availability'],
                $row['user_id']
            );
        }
        return $properties;
    }
}
