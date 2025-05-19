<?php

namespace services;

use models\StudioModel;
use models\DatabaseModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con estudios en la base de datos.
 */
class StudioService {
    /**
     * @var PDO Conexión a la base de datos.
     */
    private $db;

    /**
     * Constructor de StudioService.
     *
     * @param DatabaseModel $databaseModel Modelo de base de datos con la conexión activa.
     */
    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    /**
     * Crea un nuevo estudio en la base de datos.
     *
     * @param StudioModel $studio Modelo con los datos del estudio.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function createStudio(StudioModel $studio) {
        $sql = "INSERT INTO property_studio (property_id, furnished, balcony, air_conditioning, pets_allowed)
                VALUES (:property_id, :furnished, :balcony, :air_conditioning, :pets_allowed)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':property_id' => $studio->getPropertyId(),
            ':furnished' => $studio->getFurnished(),
            ':balcony' => $studio->getBalcony(),
            ':air_conditioning' => $studio->getAirConditioning(),
            ':pets_allowed' => $studio->getPetsAllowed()
        ]);
    }

    /**
     * Obtiene un estudio por el ID de la propiedad asociada.
     *
     * @param int $propertyId ID de la propiedad.
     * @return StudioModel|null Modelo del estudio o null si no existe.
     */
    public function getStudioByPropertyId($propertyId) {
        $sql = "SELECT * FROM property_studio WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new StudioModel(
                $row['property_id'],
                $row['furnished'],
                $row['balcony'],
                $row['air_conditioning'],
                $row['pets_allowed']
            );
        }
        return null;
    }

    /**
     * Actualiza los campos de un estudio existente.
     *
     * @param int $propertyId ID de la propiedad asociada al estudio.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function updateStudio($propertyId, $fields) {
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE property_studio SET $setClause WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            $fields['property_id'] = $propertyId;
            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar detalles de estudio: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un estudio por el ID de la propiedad asociada.
     *
     * @param int $propertyId ID de la propiedad asociada al estudio.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteStudio($propertyId) {
        try {
            $sql = "DELETE FROM property_studio WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':property_id' => $propertyId]);
        } catch (PDOException $e) {
            error_log('Error al eliminar detalles de estudio: ' . $e->getMessage());
            return false;
        }
    }
}