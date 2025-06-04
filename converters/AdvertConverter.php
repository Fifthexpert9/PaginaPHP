<?php

namespace converters;

use models\AdvertModel;
use services\ImageService;
use dtos\AdvertDto;

/**
 * Clase encargada de convertir entre AdvertModel y AdvertDto
 * para la transferencia de datos de anuncios.
 */
class AdvertConverter
{
    private $imageService;

    /**
     * Constructor de AdvertConverter.
     *
     * Inicializa el servicio de imágenes para obtener la imagen principal del anuncio.
     */
    public function __construct()
    {
        $this->imageService = ImageService::getInstance();
    }

    /**
     * Convierte un AdvertModel y opcionalmente una imagen principal (ImageDto) en un AdvertDto.
     *
     * @param AdvertModel $model Modelo de dominio con los datos del anuncio.
     * @param string $main_image Imagen principal asociada al anuncio.
     * @return AdvertDto DTO resultante con la información del anuncio.
     */
    public function modelToDto(AdvertModel $model): AdvertDto
    {
        $main_image = $this->imageService->getMainImageByPropertyId($model->getPropertyId());

        if (!$main_image) {
            $main_image = 'media/no-image.jpg';
        } else {
            $main_image = $main_image->getImagePath();
        }

        return new AdvertDto(
            $model->getId(),
            $model->getPropertyId(),
            $model->getUserId(),
            $model->getPrice(),
            $model->getAction(),
            $model->getDescription(),
            $model->getCreatedAt(),
            $main_image
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
    public static function dtoToModel(AdvertDto $dto): AdvertModel
    {
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
