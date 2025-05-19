<?php

namespace models;

/**
 * Modelo de dominio para representar un apartamento.
 */
class ApartmentModel {
    /**
     * @var int ID de la propiedad asociada.
     */
    private $property_id;
    /**
     * @var string Tipo de apartamento.
     */
    private $apartment_type;
    /**
     * @var int Número de habitaciones.
     */
    private $num_rooms;
    /**
     * @var int Número de baños.
     */
    private $num_bathrooms;
    /**
     * @var bool Indica si está amueblado.
     */
    private $furnished;
    /**
     * @var bool Indica si tiene balcón.
     */
    private $balcony;
    /**
     * @var int Planta en la que se encuentra.
     */
    private $floor;
    /**
     * @var bool Indica si tiene ascensor.
     */
    private $elevator;
    /**
     * @var bool Indica si tiene aire acondicionado.
     */
    private $air_conditioning;
    /**
     * @var bool Indica si tiene garaje.
     */
    private $garage;
    /**
     * @var bool Indica si tiene piscina.
     */
    private $pool;
    /**
     * @var bool Indica si se permiten mascotas.
     */
    private $pets_allowed;

    /**
     * Constructor de ApartmentModel.
     *
     * @param int $property_id ID de la propiedad asociada.
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
        $apartment_type,
        $num_rooms,
        $num_bathrooms,
        $furnished,
        $balcony,
        $floor,
        $elevator,
        $air_conditioning,
        $garage,
        $pool,
        $pets_allowed
    ) {
        $this->property_id = $property_id;
        $this->apartment_type = $apartment_type;
        $this->num_rooms = $num_rooms;
        $this->num_bathrooms = $num_bathrooms;
        $this->furnished = $furnished;
        $this->balcony = $balcony;
        $this->floor = $floor;
        $this->elevator = $elevator;
        $this->air_conditioning = $air_conditioning;
        $this->garage = $garage;
        $this->pool = $pool;
        $this->pets_allowed = $pets_allowed;
    }

    // Getters
    public function getPropertyId() { return $this->property_id; }
    public function getApartmentType() { return $this->apartment_type; }
    public function getNumRooms() { return $this->num_rooms; }
    public function getNumBathrooms() { return $this->num_bathrooms; }
    public function isFurnished() { return $this->furnished; }
    public function hasBalcony() { return $this->balcony; }
    public function getFloor() { return $this->floor; }
    public function hasElevator() { return $this->elevator; }
    public function hasAirConditioning() { return $this->air_conditioning; }
    public function hasGarage() { return $this->garage; }
    public function hasPool() { return $this->pool; }
    public function arePetsAllowed() { return $this->pets_allowed; }

    // Setters
    public function setPropertyId($property_id) { $this->property_id = $property_id; }
    public function setApartmentType($apartment_type) { $this->apartment_type = $apartment_type; }
    public function setNumRooms($num_rooms) { $this->num_rooms = $num_rooms; }
    public function setNumBathrooms($num_bathrooms) { $this->num_bathrooms = $num_bathrooms; }
    public function setFurnished($furnished) { $this->furnished = $furnished; }
    public function setBalcony($balcony) { $this->balcony = $balcony; }
    public function setFloor($floor) { $this->floor = $floor; }
    public function setElevator($elevator) { $this->elevator = $elevator; }
    public function setAirConditioning($air_conditioning) { $this->air_conditioning = $air_conditioning; }
    public function setGarage($garage) { $this->garage = $garage; }
    public function setPool($pool) { $this->pool = $pool; }
    public function setPetsAllowed($pets_allowed) { $this->pets_allowed = $pets_allowed; }
}