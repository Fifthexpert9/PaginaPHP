<?php

namespace models;

/**
 * Modelo de dominio para representar un estudio.
 */
class StudioModel {
    /**
     * @var int ID de la propiedad asociada.
     */
    private $property_id;
    /**
     * @var bool Indica si está amueblado.
     */
    private $furnished;
    /**
     * @var bool Indica si tiene balcón.
     */
    private $balcony;
    /**
     * @var bool Indica si tiene aire acondicionado.
     */
    private $air_conditioning;
    /**
     * @var bool Indica si se permiten mascotas.
     */
    private $pets_allowed;

    /**
     * Constructor de StudioModel.
     *
     * @param int $property_id ID de la propiedad asociada.
     * @param bool $furnished Indica si está amueblado.
     * @param bool $balcony Indica si tiene balcón.
     * @param bool $air_conditioning Indica si tiene aire acondicionado.
     * @param bool $pets_allowed Indica si se permiten mascotas.
     */
    public function __construct(
        $property_id,
        $furnished,
        $balcony,
        $air_conditioning,
        $pets_allowed
    ) {
        $this->property_id = $property_id;
        $this->furnished = $furnished;
        $this->balcony = $balcony;
        $this->air_conditioning = $air_conditioning;
        $this->pets_allowed = $pets_allowed;
    }

    // Getters
    public function getPropertyId() { return $this->property_id; }
    public function getFurnished() { return $this->furnished; }
    public function getBalcony() { return $this->balcony; }
    public function getAirConditioning() { return $this->air_conditioning; }
    public function getPetsAllowed() { return $this->pets_allowed; }

    // Setters
    public function setPropertyId($property_id) { $this->property_id = $property_id; }
    public function setFurnished($furnished) { $this->furnished = $furnished; }
    public function setBalcony($balcony) { $this->balcony = $balcony; }
    public function setAirConditioning($air_conditioning) { $this->air_conditioning = $air_conditioning; }
    public function setPetsAllowed($pets_allowed) { $this->pets_allowed = $pets_allowed; }
}