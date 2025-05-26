<?php

namespace services;

use models\AddressModel;
use models\DatabaseModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con direcciones en la base de datos.
 */
class AddressService
{
    /**
     * @var AddressService Instancia única de la clase.
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
     * @return AddressService Instancia única de AddressService.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new AddressService();
        }
        return self::$instance;
    }

    /**
     * Crea una nueva dirección en la base de datos.
     *
     * @param AddressModel $address Modelo con los datos de la dirección.
     * @return int ID de la dirección creada.
     */
    public function createAddress(AddressModel $address)
    {
        $sql = "INSERT INTO address (street, city, province, postal_code, country, latitude, longitude)
                VALUES (:street, :city, :province, :postal_code, :country, :latitude, :longitude)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':street' => $address->getStreet(),
            ':city' => $address->getCity(),
            ':province' => $address->getProvince(),
            ':postal_code' => $address->getPostalCode(),
            ':country' => $address->getCountry(),
            ':latitude' => $address->getLatitude(),
            ':longitude' => $address->getLongitude()
        ]);
        return $this->db->lastInsertId();
    }

    /**
     * Obtiene una dirección por su ID.
     *
     * @param int $id ID de la dirección.
     * @return AddressModel|null Modelo de la dirección o null si no existe.
     */
    public function getAddressById($id)
    {
        $sql = "SELECT * FROM address WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new AddressModel(
                $row['id'],
                $row['street'],
                $row['city'],
                $row['province'],
                $row['postal_code'],
                $row['country'],
                $row['latitude'],
                $row['longitude']
            );
        }
        return null;
    }

    /**
     * Obtiene la dirección asociada a una propiedad.
     *
     * @param \models\PropertyModel $propertyModel Modelo de la propiedad.
     * @return AddressModel|null Modelo de la dirección o null si no existe.
     */
    public function getAddressByPropertyId($propertyModel)
    {
        if (!$propertyModel || !method_exists($propertyModel, 'getAddressId')) {
            return null;
        }
        $addressId = $propertyModel->getAddressId();
        return $this->getAddressById($addressId);
    }

    /**
     * Actualiza los campos de una dirección existente.
     *
     * @param int $id ID de la dirección a actualizar.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function updateAddress($id, $fields)
    {
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE address SET $setClause WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $fields['id'] = $id;
            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar dirección: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina una dirección por su ID.
     *
     * @param int $id ID de la dirección a eliminar.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteAddress($id)
    {
        try {
            $sql = "DELETE FROM address WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log('Error al eliminar dirección: ' . $e->getMessage());
            return false;
        }
    }
}