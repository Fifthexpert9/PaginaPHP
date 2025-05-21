<?php

namespace facades;

use services\UserService;
use converters\UserConverter;
use dtos\UserDto;
use models\UserModel;

class UserFacade {
    private $userService;
    private $userConverter;

    public function __construct(UserService $userService, UserConverter $userConverter) {
        $this->userService = $userService;
        $this->userConverter = $userConverter;
    }

    /**
     * Registra un nuevo usuario en el sistema.
     *
     * @param UserDto $userDto DTO con los datos del usuario (sin contraseña).
     * @param string $plainPassword Contraseña en texto plano introducida por el usuario.
     * @return array Resultado del registro (success, message).
     */
    public function register(UserDto $userDto, string $plainPassword) {
        if (empty($userDto->name) || empty($userDto->last_name) || empty($userDto->email) || empty($userDto->password)) {
            return ['success' => false, 'message' => 'Todos los campos son obligatorios.'];
        }
        if ($this->userService->emailExists($userDto->email)) {
            return ['success' => false, 'message' => 'El correo ya está registrado.'];
        }

        $userModel = $this->userConverter->dtoToModel($userDto);
        $userModel->setPassword(password_hash($plainPassword, PASSWORD_BCRYPT));

        if ($this->userService->addUser($userModel)) {
            return ['success' => true, 'message' => 'Usuario registrado correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al registrar el usuario.'];
        }
    }

    /**
     * Obtiene un usuario por su ID.
     *
     * @param int $id ID del usuario.
     * @return UserDto|null DTO del usuario o null si no existe.
     */
    public function getUserById($id) {
        $userModel = $this->userService->getUserById($id);
        if (!$userModel) return null;
        return $this->userConverter->modelToDto($userModel);
    }

    /**
     * Realiza el login de un usuario.
     *
     * @param string $email Correo electrónico del usuario.
     * @param string $password Contraseña en texto plano.
     * @return array Resultado del login (success, message, user).
     */
    public function login($email, $password) {
        if (empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'El correo y la contraseña son obligatorios.'];
        }

        $userModel = $this->userService->authenticate($email, $password);

        if ($userModel) {
            return [
                'success' => true,
                'message' => 'Inicio de sesión exitoso.',
                'user' => $this->userConverter->modelToDto($userModel)
            ];
        } else {
            return ['success' => false, 'message' => 'Credenciales incorrectas.'];
        }
    }

    /**
     * Actualiza los datos de un usuario.
     *
     * @param int $id ID del usuario a actualizar.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return array Resultado de la actualización (success, message).
     */
    public function updateUser($id, $fields) {
        if(empty($fields)) {
            return ['success' => false, 'message' => 'No se han proporcionado campos para actualizar.'];
        }
        if ($this->userService->updateUser($id, $fields)) {
            return ['success' => true, 'message' => 'Usuario actualizado correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar el usuario.'];
        }
    }

    /**
     * Elimina un usuario por su ID.
     *
     * @param int $id ID del usuario a eliminar.
     * @return array Resultado de la eliminación (success, message).
     */
    public function deleteUser($id) {
        if ($this->userService->deleteUser($id)) {
            return ['success' => true, 'message' => 'Usuario eliminado correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar el usuario.'];
        }
    }
}