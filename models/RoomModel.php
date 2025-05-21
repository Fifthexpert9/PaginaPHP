<?php

namespace models;

/**
 * Modelo de dominio para representar una habitación dentro de una propiedad.
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
     * @var int Tamaño de la habitación.
     */
    //private $room_size;
    /**
     * @var int Número máximo de compañeros.
     */
    private $max_roommates;
    /**
     * @var bool Indica si incluye gastos.
     */
    //private $includes_expenses;
    /**
     * @var bool Indica si se permiten mascotas.
     */
    private $pets_allowed;
    /**
     * @var bool Indica si la habitación está amueblada.
     */
    private $furnished;
    /**
     * @var string Áreas comunes disponibles.
     */
    //private $common_areas;
    /**
     * @var bool Indica si es solo para estudiantes.
     */
    private $students_only;
    /**
     * @var string Restricción de género.
     */
    private $gender_restriction;

    /**
     * Constructor de RoomModel.
     *
     * @param int $property_id ID de la propiedad asociada.
     * @param bool $private_bathroom Indica si tiene baño privado.
     * @param int $room_size Tamaño de la habitación.
     * @param int $max_roommates Número máximo de compañeros.
     * @param bool $includes_expenses Indica si incluye gastos.
     * @param bool $pets_allowed Indica si se permiten mascotas.
     * @param bool $furnished Indica si está amueblada.
     * @param string $common_areas Áreas comunes disponibles.
     * @param bool $students_only Indica si es solo para estudiantes.
     * @param string $gender_restriction Restricción de género.
     */
    public function __construct(
        $property_id,
        $private_bathroom,
        //$room_size,
        $max_roommates,
        //$includes_expenses,
        $pets_allowed,
        $furnished,
        //$common_areas,
        $students_only,
        $gender_restriction
    ) {
        $this->property_id = $property_id;
        $this->private_bathroom = $private_bathroom;
        //$this->room_size = $room_size;
        $this->max_roommates = $max_roommates;
        //$this->includes_expenses = $includes_expenses;
        $this->pets_allowed = $pets_allowed;
        $this->furnished = $furnished;
        //$this->common_areas = $common_areas;
        $this->students_only = $students_only;
        $this->gender_restriction = $gender_restriction;
    }

    // Getters
    public function getPropertyId() { return $this->property_id; }
    public function getPrivateBathroom() { return $this->private_bathroom; }
    //public function getRoomSize() { return $this->room_size; }
    public function getMaxRoommates() { return $this->max_roommates; }
    //public function getIncludesExpenses() { return $this->includes_expenses; }
    public function getPetsAllowed() { return $this->pets_allowed; }
    public function getFurnished() { return $this->furnished; }
    //public function getCommonAreas() { return $this->common_areas; }
    public function getStudentsOnly() { return $this->students_only; }
    public function getGenderRestriction() { return $this->gender_restriction; }

    // Setters
    public function setPropertyId($property_id) { $this->property_id = $property_id; }
    public function setPrivateBathroom($private_bathroom) { $this->private_bathroom = $private_bathroom; }
    //public function setRoomSize($room_size) { $this->room_size = $room_size; }
    public function setMaxRoommates($max_roommates) { $this->max_roommates = $max_roommates; }
    //public function setIncludesExpenses($includes_expenses) { $this->includes_expenses = $includes_expenses; }
    public function setPetsAllowed($pets_allowed) { $this->pets_allowed = $pets_allowed; }
    public function setFurnished($furnished) { $this->furnished = $furnished; }
    //public function setCommonAreas($common_areas) { $this->common_areas = $common_areas; }
    public function setStudentsOnly($students_only) { $this->students_only = $students_only; }
    public function setGenderRestriction($gender_restriction) { $this->gender_restriction = $gender_restriction; }
}