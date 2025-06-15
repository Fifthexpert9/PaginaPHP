<?php

namespace dtos;

/**
 * DTO (Data Transfer Object) para transferir información de imágenes entre capas.
 *
 * Este DTO se utiliza para exponer solo los datos necesarios de una imagen a la capa de presentación o API,
 * evitando exponer la lógica interna del modelo de dominio.
 *
 * Propiedades:
 * - int $id                ID de la imagen.
 * - int $propertyId        ID de la propiedad asociada.
 * - string $imagePath      Ruta de la imagen.
 * - bool $isMain           Indica si es la imagen principal.
 * - string|null $uploadedAt Fecha de subida de la imagen (opcional).
 *
 * Métodos:
 * - __construct: Inicializa el DTO con los datos de la imagen.
 * - toArray: Devuelve los datos de la imagen como un array asociativo.
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
     * @param int         $id           ID de la imagen.
     * @param int         $propertyId   ID de la propiedad asociada.
     * @param string      $imagePath    Ruta de la imagen.
     * @param bool        $isMain       Indica si es la imagen principal.
     * @param string|null $uploadedAt   Fecha de subida de la imagen (opcional).
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
     * @return array<string, mixed> Datos de la imagen.
     */
    public function toArray() {
        return get_object_vars($this);
    }
}