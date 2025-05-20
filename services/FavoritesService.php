<?php

namespace services;

use models\DatabaseModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con favoritos (relación usuario-anuncio) en la base de datos.
 */
class FavoritesService {
    /**
     * @var PDO Conexión a la base de datos.
     */
    private $db;

    /**
     * Constructor de FavoritesService.
     *
     * @param DatabaseModel $databaseModel Modelo de base de datos con la conexión activa.
     */
    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    /**
     * Añade un anuncio a favoritos para un usuario.
     *
     * @param int $userId ID del usuario.
     * @param int $advertId ID del anuncio.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function addFavorite($userId, $advertId) {
        $sql = "INSERT INTO favorites (user_id, advert_id) VALUES (:user_id, :advert_id)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':advert_id' => $advertId
        ]);
    }

    /**
     * Obtiene un favorito por su ID.
     *
     * @param int $id ID del favorito.
     * @return array|null Datos del favorito o null si no existe.
     */
    public function getFavoriteById($id) {
        $sql = "SELECT * FROM favorites WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todos los favoritos de un usuario.
     *
     * @param int $userId ID del usuario.
     * @return array Array de favoritos del usuario.
     */
    public function getFavoritesByUserId($userId) {
        $sql = "SELECT * FROM favorites WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Elimina un favorito por usuario y anuncio.
     *
     * @param int $userId ID del usuario.
     * @param int $advertId ID del anuncio.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function removeFavorite($userId, $advertId) {
        $sql = "DELETE FROM favorites WHERE user_id = :user_id AND advert_id = :advert_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':advert_id' => $advertId
        ]);
    }

    /**
     * Elimina un favorito por su ID.
     *
     * @param int $id ID del favorito.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteFavoriteById($id) {
        $sql = "DELETE FROM favorites WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}