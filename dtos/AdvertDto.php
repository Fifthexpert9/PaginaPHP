<?php

namespace dtos;

/**
 * DTO para exponer información de un anuncio.
 */
class AdvertDto {
    public $id;
    public $property_id;
    public $user_id;
    public $price;
    public $action;
    public $description;
    public $created_at;
    public $title;

    public function __construct(
        $id,
        $property_id,
        $user_id,
        $price,
        $action,
        $description,
        $created_at,
        $title = null
    ) {
        $this->id = $id;
        $this->property_id = $property_id;
        $this->user_id = $user_id;
        $this->price = $price;
        $this->action = $action;
        $this->description = $description;
        $this->created_at = $created_at;
        $this->title = $title;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'property_id' => $this->property_id,
            'user_id' => $this->user_id,
            'price' => $this->price,
            'action' => $this->action,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'title' => $this->title
        ];
    }
}