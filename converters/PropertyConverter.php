<?php

namespace converters;

use models\PropertyModel;
use dtos\PropertyDto;

/**
 * Conversor para la entidad Property.
 * Permite convertir entre PropertyModel y PropertyDto.
 */
class PropertyConverter
{
    /**
     * Convierte un PropertyModel a PropertyDto.
     *
     * @param PropertyModel $propertyModel Modelo de la propiedad.
     * @return PropertyDto DTO de la propiedad.
     */
    public function modelToDto(PropertyModel $propertyModel)
    {
        return new PropertyDto(
            $propertyModel->getId(),
            $propertyModel->getPropertyType(),
            $propertyModel->getAddressId(),
            $propertyModel->getBuiltSize(),
            //$propertyModel->getPrice(),
            $propertyModel->getStatus(),
            $propertyModel->getImmediateAvailability(),
            $propertyModel->getUserId()
        );
    }

    /**
     * Convierte un PropertyDto a PropertyModel.
     *
     * @param PropertyDto $propertyDto DTO de la propiedad.
     * @return PropertyModel Modelo de la propiedad.
     */
    public function dtoToModel(PropertyDto $propertyDto)
    {
        return new PropertyModel(
            $propertyDto->id,
            $propertyDto->propertyType,
            $propertyDto->addressId,
            $propertyDto->builtSize,
            //$propertyDto->price,
            $propertyDto->status,
            $propertyDto->immediateAvailability,
            $propertyDto->userId
        );
    }
}