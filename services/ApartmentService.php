<?php
namespace services;

require_once __DIR__ . '/../models/ApartmentModel.php';

use models\ApartmentModel;
use models\DatabaseModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con apartamentos en la base de datos.
 */
class ApartmentService {
    /**
     * @var PDO Conexión a la base de datos.
     */
    private $db;

    /**
     * Constructor de ApartmentService.
     *
     * @param DatabaseModel $databaseModel Modelo de base de datos con la conexión activa.
     */
    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    /**
     * Crea un nuevo apartamento en la base de datos.
     *
     * @param ApartmentModel $apartment Modelo con los datos del apartamento.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function createApartment(ApartmentModel $apartment) {
        $sql = "INSERT INTO property_apartment (property_id, apartment_type, num_rooms, num_bathrooms, furnished, balcony, floor, elevator, air_conditioning, garage, pool, pets_allowed)
                VALUES (:property_id, :apartment_type, :num_rooms, :num_bathrooms, :furnished, :balcony, :floor, :elevator, :air_conditioning, :garage, :pool, :pets_allowed)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':property_id' => $apartment->getPropertyId(),
            ':apartment_type' => $apartment->getApartmentType(),
            ':num_rooms' => $apartment->getNumRooms(),
            ':num_bathrooms' => $apartment->getNumBathrooms(),
            ':furnished' => $apartment->isFurnished(),
            ':balcony' => $apartment->hasBalcony(),
            ':floor' => $apartment->getFloor(),
            ':elevator' => $apartment->hasElevator(),
            ':air_conditioning' => $apartment->hasAirConditioning(),
            ':garage' => $apartment->hasGarage(),
            ':pool' => $apartment->hasPool(),
            ':pets_allowed' => $apartment->arePetsAllowed()
        ]);
    }

    /**
     * Obtiene un apartamento por el ID de la propiedad asociada.
     *
     * @param int $propertyId ID de la propiedad.
     * @return ApartmentModel|null Modelo del apartamento o null si no existe.
     */
    public function getApartmentByPropertyId($propertyId) {
        $sql = "SELECT * FROM property_apartment WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new ApartmentModel(
                $row['property_id'],
                $row['apartment_type'],
                $row['num_rooms'],
                $row['num_bathrooms'],
                $row['furnished'],
                $row['balcony'],
                $row['floor'],
                $row['elevator'],
                $row['air_conditioning'],
                $row['garage'],
                $row['pool'],
                $row['pets_allowed']
            );
        }
        return null;
    }

    /**
     * Actualiza los campos de un apartamento existente.
     *
     * @param int $propertyId ID de la propiedad asociada al apartamento.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function updateApartment($propertyId, $fields) {
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE property_apartment SET $setClause WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            $fields['property_id'] = $propertyId;
            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar detalles de apartamento: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un apartamento por el ID de la propiedad asociada.
     *
     * @param int $propertyId ID de la propiedad asociada al apartamento.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteApartment($propertyId) {
        try {
            $sql = "DELETE FROM property_apartment WHERE property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':property_id' => $propertyId]);
        } catch (PDOException $e) {
            error_log('Error al eliminar detalles de apartamento: ' . $e->getMessage());
            return false;
        }
    }


    public function getFilteredApartmentsSql($tipo, $precioMax, $habitaciones) {
        $query = "SELECT * FROM property WHERE 1=1";
        $params = [];

        if (!empty($tipo)) {
            $query .= " AND property_type = :tipo";
            $params[':tipo'] = $tipo;
        }
        if (!empty($precioMax)) {
            $query .= " AND price <= :precioMax";
            $params[':precioMax'] = $precioMax;
        }
        if (!empty($habitaciones)) {
            $query .= " AND status >= :habitaciones";
            $params[':habitaciones'] = $habitaciones;
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $apartments = [];

        foreach ($rows as $row) {
            $apartments[] = new ApartmentModel(
                $row['property_id'],
                $row['apartment_type'],
                $row['num_rooms'],
                $row['num_bathrooms'],
                $row['furnished'],
                $row['balcony'],
                $row['floor'],
                $row['elevator'],
                $row['air_conditioning'],
                $row['garage'],
                $row['pool'],
                $row['pets_allowed']
            );
        }

        return $apartments;
    }


    
    public function getFilteredApartments($tipo, $precioMax, $habitaciones) {
        return $this->getFilteredApartmentsSql($tipo, $precioMax, $habitaciones);
    }

}