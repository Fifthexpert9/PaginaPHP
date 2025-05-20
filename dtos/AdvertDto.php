<?php

namespace dtos;

/**
 * DTO para exponer información de un anuncio.
 *
 * @property int $id ID del anuncio.
 * @property int $property_id ID de la propiedad asociada.
 * @property int $user_id ID del usuario que publica el anuncio.
 * @property float $price Precio del anuncio.
 * @property string $action Acción del anuncio (por ejemplo, 'alquiler', 'venta').
 * @property string $description Descripción del anuncio.
 * @property string $created_at Fecha de creación del anuncio.
 */
class AdvertDto {
    public $id;
    public $property_id;
    public $user_id;
    public $price;
    public $action;
    public $description;
    public $created_at;

    /**
     * Constructor de AdvertDto.
     *
     * @param int $id ID del anuncio.
     * @param int $property_id ID de la propiedad asociada.
     * @param int $user_id ID del usuario que publica el anuncio.
     * @param float $price Precio del anuncio.
     * @param string $action Acción del anuncio (por ejemplo, 'alquiler', 'venta').
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

    /**
     * Devuelve el anuncio como un array asociativo.
     *
     * @return array<string, mixed> Datos del anuncio.
     */
    public function toArray() {
        return [
            'id' => $this->id,
            'property_id' => $this->property_id,
            'user_id' => $this->user_id,
            'price' => $this->price,
            'action' => $this->action,
            'description' => $this->description,
            'created_at' => $this->created_at
        ];
    }
}