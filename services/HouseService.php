<?php

namespace services;

use models\HouseModel;
use models\DatabaseModel;
use PDO;
use PDOException;

class HouseService {
    private $db;

    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    public function createHouse(HouseModel $house) {
        $sql = "INSERT INTO property_house (property_id, house_type, garden_size, num_floors, num_rooms, num_bathrooms, private_garage, private_pool, furnished, terrace, storage_room, air_conditioning, pets_allowed)
                VALUES (:property_id, :house_type, :garden_size, :num_floors, :num_rooms, :num_bathrooms, :private_garage, :private_pool, :furnished, :terrace, :storage_room, :air_conditioning, :pets_allowed)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':property_id' => $house->getPropertyId(),
            ':house_type' => $house->getHouseType(),
            ':garden_size' => $house->getGardenSize(),
            ':num_floors' => $house->getNumFloors(),
            ':num_rooms' => $house->getNumRooms(),
            ':num_bathrooms' => $house->getNumBathrooms(),
            ':private_garage' => $house->getPrivateGarage(),
            ':private_pool' => $house->getPrivatePool(),
            ':furnished' => $house->getFurnished(),
            ':terrace' => $house->getTerrace(),
            ':storage_room' => $house->getStorageRoom(),
            ':air_conditioning' => $house->getAirConditioning(),
            ':pets_allowed' => $house->getPetsAllowed()
        ]);
    }

    public function getHouseByPropertyId($propertyId) {
        $sql = "SELECT * FROM property_house WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new HouseModel(
                $row['property_id'],
                $row['house_type'],
                $row['garden_size'],
                $row['num_floors'],
                $row['num_rooms'],
                $row['num_bathrooms'],
                $row['private_garage'],
                $row['private_pool'],
                $row['furnished'],
                $row['terrace'],
                $row['storage_room'],
                $row['air_conditioning'],
                $row['pets_allowed']
            );
        }
        return null;
    }

    public function updateHouse($propertyId, $fields) {
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE property_house SET $setClause WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            $fields['property_id'] = $propertyId;
            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar detalles de casa: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteHouse($propertyId) {
        try {
            $sql = "DELETE FROM property_house WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':property_id' => $propertyId]);
        } catch (PDOException $e) {
            error_log('Error al eliminar detalles de casa: ' . $e->getMessage());
            return false;
        }
    }
}