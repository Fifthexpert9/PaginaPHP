<?php

namespace models;

/**
 * Modelo de dominio para representar una dirección.
 */
class AddressModel {
    /**
     * @var int ID de la dirección.
     */
    private $id;
    /**
     * @var string Calle de la dirección.
     */
    private $street;
    /**
     * @var string Ciudad.
     */
    private $city;
    /**
     * @var string Provincia.
     */
    private $province;
    /**
     * @var string Código postal.
     */
    private $postal_code;
    /**
     * @var string País.
     */
    private $country;
    /**
     * @var float|null Latitud geográfica (opcional).
     */
    private $latitude;
    /**
     * @var float|null Longitud geográfica (opcional).
     */
    private $longitude;

    /**
     * Constructor de AddressModel.
     *
     * @param int $id ID de la dirección.
     * @param string $street Calle de la dirección.
     * @param string $city Ciudad.
     * @param string $province Provincia.
     * @param string $postal_code Código postal.
     * @param string $country País.
     * @param float|null $latitude Latitud geográfica (opcional).
     * @param float|null $longitude Longitud geográfica (opcional).
     */
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
    /**
     * @return int
     */
    public function getId() { return $this->id; }
    /**
     * @return string
     */
    public function getStreet() { return $this->street; }
    /**
     * @return string
     */
    public function getCity() { return $this->city; }
    /**
     * @return string
     */
    public function getProvince() { return $this->province; }
    /**
     * @return string
     */
    public function getPostalCode() { return $this->postal_code; }
    /**
     * @return string
     */
    public function getCountry() { return $this->country; }
    /**
     * @return float|null
     */
    public function getLatitude() { return $this->latitude; }
    /**
     * @return float|null
     */
    public function getLongitude() { return $this->longitude; }

    // Setters
    /**
     * @param string $street
     */
    public function setStreet($street) { $this->street = $street; }
    /**
     * @param string $city
     */
    public function setCity($city) { $this->city = $city; }
    /**
     * @param string $province
     */
    public function setProvince($province) { $this->province = $province; }
    /**
     * @param string $postal_code
     */
    public function setPostalCode($postal_code) { $this->postal_code = $postal_code; }
    /**
     * @param string $country
     */
    public function setCountry($country) { $this->country = $country; }
    /**
     * @param float|null $latitude
     */
    public function setLatitude($latitude) { $this->latitude = $latitude; }
    /**
     * @param float|null $longitude
     */
    public function setLongitude($longitude) { $this->longitude = $longitude; }

}
