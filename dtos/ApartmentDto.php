<?php

namespace dtos;

/**
 * DTO para exponer información de un apartamento junto con los datos de la propiedad y la dirección.
 *
 * Este DTO agrupa toda la información relevante de un apartamento ofertado, incluyendo los datos generales de la propiedad,
 * la dirección (AddressDto), los datos específicos del apartamento y las imágenes relativas a él.
 * Se utiliza para transferir datos entre la capa de dominio y la capa de presentación o API.
 *
 * Propiedades:
 * - int $property_id                  ID de la propiedad.
 * - string $property_type             Tipo de propiedad.
 * - int $built_size                   Superficie construida (m²).
 * - string $status                    Estado del apartamento.
 * - bool $immediate_availability      Disponibilidad inmediata.
 * - int $user_id                      ID del usuario propietario.
 * - string $main_image                Ruta de la imagen principal de la propiedad.
 * - string[] $images                  Array de rutas de imágenes asociadas a la propiedad.
 * - AddressDto $address               Objeto con la dirección del apartamento.
 * - string $apartment_type            Tipo de apartamento.
 * - int $num_rooms                    Número de habitaciones.
 * - int $num_bathrooms                Número de baños.
 * - bool $furnished                   Indica si está amueblado.
 * - bool $balcony                     Indica si tiene balcón.
 * - int $floor                        Planta en la que se encuentra.
 * - bool $elevator                    Indica si tiene ascensor.
 * - bool $air_conditioning            Indica si tiene aire acondicionado.
 * - bool $garage                      Indica si tiene garaje.
 * - bool $pets_allowed                Indica si se permiten mascotas.
 *
 * Métodos:
 * - __construct: Inicializa el DTO con los datos del apartamento.
 * - toArray: Devuelve los datos del apartamento como un array asociativo.
 */
class ApartmentDto
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

    // Datos específicos del apartamento
    public $apartment_type;
    public $num_rooms;
    public $num_bathrooms;
    public $furnished;
    public $balcony;
    public $floor;
    public $elevator;
    public $air_conditioning;
    public $garage;
    public $pets_allowed;

    /**
     * Constructor de ApartmentDto.
     *
     * @param int $property_id ID de la propiedad.
     * @param string $property_type Tipo de propiedad.
     * @param int $built_size Superficie construida (m²).
     * @param string $status Estado del apartamento.
     * @param bool $immediate_availability Disponibilidad inmediata.
     * @param int $user_id ID del usuario propietario.
     * @param string $main_image Ruta de la imagen principal de la propiedad.
     * @param string[] $images (opcional) Array de rutas de imágenes asociadas a la propiedad.
     * @param AddressDto $address Objeto con la dirección del apartamento.
     * @param string $apartment_type Tipo de apartamento.
     * @param int $num_rooms Número de habitaciones.
     * @param int $num_bathrooms Número de baños.
     * @param bool $furnished Indica si está amueblado.
     * @param bool $balcony Indica si tiene balcón.
     * @param int $floor Planta en la que se encuentra.
     * @param bool $elevator Indica si tiene ascensor.
     * @param bool $air_conditioning Indica si tiene aire acondicionado.
     * @param bool $garage Indica si tiene garaje.
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
        $address,
        $apartment_type,
        $num_rooms,
        $num_bathrooms,
        $furnished,
        $balcony,
        $floor,
        $elevator,
        $air_conditioning,
        $garage,
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
        $this->apartment_type = $apartment_type;
        $this->num_rooms = $num_rooms;
        $this->num_bathrooms = $num_bathrooms;
        $this->furnished = $furnished;
        $this->balcony = $balcony;
        $this->floor = $floor;
        $this->elevator = $elevator;
        $this->air_conditioning = $air_conditioning;
        $this->garage = $garage;
        $this->pets_allowed = $pets_allowed;
    }

    /**
     * Devuelve el apartamento como un array asociativo.
     *
     * @return array<string, mixed> Datos del apartamento.
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
            'apartment_type' => $this->apartment_type,
            'num_rooms' => $this->num_rooms,
            'num_bathrooms' => $this->num_bathrooms,
            'furnished' => $this->furnished,
            'balcony' => $this->balcony,
            'floor' => $this->floor,
            'elevator' => $this->elevator,
            'air_conditioning' => $this->air_conditioning,
            'garage' => $this->garage,
            'pets_allowed' => $this->pets_allowed
        ];
    }
}
