<?php

namespace services;

use models\AddressModel;
use models\DatabaseModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con direcciones en la base de datos.
 *
 * Esta clase proporciona métodos para crear, obtener, actualizar y eliminar direcciones,
 * así como para geocodificar direcciones utilizando el servicio Nominatim de OpenStreetMap.
 * Implementa el patrón Singleton para asegurar una única instancia y reutilizar la conexión a la base de datos.
 *
 * Métodos principales:
 * - getInstance(): Obtiene la instancia única del servicio.
 * - createAddress(AddressModel $address): Crea una nueva dirección en la base de datos.
 * - getAddressById($id): Obtiene una dirección por su ID.
 * - getAddressByPropertyId($property_id): Obtiene la dirección asociada a una propiedad.
 * - updateAddress($id, $fields): Actualiza los campos de una dirección existente.
 * - deleteAddress($id): Elimina una dirección por su ID.
 * - deleteAddressByPropertyId($property_id): Elimina la dirección asociada a una propiedad.
 * - geocodeAddress(...): Geocodifica una dirección y obtiene latitud/longitud.
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
     * Geocodifica la dirección antes de guardarla para obtener latitud y longitud.
     *
     * @param AddressModel $address Modelo con los datos de la dirección.
     * @return int ID de la dirección creada.
     */
    public function createAddress(AddressModel $address)
    {
        // Geocodificar antes de guardar
        $coords = $this->geocodeAddress(
            $address->getStreet(),
            $address->getCity(),
            $address->getProvince(),
            $address->getPostalCode(),
            $address->getCountry()
        );
        $latitude = $coords['latitude'];
        $longitude = $coords['longitude'];

        $sql = "INSERT INTO address (street, city, province, postal_code, country, latitude, longitude)
                VALUES (:street, :city, :province, :postal_code, :country, :latitude, :longitude)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':street' => $address->getStreet(),
            ':city' => $address->getCity(),
            ':province' => $address->getProvince(),
            ':postal_code' => $address->getPostalCode(),
            ':country' => $address->getCountry(),
            ':latitude' => $latitude,
            ':longitude' => $longitude
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
     * Obtiene la dirección asociada a una propiedad a partir del id de la propiedad.
     *
     * @param int $property_id ID de la propiedad.
     * @return AddressModel|null Modelo de la dirección o null si no existe.
     */
    public function getAddressByPropertyId($property_id)
    {
        $sql = "SELECT address_id FROM property WHERE id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $property_id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row && isset($row['address_id'])) {
            return $this->getAddressById($row['address_id']);
        }
        return null;
    }

    /**
     * Actualiza los campos de una dirección existente.
     *
     * Si se actualiza algún campo de dirección relevante, recalcula latitud y longitud.
     *
     * @param int $id ID de la dirección a actualizar.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function updateAddress($id, $fields)
    {
        try {
            // Si se actualiza algún campo de dirección, recalcula lat/lon
            $direccionKeys = ['street', 'city', 'province', 'postal_code', 'country'];
            $needsGeocode = false;
            foreach ($direccionKeys as $key) {
                if (array_key_exists($key, $fields)) {
                    $needsGeocode = true;
                    break;
                }
            }

            if ($needsGeocode) {
                // Obtener los valores actuales de la dirección si no se pasan todos los campos
                $current = $this->getAddressById($id);
                $street = $fields['street'] ?? $current->getStreet();
                $city = $fields['city'] ?? $current->getCity();
                $province = $fields['province'] ?? $current->getProvince();
                $postal_code = $fields['postal_code'] ?? $current->getPostalCode();
                $country = $fields['country'] ?? $current->getCountry();

                $coords = $this->geocodeAddress($street, $city, $province, $postal_code, $country);
                $fields['latitude'] = $coords['latitude'];
                $fields['longitude'] = $coords['longitude'];
            }

            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE address SET $setClause WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $fields[':id'] = $id;
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

    /**
     * Elimina la dirección asociada a una propiedad a partir del id de la propiedad.
     *
     * @param int $property_id ID de la propiedad.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteAddressByPropertyId($property_id)
    {
        try {
            $sql = "SELECT address_id FROM property WHERE id = :property_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':property_id' => $property_id]);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($row && isset($row['address_id'])) {
                return $this->deleteAddress($row['address_id']);
            }
            return false;
        } catch (PDOException $e) {
            error_log('Error al eliminar dirección por property_id: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Geocodifica una dirección utilizando el servicio Nominatim de OpenStreetMap.
     *
     * Devuelve un array con la latitud y longitud de la dirección, o null si no se pudo geocodificar.
     *
     * @param string $street Calle de la dirección.
     * @param string $city Ciudad de la dirección.
     * @param string $province Provincia de la dirección.
     * @param string $postal_code Código postal de la dirección.
     * @param string $country País de la dirección.
     * @return array Array con la latitud y longitud de la dirección, o null si no se pudo geocodificar.
     */
    private function geocodeAddress($street, $city, $province, $postal_code, $country)
    {
        $address = urlencode("$street, $city, $province, $postal_code, $country");
        $url = "https://nominatim.openstreetmap.org/search?q=$address&format=json&limit=1";
        $opts = [
            "http" => [
                "header" => "User-Agent: PaginaPHP/1.0\r\n"
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);
        $data = json_decode($response, true);

        if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
            return [
                'latitude' => $data[0]['lat'],
                'longitude' => $data[0]['lon']
            ];
        }
        return ['latitude' => null, 'longitude' => null];
    }
}