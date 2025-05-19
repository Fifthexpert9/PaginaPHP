<?php

namespace models;

/**
 * Modelo de dominio para representar una propiedad inmobiliaria.
 */
class PropertyModel {
    /**
     * @var int ID de la propiedad.
     */
    private $id;
    /**
     * @var string Tipo de propiedad.
     */
    private $property_type;
    /**
     * @var int ID de la dirección asociada.
     */
    private $address_id;
    /**
     * @var int Superficie construida (m²).
     */
    private $built_size;
    /**
     * @var float Precio de la propiedad.
     */
    private $price;
    /**
     * @var string Estado de la propiedad.
     */
    private $status;
    /**
     * @var bool Disponibilidad inmediata.
     */
    private $immediate_availability;
    /**
     * @var int ID del usuario propietario.
     */
    private $user_id;

    /**
     * Constructor de PropertyModel.
     *
     * @param int $id ID de la propiedad.
     * @param string $property_type Tipo de propiedad.
     * @param int $address_id ID de la dirección asociada.
     * @param int $built_size Superficie construida (m²).
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
        $price,
        $status,
        $immediate_availability,
        $user_id
    ) {
        $this->id = $id;
        $this->property_type = $property_type;
        $this->address_id = $address_id;
        $this->built_size = $built_size;
        $this->price = $price;
        $this->status = $status;
        $this->immediate_availability = $immediate_availability;
        $this->user_id = $user_id;
    }

    // Getters
    /**
     * @return int
     */
    public function getId() { return $this->id; }
    /**
     * @return string
     */
    public function getPropertyType() { return $this->property_type; }
    /**
     * @return int
     */
    public function getAddressId() { return $this->address_id; }
    /**
     * @return int
     */
    public function getBuiltSize() { return $this->built_size; }
    /**
     * @return float
     */
    public function getPrice() { return $this->price; }
    /**
     * @return string
     */
    public function getStatus() { return $this->status; }
    /**
     * @return bool
     */
    public function getImmediateAvailability() { return $this->immediate_availability; }
    /**
     * @return int
     */
    public function getUserId() { return $this->user_id; }

    // Setters
    /**
     * @param string $property_type
     */
    public function setPropertyType($property_type) { $this->property_type = $property_type; }
    /**
     * @param int $address_id
     */
    public function setAddressId($address_id) { $this->address_id = $address_id; }
    /**
     * @param int $built_size
     */
    public function setBuiltSize($built_size) { $this->built_size = $built_size; }
    /**
     * @param float $price
     */
    public function setPrice($price) { $this->price = $price; }
    /**
     * @param string $status
     */
    public function setStatus($status) { $this->status = $status; }
    /**
     * @param bool $immediate_availability
     */
    public function setImmediateAvailability($immediate_availability) { $this->immediate_availability = $immediate_availability; }
    /**
     * @param int $user_id
     */
    public function setUserId($user_id) { $this->user_id = $user_id; }
}