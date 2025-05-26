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
     * @var ImageService Instancia única de la clase.
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
     * @return ImageService Instancia única de ImageService.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new ImageService();
        }
        return self::$instance;
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
     * Obtiene la imagen principal de una propiedad.
     *
     * Realiza una consulta a la base de datos para buscar la imagen marcada como principal (is_main = 1)
     * asociada a la propiedad indicada por su ID. Si existe, devuelve una instancia de ImageModel con los datos
     * de la imagen principal. Si no existe ninguna imagen principal, devuelve null.
     *
     * @param int $propertyId ID de la propiedad.
     * @return ImageModel|null Instancia de ImageModel si existe imagen principal, null si no existe.
     */
    public function getMainImageByPropertyId($propertyId)
    {
        $stmt = $this->db->prepare("SELECT * FROM property_image WHERE property_id = ? AND is_main = 1");
        $stmt->execute([$propertyId]);
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
     * Obtiene todas las imágenes asociadas a una propiedad.
     *
     * @param int $propertyId ID de la propiedad.
     * @return ImageModel[] Array de objetos ImageModel.
     */
    public function getImagesByPropertyId($propertyId)
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
     * Elimina una imagen por su ID.
     *
     * @param int $id ID de la imagen.
     * @return bool True si se eliminó correctamente, false en caso contrario.
     */
    public function deleteImageById($id)
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
