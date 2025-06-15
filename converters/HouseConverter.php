<?php

namespace converters;

use models\PropertyModel;
use models\HouseModel;
use services\AddressService;
use services\ImageService;
use converters\AddressConverter;
use dtos\HouseDto;

/**
 * Clase encargada de convertir entre modelos de dominio (PropertyModel, HouseModel)
 * y el DTO HouseDto para la transferencia de datos de casas.
 *
 * Responsabilidades:
 * - Convierte modelos de dominio a DTOs para exponerlos en la capa de presentación o API.
 * - Convierte DTOs a modelos de dominio para operaciones de persistencia.
 *
 * Métodos principales:
 * - modelToDto: Convierte un PropertyModel y un HouseModel en un HouseDto, incluyendo imágenes y dirección.
 * - dtoToPropertyModel: Convierte un HouseDto en un PropertyModel.
 * - dtoToHouseModel: Convierte un HouseDto en un HouseModel.
 */
class HouseConverter
{
    private $addressService;
    private $imageService;
    private $addressConverter;

    /**
     * Constructor de HouseConverter.
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
     * Convierte un PropertyModel y un HouseModel en un HouseDto.
     *
     * Obtiene la imagen principal y todas las imágenes asociadas a la propiedad.
     * Si no existen imágenes, se asigna una imagen por defecto ('media/no-image.jpg').
     * También convierte la dirección asociada usando AddressConverter.
     *
     * @param PropertyModel $propertyModel Modelo con los datos generales de la propiedad.
     * @param HouseModel $houseModel Modelo con los datos específicos de la casa.
     * @return HouseDto DTO resultante con la información combinada.
     */
    public function modelToDto(PropertyModel $propertyModel, HouseModel $houseModel): HouseDto
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
        
        return new HouseDto(
            $propertyModel->getId(),
            $propertyModel->getPropertyType(),
            $propertyModel->getBuiltSize(),
            $propertyModel->getStatus(),
            $propertyModel->getImmediateAvailability(),
            $propertyModel->getUserId(),
            $main_image,
            $images,
            $this->addressConverter->modelToDto($this->addressService->getAddressById($propertyModel->getAddressId())),
            $houseModel->getHouseType(),
            $houseModel->getGardenSize(),
            $houseModel->getNumFloors(),
            $houseModel->getNumRooms(),
            $houseModel->getNumBathrooms(),
            $houseModel->getPrivateGarage(),
            $houseModel->getPrivatePool(),
            $houseModel->getFurnished(),
            $houseModel->getTerrace(),
            $houseModel->getStorageRoom(),
            $houseModel->getAirConditioning(),
            $houseModel->getPetsAllowed()
        );
    }

    /**
     * Convierte un HouseDto en un PropertyModel.
     *
     * @param HouseDto $dto DTO con los datos de la casa y la propiedad.
     * @return PropertyModel Modelo de dominio con los datos generales de la propiedad.
     */
    public function dtoToPropertyModel(HouseDto $dto): PropertyModel
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
     * Convierte un HouseDto en un HouseModel.
     *
     * @param HouseDto $dto DTO con los datos de la casa.
     * @return HouseModel Modelo de dominio con los datos específicos de la casa.
     */
    public function dtoToHouseModel(HouseDto $dto): HouseModel
    {
        return new HouseModel(
            $dto->property_id,
            $dto->house_type,
            $dto->garden_size,
            $dto->num_floors,
            $dto->num_rooms,
            $dto->num_bathrooms,
            $dto->private_garage,
            $dto->private_pool,
            $dto->furnished,
            $dto->terrace,
            $dto->storage_room,
            $dto->air_conditioning,
            $dto->pets_allowed
        );
    }
}
