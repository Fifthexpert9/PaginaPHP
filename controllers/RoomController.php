<?php

namespace controllers;

use services\RoomService;
use models\RoomModel;

class RoomController {
    private $roomService;

    public function __construct(RoomService $roomService) {
        $this->roomService = $roomService;
    }

    /**
     * Crea los detalles de una habitación.
     * @param int $property_id
     * @param array $data Datos de la habitación
     * @return bool True si se creó correctamente
     */
    public function createRoom($property_id, $data) {
        $room = new RoomModel(
            $property_id,
            $data['private_bathroom'],
            $data['room_size'],
            $data['max_roommates'],
            $data['includes_expenses'],
            $data['pets_allowed'],
            $data['furnished'],
            $data['common_areas'],
            $data['students_only'],
            $data['gender_restriction']
        );
        return $this->roomService->createRoom($room);
    }

    /**
     * Obtiene los detalles de una habitación por property_id.
     * @param int $property_id
     * @return RoomModel|null
     */
    public function getRoomByPropertyId($property_id) {
        return $this->roomService->getRoomByPropertyId($property_id);
    }

    /**
     * Actualiza los detalles de una habitación.
     * @param int $property_id
     * @param array $fields Campos a actualizar
     * @return bool
     */
    public function updateRoom($property_id, $fields) {
        return $this->roomService->updateRoom($property_id, $fields);
    }

    /**
     * Elimina los detalles de una habitación por property_id.
     * @param int $property_id
     * @return bool
     */
    public function deleteRoom($property_id) {
        return $this->roomService->deleteRoom($property_id);
    }
}