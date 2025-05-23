<?php

namespace converters;

use models\AdvertModel;
use dtos\AdvertDto;
use dtos\ImageDto;

/**
 * Clase encargada de convertir entre AdvertModel y AdvertDto
 * para la transferencia de datos de anuncios.
 */
class AdvertConverter {
    /**
     * Convierte un AdvertModel y opcionalmente una imagen principal (ImageDto) en un AdvertDto.
     *
     * @param AdvertModel $model Modelo de dominio con los datos del anuncio.
     * @param ImageDto|null $mainImage Imagen principal asociada al anuncio (puede ser null).
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
            $model->getCreatedAt(),
            $mainImage = null
        );
    }

    /**
     * Convierte un AdvertDto en un AdvertModel.
     *
     * Nota: La imagen principal (main_image) no se utiliza para crear el modelo de dominio,
     * ya que sólo es relevante para la capa de presentación.
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