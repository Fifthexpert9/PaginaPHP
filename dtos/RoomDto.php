<?php

namespace dtos;

/**
 * DTO para exponer información de una habitación junto con los datos de la propiedad y la dirección.
 *
 * @property int $property_id ID de la propiedad.
 * @property string $property_type Tipo de propiedad.
 * @property int $built_size Superficie construida (m²).
 * @property float $price Precio de la habitación.
 * @property string $status Estado de la propiedad.
 * @property bool $immediate_availability Disponibilidad inmediata.
 * @property int $user_id ID del usuario propietario.
 * @property AddressDto $address Objeto con la dirección de la propiedad.
 * @property bool $private_bathroom Indica si la habitación tiene baño privado.
 * @property int $room_size Tamaño de la habitación.
 * @property int $max_roommates Número máximo de compañeros.
 * @property bool $includes_expenses Indica si incluye gastos.
 * @property bool $pets_allowed Indica si se permiten mascotas.
 * @property bool $furnished Indica si está amueblada.
 * @property string $common_areas Áreas comunes disponibles.
 * @property bool $students_only Indica si es solo para estudiantes.
 * @property string $gender_restriction Restricción de género.
 */
class RoomDto {
    // Datos de la propiedad
    public $property_id;
    public $property_type;
    public $built_size;
    public $price;
    public $status;
    public $immediate_availability;
    public $user_id;

    // Dirección (AddressDto)
    public $address;

    // Datos específicos de la habitación
    public $private_bathroom;
    public $room_size;
    public $max_roommates;
    public $includes_expenses;
    public $pets_allowed;
    public $furnished;
    public $common_areas;
    public $students_only;
    public $gender_restriction;

    /**
     * Constructor de RoomDto.
     *
     * @param int $property_id ID de la propiedad.
     * @param string $property_type Tipo de propiedad.
     * @param int $built_size Superficie construida (m²).
     * @param float $price Precio de la habitación.
     * @param string $status Estado de la propiedad.
     * @param bool $immediate_availability Disponibilidad inmediata.
     * @param int $user_id ID del usuario propietario.
     * @param AddressDto $address Objeto con la dirección de la propiedad.
     * @param bool $private_bathroom Indica si la habitación tiene baño privado.
     * @param int $room_size Tamaño de la habitación.
     * @param int $max_roommates Número máximo de compañeros.
     * @param bool $includes_expenses Indica si incluye gastos.
     * @param bool $pets_allowed Indica si se permiten mascotas.
     * @param bool $furnished Indica si está amueblada.
     * @param string $common_areas Áreas comunes disponibles.
     * @param bool $students_only Indica si es solo para estudiantes.
     * @param string $gender_restriction Restricción de género.
     */
    public function __construct(
        $property_id,
        $property_type,
        $built_size,
        $price,
        $status,
        $immediate_availability,
        $user_id,
        $address, // AddressDto
        $private_bathroom,
        $room_size,
        $max_roommates,
        $includes_expenses,
        $pets_allowed,
        $furnished,
        $common_areas,
        $students_only,
        $gender_restriction
    ) {
        $this->property_id = $property_id;
        $this->property_type = $property_type;
        $this->built_size = $built_size;
        $this->price = $price;
        $this->status = $status;
        $this->immediate_availability = $immediate_availability;
        $this->user_id = $user_id;
        $this->address = $address;
        $this->private_bathroom = $private_bathroom;
        $this->room_size = $room_size;
        $this->max_roommates = $max_roommates;
        $this->includes_expenses = $includes_expenses;
        $this->pets_allowed = $pets_allowed;
        $this->furnished = $furnished;
        $this->common_areas = $common_areas;
        $this->students_only = $students_only;
        $this->gender_restriction = $gender_restriction;
    }

    /**
     * Devuelve la habitación como un array asociativo.
     *
     * @return array<string, mixed> Datos de la habitación.
     */
    public function toArray() {
        return [
            'property_id' => $this->property_id,
            'property_type' => $this->property_type,
            'built_size' => $this->built_size,
            'price' => $this->price,
            'status' => $this->status,
            'immediate_availability' => $this->immediate_availability,
            'user_id' => $this->user_id,
            'address' => $this->address ? $this->address->toArray() : null,
            'private_bathroom' => $this->private_bathroom,
            'room_size' => $this->room_size,
            'max_roommates' => $this->max_roommates,
            'includes_expenses' => $this->includes_expenses,
            'pets_allowed' => $this->pets_allowed,
            'furnished' => $this->furnished,
            'common_areas' => $this->common_areas,
            'students_only' => $this->students_only,
            'gender_restriction' => $this->gender_restriction
        ];
    }
}