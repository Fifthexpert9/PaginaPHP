<?php

namespace models;

class ApartmentModel {
    private $property_id;
    private $apartment_type;
    private $num_rooms;
    private $num_bathrooms;
    private $furnished;
    private $balcony;
    private $floor;
    private $elevator;
    private $air_conditioning;
    private $garage;
    private $pool;
    private $pets_allowed;

    public function __construct(
        $property_id,
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

    // Getters
    public function getPropertyId() { return $this->property_id; }
    public function getApartmentType() { return $this->apartment_type; }
    public function getNumRooms() { return $this->num_rooms; }
    public function getNumBathrooms() { return $this->num_bathrooms; }
    public function isFurnished() { return $this->furnished; }
    public function hasBalcony() { return $this->balcony; }
    public function getFloor() { return $this->floor; }
    public function hasElevator() { return $this->elevator; }
    public function hasAirConditioning() { return $this->air_conditioning; }
    public function hasGarage() { return $this->garage; }
    public function hasPool() { return $this->pool; }
    public function arePetsAllowed() { return $this->pets_allowed; }

    // Setters
    public function setPropertyId($property_id) { $this->property_id = $property_id; }
    public function setApartmentType($apartment_type) { $this->apartment_type = $apartment_type; }
    public function setNumRooms($num_rooms) { $this->num_rooms = $num_rooms; }
    public function setNumBathrooms($num_bathrooms) { $this->num_bathrooms = $num_bathrooms; }
    public function setFurnished($furnished) { $this->furnished = $furnished; }
    public function setBalcony($balcony) { $this->balcony = $balcony; }
    public function setFloor($floor) { $this->floor = $floor; }
    public function setElevator($elevator) { $this->elevator = $elevator; }
    public function setAirConditioning($air_conditioning) { $this->air_conditioning = $air_conditioning; }
    public function setGarage($garage) { $this->garage = $garage; }
    public function setPool($pool) { $this->pool = $pool; }
    public function setPetsAllowed($pets_allowed) { $this->pets_allowed = $pets_allowed; }

}