<?php

namespace services;

use models\RoomModel;
use models\DatabaseModel;
use PDO;
use PDOException;

class RoomService {
    private $db;

    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    public function createRoom(RoomModel $room) {
        $sql = "INSERT INTO property_room (property_id, private_bathroom, room_size, max_roommates, includes_expenses, pets_allowed, furnished, common_areas, students_only, gender_restriction)
                VALUES (:property_id, :private_bathroom, :room_size, :max_roommates, :includes_expenses, :pets_allowed, :furnished, :common_areas, :students_only, :gender_restriction)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':property_id' => $room->getId(),
            ':private_bathroom' => $room->getPrivateBathroom(),
            ':room_size' => $room->getRoomSize(),
            ':max_roommates' => $room->getMaxRoommates(),
            ':includes_expenses' => $room->getIncludesExpenses(),
            ':pets_allowed' => $room->getPetsAllowed(),
            ':furnished' => $room->getFurnished(),
            ':common_areas' => $room->getCommonAreas(),
            ':students_only' => $room->getStudentsOnly(),
            ':gender_restriction' => $room->getGenderRestriction()
        ]);
    }

    public function getRoomByPropertyId($propertyId) {
        $sql = "SELECT * FROM property_room WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new RoomModel(
                $row['property_id'],
                $row['private_bathroom'],
                $row['room_size'],
                $row['max_roommates'],
                $row['includes_expenses'],
                $row['pets_allowed'],
                $row['furnished'],
                $row['common_areas'],
                $row['students_only'],
                $row['gender_restriction']
            );
        }
        return null;
    }

    public function updateRoom($propertyId, $fields) {
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE property_room SET $setClause WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            $fields['property_id'] = $propertyId;
            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar detalles de habitación: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteRoom($propertyId) {
        try {
            $sql = "DELETE FROM property_room WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':property_id' => $propertyId]);
        } catch (PDOException $e) {
            error_log('Error al eliminar detalles de habitación: ' . $e->getMessage());
            return false;
        }
    }
}