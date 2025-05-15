<?php

namespace models;

class StudioModel {
    private $property_id;
    private $furnished;
    private $balcony;
    private $air_conditioning;
    private $pets_allowed;

    public function __construct(
        $property_id,
        $furnished,
        $balcony,
        $air_conditioning,
        $pets_allowed
    ) {
        $this->property_id = $property_id;
        $this->furnished = $furnished;
        $this->balcony = $balcony;
        $this->air_conditioning = $air_conditioning;
        $this->pets_allowed = $pets_allowed;
    }

    // Getters
    public function getPropertyId() { return $this->property_id; }
    public function getFurnished() { return $this->furnished; }
    public function getBalcony() { return $this->balcony; }
    public function getAirConditioning() { return $this->air_conditioning; }
    public function getPetsAllowed() { return $this->pets_allowed; }

    // Setters
    public function setPropertyId($property_id) { $this->property_id = $property_id; }
    public function setFurnished($furnished) { $this->furnished = $furnished; }
    public function setBalcony($balcony) { $this->balcony = $balcony; }
    public function setAirConditioning($air_conditioning) { $this->air_conditioning = $air_conditioning; }
    public function setPetsAllowed($pets_allowed) { $this->pets_allowed = $pets_allowed; }
}