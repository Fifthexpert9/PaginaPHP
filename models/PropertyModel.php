<?php

namespace models;

class PropertyModel {
    private $id;
    private $property_type;
    private $action;
    private $addressId;
    private $builtSize;
    private $price;
    private $status;
    private $immediateAvailability;
    private $userId;

    public function __construct(
        $id,
        $property_type,
        $action,
        $addressId,
        $builtSize,
        $price,
        $status,
        $immediateAvailability,
        $userId
        ) {
        $this->id = $id;
        $this->property_type = $property_type;
        $this->action = $action;
        $this->addressId = $addressId;
        $this->builtSize = $builtSize;
        $this->price = $price;
        $this->status = $status;
        $this->immediateAvailability = $immediateAvailability;
        $this->userId = $userId;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getPropertyType() { return $this->property_type; }
    public function getAction() { return $this->action; }
    public function getAddressId() { return $this->addressId; }
    public function getBuiltSize() { return $this->builtSize; }
    public function getPrice() { return $this->price; }
    public function getStatus() { return $this->status; }
    public function getImmediateAvailability() { return $this->immediateAvailability; }
    public function getUserId() { return $this->userId; }

    // Setters
    public function setPropertyType($property_type) { $this->property_type = $property_type; }
    public function setAction($action) { $this->action = $action; }
    public function setAddressId($addressId) { $this->addressId = $addressId; }
    public function setBuiltSize($builtSize) { $this->builtSize = $builtSize; }
    public function setPrice($price) { $this->price = $price; }
    public function setStatus($status) { $this->status = $status; }
    public function setImmediateAvailability($immediateAvailability) { $this->immediateAvailability = $immediateAvailability; }
    public function setUserId($userId) { $this->userId = $userId; }
}