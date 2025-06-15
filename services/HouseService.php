<?php

namespace services;

use models\HouseModel;
use models\DatabaseModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con casas en la base de datos.
 *
 * Esta clase proporciona métodos para crear, obtener, actualizar y eliminar casas asociadas a propiedades.
 * Implementa el patrón Singleton para asegurar una única instancia y reutilizar la conexión a la base de datos.
 *
 * Métodos principales:
 * - getInstance(): Obtiene la instancia única del servicio.
 * - createHouse(HouseModel $house): Crea una nueva casa.
 * - getHouseByPropertyId($propertyId): Obtiene una casa por el ID de la propiedad asociada.
 * - updateHouse($propertyId, $fields): Actualiza los campos de una casa existente.
 * - deleteHouse($propertyId): Elimina una casa por el ID de la propiedad asociada.
 */
class HouseService
{
    /**
     * @var HouseService Instancia única de la clase.
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
     * @return HouseService Instancia única de HouseService.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new HouseService();
        }
        return self::$instance;
    }

    /**
     * Crea una nueva casa en la base de datos.
     *
     * @param HouseModel $house Modelo con los datos de la casa.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function createHouse(HouseModel $house)
    {
        $sql = "INSERT INTO property_house (property_id, house_type, garden_size, num_floors, num_rooms, num_bathrooms, private_garage, private_pool, furnished, terrace, storage_room, air_conditioning, pets_allowed)
                VALUES (:property_id, :house_type, :garden_size, :num_floors, :num_rooms, :num_bathrooms, :private_garage, :private_pool, :furnished, :terrace, :storage_room, :air_conditioning, :pets_allowed)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':property_id' => $house->getPropertyId(),
            ':house_type' => $house->getHouseType(),
            ':garden_size' => $house->getGardenSize(),
            ':num_floors' => $house->getNumFloors(),
            ':num_rooms' => $house->getNumRooms(),
            ':num_bathrooms' => $house->getNumBathrooms(),
            ':private_garage' => $house->getPrivateGarage(),
            ':private_pool' => $house->getPrivatePool(),
            ':furnished' => $house->getFurnished(),
            ':terrace' => $house->getTerrace(),
            ':storage_room' => $house->getStorageRoom(),
            ':air_conditioning' => $house->getAirConditioning(),
            ':pets_allowed' => $house->getPetsAllowed()
        ]);
    }

    /**
     * Obtiene una casa por el ID de la propiedad asociada.
     *
     * @param int $propertyId ID de la propiedad.
     * @return HouseModel|null Modelo de la casa o null si no existe.
     */
    public function getHouseByPropertyId($propertyId)
    {
        $sql = "SELECT * FROM property_house WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new HouseModel(
                $row['property_id'],
                $row['house_type'],
                $row['garden_size'],
                $row['num_floors'],
                $row['num_rooms'],
                $row['num_bathrooms'],
                $row['private_garage'],
                $row['private_pool'],
                $row['furnished'],
                $row['terrace'],
                $row['storage_room'],
                $row['air_conditioning'],
                $row['pets_allowed']
            );
        }
        return null;
    }

    /**
     * Actualiza los campos de una casa existente.
     *
     * @param int $propertyId ID de la propiedad asociada a la casa.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function updateHouse($propertyId, $fields)
    {
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE `property_house` SET $setClause WHERE `property_id` = :property_id";
            $stmt = $this->db->prepare($sql);
            $fields[':property_id'] = $propertyId;
            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar detalles de casa: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina una casa por el ID de la propiedad asociada.
     *
     * @param int $propertyId ID de la propiedad asociada a la casa.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteHouse($propertyId)
    {
        try {
            $sql = "DELETE FROM property_house WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':property_id' => $propertyId]);
        } catch (PDOException $e) {
            error_log('Error al eliminar detalles de casa: ' . $e->getMessage());
            return false;
        }
    }
}
