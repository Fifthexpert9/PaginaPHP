<?php

namespace converters;

use models\DatabaseModel;
use models\PropertyModel;
use models\RoomModel;
use services\AddressService;
use dtos\RoomDto;

/**
 * Clase encargada de convertir entre modelos de dominio (PropertyModel, RoomModel)
 * y el DTO RoomDto para la transferencia de datos de habitaciones.
 */
class RoomConverter {
    /**
     * Convierte un PropertyModel y un RoomModel en un RoomDto.
     *
     * @param PropertyModel $property Modelo con los datos generales de la propiedad.
     * @param RoomModel $room Modelo con los datos específicos de la habitación.
     * @return RoomDto DTO resultante con la información combinada.
     */
    public static function modelToDto(PropertyModel $property, RoomModel $room): RoomDto {        
        $as = new AddressService(DatabaseModel::getInstance());
        $ac = new AddressConverter();

        return new RoomDto(
            $property->getId(),
            $property->getPropertyType(),
            $property->getBuiltSize(),
            $property->getPrice(),
            $property->getStatus(),
            $property->getImmediateAvailability(),
            $property->getUserId(),
            $ac->modelToDto($as->getAddressById($property->getAddressId())),
            $room->getPrivateBathroom(),
            //$room->getRoomSize(),
            $room->getMaxRoommates(),
            //$room->getIncludesExpenses(),
            $room->getPetsAllowed(),
            $room->getFurnished(),
            //$room->getCommonAreas(),
            $room->getStudentsOnly(),
            $room->getGenderRestriction()
        );
    }

    /**
     * Convierte un RoomDto en un PropertyModel.
     *
     * @param RoomDto $dto DTO con los datos de la habitación y la propiedad.
     * @return PropertyModel Modelo de dominio con los datos generales de la propiedad.
     */
    public static function roomDtoToPropertyModel(RoomDto $dto): PropertyModel {
        return new PropertyModel(
            $dto->property_id,
            $dto->property_type,
            $dto->address->id,
            $dto->built_size,
            $dto->price,
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
    public static function roomDtoToRoomModel(RoomDto $dto): RoomModel {
        return new RoomModel(
            $dto->property_id,
            $dto->private_bathroom,
            //$dto->room_size,
            $dto->max_roommates,
            //$dto->includes_expenses,
            $dto->pets_allowed,
            $dto->furnished,
            //$dto->common_areas,
            $dto->students_only,
            $dto->gender_restriction
        );
    }
}