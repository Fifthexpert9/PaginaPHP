<?php

namespace models;

class FavoritesModel {
    private $id;
    private $user_id;
    private $advert_id;
    private $created_at;

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
    public function getId() { return $this->id; }
    public function getUserId() { return $this->user_id; }
    public function getAdvertId() { return $this->advert_id; }
    public function getCreatedAt() { return $this->created_at; }

    // Setters
    public function setUserId($user_id) { $this->user_id = $user_id; }
    public function setAdvertId($advert_id) { $this->advert_id = $advert_id; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }

}
