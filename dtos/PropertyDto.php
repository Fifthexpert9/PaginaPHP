<?php

namespace dtos;

/**
 * DTO para la entidad Property.
 * Contiene los datos generales de una propiedad, independientemente de su tipo específico.
 */
class PropertyDto
{
    public $id;
    public $propertyType;
    public $addressId;
    public $builtSize;
    //public $price;
    public $status;
    public $immediateAvailability;
    public $userId;

    /**
     * Constructor de PropertyDto.
     *
     * @param int|null $id ID de la propiedad.
     * @param string $propertyType Tipo de propiedad ('Habitación', 'Estudio', 'Piso', 'Casa').
     * @param int $addressId ID de la dirección asociada.
     * @param int|null $builtSize Superficie construida (m²).
     * @param float $price Precio de la propiedad.
     * @param string $status Estado de la propiedad.
     * @param bool $immediateAvailability Disponibilidad inmediata.
     * @param int $userId ID del usuario propietario.
     */
    public function __construct(
        $id,
        $propertyType,
        $addressId,
        $builtSize,
        //$price,
        $status,
        $immediateAvailability,
        $userId
    ) {
        $this->id = $id;
        $this->propertyType = $propertyType;
        $this->addressId = $addressId;
        $this->builtSize = $builtSize;
        //$this->price = $price;
        $this->status = $status;
        $this->immediateAvailability = $immediateAvailability;
        $this->userId = $userId;
    }
}