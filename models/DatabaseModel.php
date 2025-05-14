<?php

namespace models;

use PDO;
use PDOException;

class DatabaseModel {

    private $dbConnectionString = 'mysql:dbname=tfg;host=localhost';
    private $dbUser = 'root';
    private $dbPassword = '';

    public $db;

    public function __construct() {
        try {
            $this->db = new PDO($this->dbConnectionString, $this->dbUser, $this->dbPassword);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error al conectar con la base de datos: ' . $e->getMessage());
        }
    }
}
