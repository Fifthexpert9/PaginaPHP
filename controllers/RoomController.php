<?php

namespace controllers;

use models\PropertyModel;
use services\RoomService;
use models\RoomModel;

class RoomController {
    private $roomService;

    public function __construct(RoomService $roomService) {
        $this->roomService = $roomService;
    }

    public function createRoom(PropertyModel $property, $room_data) {
        if (!$property->getId()) {
            throw new \InvalidArgumentException("La propiedad debe tener un ID válido.");
        }


        $requiredFields = ['private_bathroom', 'room_size', 'max_roommates', 'includes_expenses', 'pets_allowed', 'furnished', 'common_areas', 'students_only', 'gender_restriction'];
        foreach ($requiredFields as $field) {
            if (!isset($room_data[$field])) {
                throw new \InvalidArgumentException("El campo {$field} es obligatorio.");
            }
        }

        try {
            $room = new RoomModel(
            $property->getId(),
            $property->getPropertyType(),
            $property->getAddressId(),
            $property->getBuiltSize(),
            $property->getPrice(),
            $property->getStatus(),
            $property->getImmediateAvailability(),
            $property->getUserId(),
            $room_data['private_bathroom'],
            $room_data['room_size'],
            $room_data['max_roommates'],
            $room_data['includes_expenses'],
            $room_data['pets_allowed'],
            $room_data['furnished'],
            $room_data['common_areas'],
            $room_data['students_only'],
            $room_data['gender_restriction']
            );

            return $this->roomService->createRoom($room);
        } catch (\Exception $e) {
            throw new \RuntimeException("Error al crear la habitación: " . $e->getMessage());
            return false;
        }
    }
}