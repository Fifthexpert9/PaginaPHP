<?php

namespace converters;

use models\UserModel;
use dtos\UserDto;
use services\AdvertService;
use services\FavoritesService;
use models\DatabaseModel;

class UserConverter {
    /**
     * Convierte un UserModel en UserDto.
     */
    public static function modelToDto(UserModel $model): UserDto {
        $as = AdvertService::getInstance();
        $fs = FavoritesService::getInstance();
        
        return new UserDto(
            $model->getId(),
            $model->getName(),
            $model->getLastName(),
            $model->getUsername(),
            $model->getEmail(),
            $model->getRole(),
            $model->getRegistrationDate(),
            $as->getAdvertsByUserId($model->getId()),
            $fs->getFavoritesByUserId($model->getId())
        );
    }

    /**
     * Convierte un UserDto en UserModel.
     */
    public static function dtoToModel(UserDto $dto): UserModel {
        return new UserModel(
            $dto->id,
            $dto->name,
            $dto->last_name,
            $dto->username,
            $dto->email,
            null,
            $dto->role,
            $dto->registration_date
        );
    }
}