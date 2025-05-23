<?php

namespace models;

/**
 * Modelo de dominio para representar la relación de favoritos entre usuario y anuncio.
 *
 * Esta clase encapsula los datos y comportamientos relacionados con la funcionalidad de favoritos,
 * permitiendo asociar un usuario con un anuncio marcado como favorito. Incluye información sobre
 * el usuario, el anuncio y la fecha en la que se marcó como favorito.
 * Se utiliza para transferir información entre las capas de dominio, presentación y persistencia.
 */
class FavoritesModel {
    /**
     * @var int ID del favorito (registro único en la tabla de favoritos).
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
     * @var string|null Fecha en la que se marcó como favorito (formato timestamp o datetime).
     */
    private $created_at;

    /**
     * Constructor de FavoritesModel.
     *
     * @param int         $id         ID del favorito.
     * @param int         $user_id    ID del usuario.
     * @param int         $advert_id  ID del anuncio.
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
     * Obtiene el ID del favorito.
     * @return int
     */
    public function getId() { return $this->id; }

    /**
     * Obtiene el ID del usuario que marcó el favorito.
     * @return int
     */
    public function getUserId() { return $this->user_id; }

    /**
     * Obtiene el ID del anuncio marcado como favorito.
     * @return int
     */
    public function getAdvertId() { return $this->advert_id; }

    /**
     * Obtiene la fecha en la que se marcó como favorito.
     * @return string|null
     */
    public function getCreatedAt() { return $this->created_at; }

    // Setters

    /**
     * Establece el ID del usuario que marcó el favorito.
     * @param int $user_id
     */
    public function setUserId($user_id) { $this->user_id = $user_id; }

    /**
     * Establece el ID del anuncio marcado como favorito.
     * @param int $advert_id
     */
    public function setAdvertId($advert_id) { $this->advert_id = $advert_id; }

    /**
     * Establece la fecha en la que se marcó como favorito.
     * @param string|null $created_at
     */
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
}
