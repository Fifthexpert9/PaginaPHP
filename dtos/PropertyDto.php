<?php

namespace dtos;

/**
 * DTO para la entidad Property.
 * Contiene los datos generales de una propiedad, independientemente de su tipo específico.
 */
class PropertyDto
{
    public $id;
    public $property_type;
    public $address_td;
    public $built_size;
    //public $price;
    public $status;
    public $immediate_availability;
    public $userId;

    /**
     * Constructor de PropertyDto.
     *
     * @param int|null $id ID de la propiedad.
     * @param string $property_type Tipo de propiedad ('Habitación', 'Estudio', 'Piso', 'Casa').
     * @param int $address_td ID de la dirección asociada.
     * @param int|null $built_size Superficie construida (m²).
     * @param float $price Precio de la propiedad.
     * @param string $status Estado de la propiedad.
     * @param bool $immediate_availability Disponibilidad inmediata.
     * @param int $userId ID del usuario propietario.
     */
    public function __construct(
        $id,
        $property_type,
        $address_td,
        $built_size,
        //$price,
        $status,
        $immediate_availability,
        $userId
    ) {
        $this->id = $id;
        $this->property_type = $property_type;
        $this->address_td = $address_td;
        $this->built_size = $built_size;
        //$this->price = $price;
        $this->status = $status;
        $this->immediate_availability = $immediate_availability;
        $this->userId = $userId;
    }
}