<?php

namespace models;

class StudioModel extends PropertyModel {
    private $furnished;
    private $balcony;
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
        $furnished,
        $balcony,
        $air_conditioning,
        $pets_allowed
    ) {
        parent::__construct($id, $property_type, $address_id, $built_size, $price, $status, $immediate_availability, $user_id);
        $this->furnished = $furnished;
        $this->balcony = $balcony;
        $this->air_conditioning = $air_conditioning;
        $this->pets_allowed = $pets_allowed;
    }
    
    // Getters
    public function getFurnished() { return $this->furnished; }
    public function getBalcony() { return $this->balcony; }
    public function getAirConditioning() { return $this->air_conditioning; }
    public function getPetsAllowed() { return $this->pets_allowed; }
    
    // Setters
    public function setFurnished($furnished) { $this->furnished = $furnished; }
    public function setBalcony($balcony) { $this->balcony = $balcony; }
    public function setAirConditioning($air_conditioning) { $this->air_conditioning = $air_conditioning; }
    public function setPetsAllowed($pets_allowed) { $this->pets_allowed = $pets_allowed; }
}