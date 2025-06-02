<?php

namespace dtos;

/**
 * DTO para exponer información de un apartamento junto con los datos de la propiedad y la dirección.
 *
 * Este DTO agrupa toda la información relevante de un apartamento ofertado, incluyendo los datos generales de la propiedad,
 * la dirección (AddressDto) y los datos específicos del apartamento.
 * Se utiliza para transferir datos entre la capa de dominio y la capa de presentación o API.
 *
 * @property int $property_id ID de la propiedad.
 * @property string $property_type Tipo de propiedad.
 * @property int $built_size Superficie construida (m²).
 * @property float $price Precio del apartamento.
 * @property string $status Estado del apartamento.
 * @property bool $immediate_availability Disponibilidad inmediata.
 * @property int $user_id ID del usuario propietario.
 * @property AddressDto $address Objeto con la dirección del apartamento.
 * @property string $apartment_type Tipo de apartamento.
 * @property int $num_rooms Número de habitaciones.
 * @property int $num_bathrooms Número de baños.
 * @property bool $furnished Indica si está amueblado.
 * @property bool $balcony Indica si tiene balcón.
 * @property int $floor Planta en la que se encuentra.
 * @property bool $elevator Indica si tiene ascensor.
 * @property bool $air_conditioning Indica si tiene aire acondicionado.
 * @property bool $garage Indica si tiene garaje.
 * @property bool $pool Indica si tiene piscina.
 * @property bool $pets_allowed Indica si se permiten mascotas.
 */
class ApartmentDto
{
    // Datos de la propiedad
    public $property_id;
    public $property_type;
    public $built_size;
    //public $price;
    public $status;
    public $immediate_availability;
    public $user_id;

    // Dirección (AddressDto)
    public $address;

    // Datos específicos del apartamento
    public $apartment_type;
    public $num_rooms;
    public $num_bathrooms;
    public $furnished;
    public $balcony;
    public $floor;
    public $elevator;
    public $air_conditioning;
    public $garage;
    //public $pool;
    public $pets_allowed;

    /**
     * Constructor de ApartmentDto.
     *
     * @param int $property_id ID de la propiedad.
     * @param string $property_type Tipo de propiedad.
     * @param int $built_size Superficie construida (m²).
     * @param float $price Precio del apartamento.
     * @param string $status Estado del apartamento.
     * @param bool $immediate_availability Disponibilidad inmediata.
     * @param int $user_id ID del usuario propietario.
     * @param AddressDto $address Objeto con la dirección del apartamento.
     * @param string $apartment_type Tipo de apartamento.
     * @param int $num_rooms Número de habitaciones.
     * @param int $num_bathrooms Número de baños.
     * @param bool $furnished Indica si está amueblado.
     * @param bool $balcony Indica si tiene balcón.
     * @param int $floor Planta en la que se encuentra.
     * @param bool $elevator Indica si tiene ascensor.
     * @param bool $air_conditioning Indica si tiene aire acondicionado.
     * @param bool $garage Indica si tiene garaje.
     * @param bool $pool Indica si tiene piscina.
     * @param bool $pets_allowed Indica si se permiten mascotas.
     */
    public function __construct(
        $property_id,
        $property_type,
        $built_size,
        $status,
        $immediate_availability,
        $user_id,
        $address, // AddressDto
        $apartment_type,
        $num_rooms,
        $num_bathrooms,
        $furnished,
        $balcony,
        $floor,
        $elevator,
        $air_conditioning,
        $garage,
        $pets_allowed
    ) {
        $this->property_id = $property_id;
        $this->property_type = $property_type;
        $this->built_size = $built_size;
        $this->status = $status;
        $this->immediate_availability = $immediate_availability;
        $this->user_id = $user_id;
        $this->address = $address;
        $this->apartment_type = $apartment_type;
        $this->num_rooms = $num_rooms;
        $this->num_bathrooms = $num_bathrooms;
        $this->furnished = $furnished;
        $this->balcony = $balcony;
        $this->floor = $floor;
        $this->elevator = $elevator;
        $this->air_conditioning = $air_conditioning;
        $this->garage = $garage;
        $this->pets_allowed = $pets_allowed;
    }

    /**
     * Devuelve el apartamento como un array asociativo.
     *
     * @return array<string, mixed> Datos del apartamento.
     */
    public function toArray()
    {
        return [
            'property_id' => $this->property_id,
            'property_type' => $this->property_type,
            'built_size' => $this->built_size,
            'status' => $this->status,
            'immediate_availability' => $this->immediate_availability,
            'user_id' => $this->user_id,
            'address' => $this->address ? (method_exists($this->address, 'toArray') ? $this->address->toArray() : (array)$this->address) : null,
            'apartment_type' => $this->apartment_type,
            'num_rooms' => $this->num_rooms,
            'num_bathrooms' => $this->num_bathrooms,
            'furnished' => $this->furnished,
            'balcony' => $this->balcony,
            'floor' => $this->floor,
            'elevator' => $this->elevator,
            'air_conditioning' => $this->air_conditioning,
            'garage' => $this->garage,
            'pets_allowed' => $this->pets_allowed
        ];
    }
}
