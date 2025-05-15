<?php

namespace models;

class AddressModel {
    private $id;
    private $street;
    private $city;
    private $province;
    private $postal_code;
    private $country;
    private $latitude;
    private $longitude;

    public function __construct(
        $id,
        $street,
        $city,
        $province,
        $postal_code,
        $country,
        $latitude,
        $longitude
    ) {
        $this->id = $id;
        $this->street = $street;
        $this->city = $city;
        $this->province = $province;
        $this->postal_code = $postal_code;
        $this->country = $country;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getStreet() { return $this->street; }
    public function getCity() { return $this->city; }
    public function getProvince() { return $this->province; }
    public function getPostalCode() { return $this->postal_code; }
    public function getCountry() { return $this->country; }
    public function getLatitude() { return $this->latitude; }
    public function getLongitude() { return $this->longitude; }

    // Setters
    public function setStreet($street) { $this->street = $street; }
    public function setCity($city) { $this->city = $city; }
    public function setProvince($province) { $this->province = $province; }
    public function setPostalCode($postal_code) { $this->postal_code = $postal_code; }
    public function setCountry($country) { $this->country = $country; }
    public function setLatitude($latitude) { $this->latitude = $latitude; }
    public function setLongitude($longitude) { $this->longitude = $longitude; }

}
