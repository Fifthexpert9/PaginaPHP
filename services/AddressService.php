<?php

namespace services;

use models\AddressModel;
use models\DatabaseModel;
use PDO;
use PDOException;

class AddressService {
    private $db;

    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    public function createAddress(AddressModel $address) {
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

    public function getAddressById($id) {
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

    /*  Maybe could be difficult to implement

    public function updateAddress($id, $fields) {
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
    */

    public function deleteAddress($id) {
        try {
            $sql = "DELETE FROM address WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log('Error al eliminar dirección: ' . $e->getMessage());
            return false;
        }
    }

    /*  Not sure if needed

    public function getAllAddresses() {
        $sql = "SELECT * FROM address";
        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $addresses = [];
        foreach ($rows as $row) {
            $addresses[] = new AddressModel(
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
        return $addresses;
    }
    */
}