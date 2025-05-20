<?php

namespace dtos;

/**
 * DTO para exponer información de una dirección.
 *
 * @property int $id ID de la dirección.
 * @property string $street Calle de la dirección.
 * @property string $city Ciudad.
 * @property string $province Provincia.
 * @property string $postal_code Código postal.
 * @property string $country País.
 * @property float|null $latitude Latitud geográfica (opcional).
 * @property float|null $longitude Longitud geográfica (opcional).
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

    /**
     * Constructor de AddressDto.
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

    /**
     * Devuelve la dirección como un array asociativo.
     *
     * @return array<string, mixed> Datos de la dirección.
     */
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