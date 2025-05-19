<?php

namespace models;

/**
 * Modelo de dominio para representar un usuario del sistema.
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
     * @var string Rol del usuario.
     */
    private $role;
    /**
     * @var string Fecha de registro del usuario.
     */
    private $registration_date;

    /**
     * Constructor de UserModel.
     *
     * @param int $id ID del usuario.
     * @param string $name Nombre del usuario.
     * @param string $last_name Apellido del usuario.
     * @param string $username Nombre de usuario.
     * @param string $email Correo electrónico.
     * @param string $password Contraseña (hash).
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
     * @return int
     */
    public function getId() { return $this->id; }
    /**
     * @return string
     */
    public function getName() { return $this->name; }
    /**
     * @return string
     */
    public function getLastName() { return $this->last_name; }
    /**
     * @return string
     */
    public function getUsername() { return $this->username; }
    /**
     * @return string
     */
    public function getEmail() { return $this->email; }
    /**
     * @return string
     */
    public function getPassword() { return $this->password; }
    /**
     * @return string
     */
    public function getRole() { return $this->role; }
    /**
     * @return string
     */
    public function getRegistrationDate() { return $this->registration_date; }

    // Setters
    /**
     * @param string $name
     */
    public function setName($name) { $this->name = $name; }
    /**
     * @param string $last_name
     */
    public function setLastName($last_name) { $this->last_name = $last_name; }
    /**
     * @param string $username
     */
    public function setUsername($username) { $this->username = $username; }
    /**
     * @param string $email
     */
    public function setEmail($email) { $this->email = $email; }
    /**
     * @param string $role
     */
    public function setRole($role) { $this->role = $role; }
    /**
     * @param string $password
     */
    public function setPassword($password) { $this->password = $password; }
}