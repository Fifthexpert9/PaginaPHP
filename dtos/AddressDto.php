<?php

namespace dtos;

/**
 * DTO para exponer información de una dirección.
 */
class AddressDto {
    public $id;
    public $street;
    public $city;
    public $province;
    public $postal_code;
    public $country;
    public $latitude;
    public $longitude;

    public function __construct($id, $street, $city, $province, $postal_code, $country, $latitude = null, $longitude = null) {
        $this->id = $id;
        $this->street = $street;
        $this->city = $city;
        $this->province = $province;
        $this->postal_code = $postal_code;
        $this->country = $country;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'street' => $this->street,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];
    }
}