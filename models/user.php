<?php

class user{

    private $nombre;
    private $email;
    private $password;


    public function __construct($nombre, $email, $password){
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setPassword($password){
        $this->password = $password;
    }


}