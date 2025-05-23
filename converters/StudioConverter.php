<?php

namespace converters;

use models\DatabaseModel;
use models\PropertyModel;
use models\StudioModel;
use services\AddressService;
use dtos\StudioDto;

/**
 * Clase encargada de convertir entre modelos de dominio (PropertyModel, StudioModel)
 * y el DTO StudioDto para la transferencia de datos de estudios.
 */
class StudioConverter {
    /**
     * Convierte un PropertyModel y un StudioModel en un StudioDto.
     *
     * @param PropertyModel $property Modelo con los datos generales de la propiedad.
     * @param StudioModel $room Modelo con los datos específicos del estudio.
     * @return StudioDto DTO resultante con la información combinada.
     */
    public static function modelToDto(PropertyModel $property, StudioModel $studio): StudioDto {        
        $as = new AddressService(DatabaseModel::getInstance());
        $ac = new AddressConverter();

        return new StudioDto(
            $property->getId(),
            $property->getPropertyType(),
            $property->getBuiltSize(),
            //$property->getPrice(),
            $property->getStatus(),
            $property->getImmediateAvailability(),
            $property->getUserId(),
            $ac->modelToDto($as->getAddressById($property->getAddressId())),
            $studio->getFurnished(),
            $studio->getBalcony(),
            $studio->getAirConditioning(),
            $studio->getPetsAllowed()
        );
    }

    /**
     * Convierte un StudioDto en un PropertyModel.
     *
     * @param StudioDto $dto DTO con los datos del estudio y la propiedad.
     * @return PropertyModel Modelo de dominio con los datos generales de la propiedad.
     */
    public static function dtoToPropertyModel(StudioDto $dto): PropertyModel {
        return new PropertyModel(
            $dto->property_id,
            $dto->property_type,
            $dto->address->id,
            $dto->built_size,
            //$dto->price,
            $dto->status,
            $dto->immediate_availability,
            $dto->user_id            
        );
    }

    /**
     * Convierte un StudioDto en un StudioModel.
     *
     * @param StudioDto $dto DTO con los datos del estudio.
     * @return StudioModel Modelo de dominio con los datos específicos del estudio.
     */
    public static function dtoToStudioModel(StudioDto $dto): StudioModel {
        return new StudioModel(
            $dto->property_id,
            $dto->furnished,
            $dto->balcony,
            $dto->air_conditioning,
            $dto->pets_allowed
        );
    }
}