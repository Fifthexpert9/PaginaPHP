<?php

class Producto{

    private $id;
    private $nombre;
    private $imagen;

    public function __construct($id, $nombre, $imagen){
        $this->id = $id;    
        $this->nombre = $nombre;
        $this->imagen = $imagen;
    }

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getImagen(){
        return $this->imagen;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setImagen($imagen){
        $this->imagen = $imagen;
    }

    
    

}