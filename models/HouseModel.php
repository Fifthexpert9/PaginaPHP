<?php

namespace models;

/**
 * Modelo de dominio para representar una casa.
 */
class HouseModel {
    /**
     * @var int ID de la propiedad asociada.
     */
    private $property_id;
    /**
     * @var string Tipo de casa.
     */
    private $house_type;
    /**
     * @var int Tamaño del jardín.
     */
    private $garden_size;
    /**
     * @var int Número de plantas.
     */
    private $num_floors;
    /**
     * @var int Número de habitaciones.
     */
    private $num_rooms;
    /**
     * @var int Número de baños.
     */
    private $num_bathrooms;
    /**
     * @var bool Indica si tiene garaje privado.
     */
    private $private_garage;
    /**
     * @var bool Indica si tiene piscina privada.
     */
    private $private_pool;
    /**
     * @var bool Indica si está amueblada.
     */
    private $furnished;
    /**
     * @var bool Indica si tiene terraza.
     */
    private $terrace;
    /**
     * @var bool Indica si tiene trastero.
     */
    private $storage_room;
    /**
     * @var bool Indica si tiene aire acondicionado.
     */
    private $air_conditioning;
    /**
     * @var bool Indica si se permiten mascotas.
     */
    private $pets_allowed;

    /**
     * Constructor de HouseModel.
     *
     * @param int $property_id ID de la propiedad asociada.
     * @param string $house_type Tipo de casa.
     * @param int $garden_size Tamaño del jardín.
     * @param int $num_floors Número de plantas.
     * @param int $num_rooms Número de habitaciones.
     * @param int $num_bathrooms Número de baños.
     * @param bool $private_garage Indica si tiene garaje privado.
     * @param bool $private_pool Indica si tiene piscina privada.
     * @param bool $furnished Indica si está amueblada.
     * @param bool $terrace Indica si tiene terraza.
     * @param bool $storage_room Indica si tiene trastero.
     * @param bool $air_conditioning Indica si tiene aire acondicionado.
     * @param bool $pets_allowed Indica si se permiten mascotas.
     */
    public function __construct(
        $property_id,
        $house_type,
        $garden_size,
        $num_floors,
        $num_rooms,
        $num_bathrooms,
        $private_garage,
        $private_pool,
        $furnished,
        $terrace,
        $storage_room,
        $air_conditioning,
        $pets_allowed
    ) {
        $this->property_id = $property_id;
        $this->house_type = $house_type;
        $this->garden_size = $garden_size;
        $this->num_floors = $num_floors;
        $this->num_rooms = $num_rooms;
        $this->num_bathrooms = $num_bathrooms;
        $this->private_garage = $private_garage;
        $this->private_pool = $private_pool;
        $this->furnished = $furnished;
        $this->terrace = $terrace;
        $this->storage_room = $storage_room;
        $this->air_conditioning = $air_conditioning;
        $this->pets_allowed = $pets_allowed;
    }

    // Getters
    public function getPropertyId() { return $this->property_id; }
    public function getHouseType() { return $this->house_type; }
    public function getGardenSize() { return $this->garden_size; }
    public function getNumFloors() { return $this->num_floors; }
    public function getNumRooms() { return $this->num_rooms; }
    public function getNumBathrooms() { return $this->num_bathrooms; }
    public function getPrivateGarage() { return $this->private_garage; }
    public function getPrivatePool() { return $this->private_pool; }
    public function getFurnished() { return $this->furnished; }
    public function getTerrace() { return $this->terrace; }
    public function getStorageRoom() { return $this->storage_room; }
    public function getAirConditioning() { return $this->air_conditioning; }
    public function getPetsAllowed() { return $this->pets_allowed; }

    // Setters
    public function setPropertyId($property_id) { $this->property_id = $property_id; }
    public function setHouseType($house_type) { $this->house_type = $house_type; }
    public function setGardenSize($garden_size) { $this->garden_size = $garden_size; }
    public function setNumFloors($num_floors) { $this->num_floors = $num_floors; }
    public function setNumRooms($num_rooms) { $this->num_rooms = $num_rooms; }
    public function setNumBathrooms($num_bathrooms) { $this->num_bathrooms = $num_bathrooms; }
    public function setPrivateGarage($private_garage) { $this->private_garage = $private_garage; }
    public function setPrivatePool($private_pool) { $this->private_pool = $private_pool; }
    public function setFurnished($furnished) { $this->furnished = $furnished; }
    public function setTerrace($terrace) { $this->terrace = $terrace; }
    public function setStorageRoom($storage_room) { $this->storage_room = $storage_room; }
    public function setAirConditioning($air_conditioning) { $this->air_conditioning = $air_conditioning; }
    public function setPetsAllowed($pets_allowed) { $this->pets_allowed = $pets_allowed; }
}