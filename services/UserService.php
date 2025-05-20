<?php

namespace services;

use models\DatabaseModel;
use models\UserModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con usuarios en la base de datos.
 */
class UserService {
    /**
     * @var PDO Conexión a la base de datos.
     */
    private $db;

    /**
     * Constructor de UserService.
     *
     * @param DatabaseModel $databaseModel Modelo de base de datos con la conexión activa.
     */
    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    /**
     * Genera un nombre de usuario único a partir del nombre y apellido.
     *
     * @param string $name Nombre del usuario.
     * @param string $last_name Apellido del usuario.
     * @return string Nombre de usuario generado.
     */
    public function createUsername($name, $last_name) {
        $namePart = substr(strtolower($name), 0, 3);
        $lastNamePart = substr(strtolower($last_name), 0, 3);

        $randomNumber = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

        $username = $namePart . $lastNamePart . $randomNumber;

        $sql = "SELECT COUNT(*) FROM `user` WHERE `username` = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $username]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return $this->createUsername($name, $last_name);
        }

        return $username;
    }

    /**
     * Agrega un nuevo usuario a la base de datos.
     *
     * @param UserModel $user Modelo con los datos del usuario.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function addUser(UserModel $user) {
        try {
            $username = $this->createUsername($user->getName(), $user->getLastName());
            $user->setUsername($username);

            $sql = "INSERT INTO `user` (`name`, `last_name`, `username`, `email`, `password`, `registration_date`) 
                    VALUES (:name, :last_name, :username, :email, :password, :registration_date)";
            $stmt = $this->db->prepare($sql);

            $params = [
                ':name' => $user->getName(),
                ':last_name' => $user->getLastName(),
                ':username' => $user->getUsername(),
                ':email' => $user->getEmail(),
                ':password' => $user->getPassword(),
                ':registration_date' => $user->getRegistrationDate()
            ];

            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log('Error al agregar usuario: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene un usuario por su ID.
     *
     * @param int $id ID del usuario.
     * @return UserModel|null Modelo del usuario o null si no existe.
     */
    public function getUserById($id) {
        try {
            $sql = "SELECT * FROM `user` WHERE `id` = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new UserModel(
                    $row['id'],
                    $row['name'],
                    $row['last_name'],
                    $row['username'],
                    $row['email'],
                    $row['password'],
                    $row['registration_date']
                );
            }

            return null;
        } catch (PDOException $e) {
            error_log('Error al obtener usuario: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtiene un usuario por su email.
     *
     * @param string $email Email del usuario.
     * @return UserModel|null Modelo del usuario o null si no existe.
     */
    public function getUserByEmail($email) {
        try {
            $sql = "SELECT * FROM `user` WHERE `email` = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new UserModel(
                    $row['id'],
                    $row['name'],
                    $row['last_name'],
                    $row['username'],
                    $row['email'],
                    $row['password'],
                    $row['registration_date']
                );
            }

            return null;
        } catch (PDOException $e) {
            error_log('Error al obtener usuario por email: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtiene un usuario por su nombre de usuario.
     *
     * @param string $username Nombre de usuario.
     * @return UserModel|null Modelo del usuario o null si no existe.
     */
    public function getUserByUsername($username) {
        try {
            $sql = "SELECT * FROM `user` WHERE `username` = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':username' => $username]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new UserModel(
                    $row['id'],
                    $row['name'],
                    $row['last_name'],
                    $row['username'],
                    $row['email'],
                    $row['password'],
                    $row['registration_date']
                );
            }

            return null;
        } catch (PDOException $e) {
            error_log('Error al obtener usuario por username: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtiene todos los usuarios de la base de datos.
     *
     * @return UserModel[] Array de modelos de usuario.
     */
    public function getAllUsers() {
        try {
            $sql = "SELECT * FROM `user`";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $users = [];
            foreach ($rows as $row) {
                $users[] = new UserModel(
                    $row['id'],
                    $row['name'],
                    $row['last_name'],
                    $row['username'],
                    $row['email'],
                    $row['password'],
                    $row['registration_date']
                );
            }

            return $users;
        } catch (PDOException $e) {
            error_log('Error al obtener todos los usuarios: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Actualiza los campos de un usuario existente.
     *
     * @param int $id ID del usuario a actualizar.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    public function updateUser($id, $fields) {
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE `user` SET $setClause WHERE `id` = :id";
            $stmt = $this->db->prepare($sql);
            $fields[':id'] = $id;

            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar usuario: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Elimina un usuario por su ID.
     *
     * @param int $id ID del usuario a eliminar.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteUser($id) {
        try {
            $sql = "DELETE FROM `user` WHERE `id` = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log('Error al eliminar usuario: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Verifica si un email ya existe en la base de datos.
     *
     * @param string $email Email a verificar.
     * @return bool True si el email existe, false en caso contrario.
     */
    public function emailExists($email) {
        $sql = "SELECT COUNT(*) FROM `user` WHERE `email` = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Autentica un usuario por email y contraseña.
     *
     * @param string $email Email del usuario.
     * @param string $password Contraseña en texto plano.
     * @return UserModel|null Modelo del usuario si la autenticación es correcta, null en caso contrario.
     */
    public function authenticate($email, $password) {
        $sql = "SELECT * FROM `user` WHERE `email` = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && password_verify($password, $row['password'])) {
            return new UserModel(
                $row['id'],
                $row['name'],
                $row['last_name'],
                $row['username'],
                $row['email'],
                $row['password'],
                $row['registration_date']
            );
        }
        return null;
    }
}