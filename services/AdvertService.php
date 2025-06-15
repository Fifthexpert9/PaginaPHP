<?php

namespace services;

use models\AdvertModel;
use models\DatabaseModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con anuncios en la base de datos.
 *
 * Esta clase proporciona métodos para crear, obtener, actualizar, eliminar y buscar anuncios inmobiliarios.
 * Implementa el patrón Singleton para asegurar una única instancia y reutilizar la conexión a la base de datos.
 *
 * Métodos principales:
 * - getInstance(): Obtiene la instancia única del servicio.
 * - createAdvert(AdvertModel $advert): Crea un nuevo anuncio.
 * - getAdvertById($id): Obtiene un anuncio por su ID.
 * - getAdvertsByUserId($userId): Obtiene todos los anuncios publicados por un usuario.
 * - getAdvertByPropertyId($propertyId): Obtiene un anuncio a partir del ID de la propiedad asociada.
 * - getAdvertsByPropertyId($propertyId): Obtiene todos los anuncios asociados a una propiedad.
 * - getAllAdverts(): Obtiene todos los anuncios de la base de datos.
 * - updateAdvert($id, $fields): Actualiza los campos de un anuncio existente.
 * - deleteAdvert($id): Elimina un anuncio por su ID.
 * - searchAdverts($filters): Busca anuncios aplicando filtros generales y específicos.
 */
class AdvertService
{
    /**
     * @var AdvertService Instancia única de la clase.
     */
    private static $instance = null;

    /**
     * @var PDO Conexión a la base de datos.
     */
    private $db;

    /**
     * Constructor privado para evitar instanciación directa.
     * Establece la conexión a la base de datos.
     */
    private function __construct()
    {
        $this->db = DatabaseModel::getInstance()->getConnection();
    }

