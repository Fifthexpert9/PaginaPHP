<?php

namespace dtos;

/**
 * DTO para exponer información de una casa junto con los datos de la propiedad y la dirección.
 */
class HouseDto {
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

    // Datos específicos de la casa
    public $house_type;
    public $garden_size;
    public $num_floors;
    public $num_rooms;
    public $num_bathrooms;
    public $private_garage;
    public $private_pool;
    public $furnished;
    public $terrace;
    public $storage_room;
    public $air_conditioning;
    public $pets_allowed;

    public function __construct(
        $property_id,
        $property_type,
        $built_size,
        $price,
        $status,
        $immediate_availability,
        $user_id,
        $address, // AddressDto
        $house_type,
        $garden_size,
        $num_floors,
        $num_rooms,
        $num_bathrooms,
        $private_garage,
        $private_pool,
        $furnished,
        $terrace,
        $storage_room,
        $air_conditioning,
        $pets_allowed
    ) {
        $this->property_id = $property_id;
        $this->property_type = $property_type;
        $this->built_size = $built_size;
        $this->price = $price;
        $this->status = $status;
        $this->immediate_availability = $immediate_availability;
        $this->user_id = $user_id;
        $this->address = $address;
        $this->house_type = $house_type;
        $this->garden_size = $garden_size;
        $this->num_floors = $num_floors;
        $this->num_rooms = $num_rooms;
        $this->num_bathrooms = $num_bathrooms;
        $this->private_garage = $private_garage;
        $this->private_pool = $private_pool;
        $this->furnished = $furnished;
        $this->terrace = $terrace;
        $this->storage_room = $storage_room;
        $this->air_conditioning = $air_conditioning;
        $this->pets_allowed = $pets_allowed;
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
            'house_type' => $this->house_type,
            'garden_size' => $this->garden_size,
            'num_floors' => $this->num_floors,
            'num_rooms' => $this->num_rooms,
            'num_bathrooms' => $this->num_bathrooms,
            'private_garage' => $this->private_garage,
            'private_pool' => $this->private_pool,
            'furnished' => $this->furnished,
            'terrace' => $this->terrace,
            'storage_room' => $this->storage_room,
            'air_conditioning' => $this->air_conditioning,
            'pets_allowed' => $this->pets_allowed
        ];
    }
}