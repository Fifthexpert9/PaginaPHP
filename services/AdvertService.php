<?php

namespace services;

use models\AdvertModel;
use models\DatabaseModel;
use PDO;
use PDOException;

class AdvertService {
    private $db;

    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

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