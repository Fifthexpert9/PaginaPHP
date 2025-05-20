<?php

namespace services;

require_once __DIR__ . '/../models/AdvertModel.php';
require_once __DIR__ . '/../models/DatabaseModel.php';

use models\AdvertModel;
use models\DatabaseModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con anuncios en la base de datos.
 */
class AdvertService {
    /**
     * @var PDO Conexión a la base de datos.
     */
    private $db;

    /**
     * Constructor de AdvertService.
     *
     * @param DatabaseModel $databaseModel Modelo de base de datos con la conexión activa.
     */
    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    /**
     * Crea un nuevo anuncio en la base de datos.
     *
     * @param AdvertModel $advert Modelo con los datos del anuncio.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function createAdvert(AdvertModel $advert) {

        $db = new DatabaseModel();

        $sql = "INSERT INTO advert (property_id, user_id, price, action, description, created_at)
                VALUES (:property_id, :user_id, :price, :action, :description, :created_at)";
        $stmt = $db->db->prepare($sql);
        return $stmt->execute([
            ':property_id' => $advert->getPropertyId(),
            ':user_id' => $advert->getUserId(),
            ':price' => $advert->getPrice(),
            ':action' => $advert->getAction(),
            ':description' => $advert->getDescription(),
            ':created_at' => $advert->getCreatedAt()
        ]);
    }

    /**
     * Obtiene un anuncio por su ID.
     *
     * @param int $id ID del anuncio.
     * @return AdvertModel|null El anuncio encontrado o null si no existe.
     */
    public function getAdvertById($id) {

        $db = new DatabaseModel();

        $sql = "SELECT * FROM advert WHERE id = :id";
        $stmt = $db->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new AdvertModel(
                $row['id'],
                $row['property_id'],
                $row['user_id'],
                $row['price'],
                $row['action'],
                $row['description'],
                $row['created_at']
            );
        }
        return null;
    }

    /**
     * Obtiene todos los anuncios publicados por un usuario.
     *
     * @param int $userId ID del usuario.
     * @return AdvertModel[] Array de anuncios del usuario.
     */
    public function getAdvertsByUserId($userId) {

        $db = new DatabaseModel();

        $sql = "SELECT * FROM advert WHERE user_id = :user_id";
        $stmt = $db->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $adverts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $adverts[] = new AdvertModel(
                $row['id'],
                $row['property_id'],
                $row['user_id'],
                $row['price'],
                $row['action'],
                $row['description'],
                $row['created_at']
            );
        }
        return $adverts;
    }

    /**
     * Actualiza los campos de un anuncio existente.
     *
     * @param int $id ID del anuncio a actualizar.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function updateAdvert($id, $fields) {

        $db = new DatabaseModel();

        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE advert SET $setClause WHERE id = :id";
            $stmt = $db->db->prepare($sql);
            $fields['id'] = $id;
            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar anuncio: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un anuncio por su ID.
     *
     * @param int $id ID del anuncio a eliminar.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteAdvert($id) {

        $db = new DatabaseModel();

        try {
            $sql = "DELETE FROM advert WHERE id = :id";
            $stmt = $db->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log('Error al eliminar anuncio: ' . $e->getMessage());
            return false;
        }
    }

    public function getFeaturedAdverts() {

        $db = new DatabaseModel();

        $sql = "SELECT * FROM advert ORDER BY created_at DESC LIMIT 5"; // Ejemplo: los 5 anuncios más recientes
        $stmt = $db->db->prepare($sql);
        $stmt->execute();

        $adverts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $adverts[] = new AdvertModel(
                $row['id'],
                $row['property_id'],
                $row['user_id'],
                $row['price'],
                $row['action'],
                $row['description'],
                $row['created_at']
            );
        }

        return $adverts;
    }
}