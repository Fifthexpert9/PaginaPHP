<?php

namespace services;

use models\PropertyModel;
use models\DatabaseModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con propiedades en la base de datos.
 *
 * Esta clase proporciona métodos para crear, obtener, actualizar, eliminar y buscar propiedades inmobiliarias.
 * Implementa el patrón Singleton para asegurar una única instancia y reutilizar la conexión a la base de datos.
 *
 * Métodos principales:
 * - getInstance(): Obtiene la instancia única del servicio.
 * - createProperty(PropertyModel $property): Inserta una nueva propiedad.
 * - getPropertyById($id): Obtiene una propiedad por su ID.
 * - getPropertiesByUserId($user_id): Obtiene todas las propiedades de un usuario.
 * - updateProperty($id, $fields): Actualiza los campos de una propiedad existente.
 * - deleteProperty($id): Elimina una propiedad por su ID.
 * - searchProperties($filters): Busca propiedades aplicando filtros generales y específicos.
 */
class PropertyService
{
    /**
     * @var PropertyService Instancia única de la clase.
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
     * @return PropertyService Instancia única de PropertyService.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new PropertyService();
        }
        return self::$instance;
    }

    /**
     * Crea una nueva propiedad en la base de datos.
     *
     * @param PropertyModel $property Modelo con los datos de la propiedad.
     * @return int|string ID de la propiedad creada o mensaje de error.
     */
    public function createProperty(PropertyModel $property)
    {
        try {
            $sql = "INSERT INTO property (property_type, address_id, built_size, status, immediate_availability, user_id)
                    VALUES (:property_type, :address_id, :built_size, :status, :immediate_availability, :user_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':property_type' => $property->getPropertyType(),
                ':address_id' => $property->getAddressId(),
                ':built_size' => $property->getBuiltSize(),
                ':status' => $property->getStatus(),
                ':immediate_availability' => $property->getImmediateAvailability(),
                ':user_id' => $property->getUserId()
            ]);
            $id = $this->db->lastInsertId();
            if (!$id) {
                return "No se pudo crear la propiedad.";
            }
            return $id;
        } catch (\PDOException $e) {
            return "Error SQL: " . $e->getMessage();
        }
    }

    /**
     * Obtiene una propiedad por su ID.
     *
     * @param int $id ID de la propiedad.
     * @return PropertyModel|null Modelo de la propiedad o null si no existe.
     */
    public function getPropertyById($id)
    {
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
            $property['status'],
            $property['immediate_availability'],
            $property['user_id']
        );
    }

    /**
     * Obtiene todas las propiedades de un usuario.
     *
     * @param int $user_id ID del usuario.
     * @return PropertyModel[] Array de modelos de propiedades del usuario.
     */
    public function getPropertiesByUserId($user_id)
    {
        $sql = "SELECT * FROM property WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($property) {
            return new PropertyModel(
                $property['id'],
                $property['property_type'],
                $property['address_id'],
                $property['built_size'],
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
    public function updateProperty($id, $fields)
    {
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE `property` SET $setClause WHERE `id` = :id";
            $stmt = $this->db->prepare($sql);
            $fields[':id'] = $id;
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
    public function deleteProperty($id)
    {
        $sql = "DELETE FROM property WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Busca propiedades aplicando filtros generales y específicos.
     *
     * @param array $filters Filtros para la búsqueda de propiedades.
     * @return PropertyModel[] Array de propiedades que cumplen los filtros.
     */
    public function searchProperties($filters = [])
    {
        $sql = "SELECT * FROM property WHERE 1=1";
        $params = [];

        if (!empty($filters['property_type'])) {
            $sql .= " AND property_type = :property_type";
            $params[':property_type'] = $filters['property_type'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params[':status'] = $filters['status'];
        }

        if (isset($filters['immediate_availability'])) {
            $sql .= " AND immediate_availability = :immediate_availability";
            $params[':immediate_availability'] = $filters['immediate_availability'] ? 1 : 0;
        }

        if (!empty($filters['user_id'])) {
            $sql .= " AND user_id = :user_id";
            $params[':user_id'] = $filters['user_id'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($property) {
            return new PropertyModel(
                $property['id'],
                $property['property_type'],
                $property['address_id'],
                $property['built_size'],
                $property['status'],
                $property['immediate_availability'],
                $property['user_id']
            );
        }, $rows);
    }
}
