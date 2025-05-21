<?php

namespace services;

use models\PropertyModel;
use models\AddressModel;
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
     * Busca propiedades aplicando filtros generales y específicos.
     * Solo devuelve las propiedades (no los datos específicos de tablas hijas).
     * El resultado se ordena por tipo de propiedad.
     *
     * Ejemplo de filtros:
     * [
     *   'property_types' => ['Piso', 'Casa'],
     *   'built_size_min' => 50,
     *   'price_max' => 1000,
     *   'apartment' => ['num_rooms' => 3, 'furnished' => 1],
     *   'house' => ['house_type' => ['Adosado', 'Chalet']]
     * ]
     *
     * @param array $filters Filtros generales y específicos.
     * @return array Propiedades que cumplen los filtros, ordenadas por tipo (orden: casa, estudio, habitación, piso).
     */
    public function searchProperties($filters = []) {
        $sql = "SELECT DISTINCT p.*";
        $joins = "";
        $wheres = ["1=1"];
        $params = [];

        $propertyTypes = $filters['property_types'] ?? [];
        if (in_array('Habitación', $propertyTypes)) {
            $joins .= " LEFT JOIN property_room r ON p.id = r.property_id";
        }
        if (in_array('Estudio', $propertyTypes)) {
            $joins .= " LEFT JOIN property_studio s ON p.id = s.property_id";
        }
        if (in_array('Piso', $propertyTypes)) {
            $joins .= " LEFT JOIN property_apartment a ON p.id = a.property_id";
        }
        if (in_array('Casa', $propertyTypes)) {
            $joins .= " LEFT JOIN property_house h ON p.id = h.property_id";
        }

        $sql .= " FROM property p" . $joins;

        // Filtros generales
        if (!empty($propertyTypes)) {
            $in = implode(',', array_fill(0, count($propertyTypes), '?'));
            $wheres[] = "p.property_type IN ($in)";
            $params = array_merge($params, $propertyTypes);
        }
        if (!empty($filters['built_size_min'])) {
            $wheres[] = "p.built_size >= ?";
            $params[] = $filters['built_size_min'];
        }
        if (!empty($filters['built_size_max'])) {
            $wheres[] = "p.built_size <= ?";
            $params[] = $filters['built_size_max'];
        }
        if (!empty($filters['price_min'])) {
            $wheres[] = "p.price >= ?";
            $params[] = $filters['price_min'];
        }
        if (!empty($filters['price_max'])) {
            $wheres[] = "p.price <= ?";
            $params[] = $filters['price_max'];
        }
        if (!empty($filters['status'])) {
            $wheres[] = "p.status = ?";
            $params[] = $filters['status'];
        }
        if (isset($filters['immediate_availability'])) {
            $wheres[] = "p.immediate_availability = ?";
            $params[] = $filters['immediate_availability'];
        }

        /*
        // Filtros específicos por habitación
        if (isset($filters['room']['private_bathroom'])) {
            $wheres[] = "r.private_bathroom = ?";
            $params[] = $filters['room']['private_bathroom'];
        }
        if (!empty($filters['room']['max_roommates'])) {
            $wheres[] = "r.max_roommates = ?";
            $params[] = $filters['room']['max_roommates'];
        }
        if (isset($filters['room']['pets_allowed'])) {
            $wheres[] = "r.pets_allowed = ?";
            $params[] = $filters['room']['pets_allowed'];
        }
        if (isset($filters['room']['furnished'])) {
            $wheres[] = "r.furnished = ?";
            $params[] = $filters['room']['furnished'];
        }
        if (isset($filters['room']['students_only'])) {
            $wheres[] = "r.students_only = ?";
            $params[] = $filters['room']['students_only'];
        }
        if (!empty($filters['room']['gender_restriction']) && $filters['room']['gender_restriction'] !== 'None') {
            $wheres[] = "r.gender_restriction = ?";
            $params[] = $filters['room']['gender_restriction'];
        }

        // Filtros específicos por estudio
        if (isset($filters['studio']['furnished'])) {
            $wheres[] = "s.furnished = ?";
            $params[] = $filters['studio']['furnished'];
        }
        if (isset($filters['studio']['balcony'])) {
            $wheres[] = "s.balcony = ?";
            $params[] = $filters['studio']['balcony'];
        }
        if (isset($filters['studio']['air_conditioning'])) {
            $wheres[] = "s.air_conditioning = ?";
            $params[] = $filters['studio']['air_conditioning'];
        }
        if (isset($filters['studio']['pets_allowed'])) {
            $wheres[] = "s.pets_allowed = ?";
            $params[] = $filters['studio']['pets_allowed'];
        }

        // Filtros específicos por piso
        if (!empty($filters['apartment']['apartment_type']) && is_array($filters['apartment']['apartment_type'])) { // si son varios valores
            $apartmentTypes = $filters['apartment']['apartment_type'];
            $in = implode(',', array_fill(0, count($apartmentTypes), '?'));
            $wheres[] = "a.apartment_type IN ($in)";
            $params = array_merge($params, $apartmentTypes);
        } elseif (!empty($filters['apartment']['apartment_type'])) { // si es un solo valor
            $wheres[] = "a.apartment_type = ?";
            $params[] = $filters['apartment']['apartment_type'];
        }
        if (!empty($filters['apartment']['num_rooms'])) {
            $wheres[] = "a.num_rooms = ?";
            $params[] = $filters['apartment']['num_rooms'];
        }
        if (!empty($filters['apartment']['num_bathrooms'])) {
            $wheres[] = "a.num_bathrooms = ?";
            $params[] = $filters['apartment']['num_bathrooms'];
        }
        if (isset($filters['apartment']['furnished'])) {
            $wheres[] = "a.furnished = ?";
            $params[] = $filters['apartment']['furnished'];
        }
        if (isset($filters['apartment']['balcony'])) {
            $wheres[] = "a.balcony = ?";
            $params[] = $filters['apartment']['balcony'];
        }
        if (!empty($filters['apartment']['floor'])) {
            $wheres[] = "a.floor = ?";
            $params[] = $filters['apartment']['floor'];
        }
        if (isset($filters['apartment']['elevator'])) {
            $wheres[] = "a.elevator = ?";
            $params[] = $filters['apartment']['elevator'];
        }
        if (isset($filters['apartment']['air_conditioning'])) {
            $wheres[] = "a.air_conditioning = ?";
            $params[] = $filters['apartment']['air_conditioning'];
        }
        if (isset($filters['apartment']['garage'])) {
            $wheres[] = "a.garage = ?";
            $params[] = $filters['apartment']['garage'];
        }
        if (isset($filters['apartment']['pets_allowed'])) {
            $wheres[] = "a.pets_allowed = ?";
            $params[] = $filters['apartment']['pets_allowed'];
        }

        // Filtros específicos por casa
        if (!empty($filters['house']['house_type']) && is_array($filters['house']['house_type'])) { // si son varios valores
            $houseTypes = $filters['house']['house_type'];
            $in = implode(',', array_fill(0, count($houseTypes), '?'));
            $wheres[] = "h.house_type IN ($in)";
            $params = array_merge($params, $houseTypes);
        } elseif (!empty($filters['house']['house_type'])) { // si es un solo valor
            $wheres[] = "h.house_type = ?";
            $params[] = $filters['house']['house_type'];
        }
        if (!empty($filters['house']['garden_size_min'])) {
            $wheres[] = "h.garden_size >= ?";
            $params[] = $filters['house']['garden_size_min'];
        }
        if (!empty($filters['house']['num_floors_min'])) {
            $wheres[] = "h.num_floors >= ?";
            $params[] = $filters['house']['num_floors_min'];
        }
        if (!empty($filters['house']['num_rooms_min'])) {
            $wheres[] = "h.num_rooms >= ?";
            $params[] = $filters['house']['num_rooms_min'];
        }
        if (!empty($filters['house']['num_bathrooms_min'])) {
            $wheres[] = "h.num_bathrooms >= ?";
            $params[] = $filters['house']['num_bathrooms_min'];
        }
        if (isset($filters['house']['private_garage'])) {
            $wheres[] = "h.private_garage = ?";
            $params[] = $filters['house']['private_garage'];
        }
        if (isset($filters['house']['private_pool'])) {
            $wheres[] = "h.private_pool = ?";
            $params[] = $filters['house']['private_pool'];
        }
        if (isset($filters['house']['furnished'])) {
            $wheres[] = "h.furnished = ?";
            $params[] = $filters['house']['furnished'];
        }
        if (isset($filters['house']['terrace'])) {
            $wheres[] = "h.terrace = ?";
            $params[] = $filters['house']['terrace'];
        }
        if (isset($filters['house']['storage_room'])) {
            $wheres[] = "h.storage_room = ?";
            $params[] = $filters['house']['storage_room'];
        }
        if (isset($filters['house']['air_conditioning'])) {
            $wheres[] = "h.air_conditioning = ?";
            $params[] = $filters['house']['air_conditioning'];
        }
        if (isset($filters['house']['pets_allowed'])) {
            $wheres[] = "h.pets_allowed = ?";
            $params[] = $filters['house']['pets_allowed'];
        }
        */

        $sql .= " WHERE " . implode(' AND ', $wheres);

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        usort($result, function($a, $b) {
            return strcmp($a['property_type'], $b['property_type']);
        });

        return $result;
    }
}
