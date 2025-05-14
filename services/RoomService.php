<?php

namespace services;

use models\RoomModel;
use models\DatabaseModel;

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
}