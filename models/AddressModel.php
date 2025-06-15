<?php

namespace models;

/**
 * Modelo de dominio para representar una dirección.
 *
 * Esta clase encapsula los datos y comportamientos relacionados con una dirección postal.
 * Permite almacenar información relevante como la calle, ciudad, provincia, código postal, país y coordenadas geográficas.
 * Se utiliza para transferir información entre las capas de dominio, presentación y persistencia.
 *
 * Propiedades:
 * - int $id                ID de la dirección.
 * - string $street         Calle de la dirección.
 * - string $city           Ciudad.
 * - string $province       Provincia.
 * - string $postal_code    Código postal.
 * - string $country        País.
 * - float|null $latitude   Latitud geográfica (opcional).
 * - float|null $longitude  Longitud geográfica (opcional).
 *
 * Métodos:
 * - __construct: Inicializa el modelo con los datos de la dirección.
 * - getId, getStreet, getCity, getProvince, getPostalCode, getCountry, getLatitude, getLongitude: Getters.
 * - setStreet, setCity, setProvince, setPostalCode, setCountry, setLatitude, setLongitude: Setters.
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
     * @param int        $id         ID de la dirección.
     * @param string     $street     Calle de la dirección.
     * @param string     $city       Ciudad.
     * @param string     $province   Provincia.
     * @param string     $postal_code Código postal.
     * @param string     $country    País.
     * @param float|null $latitude   Latitud geográfica (opcional).
     * @param float|null $longitude  Longitud geográfica (opcional).
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
     * Obtiene el ID de la dirección.
     * @return int
     */
    public function getId() { return $this->id; }

    /**
     * Obtiene la calle de la dirección.
     * @return string
     */
    public function getStreet() { return $this->street; }

    /**
     * Obtiene la ciudad.
     * @return string
     */
    public function getCity() { return $this->city; }

    /**
     * Obtiene la provincia.
     * @return string
     */
    public function getProvince() { return $this->province; }

    /**
     * Obtiene el código postal.
     * @return string
     */
    public function getPostalCode() { return $this->postal_code; }

    /**
     * Obtiene el país.
     * @return string
     */
    public function getCountry() { return $this->country; }

    /**
     * Obtiene la latitud geográfica (opcional).
     * @return float|null
     */
    public function getLatitude() { return $this->latitude; }

    /**
     * Obtiene la longitud geográfica (opcional).
     * @return float|null
     */
    public function getLongitude() { return $this->longitude; }

    // Setters

    /**
     * Establece la calle de la dirección.
     * @param string $street
     */
    public function setStreet($street) { $this->street = $street; }

    /**
     * Establece la ciudad.
     * @param string $city
     */
    public function setCity($city) { $this->city = $city; }

    /**
     * Establece la provincia.
     * @param string $province
     */
    public function setProvince($province) { $this->province = $province; }

    /**
     * Establece el código postal.
     * @param string $postal_code
     */
    public function setPostalCode($postal_code) { $this->postal_code = $postal_code; }

    /**
     * Establece el país.
     * @param string $country
     */
    public function setCountry($country) { $this->country = $country; }

    /**
     * Establece la latitud geográfica (opcional).
     * @param float|null $latitude
     */
    public function setLatitude($latitude) { $this->latitude = $latitude; }

    /**
     * Establece la longitud geográfica (opcional).
     * @param float|null $longitude
     */
    public function setLongitude($longitude) { $this->longitude = $longitude; }
}