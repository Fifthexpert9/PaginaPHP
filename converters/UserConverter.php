<?php

namespace converters;

use models\UserModel;
use dtos\UserDto;

class UserConverter
{
    /**
     * Convierte un UserModel en UserDto.
     */
    public function modelToDto(UserModel $userModel): UserDto
    {
        return new UserDto(
            $userModel->getId(),
            $userModel->getName(),
            $userModel->getLastName(),
            $userModel->getUsername(),
            $userModel->getEmail(),
            $userModel->getRole(),
            $userModel->getRegistrationDate()
        );
    }

    /**
     * Convierte un UserDto en UserModel.
     */
    public function dtoToModel(UserDto $userDto): UserModel
    {
        return new UserModel(
            $userDto->id,
            $userDto->name,
            $userDto->last_name,
            $userDto->username,
            $userDto->email,
            null, // password
            $userDto->role,
            $userDto->registration_date
        );
    }
}
