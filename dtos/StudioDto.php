<?php

namespace dtos;

/**
 * DTO para exponer información de un estudio junto con los datos de la propiedad y la dirección.
 *
 * Este DTO agrupa toda la información relevante de un estudio ofertado, incluyendo los datos generales de la propiedad,
 * la dirección (AddressDto) y los datos específicos del estudio.
 * Se utiliza para transferir datos entre la capa de dominio y la capa de presentación o API.
 *
 * @property int $property_id ID de la propiedad.
 * @property string $property_type Tipo de propiedad.
 * @property int $built_size Superficie construida (m²).
 * @property float $price Precio del estudio.
 * @property string $status Estado del estudio.
 * @property bool $immediate_availability Disponibilidad inmediata.
 * @property int $user_id ID del usuario propietario.
 * @property AddressDto $address Objeto con la dirección del estudio.
 * @property bool $furnished Indica si está amueblado.
 * @property bool $balcony Indica si tiene balcón.
 * @property bool $air_conditioning Indica si tiene aire acondicionado.
 * @property bool $pets_allowed Indica si se permiten mascotas.
 */
class StudioDto
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

    // Datos específicos del estudio
    public $furnished;
    public $balcony;
    public $air_conditioning;
    public $pets_allowed;

    /**
     * Constructor de StudioDto.
     *
     * @param int $property_id ID de la propiedad.
     * @param string $property_type Tipo de propiedad.
     * @param int $built_size Superficie construida (m²).
     * @param float $price Precio del estudio.
     * @param string $status Estado del estudio.
     * @param bool $immediate_availability Disponibilidad inmediata.
     * @param int $user_id ID del usuario propietario.
     * @param AddressDto $address Objeto con la dirección del estudio.
     * @param bool $furnished Indica si está amueblado.
     * @param bool $balcony Indica si tiene balcón.
     * @param bool $air_conditioning Indica si tiene aire acondicionado.
     * @param bool $pets_allowed Indica si se permiten mascotas.
     */
    public function __construct(
        $property_id,
        $property_type,
        $built_size,
        //$price,
        $status,
        $immediate_availability,
        $user_id,
        $address, // AddressDto
        $furnished,
        $balcony,
        $air_conditioning,
        $pets_allowed
    ) {
        $this->property_id = $property_id;
        $this->property_type = $property_type;
        $this->built_size = $built_size;
        //$this->price = $price;
        $this->status = $status;
        $this->immediate_availability = $immediate_availability;
        $this->user_id = $user_id;
        $this->address = $address;
        $this->furnished = $furnished;
        $this->balcony = $balcony;
        $this->air_conditioning = $air_conditioning;
        $this->pets_allowed = $pets_allowed;
    }

    /**
     * Devuelve el estudio como un array asociativo.
     *
     * @return array<string, mixed> Datos del estudio.
     */
    public function toArray()
    {
        return [
            'property_id' => $this->property_id,
            'property_type' => $this->property_type,
            'built_size' => $this->built_size,
            //'price' => $this->price,
            'status' => $this->status,
            'immediate_availability' => $this->immediate_availability,
            'user_id' => $this->user_id,
            'address' => $this->address ? (method_exists($this->address, 'toArray') ? $this->address->toArray() : (array)$this->address) : null,
            'furnished' => $this->furnished,
            'balcony' => $this->balcony,
            'air_conditioning' => $this->air_conditioning,
            'pets_allowed' => $this->pets_allowed
        ];
    }
}
