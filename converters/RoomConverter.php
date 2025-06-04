<?php

namespace converters;

use models\PropertyModel;
use models\RoomModel;
use services\AddressService;
use services\ImageService;
use converters\AddressConverter;
use dtos\RoomDto;

/**
 * Clase encargada de convertir entre modelos de dominio (PropertyModel, RoomModel)
 * y el DTO RoomDto para la transferencia de datos de habitaciones.
 *
 * - Convierte modelos de dominio a DTOs para exponerlos en la capa de presentación o API.
 * - Convierte DTOs a modelos de dominio para operaciones de persistencia.
 */
class RoomConverter
{
    private $addressService;
    private $imageService;
    private $addressConverter;

    public function __construct()
    {
        $this->addressService = AddressService::getInstance();
        $this->imageService = ImageService::getInstance();
        $this->addressConverter = new AddressConverter();
    }

    /**
     * Convierte un PropertyModel y un RoomModel en un RoomDto.
     *
     * Obtiene la imagen principal y todas las imágenes asociadas a la propiedad.
     * Si no existen imágenes, se asigna una imagen por defecto ('media/no-image.jpg').
     *
     * @param PropertyModel $propertyModel Modelo con los datos generales de la propiedad.
     * @param RoomModel $roomModel Modelo con los datos específicos de la habitación.
     * @return RoomDto DTO resultante con la información combinada.
     */
    public function modelToDto(PropertyModel $propertyModel, RoomModel $roomModel): RoomDto
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

        return new RoomDto(
            $propertyModel->getId(),
            $propertyModel->getPropertyType(),
            $propertyModel->getBuiltSize(),
            $propertyModel->getStatus(),
            $propertyModel->getImmediateAvailability(),
            $propertyModel->getUserId(),
            $main_image,
            $images,
            $this->addressConverter->modelToDto($this->addressService->getAddressById($propertyModel->getAddressId())),
            $roomModel->getPrivateBathroom(),
            $roomModel->getMaxRoommates(),
            $roomModel->getPetsAllowed(),
            $roomModel->getFurnished(),
            $roomModel->getStudentsOnly(),
            $roomModel->getGenderRestriction()
        );
    }

    /**
     * Convierte un RoomDto en un PropertyModel.
     *
     * @param RoomDto $dto DTO con los datos de la habitación y la propiedad.
     * @return PropertyModel Modelo de dominio con los datos generales de la propiedad.
     */
    public function dtoToPropertyModel(RoomDto $dto): PropertyModel
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
     * Convierte un RoomDto en un RoomModel.
     *
     * @param RoomDto $dto DTO con los datos de la habitación.
     * @return RoomModel Modelo de dominio con los datos específicos de la habitación.
     */
    public function dtoToRoomModel(RoomDto $dto): RoomModel
    {
        return new RoomModel(
            $dto->property_id,
            $dto->private_bathroom,
            $dto->max_roommates,
            $dto->pets_allowed,
            $dto->furnished,
            $dto->students_only,
            $dto->gender_restriction
        );
    }
}
