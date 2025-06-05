<?php

namespace dtos;

/**
 * DTO para exponer información de usuario sin datos sensibles.
 *
 * @property int $id ID del usuario.
 * @property string $name Nombre del usuario.
 * @property string $last_name Apellido del usuario.
 * @property string $username Nombre de usuario.
 * @property string $email Correo electrónico del usuario.
 * @property string $role Rol del usuario.
 * @property string $registration_date Fecha de registro del usuario.
 * @property array $favorite_adverts Anuncios marcados como favoritos por el usuario.
 */
class UserDto
{
    public $id;
    public $name;
    public $last_name;
    public $username;
    public $email;
    public $role;
    public $registration_date;
    public $adverts;
    public $favorite_adverts;

    /**
     * Constructor de UserDto.
     *
     * @param int $id ID del usuario.
     * @param string $name Nombre del usuario.
     * @param string $last_name Apellido del usuario.
     * @param string $username Nombre de usuario.
     * @param string $email Correo electrónico del usuario.
     * @param string $role Rol del usuario.
     * @param string $registration_date Fecha de registro del usuario.
     * @param array $favorite_adverts listado de anuncios favoritos del usuario.
     */
    public function __construct($id, $name, $last_name, $username, $email, $role, $registration_date, $favorite_adverts = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->username = $username;
        $this->email = $email;
        $this->role = $role;
        $this->registration_date = $registration_date;
        $this->favorite_adverts = $favorite_adverts;
    }

    /**
     * Devuelve el usuario como un array asociativo.
     *
     * @return array<string, mixed> Datos del usuario.
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
            'registration_date' => $this->registration_date,
            'favorite_adverts' => $this->favorite_adverts
        ];
    }
}
