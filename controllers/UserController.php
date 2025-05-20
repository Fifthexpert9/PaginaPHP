<?php

namespace controllers;

use services\UserService;
use models\UserModel;

class UserController {
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * Registra un nuevo usuario.
     * @param string $name Nombre del usuario
     * @param string $last_name Apellido del usuario
     * @param string $email Correo electrónico
     * @param string $password Contraseña
     * @return array Resultado del registro (success (key), message (key))
     */
    public function register($name, $last_name, $email, $password) {
        if (empty($name) || empty($last_name) || empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Todos los campos son obligatorios.'];
        }

        if ($this->userService->emailExists($email)) {
            return ['success' => false, 'message' => 'El correo ya está registrado.'];
        }

        $user = new UserModel(null, $name, $last_name, null, $email, password_hash($password, PASSWORD_BCRYPT), date('Y-m-d H:i:s'));

        if ($this->userService->addUser($user)) {
            return ['success' => true, 'message' => 'Usuario registrado correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al registrar el usuario.'];
        }
    }

    /**
     * Inicia sesión de usuario.
     * @param string $email Correo electrónico
     * @param string $password Contraseña
     * @return array Resultado del login (success (key), message (key))
     */
    public function login($email, $password) {
        if (empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'El correo y la contraseña son obligatorios.'];
        }

        $user = $this->userService->authenticate($email, $password);

        if ($user) {
            return ['success' => true, 'message' => 'Inicio de sesión exitoso.', 'user' => $user];
        } else {
            return ['success' => false, 'message' => 'Credenciales incorrectas.'];
        }
    }

    /**
     * Obtiene un usuario por su ID.
     * @param int $id ID del usuario
     * @return array Resultado de la búsqueda (success (key), user (key) / message (key))
     */
    public function getUser($id) {
        if (empty($id)) {
            return ['success' => false, 'message' => 'El ID del usuario es obligatorio.'];
        }

        $user = $this->userService->getUserById($id);
        if ($user) {
            return ['success' => true, 'user' => $user];
        } else {
            return ['success' => false, 'message' => 'Usuario no encontrado.'];
        }
    }

    /**
     * Obtiene todos los usuarios.
     * @return array Lista de usuarios
     */
    public function getAllUsers() {
        $users = $this->userService->getAllUsers();
        return ['success' => true, 'users' => $users];
    }

    /**
     * Obtiene un usuario por su correo electrónico.
     * @param string $email Correo electrónico
     * @return array Resultado de la búsqueda
     */
    public function getUserByEmail($email) {
        if (empty($email)) {
            return ['success' => false, 'message' => 'El correo es obligatorio.'];
        }

        $user = $this->userService->getUserByEmail($email);
        if ($user) {
            return ['success' => true, 'user' => $user];
        } else {
            return ['success' => false, 'message' => 'Usuario no encontrado.'];
        }
    }

    /**
     * Obtiene un usuario por su nombre de usuario.
     * @param string $username Nombre de usuario
     * @return array Resultado de la búsqueda
     */
    public function getUserByUsername($username) {
        if (empty($username)) {
            return ['success' => false, 'message' => 'El nombre de usuario es obligatorio.'];
        }

        $user = $this->userService->getUserByUsername($username);
        if ($user) {
            return ['success' => true, 'user' => $user];
        } else {
            return ['success' => false, 'message' => 'Usuario no encontrado.'];
        }
    }

    /**
     * Actualiza los datos de un usuario.
     * @param int $id ID del usuario
     * @param array $fields Campos a actualizar
     * @return array Resultado de la actualización
     */
    public function updateUser($id, $fields) {
        if (empty($id) || empty($fields)) {
            return ['success' => false, 'message' => 'ID y campos a actualizar son obligatorios.'];
        }

        if ($this->userService->updateUser($id, $fields)) {
            return ['success' => true, 'message' => 'Usuario actualizado correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar el usuario.'];
        }
    }

    /**
     * Elimina un usuario por su ID.
     * @param int $id ID del usuario
     * @return array Resultado de la eliminación
     */
    public function deleteUser($id) {
        if (empty($id)) {
            return ['success' => false, 'message' => 'El ID del usuario es obligatorio.'];
        }

        if ($this->userService->deleteUser($id)) {
            return ['success' => true, 'message' => 'Usuario eliminado correctamente.'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar el usuario.'];
        }
    }
}
