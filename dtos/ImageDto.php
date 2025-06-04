<?php

namespace dtos;

/**
 * DTO (Data Transfer Object) para transferir información de imágenes entre capas.
 *
 * Este DTO se utiliza para exponer solo los datos necesarios de una imagen a la capa de presentación o API,
 * evitando exponer la lógica interna del modelo de dominio.
 */
class ImageDto
{
    public $id;
    public $propertyId;
    public $imagePath;
    public $isMain;
    public $uploadedAt;

    /**
     * Constructor de ImageDto.
     *
     * @param int         $id
     * @param int         $propertyId
     * @param string      $imagePath
     * @param bool        $isMain
     * @param string|null $uploadedAt
     */
    public function __construct($id, $propertyId, $imagePath, $isMain = false, $uploadedAt = null)
    {
        $this->id = $id;
        $this->propertyId = $propertyId;
        $this->imagePath = $imagePath;
        $this->isMain = $isMain;
        $this->uploadedAt = $uploadedAt;
    }

    /**
     * Devuelve la imagen como un array asociativo.
     *
     * @return array<string, mixed>
     */
    public function toArray() {
        return get_object_vars($this);
    }
}