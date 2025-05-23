<?php

namespace services;

use models\PropertyModel;
use models\DatabaseModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con propiedades en la base de datos.
 *
 * Métodos principales:
 * - createProperty: Inserta una nueva propiedad.
 * - getPropertyById: Obtiene una propiedad por su ID.
 * - getPropertiesByUserId: Obtiene todas las propiedades de un usuario.
 * - updateProperty: Actualiza los campos de una propiedad existente.
 * - deleteProperty: Elimina una propiedad por su ID.
 * - searchProperties: Busca propiedades aplicando filtros generales y específicos, devolviendo solo las propiedades que cumplen los criterios.
 */
class PropertyService {
    /**
     * @var PDO Conexión a la base de datos.
     */
    private $db;

    /**
     * Constructor de PropertyService.
     *
     * @param DatabaseModel $databaseModel Modelo de base de datos con la conexión activa.
     */
    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    /**
     * Crea una nueva propiedad en la base de datos.
     *
     * @param PropertyModel $property Modelo con los datos de la propiedad.
     * @return int ID de la propiedad creada.
     */
    public function createProperty(PropertyModel $property) {
        $sql = "INSERT INTO property (property_type, address_id, built_size, /*price,*/ status, immediate_availability, user_id)
                VALUES (:property_type, :address_id, :built_size, /*:price,*/ :status, :immediate_availability, :user_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':property_type' => $property->getPropertyType(),
            ':address_id' => $property->getAddressId(),
            ':built_size' => $property->getBuiltSize(),
            //':price' => $property->getPrice(),
            ':status' => $property->getStatus(),
            ':immediate_availability' => $property->getImmediateAvailability(),
            ':user_id' => $property->getUserId()
        ]);
        return $this->db->lastInsertId();
    }
    
    /**
     * Obtiene una propiedad por su ID.
     *
     * @param int $id ID de la propiedad.
     * @return PropertyModel|null Modelo de la propiedad o null si no existe.
     */
    public function getPropertyById($id) {
        $sql = "SELECT * FROM property WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $property = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$property) return null;
        return new PropertyModel(
            $property['id'],
            $property['property_type'],
            $property['address_id'],
            $property['built_size'],
            //$property['price'],
            $property['status'],
            $property['immediate_availability'],
            $property['user_id']
        );
    }

    /**
     * Obtiene todas las propiedades de un usuario.
     *
     * @param int $userId ID del usuario.
     * @return PropertyModel[] Array de modelos de propiedades del usuario.
     */
    public function getPropertiesByUserId($userId) {
        $sql = "SELECT * FROM property WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($property) {
            return new PropertyModel(
                $property['id'],
                $property['property_type'],
                $property['address_id'],
                $property['built_size'],
                //$property['price'],
                $property['status'],
                $property['immediate_availability'],
                $property['user_id']
            );
        }, $rows);
    }

    /**
     * Actualiza los campos de una propiedad existente.
     *
     * @param int $id ID de la propiedad a actualizar.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function updateProperty($id, $fields) {
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE property SET $setClause WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $fields['id'] = $id;
            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar propiedad: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina una propiedad por su ID.
     *
     * @param int $id ID de la propiedad a eliminar.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteProperty($id) {
        $sql = "DELETE FROM property WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
