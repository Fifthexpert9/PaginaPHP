<?php

namespace services;

use models\ImageModel;
use models\DatabaseModel;
use PDO;

/**
 * Servicio para la gestión de imágenes asociadas a propiedades.
 *
 * Permite realizar operaciones CRUD sobre las imágenes de propiedades.
 */
class ImageService
{
    /**
     * @var PDO Conexión a la base de datos.
     */
    private $db;

    public function __construct()
    {
        $this->db = DatabaseModel::getInstance()->getConnection();
    }

    /**
     * Añade una nueva imagen a una propiedad.
     *
     * @param ImageModel $image Instancia de ImageModel.
     * @return int ID de la imagen insertada.
     */
    public function addImage(ImageModel $image)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO property_image (property_id, image_path, is_main, uploaded_at)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([
            $image->getPropertyId(),
            $image->getImagePath(),
            $image->isMain(),
            $image->getUploadedAt()
        ]);
        return $this->db->lastInsertId();
    }

    /**
     * Obtiene todas las imágenes asociadas a una propiedad.
     *
     * @param int $propertyId ID de la propiedad.
     * @return ImageModel[] Array de objetos ImageModel.
     */
    public function getImagesByProperty($propertyId)
    {
        $stmt = $this->db->prepare("SELECT * FROM property_image WHERE property_id = ?");
        $stmt->execute([$propertyId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $images = [];
        foreach ($rows as $row) {
            $images[] = new ImageModel(
                $row['id'],
                $row['property_id'],
                $row['image_path'],
                $row['is_main'],
                $row['uploaded_at']
            );
        }
        return $images;
    }

    /**
     * Obtiene una imagen por su ID.
     *
     * @param int $id ID de la imagen.
     * @return ImageModel|null
     */
    public function getImageById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM property_image WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new ImageModel(
                $row['id'],
                $row['property_id'],
                $row['image_path'],
                $row['is_main'],
                $row['uploaded_at']
            );
        }
        return null;
    }

    /**
     * Elimina una imagen por su ID.
     *
     * @param int $id ID de la imagen.
     * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    public function deleteImage($id)
    {
        $stmt = $this->db->prepare("DELETE FROM property_image WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Marca una imagen como principal para una propiedad.
     * (Desmarca las demás imágenes de la propiedad como principales).
     *
     * @param int $imageId     ID de la imagen a marcar como principal.
     * @param int $propertyId  ID de la propiedad.
     * @return bool True si la operación fue exitosa.
     */
    public function setMainImage($imageId, $propertyId)
    {
        // Desmarcar todas las imágenes como principales
        $stmt1 = $this->db->prepare("UPDATE property_image SET is_main = 0 WHERE property_id = ?");
        $stmt1->execute([$propertyId]);

        // Marcar la imagen seleccionada como principal
        $stmt2 = $this->db->prepare("UPDATE property_image SET is_main = 1 WHERE id = ? AND property_id = ?");
        return $stmt2->execute([$imageId, $propertyId]);
    }
}