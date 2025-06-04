<?php

namespace converters;

use models\PropertyModel;
use models\StudioModel;
use services\AddressService;
use services\ImageService;
use converters\AddressConverter;
use dtos\StudioDto;

/**
 * Clase encargada de convertir entre modelos de dominio (PropertyModel, StudioModel)
 * y el DTO StudioDto para la transferencia de datos de estudios.
 *
 * - Convierte modelos de dominio a DTOs para exponerlos en la capa de presentación o API.
 * - Convierte DTOs a modelos de dominio para operaciones de persistencia.
 */
class StudioConverter
{
    private $addressService;
    private $imageService;
    private $addressConverter;

    /**
     * Constructor de StudioConverter.
     *
     * Inicializa los servicios y conversores necesarios para la conversión.
     */
    public function __construct()
    {
        $this->addressService = AddressService::getInstance();
        $this->imageService = ImageService::getInstance();
        $this->addressConverter = new AddressConverter();
    }

    /**
     * Convierte un PropertyModel y un StudioModel en un StudioDto.
     *
     * Obtiene la imagen principal y todas las imágenes asociadas a la propiedad.
     * Si no existen imágenes, se asigna una imagen por defecto ('media/no-image.jpg').
     *
     * @param PropertyModel $propertyModel Modelo con los datos generales de la propiedad.
     * @param StudioModel $studioModel Modelo con los datos específicos del estudio.
     * @return StudioDto DTO resultante con la información combinada.
     */
    public function modelToDto(PropertyModel $propertyModel, StudioModel $studioModel): StudioDto
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

        return new StudioDto(
            $propertyModel->getId(),
            $propertyModel->getPropertyType(),
            $propertyModel->getBuiltSize(),
            $propertyModel->getStatus(),
            $propertyModel->getImmediateAvailability(),
            $propertyModel->getUserId(),
            $main_image,
            $images,
            $this->addressConverter->modelToDto($this->addressService->getAddressById($propertyModel->getAddressId())),
            $studioModel->getFurnished(),
            $studioModel->getBalcony(),
            $studioModel->getAirConditioning(),
            $studioModel->getPetsAllowed()
        );
    }

    /**
     * Convierte un StudioDto en un PropertyModel.
     *
     * @param StudioDto $dto DTO con los datos del estudio y la propiedad.
     * @return PropertyModel Modelo de dominio con los datos generales de la propiedad.
     */
    public function dtoToPropertyModel(StudioDto $dto): PropertyModel
    {
        return new PropertyModel(
            $dto->property_id,
            $dto->property_type,
            $dto->address->id,
            $dto->built_size,
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
    public function dtoToStudioModel(StudioDto $dto): StudioModel
    {
        return new StudioModel(
            $dto->property_id,
            $dto->furnished,
            $dto->balcony,
            $dto->air_conditioning,
            $dto->pets_allowed
        );
    }
}
