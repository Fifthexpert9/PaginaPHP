<?php

namespace services;

use models\MessageModel;
use models\DatabaseModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con mensajes entre usuarios en la base de datos.
 */
class MessageService {
    /**
     * @var PDO Conexión a la base de datos.
     */
    private $db;

    /**
     * Constructor de MessageService.
     *
     * @param DatabaseModel $databaseModel Modelo de base de datos con la conexión activa.
     */
    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

    /**
     * Crea un nuevo mensaje en la base de datos.
     *
     * @param MessageModel $message Modelo con los datos del mensaje.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function createMessage(MessageModel $message) {
        $sql = "INSERT INTO message (sender_id, receiver_id, advert_id, subject, content, sent_at)
                VALUES (:sender_id, :receiver_id, :advert_id, :subject, :content, :sent_at)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':sender_id' => $message->getSenderId(),
            ':receiver_id' => $message->getReceiverId(),
            ':advert_id' => $message->getAdvertId(),
            ':subject' => $message->getSubject(),
            ':content' => $message->getContent(),
            ':sent_at' => $message->getSentAt()
        ]);
    }

    /**
     * Obtiene un mensaje por su ID.
     *
     * @param int $id ID del mensaje.
     * @return MessageModel|null Modelo del mensaje o null si no existe.
     */
    public function getMessageById($id) {
        $sql = "SELECT * FROM message WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new MessageModel(
                $row['id'],
                $row['sender_id'],
                $row['receiver_id'],
                $row['advert_id'],
                $row['subject'],
                $row['content'],
                $row['sent_at']
            );
        }
        return null;
    }

    /**
     * Obtiene todos los mensajes enviados o recibidos por un usuario.
     *
     * @param int $userId ID del usuario.
     * @return MessageModel[] Array de mensajes del usuario.
     */
    public function getMessagesByUserId($userId) {
        $sql = "SELECT * FROM message WHERE sender_id = :user_id OR receiver_id = :user_id ORDER BY sent_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $messages = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $messages[] = new MessageModel(
                $row['id'],
                $row['sender_id'],
                $row['receiver_id'],
                $row['advert_id'],
                $row['subject'],
                $row['content'],
                $row['sent_at']
            );
        }
        return $messages;
    }

    /**
     * Actualiza los campos de un mensaje existente.
     *
     * @param int $id ID del mensaje a actualizar.
     * @param array $fields Campos a actualizar (clave => valor).
     * @return bool True si la actualización fue exitosa, false en caso contrario.
     */
    /*
     public function updateMessage($id, $fields) {
        try {
            $setClause = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "`$key` = :$key";
            }
            $setClause = implode(", ", $setClause);

            $sql = "UPDATE message SET $setClause WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $fields['id'] = $id;
            return $stmt->execute($fields);
        } catch (PDOException $e) {
            error_log('Error al actualizar mensaje: ' . $e->getMessage());
            return false;
        }
    }
    */

    /**
     * Elimina un mensaje por su ID.
     *
     * @param int $id ID del mensaje a eliminar.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteMessage($id) {
        try {
            $sql = "DELETE FROM message WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log('Error al eliminar mensaje: ' . $e->getMessage());
            return false;
        }
    }
}