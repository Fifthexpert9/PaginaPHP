<?php

namespace dtos;

/**
 * DTO para exponer información de una habitación junto con los datos de la propiedad y la dirección.
 *
 * Este DTO agrupa toda la información relevante de una habitación ofertada, incluyendo los datos generales de la propiedad,
 * la dirección (AddressDto), los datos específicos de la habitación y las imágenes relativas a ella.
 * Se utiliza para transferir datos entre la capa de dominio y la capa de presentación o API.
 *
 * Propiedades:
 * - int $property_id                ID de la propiedad.
 * - string $property_type           Tipo de propiedad.
 * - int $built_size                 Superficie construida (m²).
 * - string $status                  Estado de la propiedad.
 * - bool $immediate_availability    Disponibilidad inmediata.
 * - int $user_id                    ID del usuario propietario.
 * - string $main_image              Ruta de la imagen principal de la propiedad (image_path de ImageDto).
 * - string[] $images                Array de rutas de imágenes (image_path de ImageDto) asociadas a la propiedad.
 * - AddressDto $address             Objeto con la dirección de la propiedad.
 * - bool $private_bathroom          Indica si la habitación tiene baño privado.
 * - int $max_roommates              Número máximo de compañeros.
 * - bool $pets_allowed              Indica si se permiten mascotas.
 * - bool $furnished                 Indica si está amueblada.
 * - bool $students_only             Indica si es solo para estudiantes.
 * - string $gender_restriction      Restricción de género.
 *
 * Métodos:
 * - __construct: Inicializa el DTO con los datos de la habitación.
 * - toArray: Devuelve los datos de la habitación como un array asociativo.
 */
class RoomDto
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

    // Datos específicos de la habitación
    public $private_bathroom;
    public $max_roommates;
    public $pets_allowed;
    public $furnished;
    public $students_only;
    public $gender_restriction;

    /**
     * Constructor de RoomDto.
     *
     * @param int $property_id ID de la propiedad.
     * @param string $property_type Tipo de propiedad.
     * @param int $built_size Superficie construida (m²).
     * @param string $status Estado de la propiedad.
     * @param bool $immediate_availability Disponibilidad inmediata.
     * @param int $user_id ID del usuario propietario.
     * @param string $main_image Ruta de la imagen principal de la propiedad (image_path de ImageDto).
     * @param string[] $images (opcional) Array de rutas de imágenes (image_path de ImageDto) asociadas a la propiedad.
     * @param AddressDto $address Objeto con la dirección de la propiedad.
     * @param bool $private_bathroom Indica si la habitación tiene baño privado.
     * @param int $max_roommates Número máximo de compañeros.
     * @param bool $pets_allowed Indica si se permiten mascotas.
     * @param bool $furnished Indica si está amueblada.
     * @param bool $students_only Indica si es solo para estudiantes.
     * @param string $gender_restriction Restricción de género.
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
        $address,
        $private_bathroom,
        $max_roommates,
        $pets_allowed,
        $furnished,
        $students_only,
        $gender_restriction
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
        $this->private_bathroom = $private_bathroom;
        $this->max_roommates = $max_roommates;
        $this->pets_allowed = $pets_allowed;
        $this->furnished = $furnished;
        $this->students_only = $students_only;
        $this->gender_restriction = $gender_restriction;
    }

    /**
     * Devuelve la habitación como un array asociativo.
     *
     * @return array<string, mixed> Datos de la habitación.
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
            'private_bathroom' => $this->private_bathroom,
            'max_roommates' => $this->max_roommates,
            'pets_allowed' => $this->pets_allowed,
            'furnished' => $this->furnished,
            'students_only' => $this->students_only,
            'gender_restriction' => $this->gender_restriction
        ];
    }
}