    /**
     * Método estático para obtener la instancia única de la clase.
     *
     * @return AdvertService Instancia única de AdvertService.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new AdvertService();
        }
        return self::$instance;
    }

    /**
     * Crea un nuevo anuncio en la base de datos.
     *
     * @param AdvertModel $advert Modelo con los datos del anuncio.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function createAdvert(AdvertModel $advert)
    {
        $sql = "INSERT INTO advert (property_id, user_id, price, action, description)
                VALUES (:property_id, :user_id, :price, :action, :description)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':property_id' => $advert->getPropertyId(),
            ':user_id' => $advert->getUserId(),
            ':price' => $advert->getPrice(),
            ':action' => $advert->getAction(),
            ':description' => $advert->getDescription()
        ]);
    }

    /**
     * Obtiene un anuncio por su ID.
     *
     * @param int $id ID del anuncio.
     * @return AdvertModel|null El anuncio encontrado o null si no existe.
     */
    public function getAdvertById($id)
    {
        $sql = "SELECT * FROM advert WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new AdvertModel(
                $row['id'],
                $row['property_id'],
                $row['user_id'],
                $row['price'],
                $row['action'],
                $row['description'],
                $row['created_at']
            );
        }
        return null;
    }

    /**
     * Obtiene todos los anuncios publicados por un usuario.
     *
     * @param int $userId ID del usuario.
     * @return AdvertModel[] Array de anuncios del usuario.
     */
    public function getAdvertsByUserId($userId)
    {
        $sql = "SELECT * FROM advert WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $adverts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $adverts[] = new AdvertModel(
                $row['id'],
                $row['property_id'],
                $row['user_id'],
                $row['price'],
                $row['action'],
                $row['description'],
                $row['created_at']
            );
        }
        return $adverts;
    }

    /**
     * Obtiene un anuncio a partir del ID de la propiedad asociada.
     *
     * @param int $propertyId ID de la propiedad.
     * @return AdvertModel|null El anuncio encontrado o null si no existe.
     */
    public function getAdvertByPropertyId($propertyId)
    {
        $sql = "SELECT * FROM advert WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new AdvertModel(
                $row['id'],
                $row['property_id'],
                $row['user_id'],
                $row['price'],
                $row['action'],
                $row['description'],
                $row['created_at']
            );
        }
        return null;
    }


    /**
     * Obtiene todos los anuncios asociados a una propiedad.
     *
     * @param int $propertyId ID de la propiedad.
     * @return AdvertModel[] Array de modelos de anuncios asociados a la propiedad.
     */
    public function getAdvertsByPropertyId($propertyId)
    {
        $sql = "SELECT * FROM advert WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $adverts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $adverts[] = new AdvertModel(
                $row['id'],
                $row['property_id'],
                $row['user_id'],
                $row['price'],
                $row['action'],
                $row['description'],
                $row['created_at']
            );
        }
        return $adverts;
    }

    /**
     * Obtiene todos los anuncios de la base de datos, ordenados por los más recientes.
     *
     * @return AdvertModel[] Array de modelos de anuncios.
     */
    public function getAllAdverts()
    {
        $sql = "SELECT * FROM advert ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        $adverts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $adverts[] = new AdvertModel(
                $row['id'],
                $row['property_id'],
                $row['user_id'],
                $row['price'],
                $row['action'],
                $row['description'],
                $row['created_at']
            );
        }
        return $adverts;
    }

    /**
     * Actualiza los campos de un anuncio existente.
     *
     * @param int $id ID del anuncio a actualizar.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function updateAdvert($id, $fields)
    {
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE advert SET $setClause WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $fields['id'] = $id;
            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar anuncio: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un anuncio por su ID.
     *
     * @param int $id ID del anuncio a eliminar.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteAdvert($id)
    {
        try {
            $sql = "DELETE FROM advert WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log('Error al eliminar anuncio: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca anuncios aplicando filtros generales y específicos.
     *
     * Esta función permite buscar anuncios en la base de datos aplicando filtros generales (precio, acción, ciudad, provincia, país, tamaño, estado, disponibilidad)
     * y filtros específicos según el tipo de propiedad (habitaciones, estudios, pisos, casas).
     * Los filtros se aplican sobre las tablas advert, property, address y las tablas específicas de cada tipo de propiedad.
     * Devuelve un array de objetos AdvertModel que cumplen con todos los filtros indicados.
     *
     * Ejemplo de uso de filtros:
     * [
     *   'property_types' => ['Piso', 'Casa'],
     *   'apartment' => ['num_bathrooms' => 2],
     *   'house' => ['num_bathrooms_min' => 2]
     * ]
     *
     * @param array $filters Filtros generales y específicos para la búsqueda de anuncios.
     *                      Puede incluir filtros de anuncio (precio, acción), dirección (ciudad, provincia, país),
     *                      propiedad (tipo, tamaño, estado, disponibilidad) y filtros específicos por tipo de vivienda.
     * @return AdvertModel[] Array de anuncios (AdvertModel) que cumplen los filtros.
     */
    public function searchAdverts($filters = [])
    {
        $sql = "SELECT DISTINCT adv.* FROM advert adv
                INNER JOIN property p ON adv.property_id = p.id
                INNER JOIN address addr ON p.address_id = addr.id";
        $joins = "";
        $wheres = ["1=1"];
        $params = [];

        // Joins para tipos de vivienda
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
        $sql .= $joins;

        // Filtros de anuncio (advert)
        if (!empty($filters['advert_price_min'])) {
            $wheres[] = "adv.price >= ?";
            $params[] = $filters['advert_price_min'];
        }
        if (!empty($filters['advert_price_max'])) {
            $wheres[] = "adv.price <= ?";
            $params[] = $filters['advert_price_max'];
        }
        if (!empty($filters['action'])) {
            $wheres[] = "adv.action = ?";
            $params[] = $filters['action'];
        }

        // Filtros de dirección (address)
        if (!empty($filters['city'])) {
            $wheres[] = "addr.city = ?";
            $params[] = $filters['city'];
        }
        if (!empty($filters['province'])) {
            $wheres[] = "addr.province = ?";
            $params[] = $filters['province'];
        }
        if (!empty($filters['country'])) {
            $wheres[] = "addr.country = ?";
            $params[] = $filters['country'];
        }

        // Filtros de propiedad (property)
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
        if (!empty($filters['status'])) {
            if (is_array($filters['status'])) {
                $placeholders = implode(',', array_fill(0, count($filters['status']), '?'));
                $wheres[] = "p.status IN ($placeholders)";
                foreach ($filters['status'] as $status) {
                    $params[] = $status;
                }
            } else {
                $wheres[] = "p.status = ?";
                $params[] = $filters['status'];
            }
        }
        if (isset($filters['immediate_availability'])) {
            $wheres[] = "p.immediate_availability = ?";
            $params[] = $filters['immediate_availability'];
        }

        // Filtros específicos por tipo de vivienda (ejemplo: baños)
        $tipoFiltros = [];

        // Filtros específicos para habitaciones
        if (!empty($filters['property_types']) && $filters['property_types'][0] === 'Habitación' && !empty($filters['room'])) {
            if (isset($filters['room']['private_bathroom'])) {
                $tipoFiltros[] = "r.private_bathroom = ?";
                $params[] = $filters['room']['private_bathroom'];
            }
            if (!empty($filters['room']['max_roommates'])) {
                $tipoFiltros[] = "r.max_roommates <= ?";
                $params[] = $filters['room']['max_roommates'];
            }
            if (isset($filters['room']['pets_allowed'])) {
                $tipoFiltros[] = "r.pets_allowed = ?";
                $params[] = $filters['room']['pets_allowed'];
            }
            if (isset($filters['room']['furnished'])) {
                $tipoFiltros[] = "r.furnished = ?";
                $params[] = $filters['room']['furnished'];
            }
            if (isset($filters['room']['students_only'])) {
                $tipoFiltros[] = "r.students_only = ?";
                $params[] = $filters['room']['students_only'];
            }
            if (!empty($filters['room']['gender_restriction']) && $filters['room']['gender_restriction'] !== 'sin restricciones') {
                $tipoFiltros[] = "r.gender_restriction = ?";
                $params[] = $filters['room']['gender_restriction'];
            }
        }

        // Filtros específicos para estudios
        if (!empty($filters['property_types']) && $filters['property_types'][0] === 'Estudio' && !empty($filters['studio'])) {
            if (isset($filters['studio']['furnished'])) {
                $tipoFiltros[] = "s.furnished = ?";
                $params[] = $filters['studio']['furnished'];
            }
            if (isset($filters['studio']['balcony'])) {
                $tipoFiltros[] = "s.balcony = ?";
                $params[] = $filters['studio']['balcony'];
            }
            if (isset($filters['studio']['air_conditioning'])) {
                $tipoFiltros[] = "s.air_conditioning = ?";
                $params[] = $filters['studio']['air_conditioning'];
            }
            if (isset($filters['studio']['pets_allowed'])) {
                $tipoFiltros[] = "s.pets_allowed = ?";
                $params[] = $filters['studio']['pets_allowed'];
            }
        }

        // Filtros específicos para pisos
        if (!empty($filters['property_types']) && $filters['property_types'][0] === 'Piso' && !empty($filters['apartment'])) {
            if (!empty($filters['apartment']['apartment_type'])) {
                $tipoFiltros[] = "a.apartment_type = ?";
                $params[] = $filters['apartment']['apartment_type'];
            }
            if (!empty($filters['apartment']['num_rooms'])) {
                $tipoFiltros[] = "a.num_rooms = ?";
                $params[] = $filters['apartment']['num_rooms'];
            }
            if (!empty($filters['apartment']['num_bathrooms'])) {
                $tipoFiltros[] = "a.num_bathrooms = ?";
                $params[] = $filters['apartment']['num_bathrooms'];
            }
            if (isset($filters['apartment']['furnished'])) {
                $tipoFiltros[] = "a.furnished = ?";
                $params[] = $filters['apartment']['furnished'];
            }
            if (isset($filters['apartment']['balcony'])) {
                $tipoFiltros[] = "a.balcony = ?";
                $params[] = $filters['apartment']['balcony'];
            }
            if (!empty($filters['apartment']['floor'])) {
                $tipoFiltros[] = "a.floor = ?";
                $params[] = $filters['apartment']['floor'];
            }
            if (isset($filters['apartment']['elevator'])) {
                $tipoFiltros[] = "a.elevator = ?";
                $params[] = $filters['apartment']['elevator'];
            }
            if (isset($filters['apartment']['air_conditioning'])) {
                $tipoFiltros[] = "a.air_conditioning = ?";
                $params[] = $filters['apartment']['air_conditioning'];
            }
            if (isset($filters['apartment']['garage'])) {
                $tipoFiltros[] = "a.garage = ?";
                $params[] = $filters['apartment']['garage'];
            }
            if (isset($filters['apartment']['pets_allowed'])) {
                $tipoFiltros[] = "a.pets_allowed = ?";
                $params[] = $filters['apartment']['pets_allowed'];
            }
        }

        // Filtros específicos para casas
        if (!empty($filters['property_types']) && $filters['property_types'][0] === 'Casa' && !empty($filters['house'])) {
            if (!empty($filters['house']['house_type'])) {
                $tipoFiltros[] = "h.house_type = ?";
                $params[] = $filters['house']['house_type'];
            }
            if (!empty($filters['house']['garden_size_min'])) {
                $tipoFiltros[] = "h.garden_size >= ?";
                $params[] = $filters['house']['garden_size_min'];
            }
            if (!empty($filters['house']['garden_size_max'])) {
                $tipoFiltros[] = "h.garden_size <= ?";
                $params[] = $filters['house']['garden_size_max'];
            }
            if (!empty($filters['house']['num_floors_min'])) {
                $tipoFiltros[] = "h.num_floors >= ?";
                $params[] = $filters['house']['num_floors_min'];
            }
            if (!empty($filters['house']['num_floors_max'])) {
                $tipoFiltros[] = "h.num_floors <= ?";
                $params[] = $filters['house']['num_floors_max'];
            }
            if (!empty($filters['house']['num_rooms_min'])) {
                $tipoFiltros[] = "h.num_rooms >= ?";
                $params[] = $filters['house']['num_rooms_min'];
            }
            if (!empty($filters['house']['num_rooms_max'])) {
                $tipoFiltros[] = "h.num_rooms <= ?";
                $params[] = $filters['house']['num_rooms_max'];
            }
            if (!empty($filters['house']['num_bathrooms_min'])) {
                $tipoFiltros[] = "h.num_bathrooms >= ?";
                $params[] = $filters['house']['num_bathrooms_min'];
            }
            if (!empty($filters['house']['num_bathrooms_max'])) {
                $tipoFiltros[] = "h.num_bathrooms <= ?";
                $params[] = $filters['house']['num_bathrooms_max'];
            }
            if (isset($filters['house']['private_garage'])) {
                $tipoFiltros[] = "h.private_garage = ?";
                $params[] = $filters['house']['private_garage'];
            }
            if (isset($filters['house']['private_pool'])) {
                $tipoFiltros[] = "h.private_pool = ?";
                $params[] = $filters['house']['private_pool'];
            }
            if (isset($filters['house']['furnished'])) {
                $tipoFiltros[] = "h.furnished = ?";
                $params[] = $filters['house']['furnished'];
            }
            if (isset($filters['house']['terrace'])) {
                $tipoFiltros[] = "h.terrace = ?";
                $params[] = $filters['house']['terrace'];
            }
            if (isset($filters['house']['storage_room'])) {
                $tipoFiltros[] = "h.storage_room = ?";
                $params[] = $filters['house']['storage_room'];
            }
            if (isset($filters['house']['air_conditioning'])) {
                $tipoFiltros[] = "h.air_conditioning = ?";
                $params[] = $filters['house']['air_conditioning'];
            }
            if (isset($filters['house']['pets_allowed'])) {
                $tipoFiltros[] = "h.pets_allowed = ?";
                $params[] = $filters['house']['pets_allowed'];
            }
        }

        // Añade los filtros específicos al WHERE
        if (!empty($tipoFiltros)) {
            $wheres[] = implode(' AND ', $tipoFiltros);
        }

        $sql .= " WHERE " . implode(' AND ', $wheres);

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(function ($row) {
            return new AdvertModel(
                $row['id'],
                $row['property_id'],
                $row['user_id'],
                $row['price'],
                $row['action'],
                $row['description'],
                $row['created_at']
            );
        }, $result);
    }
}
