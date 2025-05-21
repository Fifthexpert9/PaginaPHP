<?php

namespace converters;

use models\DatabaseModel;
use models\PropertyModel;
use models\ApartmentModel;
use services\AddressService;
use dtos\ApartmentDto;

/**
 * Clase encargada de convertir entre modelos de dominio (PropertyModel, ApartmentModel)
 * y el DTO ApartmentDto para la transferencia de datos de pisos.
 */
class ApartmentConverter {
    /**
     * Convierte un PropertyModel y un ApartmentModel en un ApartmentDto.
     *
     * @param PropertyModel $property Modelo con los datos generales de la propiedad.
     * @param ApartmentModel $apartment Modelo con los datos específicos del piso.
     * @return ApartmentDto DTO resultante con la información combinada.
     */
    public static function modelToDto(PropertyModel $property, ApartmentModel $apartment): ApartmentDto {        
        $as = new AddressService(DatabaseModel::getInstance());
        $ac = new AddressConverter();

        return new ApartmentDto(
            $property->getId(),
            $property->getPropertyType(),
            $property->getBuiltSize(),
            $property->getPrice(),
            $property->getStatus(),
            $property->getImmediateAvailability(),
            $property->getUserId(),
            $ac->modelToDto($as->getAddressById($property->getAddressId())),
            $apartment->getApartmentType(),
            $apartment->getNumRooms(),
            $apartment->getNumBathrooms(),
            $apartment->isFurnished(),
            $apartment->hasBalcony(),
            $apartment->getFloor(),
            $apartment->hasElevator(),
            $apartment->hasAirConditioning(),
            $apartment->hasGarage(),
            //$apartment->hasPool(),
            $apartment->arePetsAllowed()
        );
    }

    /**
     * Convierte un ApartmentDto en un PropertyModel.
     *
     * @param ApartmentDto $dto DTO con los datos del piso y la propiedad.
     * @return PropertyModel Modelo de dominio con los datos generales de la propiedad.
     */
    public static function apartmentDtoToPropertyModel(ApartmentDto $dto): PropertyModel {
        return new PropertyModel(
            $dto->property_id,
            $dto->property_type,
            $dto->address->id,
            $dto->built_size,
            $dto->price,
            $dto->status,
            $dto->immediate_availability,
            $dto->user_id            
        );
    }

    /**
     * Convierte un ApartmentDto en un ApartmentModel.
     *
     * @param ApartmentDto $dto DTO con los datos del piso.
     * @return ApartmentModel Modelo de dominio con los datos específicos del piso.
     */
    public static function apartmentDtoToApartmentModel(ApartmentDto $dto): ApartmentModel {
        return new ApartmentModel(
            $dto->property_id,
            $dto->apartment_type,
            $dto->num_rooms,
            $dto->num_bathrooms,
            $dto->furnished,
            $dto->balcony,
            $dto->floor,
            $dto->elevator,
            $dto->air_conditioning,
            $dto->garage,
            //$dto->pool,
            $dto->pets_allowed
        );
    }
}