<?php

namespace models;

/**
 * Modelo de dominio para representar un usuario del sistema.
 *
 * Esta clase encapsula los datos y comportamientos relacionados con un usuario registrado en la plataforma.
 * Permite almacenar información relevante como el nombre, apellidos, nombre de usuario, correo electrónico,
 * contraseña (hash), rol y fecha de registro. Se utiliza para transferir información entre las capas de dominio,
 * presentación y persistencia.
 */
class UserModel {
    /**
     * @var int ID del usuario.
     */
    private $id;

    /**
     * @var string Nombre del usuario.
     */
    private $name;

    /**
     * @var string Apellido del usuario.
     */
    private $last_name;

    /**
     * @var string Nombre de usuario.
     */
    private $username;

    /**
     * @var string Correo electrónico del usuario.
     */
    private $email;

    /**
     * @var string Contraseña del usuario (hash).
     */
    private $password;

    /**
     * @var string Rol del usuario (por ejemplo, 'user' o 'admin').
     */
    private $role;

    /**
     * @var string Fecha de registro del usuario (formato timestamp o datetime).
     */
    private $registration_date;

    /**
     * Constructor de UserModel.
     *
     * @param int    $id                ID del usuario.
     * @param string $name              Nombre del usuario.
     * @param string $last_name         Apellido del usuario.
     * @param string $username          Nombre de usuario.
     * @param string $email             Correo electrónico.
     * @param string $password          Contraseña (hash).
     * @param string $registration_date Fecha de registro.
     */
    public function __construct($id, $name, $last_name, $username, $email, $password, $registration_date) {
        $this->id = $id;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = 'user';
        $this->registration_date = $registration_date;
    }

    // Getters

    /**
     * Obtiene el ID del usuario.
     * @return int
     */
    public function getId() { return $this->id; }

    /**
     * Obtiene el nombre del usuario.
     * @return string
     */
    public function getName() { return $this->name; }

    /**
     * Obtiene el apellido del usuario.
     * @return string
     */
    public function getLastName() { return $this->last_name; }

    /**
     * Obtiene el nombre de usuario.
     * @return string
     */
    public function getUsername() { return $this->username; }

    /**
     * Obtiene el correo electrónico del usuario.
     * @return string
     */
    public function getEmail() { return $this->email; }

    /**
     * Obtiene la contraseña del usuario (hash).
     * @return string
     */
    public function getPassword() { return $this->password; }

    /**
     * Obtiene el rol del usuario.
     * @return string
     */
    public function getRole() { return $this->role; }

    /**
     * Obtiene la fecha de registro del usuario.
     * @return string
     */
    public function getRegistrationDate() { return $this->registration_date; }

    // Setters

    /**
     * Establece el nombre del usuario.
     * @param string $name
     */
    public function setName($name) { $this->name = $name; }

    /**
     * Establece el apellido del usuario.
     * @param string $last_name
     */
    public function setLastName($last_name) { $this->last_name = $last_name; }

    /**
     * Establece el nombre de usuario.
     * @param string $username
     */
    public function setUsername($username) { $this->username = $username; }

    /**
     * Establece el correo electrónico del usuario.
     * @param string $email
     */
    public function setEmail($email) { $this->email = $email; }

    /**
     * Establece el rol del usuario.
     * @param string $role
     */
    public function setRole($role) { $this->role = $role; }

    /**
     * Establece la contraseña del usuario (hash).
     * @param string $password
     */
    public function setPassword($password) { $this->password = $password; }
}