<?php

namespace models;

/**
 * Modelo de dominio para representar una casa.
 *
 * Esta clase encapsula los datos y comportamientos relacionados con una casa.
 * Permite almacenar información relevante como el tipo de casa, tamaño del jardín, número de plantas,
 * habitaciones, baños, si tiene garaje o piscina privada, si está amueblada, terraza, trastero,
 * aire acondicionado y si se permiten mascotas.
 * Se utiliza para transferir información entre las capas de dominio, presentación y persistencia.
 *
 * Propiedades:
 * - int $property_id           ID de la propiedad asociada.
 * - string $house_type         Tipo de casa.
 * - int $garden_size           Tamaño del jardín.
 * - int $num_floors            Número de plantas.
 * - int $num_rooms             Número de habitaciones.
 * - int $num_bathrooms         Número de baños.
 * - bool $private_garage       Indica si tiene garaje privado.
 * - bool $private_pool         Indica si tiene piscina privada.
 * - bool $furnished            Indica si está amueblada.
 * - bool $terrace              Indica si tiene terraza.
 * - bool $storage_room         Indica si tiene trastero.
 * - bool $air_conditioning     Indica si tiene aire acondicionado.
 * - bool $pets_allowed         Indica si se permiten mascotas.
 *
 * Métodos:
 * - __construct: Inicializa el modelo con los datos de la casa.
 * - Getters y setters para cada propiedad.
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
     * @param int    $property_id       ID de la propiedad asociada.
     * @param string $house_type        Tipo de casa.
     * @param int    $garden_size       Tamaño del jardín.
     * @param int    $num_floors        Número de plantas.
     * @param int    $num_rooms         Número de habitaciones.
     * @param int    $num_bathrooms     Número de baños.
     * @param bool   $private_garage    Indica si tiene garaje privado.
     * @param bool   $private_pool      Indica si tiene piscina privada.
     * @param bool   $furnished         Indica si está amueblada.
     * @param bool   $terrace           Indica si tiene terraza.
     * @param bool   $storage_room      Indica si tiene trastero.
     * @param bool   $air_conditioning  Indica si tiene aire acondicionado.
     * @param bool   $pets_allowed      Indica si se permiten mascotas.
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

    /**
     * Obtiene el ID de la propiedad asociada.
     * @return int
     */
    public function getPropertyId() { return $this->property_id; }

    /**
     * Obtiene el tipo de casa.
     * @return string
     */
    public function getHouseType() { return $this->house_type; }

    /**
     * Obtiene el tamaño del jardín.
     * @return int
     */
    public function getGardenSize() { return $this->garden_size; }

    /**
     * Obtiene el número de plantas.
     * @return int
     */
    public function getNumFloors() { return $this->num_floors; }

    /**
     * Obtiene el número de habitaciones.
     * @return int
     */
    public function getNumRooms() { return $this->num_rooms; }

    /**
     * Obtiene el número de baños.
     * @return int
     */
    public function getNumBathrooms() { return $this->num_bathrooms; }

    /**
     * Indica si tiene garaje privado.
     * @return bool
     */
    public function getPrivateGarage() { return $this->private_garage; }

    /**
     * Indica si tiene piscina privada.
     * @return bool
     */
    public function getPrivatePool() { return $this->private_pool; }

    /**
     * Indica si está amueblada.
     * @return bool
     */
    public function getFurnished() { return $this->furnished; }

    /**
     * Indica si tiene terraza.
     * @return bool
     */
    public function getTerrace() { return $this->terrace; }

    /**
     * Indica si tiene trastero.
     * @return bool
     */
    public function getStorageRoom() { return $this->storage_room; }

    /**
     * Indica si tiene aire acondicionado.
     * @return bool
     */
    public function getAirConditioning() { return $this->air_conditioning; }

    /**
     * Indica si se permiten mascotas.
     * @return bool
     */
    public function getPetsAllowed() { return $this->pets_allowed; }

    // Setters

    /**
     * Establece el ID de la propiedad asociada.
     * @param int $property_id
     */
    public function setPropertyId($property_id) { $this->property_id = $property_id; }

    /**
     * Establece el tipo de casa.
     * @param string $house_type
     */
    public function setHouseType($house_type) { $this->house_type = $house_type; }

    /**
     * Establece el tamaño del jardín.
     * @param int $garden_size
     */
    public function setGardenSize($garden_size) { $this->garden_size = $garden_size; }

    /**
     * Establece el número de plantas.
     * @param int $num_floors
     */
    public function setNumFloors($num_floors) { $this->num_floors = $num_floors; }

    /**
     * Establece el número de habitaciones.
     * @param int $num_rooms
     */
    public function setNumRooms($num_rooms) { $this->num_rooms = $num_rooms; }

    /**
     * Establece el número de baños.
     * @param int $num_bathrooms
     */
    public function setNumBathrooms($num_bathrooms) { $this->num_bathrooms = $num_bathrooms; }

    /**
     * Establece si tiene garaje privado.
     * @param bool $private_garage
     */
    public function setPrivateGarage($private_garage) { $this->private_garage = $private_garage; }

    /**
     * Establece si tiene piscina privada.
     * @param bool $private_pool
     */
    public function setPrivatePool($private_pool) { $this->private_pool = $private_pool; }

    /**
     * Establece si está amueblada.
     * @param bool $furnished
     */
    public function setFurnished($furnished) { $this->furnished = $furnished; }

    /**
     * Establece si tiene terraza.
     * @param bool $terrace
     */
    public function setTerrace($terrace) { $this->terrace = $terrace; }

    /**
     * Establece si tiene trastero.
     * @param bool $storage_room
     */
    public function setStorageRoom($storage_room) { $this->storage_room = $storage_room; }

    /**
     * Establece si tiene aire acondicionado.
     * @param bool $air_conditioning
     */
    public function setAirConditioning($air_conditioning) { $this->air_conditioning = $air_conditioning; }

    /**
     * Establece si se permiten mascotas.
     * @param bool $pets_allowed
     */
    public function setPetsAllowed($pets_allowed) { $this->pets_allowed = $pets_allowed; }
}