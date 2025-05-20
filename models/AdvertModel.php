<?php

namespace models;

/**
 * Modelo de dominio para representar un anuncio.
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
     * @var string Fecha de creación del anuncio.
     */
    private $created_at;

    /**
     * Constructor de AdvertModel.
     *
     * @param int $id ID del anuncio.
     * @param int $property_id ID de la propiedad asociada.
     * @param int $user_id ID del usuario que publica el anuncio.
     * @param float $price Precio del anuncio.
     * @param string $action Acción del anuncio.
     * @param string $description Descripción del anuncio.
     * @param string $created_at Fecha de creación del anuncio.
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
     * @return int
     */
    public function getId() { return $this->id; }
    /**
     * @return int
     */
    public function getPropertyId() { return $this->property_id; }
    /**
     * @return int
     */
    public function getUserId() { return $this->user_id; }
    /**
     * @return float
     */
    public function getPrice() { return $this->price; }
    /**
     * @return string
     */
    public function getAction() { return $this->action; }
    /**
     * @return string
     */
    public function getDescription() { return $this->description; }
    /**
     * @return string
     */
    public function getCreatedAt() { return $this->created_at; }

    // Setters
    /**
     * @param int $property_id
     */
    public function setPropertyId($property_id) { $this->property_id = $property_id; }
    /**
     * @param int $user_id
     */
    public function setUserId($user_id) { $this->user_id = $user_id; }
    /**
     * @param float $price
     */
    public function setPrice($price) { $this->price = $price; }
    /**
     * @param string $action
     */
    public function setAction($action) { $this->action = $action; }
    /**
     * @param string $description
     */
    public function setDescription($description) { $this->description = $description; }
    /**
     * @param string $created_at
     */
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }

}
