<?php

namespace services;

use models\RoomModel;
use models\DatabaseModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con habitaciones en la base de datos.
 */
class RoomService
{
    /**
     * @var RoomService Instancia única de la clase.
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
     * @return RoomService Instancia única de RoomService.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new RoomService();
        }
        return self::$instance;
    }

    /**
     * Crea una nueva habitación en la base de datos.
     *
     * @param RoomModel $room Modelo con los datos de la habitación.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function createRoom(RoomModel $room)
    {
        $sql = "INSERT INTO property_room (property_id, private_bathroom, room_size, max_roommates, includes_expenses, pets_allowed, furnished, common_areas, students_only, gender_restriction)
                VALUES (:property_id, :private_bathroom, :room_size, :max_roommates, :includes_expenses, :pets_allowed, :furnished, :common_areas, :students_only, :gender_restriction)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':property_id' => $room->getPropertyId(),
            ':private_bathroom' => $room->getPrivateBathroom(),
            //':room_size' => $room->getRoomSize(),
            ':max_roommates' => $room->getMaxRoommates(),
            //':includes_expenses' => $room->getIncludesExpenses(),
            ':pets_allowed' => $room->getPetsAllowed(),
            ':furnished' => $room->getFurnished(),
            //':common_areas' => $room->getCommonAreas(),
            ':students_only' => $room->getStudentsOnly(),
            ':gender_restriction' => $room->getGenderRestriction()
        ]);
    }

    /**
     * Obtiene una habitación por el ID de la propiedad asociada.
     *
     * @param int $propertyId ID de la propiedad.
     * @return RoomModel|null Modelo de la habitación o null si no existe.
     */
    public function getRoomByPropertyId($propertyId)
    {
        $sql = "SELECT * FROM property_room WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new RoomModel(
                $row['property_id'],
                $row['private_bathroom'],
                //$row['room_size'],
                $row['max_roommates'],
                //$row['includes_expenses'],
                $row['pets_allowed'],
                $row['furnished'],
                //$row['common_areas'],
                $row['students_only'],
                $row['gender_restriction']
            );
        }
        return null;
    }

    /**
     * Actualiza los campos de una habitación existente.
     *
     * @param int $propertyId ID de la propiedad asociada a la habitación.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function updateRoom($propertyId, $fields)
    {
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE property_room SET $setClause WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            $fields['property_id'] = $propertyId;
            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar detalles de habitación: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina una habitación por el ID de la propiedad asociada.
     *
     * @param int $propertyId ID de la propiedad asociada a la habitación.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteRoom($propertyId)
    {
        try {
            $sql = "DELETE FROM property_room WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':property_id' => $propertyId]);
        } catch (PDOException $e) {
            error_log('Error al eliminar detalles de habitación: ' . $e->getMessage());
            return false;
        }
    }
}
