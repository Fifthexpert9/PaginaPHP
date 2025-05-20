<?php

namespace converters;

use models\AdvertModel;
use dtos\AdvertDto;

/**
 * Clase encargada de convertir entre AdvertModel y AdvertDto
 * para la transferencia de datos de anuncios.
 */
class AdvertConverter {
    /**
     * Convierte un AdvertModel en AdvertDto.
     *
     * @param AdvertModel $model Modelo de dominio con los datos del anuncio.
     * @return AdvertDto DTO resultante con la información del anuncio.
     */
    public static function modelToDto(AdvertModel $model): AdvertDto {        
        return new AdvertDto(
            $model->getId(),
            $model->getPropertyId(),
            $model->getUserId(),
            $model->getPrice(),
            $model->getAction(),
            $model->getDescription(),
            $model->getCreatedAt()
        );
    }

    /**
     * Convierte un AdvertDto en AdvertModel.
     *
     * @param AdvertDto $dto DTO con los datos del anuncio.
     * @return AdvertModel Modelo de dominio con los datos del anuncio.
     */
    public static function dtoToModel(AdvertDto $dto): AdvertModel {
        return new AdvertModel(
            $dto->id,
            $dto->property_id,
            $dto->user_id,
            $dto->price,
            $dto->action,
            $dto->description,
            $dto->created_at
        );
    }
}