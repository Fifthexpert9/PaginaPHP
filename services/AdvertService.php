<?php

namespace services;

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
        $sql = "INSERT INTO advert (property_id, user_id, price, action, description, created_at)
                VALUES (:property_id, :user_id, :price, :action, :description, :created_at)";
        $stmt = $this->db->prepare($sql);
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
        $sql = "SELECT * FROM advert WHERE id = :id";
        $stmt = $this->db->prepare($sql);
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
        $sql = "SELECT * FROM advert WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
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
     * Obtiene un anuncio a partir del ID de la propiedad asociada.
     *
     * @param int $propertyId ID de la propiedad.
     * @return AdvertModel|null El anuncio encontrado o null si no existe.
     */
    public function getAdvertByPropertyId($propertyId) {
        $sql = "SELECT * FROM advert WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
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
     * Obtiene todos los anuncios asociados a una propiedad.
     *
     * @param int $propertyId ID de la propiedad.
     * @return AdvertModel[] Array de modelos de anuncios asociados a la propiedad.
     */
    public function getAdvertsByPropertyId($propertyId) {
        $sql = "SELECT * FROM advert WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
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
     * Obtiene todos los anuncios de la base de datos.
     *
     * @return AdvertModel[] Array de modelos de anuncios.
     */
    public function getAllAdverts() {
        $sql = "SELECT * FROM advert";
        $stmt = $this->db->query($sql);
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
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE advert SET $setClause WHERE id = :id";
            $stmt = $this->db->prepare($sql);
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
        try {
            $sql = "DELETE FROM advert WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log('Error al eliminar anuncio: ' . $e->getMessage());
            return false;
        }
    }
}