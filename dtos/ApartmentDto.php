<?php

namespace dtos;

/**
 * DTO para exponer información de un apartamento junto con los datos de la propiedad y la dirección.
 */
class ApartmentDto {
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

    // Datos específicos del apartamento
    public $apartment_type;
    public $num_rooms;
    public $num_bathrooms;
    public $furnished;
    public $balcony;
    public $floor;
    public $elevator;
    public $air_conditioning;
    public $garage;
    public $pool;
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
        $apartment_type,
        $num_rooms,
        $num_bathrooms,
        $furnished,
        $balcony,
        $floor,
        $elevator,
        $air_conditioning,
        $garage,
        $pool,
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
        $this->apartment_type = $apartment_type;
        $this->num_rooms = $num_rooms;
        $this->num_bathrooms = $num_bathrooms;
        $this->furnished = $furnished;
        $this->balcony = $balcony;
        $this->floor = $floor;
        $this->elevator = $elevator;
        $this->air_conditioning = $air_conditioning;
        $this->garage = $garage;
        $this->pool = $pool;
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
            'apartment_type' => $this->apartment_type,
            'num_rooms' => $this->num_rooms,
            'num_bathrooms' => $this->num_bathrooms,
            'furnished' => $this->furnished,
            'balcony' => $this->balcony,
            'floor' => $this->floor,
            'elevator' => $this->elevator,
            'air_conditioning' => $this->air_conditioning,
            'garage' => $this->garage,
            'pool' => $this->pool,
            'pets_allowed' => $this->pets_allowed
        ];
    }
}