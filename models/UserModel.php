<?php

namespace models;

class UserModel {
    private $id;
    private $name;
    private $last_name;
    private $username;
    private $email;
    private $password;
    private $registration_date;

    public function __construct($id, $name, $last_name, $username, $email, $password, $registration_date) {
        $this->id = $id;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->registration_date = $registration_date;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getLastName() { return $this->last_name; }
    public function getUsername() { return $this->username; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getRegistrationDate() { return $this->registration_date; }

    // Setters
    public function setName($name) { $this->name = $name; }
    public function setLastName($last_name) { $this->last_name = $last_name; }
    public function setUsername($username) { $this->username = $username; }
    public function setEmail($email) { $this->email = $email; }
    public function setPassword($password) { $this->password = $password; }
}