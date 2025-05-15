<?php

namespace models;

class PropertyModel {
    private $id;
    private $property_type;
    private $address_id;
    private $built_size;
    private $price;
    private $status;
    private $immediate_availability;
    private $user_id;

    public function __construct(
        $id,
        $property_type,
        $address_id,
        $built_size,
        $price,
        $status,
        $immediateAvailability,
        $user_id
        ) {
        $this->id = $id;
        $this->property_type = $property_type;
        $this->address_id = $address_id;
        $this->built_size = $built_size;
        $this->price = $price;
        $this->status = $status;
        $this->immediate_availability = $immediate_availability;
        $this->user_id = $user_id;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getPropertyType() { return $this->property_type; }
    public function getAddressId() { return $this->address_id; }
    public function getBuiltSize() { return $this->built_size; }
    public function getPrice() { return $this->price; }
    public function getStatus() { return $this->status; }
    public function getImmediateAvailability() { return $this->immediate_availability; }
    public function getUserId() { return $this->user_id; }

    // Setters
    public function setPropertyType($property_type) { $this->property_type = $property_type; }
    public function setAddressId($address_id) { $this->address_id = $address_id; }
    public function setBuiltSize($built_size) { $this->built_size = $built_size; }
    public function setPrice($price) { $this->price = $price; }
    public function setStatus($status) { $this->status = $status; }
    public function setImmediateAvailability($immediate_availability) { $this->immediate_availability = $immediate_availability; }
    public function setUserId($user_id) { $this->user_id = $user_id; }
}