<?php

namespace converters;

use models\DatabaseModel;
use models\PropertyModel;
use models\HouseModel;
use services\AddressService;
use dtos\HouseDto;

/**
 * Clase encargada de convertir entre modelos de dominio (PropertyModel, HouseModel)
 * y el DTO HouseDto para la transferencia de datos de casas.
 */
class HouseConverter {
    /**
     * Convierte un PropertyModel y un HouseModel en un HouseDto.
     *
     * @param PropertyModel $property Modelo con los datos generales de la propiedad.
     * @param HouseModel $house Modelo con los datos específicos de la casa.
     * @return HouseDto DTO resultante con la información combinada.
     */
    public static function modelToDto(PropertyModel $property, HouseModel $house): HouseDto {        
        $as = new AddressService(DatabaseModel::getInstance());
        $ac = new AddressConverter();

        return new HouseDto(
            $property->getId(),
            $property->getPropertyType(),
            $property->getBuiltSize(),
            //$property->getPrice(),
            $property->getStatus(),
            $property->getImmediateAvailability(),
            $property->getUserId(),
            $ac->modelToDto($as->getAddressById($property->getAddressId())),
            $house->getHouseType(),
            $house->getGardenSize(),
            $house->getNumFloors(),
            $house->getNumRooms(),
            $house->getNumBathrooms(),
            $house->getPrivateGarage(),
            $house->getPrivatePool(),
            $house->getFurnished(),
            $house->getTerrace(),
            $house->getStorageRoom(),
            $house->getAirConditioning(),
            $house->getPetsAllowed()
        );
    }

    /**
     * Convierte un HouseDto en un PropertyModel.
     *
     * @param HouseDto $dto DTO con los datos de la casa y la propiedad.
     * @return PropertyModel Modelo de dominio con los datos generales de la propiedad.
     */
    public static function dtoToPropertyModel(HouseDto $dto): PropertyModel {
        return new PropertyModel(
            $dto->property_id,
            $dto->property_type,
            $dto->address->id,
            $dto->built_size,
            //$dto->price,
            $dto->status,
            $dto->immediate_availability,
            $dto->user_id            
        );
    }

    /**
     * Convierte un HouseDto en un ApartmentModel.
     *
     * @param HouseDto $dto DTO con los datos de la casa.
     * @return HouseModel Modelo de dominio con los datos específicos de la casa.
     */
    public static function dtoToHouseModel(HouseDto $dto): HouseModel {
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