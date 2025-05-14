<?php

namespace models;

class RoomModel extends PropertyModel {
    private $private_bathroom;
    private $room_size;
    private $max_roommates;
    private $includes_expenses;
    private $pets_allowed;
    private $furnished;
    private $common_areas;
    private $students_only;
    private $gender_restriction;

    public function __construct(
        $id,
        $property_type,
        $address_id,
        $built_size,
        $price,
        $status,
        $immediate_availability,
        $user_id,
        $private_bathroom,
        $room_size,
        $max_roommates,
        $includes_expenses,
        $pets_allowed,
        $furnished,
        $common_areas,
        $students_only,
        $gender_restriction
    ) {
        parent::__construct($id, $property_type, $address_id, $built_size, $price, $status, $immediate_availability, $user_id);
        $this->private_bathroom = $private_bathroom;
        $this->room_size = $room_size;
        $this->max_roommates = $max_roommates;
        $this->includes_expenses = $includes_expenses;
        $this->pets_allowed = $pets_allowed;
        $this->furnished = $furnished;
        $this->common_areas = $common_areas;
        $this->students_only = $students_only;
        $this->gender_restriction = $gender_restriction;
    }

    // Getters
    public function getPrivateBathroom() { return $this->private_bathroom; }
    public function getRoomSize() { return $this->room_size; }
    public function getMaxRoommates() { return $this->max_roommates; }
    public function getIncludesExpenses() { return $this->includes_expenses; }
    public function getPetsAllowed() { return $this->pets_allowed; }
    public function getFurnished() { return $this->furnished; }
    public function getCommonAreas() { return $this->common_areas; }
    public function getStudentsOnly() { return $this->students_only; }
    public function getGenderRestriction() { return $this->gender_restriction; }

    // Setters
    public function setPrivateBathroom($private_bathroom) { $this->private_bathroom = $private_bathroom; }
    public function setRoomSize($room_size) { $this->room_size = $room_size; }
    public function setMaxRoommates($max_roommates) { $this->max_roommates = $max_roommates; }
    public function setIncludesExpenses($includes_expenses) { $this->includes_expenses = $includes_expenses; }
    public function setPetsAllowed($pets_allowed) { $this->pets_allowed = $pets_allowed; }
    public function setFurnished($furnished) { $this->furnished = $furnished; }
    public function setCommonAreas($common_areas) { $this->common_areas = $common_areas; }
    public function setStudentsOnly($students_only) { $this->students_only = $students_only; }
    public function setGenderRestriction($gender_restriction) { $this->gender_restriction = $gender_restriction; }
}