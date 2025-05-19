<?php

namespace dtos;

/**
 * DTO para exponer información de usuario sin datos sensibles.
 */
class UserDto {
    public $id;
    public $name;
    public $last_name;
    public $username;
    public $email;
    public $role;
    public $registration_date;
    public $advert_ids;
    public $favorite_advert_ids;
    
    public function __construct($id, $name, $last_name, $username, $email, $role, $registration_date, $advert_ids = [], $favorite_advert_ids = []) {
        $this->id = $id;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->username = $username;
        $this->email = $email;
        $this->role = $role;
        $this->registration_date = $registration_date;
        $this->advert_ids = $advert_ids;
        $this->favorite_advert_ids = $favorite_advert_ids;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
            'registration_date' => $this->registration_date,
            'advert_ids' => $this->advert_ids,
            'favorite_advert_ids' => $this->favorite_advert_ids
        ];
    }
}