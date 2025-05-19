<?php

namespace dtos;

/**
 * DTO para exponer información de una habitación junto con los datos de la propiedad y la dirección.
 */
class RoomDto {
    // Datos de la propiedad
    public $property_id;
    public $property_type;
    public $built_size;
    public $price;
    public $status;
    public $immediate_availability;
    public $user_id;

    // Dirección (AddressDto)
    public $address;

    // Datos específicos de la habitación
    public $private_bathroom;
    public $room_size;
    public $max_roommates;
    public $includes_expenses;
    public $pets_allowed;
    public $furnished;
    public $common_areas;
    public $students_only;
    public $gender_restriction;

    public function __construct(
        $property_id,
        $property_type,
        $built_size,
        $price,
        $status,
        $immediate_availability,
        $user_id,
        $address, // AddressDto
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
        $this->property_id = $property_id;
        $this->property_type = $property_type;
        $this->built_size = $built_size;
        $this->price = $price;
        $this->status = $status;
        $this->immediate_availability = $immediate_availability;
        $this->user_id = $user_id;
        $this->address = $address;
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

    public function toArray() {
        return [
            'property_id' => $this->property_id,
            'property_type' => $this->property_type,
            'built_size' => $this->built_size,
            'price' => $this->price,
            'status' => $this->status,
            'immediate_availability' => $this->immediate_availability,
            'user_id' => $this->user_id,
            'address' => $this->address ? $this->address->toArray() : null,
            'private_bathroom' => $this->private_bathroom,
            'room_size' => $this->room_size,
            'max_roommates' => $this->max_roommates,
            'includes_expenses' => $this->includes_expenses,
            'pets_allowed' => $this->pets_allowed,
            'furnished' => $this->furnished,
            'common_areas' => $this->common_areas,
            'students_only' => $this->students_only,
            'gender_restriction' => $this->gender_restriction
        ];
    }
}