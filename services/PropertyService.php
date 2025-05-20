<?php

namespace services;

use models\PropertyModel;
use models\AddressModel;
use models\DatabaseModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con propiedades en la base de datos.
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
        $sql = "INSERT INTO property (property_type, address_id, built_size, price, status, immediate_availability, user_id)
                VALUES (:property_type, :address_id, :built_size, :price, :status, :immediate_availability, :user_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':property_type' => $property->getPropertyType(),
            ':address_id' => $property->getAddressId(),
            ':built_size' => $property->getBuiltSize(),
            ':price' => $property->getPrice(),
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
     * @return array|null Datos de la propiedad o null si no existe.
     */
    public function getPropertyById($id) {
        $sql = "SELECT * FROM property WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $property = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$property) return null;
        return $property;
    }

    
    /**
     * Obtiene todas las propiedades.
     *
     * @return array Array de todas las propiedades.
     */
    /*
    public function getAllProperties() {
        $sql = "SELECT * FROM property";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    */

    /**
     * Obtiene todas las propiedades de un usuario.
     *
     * @param int $userId ID del usuario.
     * @return array Array de propiedades del usuario.
     */
    public function getPropertiesByUserId($userId) {
        $sql = "SELECT * FROM property WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    /**
     * Busca propiedades según los filtros generales y específicos.
     *
     * @param array $filters Filtros de búsqueda (ej: [
     *   'property_types' => ['Piso', 'Estudio'],
     *   'price_max' => 800,
     *   'apartment' => ['num_rooms' => 3],
     *   'studio' => ['has_balcony' => 1]
     * ])
     * @return array Propiedades encontradas
     */
    public function searchProperties($filters = []) {
        $sql = "SELECT p.*";
        $joins = "";
        $wheres = ["1=1"];
        $params = [];

        // JOINs y selección de columnas específicas según tipos de vivienda
        $propertyTypes = $filters['property_types'] ?? [];
        if (in_array('Piso', $propertyTypes)) {
            $sql .= ", a.*";
            $joins .= " LEFT JOIN property_apartment a ON p.id = a.property_id";
        }
        if (in_array('Estudio', $propertyTypes)) {
            $sql .= ", s.*";
            $joins .= " LEFT JOIN property_studio s ON p.id = s.property_id";
        }
        if (in_array('Casa', $propertyTypes)) {
            $sql .= ", h.*";
            $joins .= " LEFT JOIN property_house h ON p.id = h.property_id";
        }
        // Añade más tipos según tu modelo

        $sql = "SELECT " . substr($sql, 9) . " FROM property p" . $joins;

        // Filtros generales
        if (!empty($propertyTypes)) {
            $in = implode(',', array_fill(0, count($propertyTypes), '?'));
            $wheres[] = "p.property_type IN ($in)";
            $params = array_merge($params, $propertyTypes);
        }
        if (!empty($filters['price_max'])) {
            $wheres[] = "p.price <= ?";
            $params[] = $filters['price_max'];
        }
        if (!empty($filters['price_min'])) {
            $wheres[] = "p.price >= ?";
            $params[] = $filters['price_min'];
        }
        if (!empty($filters['user_id'])) {
            $wheres[] = "p.user_id = ?";
            $params[] = $filters['user_id'];
        }

        // Filtros específicos por tipo
        if (!empty($filters['apartment']['num_rooms'])) {
            $wheres[] = "a.num_rooms = ?";
            $params[] = $filters['apartment']['num_rooms'];
        }
        if (!empty($filters['studio']['has_balcony'])) {
            $wheres[] = "s.has_balcony = ?";
            $params[] = $filters['studio']['has_balcony'];
        }
        if (!empty($filters['house']['garden_size'])) {
            $wheres[] = "h.garden_size >= ?";
            $params[] = $filters['house']['garden_size'];
        }
        // Añade más filtros específicos según tus necesidades

        $sql .= " WHERE " . implode(' AND ', $wheres);

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
