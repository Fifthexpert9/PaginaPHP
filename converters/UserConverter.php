<?php

namespace converters;

use models\UserModel;
use dtos\UserDto;

/**
 * Clase encargada de convertir entre UserModel y UserDto
 * para la transferencia de datos de usuarios.
 *
 * Métodos:
 * - modelToDto: Convierte un modelo de dominio UserModel en un DTO UserDto.
 * - dtoToModel: Convierte un DTO UserDto en un modelo de dominio UserModel.
 */
class UserConverter
{
    /**
     * Convierte un UserModel en UserDto.
     *
     * @param UserModel $userModel Modelo de dominio con los datos del usuario.
     * @return UserDto DTO resultante con la información del usuario.
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
     *
     * @param UserDto $userDto DTO con los datos del usuario.
     * @return UserModel Modelo de dominio con los datos del usuario.
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
