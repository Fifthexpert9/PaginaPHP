<?php

namespace converters;

use models\AddressModel;
use dtos\AddressDto;

/**
 * Clase encargada de convertir entre AddressModel y AddressDto
 * para la transferencia de datos de direcciones.
 */
class AddressConverter {
    /**
     * Convierte un AddressModel en AddressDto.
     *
     * @param AddressModel $model Modelo de dominio con los datos de la dirección.
     * @return AddressDto DTO resultante con la información de la dirección.
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
     *
     * @param AddressDto $dto DTO con los datos de la dirección.
     * @return AddressModel Modelo de dominio con los datos de la dirección.
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