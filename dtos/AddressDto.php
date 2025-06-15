<?php

namespace dtos;

/**
 * DTO para exponer información de una dirección.
 *
 * Este objeto de transferencia de datos (DTO) se utiliza para transportar
 * información de direcciones entre las distintas capas de la aplicación,
 * evitando exponer directamente los modelos de dominio.
 *
 * Propiedades:
 * - int $id               ID de la dirección.
 * - string $street        Calle de la dirección.
 * - string $city          Ciudad.
 * - string $province      Provincia.
 * - string $postal_code   Código postal.
 * - string $country       País.
 * - float|null $latitude  Latitud geográfica (opcional).
 * - float|null $longitude Longitud geográfica (opcional).
 *
 * Métodos:
 * - __construct: Inicializa el DTO con los datos de la dirección.
 * - toArray: Devuelve los datos de la dirección como un array asociativo.
 */
class AddressDto
{
    /** @var int ID de la dirección */
    public $id;
    /** @var string Calle de la dirección */
    public $street;
    /** @var string Ciudad */
    public $city;
    /** @var string Provincia */
    public $province;
    /** @var string Código postal */
    public $postal_code;
    /** @var string País */
    public $country;
    /** @var float|null Latitud geográfica (opcional) */
    public $latitude;
    /** @var float|null Longitud geográfica (opcional) */
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
    public function __construct($id, $street, $city, $province, $postal_code, $country, $latitude = null, $longitude = null)
    {
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
    public function toArray()
    {
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
