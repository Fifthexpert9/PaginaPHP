<?php

namespace models;

/**
 * Modelo de dominio para representar una habitación dentro de una propiedad.
 *
 * Esta clase encapsula los datos y comportamientos relacionados con una habitación ofertada en una propiedad.
 * Permite almacenar información relevante como si tiene baño privado, número máximo de compañeros, si se permiten mascotas,
 * si está amueblada, si es solo para estudiantes y la restricción de género.
 * Se utiliza para transferir información entre las capas de dominio, presentación y persistencia.
 */
class RoomModel {
    /**
     * @var int ID de la propiedad asociada.
     */
    private $property_id;

    /**
     * @var bool Indica si la habitación tiene baño privado.
     */
    private $private_bathroom;

    /**
     * @var int Número máximo de compañeros de piso.
     */
    private $max_roommates;

    /**
     * @var bool Indica si se permiten mascotas.
     */
    private $pets_allowed;

    /**
     * @var bool Indica si la habitación está amueblada.
     */
    private $furnished;

    /**
     * @var bool Indica si es solo para estudiantes.
     */
    private $students_only;

    /**
     * @var string Restricción de género ('None', 'Only males', 'Only females').
     */
    private $gender_restriction;

    /**
     * Constructor de RoomModel.
     *
     * @param int    $property_id        ID de la propiedad asociada.
     * @param bool   $private_bathroom   Indica si tiene baño privado.
     * @param int    $max_roommates      Número máximo de compañeros.
     * @param bool   $pets_allowed       Indica si se permiten mascotas.
     * @param bool   $furnished          Indica si está amueblada.
     * @param bool   $students_only      Indica si es solo para estudiantes.
     * @param string $gender_restriction Restricción de género.
     */
    public function __construct(
        $property_id,
        $private_bathroom,
        $max_roommates,
        $pets_allowed,
        $furnished,
        $students_only,
        $gender_restriction
    ) {
        $this->property_id = $property_id;
        $this->private_bathroom = $private_bathroom;
        $this->max_roommates = $max_roommates;
        $this->pets_allowed = $pets_allowed;
        $this->furnished = $furnished;
        $this->students_only = $students_only;
        $this->gender_restriction = $gender_restriction;
    }

    // Getters

    /**
     * Obtiene el ID de la propiedad asociada.
     * @return int
     */
    public function getPropertyId() { return $this->property_id; }

    /**
     * Indica si la habitación tiene baño privado.
     * @return bool
     */
    public function getPrivateBathroom() { return $this->private_bathroom; }

    /**
     * Obtiene el número máximo de compañeros de piso.
     * @return int
     */
    public function getMaxRoommates() { return $this->max_roommates; }

    /**
     * Indica si se permiten mascotas.
     * @return bool
     */
    public function getPetsAllowed() { return $this->pets_allowed; }

    /**
     * Indica si la habitación está amueblada.
     * @return bool
     */
    public function getFurnished() { return $this->furnished; }

    /**
     * Indica si es solo para estudiantes.
     * @return bool
     */
    public function getStudentsOnly() { return $this->students_only; }

    /**
     * Obtiene la restricción de género.
     * @return string
     */
    public function getGenderRestriction() { return $this->gender_restriction; }

    // Setters

    /**
     * Establece el ID de la propiedad asociada.
     * @param int $property_id
     */
    public function setPropertyId($property_id) { $this->property_id = $property_id; }

    /**
     * Establece si la habitación tiene baño privado.
     * @param bool $private_bathroom
     */
    public function setPrivateBathroom($private_bathroom) { $this->private_bathroom = $private_bathroom; }

    /**
     * Establece el número máximo de compañeros de piso.
     * @param int $max_roommates
     */
    public function setMaxRoommates($max_roommates) { $this->max_roommates = $max_roommates; }

    /**
     * Establece si se permiten mascotas.
     * @param bool $pets_allowed
     */
    public function setPetsAllowed($pets_allowed) { $this->pets_allowed = $pets_allowed; }

    /**
     * Establece si la habitación está amueblada.
     * @param bool $furnished
     */
    public function setFurnished($furnished) { $this->furnished = $furnished; }

    /**
     * Establece si es solo para estudiantes.
     * @param bool $students_only
     */
    public function setStudentsOnly($students_only) { $this->students_only = $students_only; }

    /**
     * Establece la restricción de género.
     * @param string $gender_restriction
     */
    public function setGenderRestriction($gender_restriction) { $this->gender_restriction = $gender_restriction; }
}