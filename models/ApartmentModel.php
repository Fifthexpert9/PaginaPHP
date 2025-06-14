<?php

namespace models;

/**
 * Modelo de dominio para representar un apartamento.
 *
 * Esta clase encapsula los datos y comportamientos relacionados con un apartamento.
 * Permite almacenar información relevante como el tipo de apartamento, número de habitaciones, baños, si está amueblado,
 * si tiene balcón, planta, ascensor, aire acondicionado, garaje y si se permiten mascotas.
 * Se utiliza para transferir información entre las capas de dominio, presentación y persistencia.
 *
 * Propiedades:
 * - int $property_id           ID de la propiedad asociada.
 * - string $apartment_type     Tipo de apartamento.
 * - int $num_rooms             Número de habitaciones.
 * - int $num_bathrooms         Número de baños.
 * - bool $furnished            Indica si está amueblado.
 * - bool $balcony              Indica si tiene balcón.
 * - int $floor                 Planta en la que se encuentra.
 * - bool $elevator             Indica si tiene ascensor.
 * - bool $air_conditioning     Indica si tiene aire acondicionado.
 * - bool $garage               Indica si tiene garaje.
 * - bool $pets_allowed         Indica si se permiten mascotas.
 *
 * Métodos:
 * - __construct: Inicializa el modelo con los datos del apartamento.
 * - Getters y setters para cada propiedad.
 */
class ApartmentModel
{
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
     * @var bool Indica si se permiten mascotas.
     */
    private $pets_allowed;

    /**
     * Constructor de ApartmentModel.
     *
     * @param int    $property_id       ID de la propiedad asociada.
     * @param string $apartment_type    Tipo de apartamento.
     * @param int    $num_rooms         Número de habitaciones.
     * @param int    $num_bathrooms     Número de baños.
     * @param bool   $furnished         Indica si está amueblado.
     * @param bool   $balcony           Indica si tiene balcón.
     * @param int    $floor             Planta en la que se encuentra.
     * @param bool   $elevator          Indica si tiene ascensor.
     * @param bool   $air_conditioning  Indica si tiene aire acondicionado.
     * @param bool   $garage            Indica si tiene garaje.
     * @param bool   $pets_allowed      Indica si se permiten mascotas.
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
        $this->pets_allowed = $pets_allowed;
    }

    // Getters

    /**
     * Obtiene el ID de la propiedad asociada.
     * @return int
     */
    public function getPropertyId()
    {
        return $this->property_id;
    }

    /**
     * Obtiene el tipo de apartamento.
     * @return string
     */
    public function getApartmentType()
    {
        return $this->apartment_type;
    }

    /**
     * Obtiene el número de habitaciones.
     * @return int
     */
    public function getNumRooms()
    {
        return $this->num_rooms;
    }

    /**
     * Obtiene el número de baños.
     * @return int
     */
    public function getNumBathrooms()
    {
        return $this->num_bathrooms;
    }

    /**
     * Indica si está amueblado.
     * @return bool
     */
    public function isFurnished()
    {
        return $this->furnished;
    }

    /**
     * Indica si tiene balcón.
     * @return bool
     */
    public function hasBalcony()
    {
        return $this->balcony;
    }

    /**
     * Obtiene la planta en la que se encuentra.
     * @return int
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Indica si tiene ascensor.
     * @return bool
     */
    public function hasElevator()
    {
        return $this->elevator;
    }

    /**
     * Indica si tiene aire acondicionado.
     * @return bool
     */
    public function hasAirConditioning()
    {
        return $this->air_conditioning;
    }

    /**
     * Indica si tiene garaje.
     * @return bool
     */
    public function hasGarage()
    {
        return $this->garage;
    }

    /**
     * Indica si se permiten mascotas.
     * @return bool
     */
    public function arePetsAllowed()
    {
        return $this->pets_allowed;
    }

    // Setters

    /**
     * Establece el ID de la propiedad asociada.
     * @param int $property_id
     */
    public function setPropertyId($property_id)
    {
        $this->property_id = $property_id;
    }

    /**
     * Establece el tipo de apartamento.
     * @param string $apartment_type
     */
    public function setApartmentType($apartment_type)
    {
        $this->apartment_type = $apartment_type;
    }

    /**
     * Establece el número de habitaciones.
     * @param int $num_rooms
     */
    public function setNumRooms($num_rooms)
    {
        $this->num_rooms = $num_rooms;
    }

    /**
     * Establece el número de baños.
     * @param int $num_bathrooms
     */
    public function setNumBathrooms($num_bathrooms)
    {
        $this->num_bathrooms = $num_bathrooms;
    }

    /**
     * Establece si está amueblado.
     * @param bool $furnished
     */
    public function setFurnished($furnished)
    {
        $this->furnished = $furnished;
    }

    /**
     * Establece si tiene balcón.
     * @param bool $balcony
     */
    public function setBalcony($balcony)
    {
        $this->balcony = $balcony;
    }

    /**
     * Establece la planta en la que se encuentra.
     * @param int $floor
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;
    }

    /**
     * Establece si tiene ascensor.
     * @param bool $elevator
     */
    public function setElevator($elevator)
    {
        $this->elevator = $elevator;
    }

    /**
     * Establece si tiene aire acondicionado.
     * @param bool $air_conditioning
     */
    public function setAirConditioning($air_conditioning)
    {
        $this->air_conditioning = $air_conditioning;
    }

    /**
     * Establece si tiene garaje.
     * @param bool $garage
     */
    public function setGarage($garage)
    {
        $this->garage = $garage;
    }

    /**
     * Establece si se permiten mascotas.
     * @param bool $pets_allowed
     */
    public function setPetsAllowed($pets_allowed)
    {
        $this->pets_allowed = $pets_allowed;
    }
}
