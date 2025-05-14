<?php

namespace services;

use models\DatabaseModel;
use PDOException;

class DatabaseService {
    private $db;

    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    function createUsername($name, $last_name) {
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

    function addUser($name, $last_name, $email, $password) {
        try {
            $params = [
                ':name' => $name,
                ':last_name' => $last_name,
                ':username' => $this->createUsername($name, $last_name),
                ':email' => $email,
                ':password' => password_hash($password, PASSWORD_BCRYPT)
            ];

            $stmt = $this->db->prepare(
                "INSERT INTO `user` "
                . "(`name`, `last_name`, `username`, `email`, `password`)"
                . " VALUES (:name, :last_name, :username, :email, :password)"
            );

            return $stmt->execute($params);
        } catch (PDOException $e) {
            //error_log('Error al agregar usuario: ' . $e->getMessage());
            return false;
        }
    }
}