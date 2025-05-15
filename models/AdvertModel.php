<?php

namespace models;

class AdvertModel {
    private $id;
    private $property_id;
    private $user_id;
    private $price;
    private $action;
    private $description;
    private $created_at;

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
    public function getId() { return $this->id; }
    public function getPropertyId() { return $this->property_id; }
    public function getUserId() { return $this->user_id; }
    public function getPrice() { return $this->price; }
    public function getAction() { return $this->action; }
    public function getDescription() { return $this->description; }
    public function getCreatedAt() { return $this->created_at; }

    // Setters
    public function setPropertyId($property_id) { $this->property_id = $property_id; }
    public function setUserId($user_id) { $this->user_id = $user_id; }
    public function setPrice($price) { $this->price = $price; }
    public function setAction($action) { $this->action = $action; }
    public function setDescription($description) { $this->description = $description; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }

}
