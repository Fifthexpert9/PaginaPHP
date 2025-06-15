<?php

namespace models;

/**
 * Modelo de dominio para representar un estudio.
 *
 * Esta clase encapsula los datos y comportamientos relacionados con un estudio (vivienda tipo "estudio").
 * Permite almacenar información relevante como si está amueblado, si tiene balcón, aire acondicionado y si se permiten mascotas.
 * Se utiliza para transferir información entre las capas de dominio, presentación y persistencia.
 *
 * Propiedades:
 * - int $property_id           ID de la propiedad asociada.
 * - bool $furnished            Indica si el estudio está amueblado.
 * - bool $balcony              Indica si el estudio tiene balcón.
 * - bool $air_conditioning     Indica si el estudio tiene aire acondicionado.
 * - bool $pets_allowed         Indica si se permiten mascotas en el estudio.
 *
 * Métodos:
 * - __construct: Inicializa el modelo con los datos del estudio.
 * - getPropertyId, getFurnished, getBalcony, getAirConditioning, getPetsAllowed: Getters.
 * - setPropertyId, setFurnished, setBalcony, setAirConditioning, setPetsAllowed: Setters.
 */
class StudioModel {
    /**
     * @var int ID de la propiedad asociada.
     */
    private $property_id;

    /**
     * @var bool Indica si el estudio está amueblado.
     */
    private $furnished;

    /**
     * @var bool Indica si el estudio tiene balcón.
     */
    private $balcony;

    /**
     * @var bool Indica si el estudio tiene aire acondicionado.
     */
    private $air_conditioning;

    /**
     * @var bool Indica si se permiten mascotas en el estudio.
     */
    private $pets_allowed;

    /**
     * Constructor de StudioModel.
     *
     * @param int  $property_id       ID de la propiedad asociada.
     * @param bool $furnished         Indica si está amueblado.
     * @param bool $balcony           Indica si tiene balcón.
     * @param bool $air_conditioning  Indica si tiene aire acondicionado.
     * @param bool $pets_allowed      Indica si se permiten mascotas.
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

    /**
     * Obtiene el ID de la propiedad asociada.
     * @return int
     */
    public function getPropertyId() { return $this->property_id; }

    /**
     * Indica si el estudio está amueblado.
     * @return bool
     */
    public function getFurnished() { return $this->furnished; }

    /**
     * Indica si el estudio tiene balcón.
     * @return bool
     */
    public function getBalcony() { return $this->balcony; }

    /**
     * Indica si el estudio tiene aire acondicionado.
     * @return bool
     */
    public function getAirConditioning() { return $this->air_conditioning; }

    /**
     * Indica si se permiten mascotas en el estudio.
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
     * Establece si el estudio está amueblado.
     * @param bool $furnished
     */
    public function setFurnished($furnished) { $this->furnished = $furnished; }

    /**
     * Establece si el estudio tiene balcón.
     * @param bool $balcony
     */
    public function setBalcony($balcony) { $this->balcony = $balcony; }

    /**
     * Establece si el estudio tiene aire acondicionado.
     * @param bool $air_conditioning
     */
    public function setAirConditioning($air_conditioning) { $this->air_conditioning = $air_conditioning; }

    /**
     * Establece si se permiten mascotas en el estudio.
     * @param bool $pets_allowed
     */
    public function setPetsAllowed($pets_allowed) { $this->pets_allowed = $pets_allowed; }
}