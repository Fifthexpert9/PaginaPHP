<?php

namespace dtos;

/**
 * DTO para exponer información de un favorito (relación usuario-anuncio).
 *
 * @property int $id ID del favorito.
 * @property int $user_id ID del usuario que marcó el favorito.
 * @property int $advert_id ID del anuncio marcado como favorito.
 * @property string|null $created_at Fecha en la que se marcó como favorito.
 */
class FavoritesDto {
    public $id;
    public $user_id;
    public $advert_id;
    public $created_at;

    /**
     * Constructor de FavoritesDto.
     *
     * @param int $id ID del favorito.
     * @param int $user_id ID del usuario.
     * @param int $advert_id ID del anuncio.
     * @param string|null $created_at Fecha de creación (opcional).
     */
    public function __construct($id, $user_id, $advert_id, $created_at = null) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->advert_id = $advert_id;
        $this->created_at = $created_at;
    }

    /**
     * Devuelve el favorito como un array asociativo.
     *
     * @return array<string, mixed> Datos del favorito.
     */
    public function toArray() {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'advert_id' => $this->advert_id,
            'created_at' => $this->created_at
        ];
    }
}