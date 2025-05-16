<?php

namespace converters;

use models\AddressModel;
use dtos\AddressDto;

class AddressConverter {
    /**
     * Convierte un AddressModel en AddressDto.
     */
    public static function modelToDto(AddressModel $model): AddressDto {
        return new AddressDto(
            $model->getId(),
            $model->getStreet(),
            $model->getCity(),
            $model->getProvince(),
            $model->getPostalCode(),
            $model->getCountry(),
            $model->getLatitude(),
            $model->getLongitude()
        );
    }

    /**
     * Convierte un AddressDto en AddressModel.
     */
    public static function dtoToModel(AddressDto $dto): AddressModel {
        return new AddressModel(
            $dto->id,
            $dto->street,
            $dto->city,
            $dto->province,
            $dto->postal_code,
            $dto->country,
            $dto->latitude,
            $dto->longitude
        );
    }
}