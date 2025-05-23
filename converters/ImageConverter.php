<?php

namespace converters;

use models\ImageModel;
use dtos\ImageDto;

/**
 * Conversor entre ImageModel y ImageDto.
 *
 * Permite transformar objetos del modelo de dominio a DTO y viceversa.
 */
class ImageConverter
{
    /**
     * Convierte un ImageModel a un ImageDto.
     *
     * @param ImageModel $model
     * @return ImageDto
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
     * @param ImageDto $dto
     * @return ImageModel
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