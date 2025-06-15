<?php

namespace models;

/**
 * Modelo de dominio para representar una propiedad inmobiliaria.
 *
 * Esta clase encapsula los datos y comportamientos relacionados con una propiedad.
 * Permite almacenar información relevante como el tipo de propiedad, dirección asociada,
 * superficie construida, estado, disponibilidad inmediata y usuario propietario.
 * Se utiliza para transferir información entre las capas de dominio, presentación y persistencia.
 *
 * Propiedades:
 * - int $id                        ID de la propiedad.
 * - string $property_type          Tipo de propiedad (por ejemplo, 'Piso', 'Casa', 'Habitación', 'Estudio').
 * - int $address_id                ID de la dirección asociada.
 * - int $built_size                Superficie construida en metros cuadrados (m²).
 * - string $status                 Estado de la propiedad (por ejemplo, 'Obra nueva', 'Reformado', etc.).
 * - bool $immediate_availability   Indica si la propiedad tiene disponibilidad inmediata.
 * - int $user_id                   ID del usuario propietario de la propiedad.
 *
 * Métodos:
 * - __construct: Inicializa el modelo con los datos de la propiedad.
 * - getId, getPropertyType, getAddressId, getBuiltSize, getStatus, getImmediateAvailability, getUserId: Getters.
 * - setPropertyType, setAddressId, setBuiltSize, setStatus, setImmediateAvailability, setUserId: Setters.
 */
class PropertyModel {
    /**
     * @var int ID de la propiedad.
     */
    private $id;

    /**
     * @var string Tipo de propiedad (por ejemplo, 'Piso', 'Casa', 'Habitación', 'Estudio').
     */
    private $property_type;

    /**
     * @var int ID de la dirección asociada.
     */
    private $address_id;

    /**
     * @var int Superficie construida en metros cuadrados (m²).
     */
    private $built_size;

    /**
     * @var string Estado de la propiedad (por ejemplo, 'Obra nueva', 'Reformado', etc.).
     */
    private $status;

    /**
     * @var bool Indica si la propiedad tiene disponibilidad inmediata.
     */
    private $immediate_availability;

    /**
     * @var int ID del usuario propietario de la propiedad.
     */
    private $user_id;

    /**
     * Constructor de PropertyModel.
     *
     * @param int    $id                     ID de la propiedad.
     * @param string $property_type          Tipo de propiedad.
     * @param int    $address_id             ID de la dirección asociada.
     * @param int    $built_size             Superficie construida (m²).
     * @param string $status                 Estado de la propiedad.
     * @param bool   $immediate_availability Disponibilidad inmediata.
     * @param int    $user_id                ID del usuario propietario.
     */
    public function __construct(
        $id,
        $property_type,
        $address_id,
        $built_size,
        $status,
        $immediate_availability,
        $user_id
    ) {
        $this->id = $id;
        $this->property_type = $property_type;
        $this->address_id = $address_id;
        $this->built_size = $built_size;
        $this->status = $status;
        $this->immediate_availability = $immediate_availability;
        $this->user_id = $user_id;
    }

    // Getters

    /**
     * Obtiene el ID de la propiedad.
     * @return int
     */
    public function getId() { return $this->id; }

    /**
     * Obtiene el tipo de propiedad.
     * @return string
     */
    public function getPropertyType() { return $this->property_type; }

    /**
     * Obtiene el ID de la dirección asociada.
     * @return int
     */
    public function getAddressId() { return $this->address_id; }

    /**
     * Obtiene la superficie construida (m²).
     * @return int
     */
    public function getBuiltSize() { return $this->built_size; }

    /**
     * Obtiene el estado de la propiedad.
     * @return string
     */
    public function getStatus() { return $this->status; }

    /**
     * Indica si la propiedad tiene disponibilidad inmediata.
     * @return bool
     */
    public function getImmediateAvailability() { return $this->immediate_availability; }

    /**
     * Obtiene el ID del usuario propietario.
     * @return int
     */
    public function getUserId() { return $this->user_id; }

    // Setters

    /**
     * Establece el tipo de propiedad.
     * @param string $property_type
     */
    public function setPropertyType($property_type) { $this->property_type = $property_type; }

    /**
     * Establece el ID de la dirección asociada.
     * @param int $address_id
     */
    public function setAddressId($address_id) { $this->address_id = $address_id; }

    /**
     * Establece la superficie construida (m²).
     * @param int $built_size
     */
    public function setBuiltSize($built_size) { $this->built_size = $built_size; }

    /**
     * Establece el estado de la propiedad.
     * @param string $status
     */
    public function setStatus($status) { $this->status = $status; }

    /**
     * Establece la disponibilidad inmediata.
     * @param bool $immediate_availability
     */
    public function setImmediateAvailability($immediate_availability) { $this->immediate_availability = $immediate_availability; }

    /**
     * Establece el ID del usuario propietario.
     * @param int $user_id
     */
    public function setUserId($user_id) { $this->user_id = $user_id; }
}