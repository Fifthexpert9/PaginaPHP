<?php

namespace services;

use models\StudioModel;
use models\DatabaseModel;
use PDO;
use PDOException;

class StudioService {
    private $db;

    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    public function createStudio(StudioModel $studio) {
        $sql = "INSERT INTO property_studio (property_id, furnished, balcony, air_conditioning, pets_allowed)
                VALUES (:property_id, :furnished, :balcony, :air_conditioning, :pets_allowed)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':property_id' => $studio->getId(),
            ':furnished' => $studio->getFurnished(),
            ':balcony' => $studio->getBalcony(),
            ':air_conditioning' => $studio->getAirConditioning(),
            ':pets_allowed' => $studio->getPetsAllowed()
        ]);
    }

    public function getStudioByPropertyId($propertyId) {
        $sql = "SELECT * FROM property_studio WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new StudioModel(
                $row['property_id'],
                $row['furnished'],
                $row['balcony'],
                $row['air_conditioning'],
                $row['pets_allowed']
            );
        }
        return null;
    }

    public function updateStudio($propertyId, $fields) {
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE property_studio SET $setClause WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            $fields['property_id'] = $propertyId;
            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar detalles de estudio: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteStudio($propertyId) {
        try {
            $sql = "DELETE FROM property_studio WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':property_id' => $propertyId]);
        } catch (PDOException $e) {
            error_log('Error al eliminar detalles de estudio: ' . $e->getMessage());
            return false;
        }
    }
}