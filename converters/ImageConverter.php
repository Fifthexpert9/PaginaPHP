<?php

namespace converters;

use models\ImageModel;
use dtos\ImageDto;

/**
 * Clase encargada de convertir entre ImageModel y ImageDto.
 *
 * Permite transformar objetos del modelo de dominio (ImageModel) a DTO (ImageDto) y viceversa,
 * facilitando la transferencia de datos entre capas de la aplicación.
 *
 * Métodos:
 * - modelToDto: Convierte un modelo de dominio ImageModel en un DTO ImageDto.
 * - dtoToModel: Convierte un DTO ImageDto en un modelo de dominio ImageModel.
 */
class ImageConverter
{
    /**
     * Convierte un ImageModel a un ImageDto.
     *
     * @param ImageModel $model Modelo de dominio con los datos de la imagen.
     * @return ImageDto DTO resultante con la información de la imagen.
     */
    public static function modelToDto(ImageModel $model)
    {
        return new ImageDto(
            $model->getId(),
            $model->getPropertyId(),
            $model->getImagePath(),
            $model->isMain(),
            $model->getUploadedAt()
        );
    }

    /**
     * Convierte un ImageDto a un ImageModel.
     *
     * @param ImageDto $dto DTO con los datos de la imagen.
     * @return ImageModel Modelo de dominio con los datos de la imagen.
     */
    public static function dtoToModel(ImageDto $dto)
    {
        return new ImageModel(
            $dto->id,
            $dto->propertyId,
            $dto->imagePath,
            $dto->isMain,
            $dto->uploadedAt
        );
    }
}