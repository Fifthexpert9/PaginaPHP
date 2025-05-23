<?php

namespace models;

use PDO;
use PDOException;

/**
 * Modelo de dominio para gestionar la conexión a la base de datos mediante el patrón Singleton.
 *
 * Esta clase se encarga de establecer y mantener una única conexión activa a la base de datos
 * durante el ciclo de vida de la aplicación. Utiliza el patrón Singleton para asegurar que solo
 * exista una instancia de la conexión y facilitar el acceso global a la misma.
 *
 * Ejemplo de uso:
 * $db = DatabaseModel::getInstance()->db;
 */
class DatabaseModel {
    /**
     * @var DatabaseModel|null Instancia única de la clase (Singleton).
     */
    private static $instance = null;

    /**
     * @var string Cadena de conexión a la base de datos (DSN).
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
     * Constructor privado para evitar la instanciación directa.
     * Establece la conexión a la base de datos utilizando PDO.
     * Si la conexión falla, detiene la ejecución y muestra el mensaje de error.
     */
    private function __construct() {
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
     * Si la instancia aún no ha sido creada, la crea y la devuelve.
     * En caso contrario, devuelve la instancia ya existente.
     *
     * @return DatabaseModel Instancia única de la clase.
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DatabaseModel();
        }
        return self::$instance;
    }

    /**
     * Obtiene la conexión PDO activa.
     *
     * @return PDO Conexión PDO activa.
     */
    public function getConnection() {
        return $this->db;
    }
}
