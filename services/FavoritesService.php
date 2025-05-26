<?php

namespace services;

use models\DatabaseModel;
use models\FavoritesModel;
use PDO;

/**
 * Servicio para gestionar operaciones relacionadas con favoritos (relación usuario-anuncio) en la base de datos.
 */
class FavoritesService 
{
    /**
     * @var FavoritesService Instancia única de la clase.
     */
    private static $instance = null;

    /**
     * @var PDO Conexión a la base de datos.
     */
    private $db;

    /**
     * Constructor privado para evitar instanciación directa.
     */
    private function __construct()
    {
        $this->db = DatabaseModel::getInstance()->getConnection();
    }

    /**
     * Método estático para obtener la instancia única de la clase.
     *
     * @return FavoritesService Instancia única de FavoritesService.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new FavoritesService();
        }
        return self::$instance;
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
     * @return FavoritesModel|null Modelo del favorito o null si no existe.
     */
    public function getFavoriteById($id) {
        $sql = "SELECT * FROM favorites WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new FavoritesModel(
                $row['id'],
                $row['user_id'],
                $row['advert_id'],
                isset($row['created_at']) ? $row['created_at'] : null
            );
        }
        return null;
    }

    /**
     * Obtiene todos los favoritos de un usuario.
     *
     * @param int $userId ID del usuario.
     * @return FavoritesModel[] Array de modelos de favoritos del usuario.
     */
    public function getFavoritesByUserId($userId) {
        $sql = "SELECT * FROM favorites WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($row) {
            return new FavoritesModel(
                $row['id'],
                $row['user_id'],
                $row['advert_id'],
                isset($row['created_at']) ? $row['created_at'] : null
            );
        }, $rows);
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