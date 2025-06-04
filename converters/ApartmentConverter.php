<?php

namespace converters;

use models\PropertyModel;
use models\ApartmentModel;
use services\AddressService;
use services\ImageService;
use converters\AddressConverter;
use dtos\ApartmentDto;

/**
 * Clase encargada de convertir entre modelos de dominio (PropertyModel, ApartmentModel)
 * y el DTO ApartmentDto para la transferencia de datos de pisos.
 *
 * - Convierte modelos de dominio a DTOs para exponerlos en la capa de presentación o API.
 * - Convierte DTOs a modelos de dominio para operaciones de persistencia.
 */
class ApartmentConverter
{
    private $addressService;
    private $imageService;
    private $addressConverter;

    /**
     * Constructor de ApartmentConverter.
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
     * Convierte un PropertyModel y un ApartmentModel en un ApartmentDto.
     *
     * Obtiene la imagen principal y todas las imágenes asociadas a la propiedad.
     * Si no existen imágenes, se asigna una imagen por defecto ('media/no-image.jpg').
     *
     * @param PropertyModel $propertyModel Modelo con los datos generales de la propiedad.
     * @param ApartmentModel $apartmentModel Modelo con los datos específicos del piso.
     * @return ApartmentDto DTO resultante con la información combinada.
     */
    public function modelToDto(PropertyModel $propertyModel, ApartmentModel $apartmentModel): ApartmentDto
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
        
        return new ApartmentDto(
            $propertyModel->getId(),
            $propertyModel->getPropertyType(),
            $propertyModel->getBuiltSize(),
            $propertyModel->getStatus(),
            $propertyModel->getImmediateAvailability(),
            $propertyModel->getUserId(),
            $main_image,
            $images,
            $this->addressConverter->modelToDto($this->addressService->getAddressById($propertyModel->getAddressId())),
            $apartmentModel->getApartmentType(),
            $apartmentModel->getNumRooms(),
            $apartmentModel->getNumBathrooms(),
            $apartmentModel->isFurnished(),
            $apartmentModel->hasBalcony(),
            $apartmentModel->getFloor(),
            $apartmentModel->hasElevator(),
            $apartmentModel->hasAirConditioning(),
            $apartmentModel->hasGarage(),
            $apartmentModel->arePetsAllowed()
        );
    }

    /**
     * Convierte un ApartmentDto en un PropertyModel.
     *
     * @param ApartmentDto $dto DTO con los datos del piso y la propiedad.
     * @return PropertyModel Modelo de dominio con los datos generales de la propiedad.
     */
    public function dtoToPropertyModel(ApartmentDto $dto): PropertyModel
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
     * Convierte un ApartmentDto en un ApartmentModel.
     *
     * @param ApartmentDto $dto DTO con los datos del piso.
     * @return ApartmentModel Modelo de dominio con los datos específicos del piso.
     */
    public function dtoToApartmentModel(ApartmentDto $dto): ApartmentModel
    {
        return new ApartmentModel(
            $dto->property_id,
            $dto->apartment_type,
            $dto->num_rooms,
            $dto->num_bathrooms,
            $dto->furnished,
            $dto->balcony,
            $dto->floor,
            $dto->elevator,
            $dto->air_conditioning,
            $dto->garage,
            $dto->pets_allowed
        );
    }
}
