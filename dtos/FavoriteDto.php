<?php

namespace dtos;

/**
 * DTO para exponer información de un favorito (relación usuario-anuncio).
 */
class FavoriteDto {
    public $id;
    public $user_id;
    public $advert_id;
    public $created_at;

    public function __construct($id, $user_id, $advert_id, $created_at = null) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->advert_id = $advert_id;
        $this->created_at = $created_at;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'advert_id' => $this->advert_id,
            'created_at' => $this->created_at
        ];
    }
}