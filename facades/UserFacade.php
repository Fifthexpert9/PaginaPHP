<?php

namespace facades;

use services\UserService;
use converters\UserConverter;
use dtos\UserDto;

/**
 * UserFacade
 * ----------
 * Fachada para gestionar operaciones de usuario en la aplicación.
 * 
 * Métodos principales:
 * - userRegister(UserDto $userDto, string $plainPassword): Registra un nuevo usuario.
 * - userLogin($email, $password): Autentica un usuario por email y contraseña.
 * - isRegularUser($id): Indica si el usuario es regular (no admin).
 * - updateUser($id, $fields): Actualiza los datos de un usuario.
 * - deleteUser($id): Elimina un usuario por su ID.
 * 
 * Cada método devuelve un array con el resultado de la operación (success, message, y datos si aplica).
 */
class UserFacade
{
    private $userService;
    private $userConverter;

    /**
     * Constructor de UserFacade.
     * 
     * @param UserConverter $userConverter Conversor de modelos y DTOs de usuario.
     */
    public function __construct(UserConverter $userConverter)
    {
        $this->userService = UserService::getInstance();
        $this->userConverter = $userConverter;
    }

    /**
     * Registra un nuevo usuario en el sistema.
     *
     * @param UserDto $userDto DTO con los datos del usuario (sin contraseña).
     * @param string $plainPassword Contraseña en texto plano introducida por el usuario.
     * @return array Resultado del registro (success, message).
     */
    public function userRegister(UserDto $userDto, string $plainPassword)
    {
        if (empty($userDto->name) || empty($userDto->last_name) || empty($userDto->email) || empty($plainPassword)) {
            return ['success' => false, 'message' => 'Todos los campos son obligatorios.'];
        }
        if ($this->userService->emailExists($userDto->email)) {
            return ['success' => false, 'message' => 'El correo ya está registrado. <br> Si tienes problemas para iniciar sesión, por favor, contacta con el messaging.houspecial@gmail.com.'];
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
     * Autentica un usuario por email y contraseña.
     *
     * @param string $email Email del usuario.
     * @param string $password Contraseña en texto plano.
     * @return array Resultado de la autenticación (success, message, user si es correcto).
     */
    public function userLogin($email, $password)
    {
        $userModel = $this->userService->authenticate($email, $password);

        if (!is_null($userModel)) {
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
     * Indica si el usuario con el ID dado es un usuario regular (no administrador).
     *
     * @param int $id ID del usuario a comprobar.
     * @return bool|null Devuelve true si es usuario regular, false si es admin, o null si no existe el usuario.
     */
    public function isRegularUser($id)
    {
        $userModel = $this->userService->getUserById($id);
        if (!$userModel) return null;
        if ($userModel->getRole() === 'admin') {
            return false;
        } else return true;
    }

    /**
     * Actualiza los datos de un usuario.
     *
     * @param int $id ID del usuario a actualizar.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return array Resultado de la actualización (success, message).
     */
    public function updateUser($id, $fields)
    {
        if (empty($fields)) {
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
    public function deleteUser($id)
    {
        if ($this->userService->deleteUser($id)) {
            return ['success' => true, 'message' => 'Usuario eliminado correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar el usuario.'];
        }
    }
}
