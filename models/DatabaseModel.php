<?php

namespace models;

use PDO;
use PDOException;

/**
 * Modelo de dominio para gestionar la conexión a la base de datos mediante el patrón Singleton.
 */
class DatabaseModel {
    /**
     * @var DatabaseModel|null Instancia única de la clase.
     */
    private static $instance = null;

    /**
     * @var string Cadena de conexión a la base de datos.
     */
    private $dbConnectionString = 'mysql:dbname=tfg;host=localhost';

    /**
     * @var string Usuario de la base de datos.
     */
    private $dbUser = 'root';

    /**
     * @var string Contraseña de la base de datos.
     */
    private $dbPassword = '';

    /**
     * @var PDO Conexión PDO activa.
     */
    public $db;

    /**
     * Constructor privado para evitar instanciación directa.
     * Establece la conexión a la base de datos.
     */
    public function __construct() {
        try {
            $this->db = new PDO($this->dbConnectionString, $this->dbUser, $this->dbPassword);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }

    /**
     * Obtiene la instancia única de DatabaseModel.
     *
     * @return DatabaseModel Instancia única de la clase.
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DatabaseModel();
        }
        return self::$instance;
    }
}
