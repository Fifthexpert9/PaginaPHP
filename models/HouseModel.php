<?php

namespace models;

class HouseModel extends PropertyModel {
    private $house_type;
    private $garden_size;
    private $num_floors;
    private $num_rooms;
    private $num_bathrooms;
    private $private_garage;
    private $private_pool;
    private $furnished;
    private $terrace;
    private $storage_room;
    private $air_conditioning;
    private $pets_allowed;

    public function __construct(
        $id,
        $property_type,
        $address_id,
        $built_size,
        $price,
        $status,
        $immediate_availability,
        $user_id,
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
        parent::__construct($id, $property_type, $address_id, $built_size, $price, $status, $immediate_availability, $user_id);
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

    // Getters
    public function getHouseType() { return $this->house_type; }
    public function getGardenSize() { return $this->garden_size; }
    public function getNumFloors() { return $this->num_floors; }
    public function getNumRooms() { return $this->num_rooms; }
    public function getNumBathrooms() { return $this->num_bathrooms; }
    public function getPrivateGarage() { return $this->private_garage; }
    public function getPrivatePool() { return $this->private_pool; }
    public function getFurnished() { return $this->furnished; }
    public function getTerrace() { return $this->terrace; }
    public function getStorageRoom() { return $this->storage_room; }
    public function getAirConditioning() { return $this->air_conditioning; }
    public function getPetsAllowed() { return $this->pets_allowed; }

    // Setters
    public function setHouseType($house_type) { $this->house_type = $house_type; }
    public function setGardenSize($garden_size) { $this->garden_size = $garden_size; }
    public function setNumFloors($num_floors) { $this->num_floors = $num_floors; }
    public function setNumRooms($num_rooms) { $this->num_rooms = $num_rooms; }
    public function setNumBathrooms($num_bathrooms) { $this->num_bathrooms = $num_bathrooms; }
    public function setPrivateGarage($private_garage) { $this->private_garage = $private_garage; }
    public function setPrivatePool($private_pool) { $this->private_pool = $private_pool; }
    public function setFurnished($furnished) { $this->furnished = $furnished; }
    public function setTerrace($terrace) { $this->terrace = $terrace; }
    public function setStorageRoom($storage_room) { $this->storage_room = $storage_room; }
    public function setAirConditioning($air_conditioning) { $this->air_conditioning = $air_conditioning; }
    public function setPetsAllowed($pets_allowed) { $this->pets_allowed = $pets_allowed; }
}