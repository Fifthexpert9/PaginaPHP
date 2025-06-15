<?php

namespace dtos;

/**
 * DTO para exponer información de un estudio junto con los datos de la propiedad y la dirección.
 *
 * Este DTO agrupa toda la información relevante de un estudio ofertado, incluyendo los datos generales de la propiedad,
 * la dirección (AddressDto), los datos específicos del estudio y las imágenes relativas a él.
 * Se utiliza para transferir datos entre la capa de dominio y la capa de presentación o API.
 *
 * Propiedades:
 * - int $property_id                ID de la propiedad.
 * - string $property_type           Tipo de propiedad.
 * - int $built_size                 Superficie construida (m²).
 * - string $status                  Estado del estudio.
 * - bool $immediate_availability    Disponibilidad inmediata.
 * - int $user_id                    ID del usuario propietario.
 * - string $main_image              Ruta de la imagen principal de la propiedad (image_path de ImageDto).
 * - string[] $images                Array de rutas de imágenes (image_path de ImageDto) asociadas a la propiedad.
 * - AddressDto $address             Objeto con la dirección del estudio.
 * - bool $furnished                 Indica si está amueblado.
 * - bool $balcony                   Indica si tiene balcón.
 * - bool $air_conditioning          Indica si tiene aire acondicionado.
 * - bool $pets_allowed              Indica si se permiten mascotas.
 *
 * Métodos:
 * - __construct: Inicializa el DTO con los datos del estudio.
 * - toArray: Devuelve los datos del estudio como un array asociativo.
 */
class StudioDto
{
    // Datos de la propiedad
    public $property_id;
    public $property_type;
    public $built_size;
    public $status;
    public $immediate_availability;
    public $user_id;
    public $main_image;
    public $images = [];

    // Dirección (AddressDto)
    public $address;

    // Datos específicos del estudio
    public $furnished;
    public $balcony;
    public $air_conditioning;
    public $pets_allowed;

    /**
     * Constructor de StudioDto.
     *
     * @param int $property_id ID de la propiedad.
     * @param string $property_type Tipo de propiedad.
     * @param int $built_size Superficie construida (m²).
     * @param string $status Estado del estudio.
     * @param bool $immediate_availability Disponibilidad inmediata.
     * @param int $user_id ID del usuario propietario.
     * @param string $main_image Ruta de la imagen principal de la propiedad (image_path de ImageDto).
     * @param string[] $images (opcional) Array de rutas de imágenes (image_path de ImageDto) asociadas a la propiedad.
     * @param AddressDto $address Objeto con la dirección del estudio.
     * @param bool $furnished Indica si está amueblado.
     * @param bool $balcony Indica si tiene balcón.
     * @param bool $air_conditioning Indica si tiene aire acondicionado.
     * @param bool $pets_allowed Indica si se permiten mascotas.
     */
    public function __construct(
        $property_id,
        $property_type,
        $built_size,
        $status,
        $immediate_availability,
        $user_id,
        $main_image,
        $images = [],
        $address, // AddressDto
        $furnished,
        $balcony,
        $air_conditioning,
        $pets_allowed
    ) {
        $this->property_id = $property_id;
        $this->property_type = $property_type;
        $this->built_size = $built_size;
        $this->status = $status;
        $this->immediate_availability = $immediate_availability;
        $this->user_id = $user_id;
        $this->main_image = $main_image;
        $this->images = $images;
        $this->address = $address;
        $this->furnished = $furnished;
        $this->balcony = $balcony;
        $this->air_conditioning = $air_conditioning;
        $this->pets_allowed = $pets_allowed;
    }

    /**
     * Devuelve el estudio como un array asociativo.
     *
     * @return array<string, mixed> Datos del estudio.
     */
    public function toArray()
    {
        return [
            'property_id' => $this->property_id,
            'property_type' => $this->property_type,
            'built_size' => $this->built_size,
            'status' => $this->status,
            'immediate_availability' => $this->immediate_availability,
            'user_id' => $this->user_id,
            'main_image' => $this->main_image,
            'images' => $this->images,
            'address' => $this->address ? $this->address->toArray() : null,
            'furnished' => $this->furnished,
            'balcony' => $this->balcony,
            'air_conditioning' => $this->air_conditioning,
            'pets_allowed' => $this->pets_allowed
        ];
    }
}
