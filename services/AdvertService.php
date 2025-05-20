<?php

namespace services;

require_once __DIR__ . '/../models/AdvertModel.php';
require_once __DIR__ . '/../models/DatabaseModel.php';

use models\AdvertModel;
use models\DatabaseModel;
use PDO;
use PDOException;

class AdvertService {
    private $db;
/*
    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }
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