<?php

namespace facades;

use services\UserService;
use converters\UserConverter;
use dtos\UserDto;

class UserFacade {
    private $userService;
    private $userConverter;

    public function __construct(UserService $userService, UserConverter $userConverter) {
        $this->userService = $userService;
        $this->userConverter = $userConverter;
    }

    /**
     * Registra un nuevo usuario.
     * @param UserDto $userDto
     * @return array Resultado del registro
     */
    public function register(UserDto $userDto, string $plainPassword) {
        // Validación básica
        if (empty($userDto->name) || empty($userDto->last_name) || empty($userDto->email) || empty($userDto->password)) {
            return ['success' => false, 'message' => 'Todos los campos son obligatorios.'];
        }
        if ($this->userService->emailExists($userDto->email)) {
            return ['success' => false, 'message' => 'El correo ya está registrado.'];
        }

        // Convertir DTO a modelo y hashear la contraseña
        $userModel = $this->userConverter->dtoToModel($userDto);
        $userModel->setPassword(password_hash($plainPassword, PASSWORD_BCRYPT));

        // Guardar usuario
        if ($this->userService->addUser($userModel)) {
            return ['success' => true, 'message' => 'Usuario registrado correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al registrar el usuario.'];
        }
    }

    /**
     * Obtiene un usuario por su ID.
     * @param int $id
     * @return UserDto|null
     */
    public function getUserById($id) {
        $userModel = $this->userService->getUserById($id);
        if (!$userModel) return null;
        return $this->userConverter->modelToDto($userModel);
    }

    // Puedes añadir más métodos: login, update, delete, etc.
}