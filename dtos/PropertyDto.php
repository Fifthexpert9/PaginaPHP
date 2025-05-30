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
    public $address_id;
    public $built_size;
    //public $price;
    public $status;
    public $immediate_availability;
    public $user_id;

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
     * @param int $user_id ID del usuario propietario.
     */
    public function __construct(
        $id,
        $property_type,
        $address_id,
        $built_size,
        //$price,
        $status,
        $immediate_availability,
        $user_id
    ) {
        $this->id = $id;
        $this->property_type = $property_type;
        $this->address_id = $address_id;
        $this->built_size = $built_size;
        //$this->price = $price;
        $this->status = $status;
        $this->immediate_availability = $immediate_availability;
        $this->user_id = $user_id;
    }
}
