<?php

namespace converters;

use models\PropertyModel;
use services\ImageService;
use dtos\PropertyDto;

/**
 * Clase encargada de convertir entre PropertyModel y PropertyDto.
 *
 * Permite transformar objetos del modelo de dominio (PropertyModel) a DTO (PropertyDto) y viceversa,
 * facilitando la transferencia de datos entre capas de la aplicación.
 * Además, obtiene la imagen principal y todas las imágenes asociadas a la propiedad,
 * devolviendo rutas válidas o una imagen por defecto si no existen.
 *
 * Métodos:
 * - modelToDto: Convierte un modelo de dominio PropertyModel en un DTO PropertyDto, incluyendo imágenes.
 * - dtoToModel: Convierte un DTO PropertyDto en un modelo de dominio PropertyModel.
 */
class PropertyConverter
{
    private $imageService;

    /**
     * Constructor de PropertyConverter.
     *
     * Inicializa los servicios necesarios para la conversión y obtención de imágenes.
     */
    public function __construct()
    {
        $this->imageService = ImageService::getInstance();
    }

    /**
     * Convierte un PropertyModel en un PropertyDto.
     *
     * Obtiene la imagen principal y todas las imágenes asociadas a la propiedad.
     * Si no existen imágenes, se asigna una imagen por defecto ('media/no-image.jpg').
     *
     * @param PropertyModel $propertyModel Modelo de la propiedad.
     * @return PropertyDto DTO de la propiedad con imágenes asociadas.
     */
    public function modelToDto(PropertyModel $propertyModel)
    {
        $main_image = $this->imageService->getMainImageByPropertyId($propertyModel->getId());

        if (!$main_image) {
            $main_image = 'media/no-image.jpg';
        } else {
            $main_image = $main_image->getImagePath();
        }

        $images = $this->imageService->getImagesByPropertyId($propertyModel->getId());

        if (!$images) {
            $images = ['media/no-image.jpg'];
        } else {
            $images = array_map(function ($imageModel) {
                return $imageModel->getImagePath();
            }, $images);
        }

        return new PropertyDto(
            $propertyModel->getId(),
            $propertyModel->getPropertyType(),
            $propertyModel->getAddressId(),
            $propertyModel->getBuiltSize(),
            $propertyModel->getStatus(),
            $propertyModel->getImmediateAvailability(),
            $propertyModel->getUserId(),
            $main_image,
            $images
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
            $propertyDto->property_type,
            $propertyDto->address_id,
            $propertyDto->built_size,
            $propertyDto->status,
            $propertyDto->immediate_availability,
            $propertyDto->user_id
        );
    }
}
