<?php

namespace dtos;

/**
 * DTO (Data Transfer Object) para la entidad Property.
 *
 * Esta clase se utiliza para transferir los datos de una propiedad entre capas de la aplicación,
 * como la base de datos, la lógica de negocio y la capa de presentación o API.
 * Permite exponer solo los datos necesarios de la propiedad, evitando exponer la lógica interna del modelo de dominio.
 *
 * Propiedades:
 * - int $id                        ID de la propiedad.
 * - string $property_type          Tipo de propiedad (Habitación, Estudio, Piso, Casa).
 * - int $address_id                ID de la dirección asociada.
 * - int $built_size                Tamaño construido de la propiedad (en m²).
 * - string $status                 Estado de la propiedad (Obra nueva, Reformado, etc.).
 * - bool $immediate_availability   Indica si la propiedad está disponible inmediatamente.
 * - int $user_id                   ID del usuario propietario.
 * - string $main_image             Ruta de la imagen principal de la propiedad (image_path de ImageDto).
 * - string[] $images               Array de rutas de imágenes (image_path de ImageDto) asociadas a la propiedad.
 *
 * Métodos:
 * - __construct: Inicializa el DTO con los datos de la propiedad.
 */
class PropertyDto
{
    public $id;
    public $property_type;
    public $address_id;
    public $built_size;
    public $status;
    public $immediate_availability;
    public $user_id;
    public $main_image;
    public $images = [];

    /**
     * Constructor de PropertyDto.
     *
     * @param int $id ID de la propiedad.
     * @param string $property_type Tipo de propiedad (Habitación, Estudio, Piso, Casa).
     * @param int $address_id ID de la dirección asociada.
     * @param int $built_size Tamaño construido de la propiedad (en m²).
     * @param string $status Estado de la propiedad (Obra nueva, Reformado, etc.).
     * @param bool $immediate_availability Indica si la propiedad está disponible inmediatamente.
     * @param int $user_id ID del usuario propietario.
     * @param string $main_image Ruta de la imagen principal de la propiedad (image_path de ImageDto).
     * @param string[] $images (opcional) Array de rutas de imágenes (image_path de ImageDto) asociadas a la propiedad.
     */
    public function __construct(
        $id,
        $property_type,
        $address_id,
        $built_size,
        $status,
        $immediate_availability,
        $user_id,
        $main_image,
        $images = []
    ) {
        $this->id = $id;
        $this->property_type = $property_type;
        $this->address_id = $address_id;
        $this->built_size = $built_size;
        $this->status = $status;
        $this->immediate_availability = $immediate_availability;
        $this->user_id = $user_id;
        $this->main_image = $main_image;
        $this->images = $images;
    }
}
