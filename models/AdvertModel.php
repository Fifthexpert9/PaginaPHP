<?php

namespace models;

/**
 * Modelo de dominio para representar un anuncio.
 *
 * Esta clase encapsula los datos y comportamientos relacionados con un anuncio de una propiedad inmobiliaria.
 * Permite almacenar información relevante como el precio, la acción (alquiler/venta), la descripción, la fecha de creación, etc.
 * Se utiliza para transferir información entre las capas de dominio, presentación y persistencia.
 *
 * Propiedades:
 * - int $id             ID del anuncio.
 * - int $property_id    ID de la propiedad asociada.
 * - int $user_id        ID del usuario que publica el anuncio.
 * - float $price        Precio del anuncio.
 * - string $action      Acción del anuncio (por ejemplo, 'alquiler', 'venta').
 * - string $description Descripción del anuncio.
 * - string $created_at  Fecha de creación del anuncio (formato timestamp o datetime).
 *
 * Métodos:
 * - __construct: Inicializa el modelo con los datos del anuncio.
 * - Getters y setters para cada propiedad.
 */
class AdvertModel {
    /**
     * @var int ID del anuncio.
     */
    private $id;

    /**
     * @var int ID de la propiedad asociada.
     */
    private $property_id;

    /**
     * @var int ID del usuario que publica el anuncio.
     */
    private $user_id;

    /**
     * @var float Precio del anuncio.
     */
    private $price;

    /**
     * @var string Acción del anuncio (por ejemplo, 'alquiler', 'venta').
     */
    private $action;

    /**
     * @var string Descripción del anuncio.
     */
    private $description;

    /**
     * @var string Fecha de creación del anuncio (formato timestamp o datetime).
     */
    private $created_at;

    /**
     * Constructor de AdvertModel.
     *
     * @param int    $id           ID del anuncio.
     * @param int    $property_id  ID de la propiedad asociada.
     * @param int    $user_id      ID del usuario que publica el anuncio.
     * @param float  $price        Precio del anuncio.
     * @param string $action       Acción del anuncio (por ejemplo, 'alquiler', 'venta').
     * @param string $description  Descripción del anuncio.
     * @param string $created_at   Fecha de creación del anuncio.
     */
    public function __construct(
        $id,
        $property_id,
        $user_id,
        $price,
        $action,
        $description,
        $created_at
    ) {
        $this->id = $id;
        $this->property_id = $property_id;
        $this->user_id = $user_id;
        $this->price = $price;
        $this->action = $action;
        $this->description = $description;
        $this->created_at = $created_at;
    }

    // Getters

    /**
     * Obtiene el ID del anuncio.
     * @return int
     */
    public function getId() { return $this->id; }

    /**
     * Obtiene el ID de la propiedad asociada.
     * @return int
     */
    public function getPropertyId() { return $this->property_id; }

    /**
     * Obtiene el ID del usuario que publica el anuncio.
     * @return int
     */
    public function getUserId() { return $this->user_id; }

    /**
     * Obtiene el precio del anuncio.
     * @return float
     */
    public function getPrice() { return $this->price; }

    /**
     * Obtiene la acción del anuncio (por ejemplo, 'alquiler', 'venta').
     * @return string
     */
    public function getAction() { return $this->action; }

    /**
     * Obtiene la descripción del anuncio.
     * @return string
     */
    public function getDescription() { return $this->description; }

    /**
     * Obtiene la fecha de creación del anuncio.
     * @return string
     */
    public function getCreatedAt() { return $this->created_at; }

    // Setters

    /**
     * Establece el ID de la propiedad asociada.
     * @param int $property_id
     */
    public function setPropertyId($property_id) { $this->property_id = $property_id; }

    /**
     * Establece el ID del usuario que publica el anuncio.
     * @param int $user_id
     */
    public function setUserId($user_id) { $this->user_id = $user_id; }

    /**
     * Establece el precio del anuncio.
     * @param float $price
     */
    public function setPrice($price) { $this->price = $price; }

    /**
     * Establece la acción del anuncio.
     * @param string $action
     */
    public function setAction($action) { $this->action = $action; }

    /**
     * Establece la descripción del anuncio.
     * @param string $description
     */
    public function setDescription($description) { $this->description = $description; }

    /**
     * Establece la fecha de creación del anuncio.
     * @param string $created_at
     */
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
}
