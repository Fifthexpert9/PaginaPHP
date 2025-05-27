<?php

namespace dtos;

/**
 * DTO para exponer información de un anuncio.
 *
 * Este DTO agrupa toda la información relevante de un anuncio publicado en la plataforma,
 * incluyendo los datos básicos del anuncio y la ruta de la imagen principal de la propiedad asociada.
 * Se utiliza para transferir datos entre la capa de dominio y la capa de presentación o API.
 *
 * @property int $id ID del anuncio.
 * @property int $property_id ID de la propiedad asociada.
 * @property int $user_id ID del usuario que publica el anuncio.
 * @property float $price Precio del anuncio.
 * @property string $action Acción del anuncio (por ejemplo, 'alquiler', 'venta').
 * @property string $description Descripción del anuncio.
 * @property string $created_at Fecha de creación del anuncio.
 * @property string $main_image Ruta de la imagen principal asociada al anuncio.
 */
class AdvertDto {
    /**
     * @var int ID del anuncio.
     */
    public $id;

    /**
     * @var int ID de la propiedad asociada.
     */
    public $property_id;

    /**
     * @var int ID del usuario que publica el anuncio.
     */
    public $user_id;

    /**
     * @var float Precio del anuncio.
     */
    public $price;

    /**
     * @var string Acción del anuncio (por ejemplo, 'alquiler', 'venta').
     */
    public $action;

    /**
     * @var string Descripción del anuncio.
     */
    public $description;

    /**
     * @var string Fecha de creación del anuncio.
     */
    public $created_at;

    /**
     * @var string Ruta de la imagen principal asociada al anuncio.
     */
    public $main_image;

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
     * @param string $main_image Ruta de la imagen principal asociada al anuncio.
     */
    public function __construct(
        $id,
        $property_id,
        $user_id,
        $price,
        $action,
        $description,
        $created_at,
        $main_image = null
    ) {
        $this->id = $id;
        $this->property_id = $property_id;
        $this->user_id = $user_id;
        $this->price = $price;
        $this->action = $action;
        $this->description = $description;
        $this->created_at = $created_at;
        $this->main_image = $main_image;
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
            'created_at' => $this->created_at,
            'main_image' => $this->main_image
        ];
    }
}