<?php

namespace services;

use models\ApartmentModel;
use models\DatabaseModel;
use PDO;
use PDOException;

class ApartmentService {
    private $db;

    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    public function createApartment(ApartmentModel $apartment) {
        $sql = "INSERT INTO property_apartment (property_id, apartment_type, num_rooms, num_bathrooms, furnished, balcony, floor, elevator, air_conditioning, garage, pool, pets_allowed)
                VALUES (:property_id, :apartment_type, :num_rooms, :num_bathrooms, :furnished, :balcony, :floor, :elevator, :air_conditioning, :garage, :pool, :pets_allowed)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':property_id' => $apartment->getPropertyId(),
            ':apartment_type' => $apartment->getApartmentType(),
            ':num_rooms' => $apartment->getNumRooms(),
            ':num_bathrooms' => $apartment->getNumBathrooms(),
            ':furnished' => $apartment->isFurnished(),
            ':balcony' => $apartment->hasBalcony(),
            ':floor' => $apartment->getFloor(),
            ':elevator' => $apartment->hasElevator(),
            ':air_conditioning' => $apartment->hasAirConditioning(),
            ':garage' => $apartment->hasGarage(),
            ':pool' => $apartment->hasPool(),
            ':pets_allowed' => $apartment->arePetsAllowed()
        ]);
    }

    public function getApartmentByPropertyId($propertyId) {
        $sql = "SELECT * FROM property_apartment WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new ApartmentModel(
                $row['property_id'],
                $row['apartment_type'],
                $row['num_rooms'],
                $row['num_bathrooms'],
                $row['furnished'],
                $row['balcony'],
                $row['floor'],
                $row['elevator'],
                $row['air_conditioning'],
                $row['garage'],
                $row['pool'],
                $row['pets_allowed']
            );
        }
        return null;
    }

    public function updateApartment($propertyId, $fields) {
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE property_apartment SET $setClause WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            $fields['property_id'] = $propertyId;
            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar detalles de apartamento: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteApartment($propertyId) {
        try {
            $sql = "DELETE FROM property_apartment WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':property_id' => $propertyId]);
        } catch (PDOException $e) {
            error_log('Error al eliminar detalles de apartamento: ' . $e->getMessage());
            return false;
        }
    }
}