<?php

namespace services;

use models\DatabaseModel;
use PDO;
use PDOException;

class FavoritesService {
    private $db;

    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    public function addFavorite($userId, $advertId) {
        $sql = "INSERT INTO favorites (user_id, advert_id) VALUES (:user_id, :advert_id)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':advert_id' => $advertId
        ]);
    }

    public function getFavoriteById($id) {
        $sql = "SELECT * FROM favorites WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFavoritesByUserId($userId) {
        $sql = "SELECT * FROM favorites WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeFavorite($userId, $advertId) {
        $sql = "DELETE FROM favorites WHERE user_id = :user_id AND advert_id = :advert_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':advert_id' => $advertId
        ]);
    }

    public function deleteFavoriteById($id) {
        $sql = "DELETE FROM favorites WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}