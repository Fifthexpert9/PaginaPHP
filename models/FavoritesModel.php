<?php

namespace models;

/**
 * Modelo de dominio para representar la relación de favoritos entre usuario y anuncio.
 */
class FavoritesModel {
    /**
     * @var int ID del favorito.
     */
    private $id;
    /**
     * @var int ID del usuario que marcó el favorito.
     */
    private $user_id;
    /**
     * @var int ID del anuncio marcado como favorito.
     */
    private $advert_id;
    /**
     * @var string|null Fecha en la que se marcó como favorito.
     */
    private $created_at;

    /**
     * Constructor de FavoritesModel.
     *
     * @param int $id ID del favorito.
     * @param int $user_id ID del usuario.
     * @param int $advert_id ID del anuncio.
     * @param string|null $created_at Fecha de creación (opcional).
     */
    public function __construct(
        $id,
        $user_id,
        $advert_id,
        $created_at
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->advert_id = $advert_id;
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
    public function getUserId() { return $this->user_id; }
    /**
     * @return int
     */
    public function getAdvertId() { return $this->advert_id; }
    /**
     * @return string|null
     */
    public function getCreatedAt() { return $this->created_at; }

    // Setters
    /**
     * @param int $user_id
     */
    public function setUserId($user_id) { $this->user_id = $user_id; }
    /**
     * @param int $advert_id
     */
    public function setAdvertId($advert_id) { $this->advert_id = $advert_id; }
    /**
     * @param string|null $created_at
     */
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }

}
