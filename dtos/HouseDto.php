<?php

namespace dtos;

/**
 * DTO para exponer información de una casa junto con los datos de la propiedad, la dirección y las imágenes.
 *
 * Este DTO agrupa toda la información relevante de una casa ofertada, incluyendo los datos generales de la propiedad,
 * la dirección (AddressDto), los datos específicos de la casa y las imágenes relativas a ella.
 * Se utiliza para transferir datos entre la capa de dominio y la capa de presentación o API.
 *
 * Propiedades:
 * - int $property_id                  ID de la propiedad.
 * - string $property_type             Tipo de propiedad.
 * - int $built_size                   Superficie construida (m²).
 * - string $status                    Estado de la casa.
 * - bool $immediate_availability      Disponibilidad inmediata.
 * - int $user_id                      ID del usuario propietario.
 * - string $main_image                Ruta de la imagen principal de la casa.
 * - string[] $images                  Array de rutas de imágenes asociadas a la casa.
 * - AddressDto $address               Objeto con la dirección de la casa.
 * - string $house_type                Tipo de casa.
 * - int $garden_size                  Tamaño del jardín.
 * - int $num_floors                   Número de plantas.
 * - int $num_rooms                    Número de habitaciones.
 * - int $num_bathrooms                Número de baños.
 * - bool $private_garage              Indica si tiene garaje privado.
 * - bool $private_pool                Indica si tiene piscina privada.
 * - bool $furnished                   Indica si está amueblada.
 * - bool $terrace                     Indica si tiene terraza.
 * - bool $storage_room                Indica si tiene trastero.
 * - bool $air_conditioning            Indica si tiene aire acondicionado.
 * - bool $pets_allowed                Indica si se permiten mascotas.
 *
 * Métodos:
 * - __construct: Inicializa el DTO con los datos de la casa.
 * - toArray: Devuelve los datos de la casa como un array asociativo.
 */
class HouseDto
{
    // Datos de la propiedad
    public $property_id;
    public $property_type;
    public $built_size;
    public $status;
    public $immediate_availability;
    public $user_id;
    public $main_image;
    public $images;

    // Dirección (AddressDto)
    public $address;

    // Datos específicos de la casa
    public $house_type;
    public $garden_size;
    public $num_floors;
    public $num_rooms;
    public $num_bathrooms;
    public $private_garage;
    public $private_pool;
    public $furnished;
    public $terrace;
    public $storage_room;
    public $air_conditioning;
    public $pets_allowed;

    /**
     * Constructor de HouseDto.
     *
     * @param int $property_id ID de la propiedad.
     * @param string $property_type Tipo de propiedad.
     * @param int $built_size Superficie construida (m²).
     * @param string $status Estado de la casa.
     * @param bool $immediate_availability Disponibilidad inmediata.
     * @param int $user_id ID del usuario propietario.
     * @param string $main_image Ruta de la imagen principal de la casa.
     * @param string[] $images (opcional) Array de rutas de imágenes asociadas a la casa.
     * @param AddressDto $address Objeto con la dirección de la casa.
     * @param string $house_type Tipo de casa.
     * @param int $garden_size Tamaño del jardín.
     * @param int $num_floors Número de plantas.
     * @param int $num_rooms Número de habitaciones.
     * @param int $num_bathrooms Número de baños.
     * @param bool $private_garage Indica si tiene garaje privado.
     * @param bool $private_pool Indica si tiene piscina privada.
     * @param bool $furnished Indica si está amueblada.
     * @param bool $terrace Indica si tiene terraza.
     * @param bool $storage_room Indica si tiene trastero.
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
        $address,
        $house_type,
        $garden_size,
        $num_floors,
        $num_rooms,
        $num_bathrooms,
        $private_garage,
        $private_pool,
        $furnished,
        $terrace,
        $storage_room,
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
        $this->house_type = $house_type;
        $this->garden_size = $garden_size;
        $this->num_floors = $num_floors;
        $this->num_rooms = $num_rooms;
        $this->num_bathrooms = $num_bathrooms;
        $this->private_garage = $private_garage;
        $this->private_pool = $private_pool;
        $this->furnished = $furnished;
        $this->terrace = $terrace;
        $this->storage_room = $storage_room;
        $this->air_conditioning = $air_conditioning;
        $this->pets_allowed = $pets_allowed;
    }

    /**
     * Devuelve la casa como un array asociativo.
     *
     * @return array<string, mixed> Datos de la casa.
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
            'house_type' => $this->house_type,
            'garden_size' => $this->garden_size,
            'num_floors' => $this->num_floors,
            'num_rooms' => $this->num_rooms,
            'num_bathrooms' => $this->num_bathrooms,
            'private_garage' => $this->private_garage,
            'private_pool' => $this->private_pool,
            'furnished' => $this->furnished,
            'terrace' => $this->terrace,
            'storage_room' => $this->storage_room,
            'air_conditioning' => $this->air_conditioning,
            'pets_allowed' => $this->pets_allowed
        ];
    }
}
