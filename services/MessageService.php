<?php

namespace services;

use models\MessageModel;
use models\DatabaseModel;
use PDO;
use PDOException;

/**
 * Servicio para gestionar operaciones relacionadas con mensajes entre usuarios en la base de datos.
 *
 * Esta clase proporciona métodos para crear, obtener, listar y eliminar mensajes enviados entre usuarios.
 * Implementa el patrón Singleton para asegurar una única instancia y reutilizar la conexión a la base de datos.
 *
 * Métodos principales:
 * - getInstance(): Obtiene la instancia única del servicio.
 * - createMessage(MessageModel $message): Crea un nuevo mensaje.
 * - getMessageById($id): Obtiene un mensaje por su ID.
 * - getMessagesSentByUser($userId): Obtiene todos los mensajes enviados por un usuario.
 * - getMessagesReceivedByUser($userId): Obtiene todos los mensajes recibidos por un usuario.
 * - deleteMessageById($id): Elimina un mensaje por su ID.
 */
class MessageService
{
    /**
     * @var MessageService Instancia única de la clase.
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
     * @return MessageService Instancia única de MessageService.
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new MessageService();
        }
        return self::$instance;
    }

    /**
     * Crea un nuevo mensaje en la base de datos.
     *
     * @param MessageModel $message Modelo con los datos del mensaje.
     * @return bool True si la inserción fue exitosa, false en caso contrario.
     */
    public function createMessage(MessageModel $message)
    {
        $sql = "INSERT INTO `message`(`sender_id`, `receiver_id`, `advert_id`, `subject`, `content`)
                VALUES (:sender_id, :receiver_id, :advert_id, :subject, :content)";
                
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':sender_id' => $message->getSenderId(),
            ':receiver_id' => $message->getReceiverId(),
            ':advert_id' => $message->getAdvertId(),
            ':subject' => $message->getSubject(),
            ':content' => $message->getContent()
        ]);
    }

    /**
     * Obtiene un mensaje por su ID.
     *
     * @param int $id ID del mensaje.
     * @return MessageModel|null Modelo del mensaje o null si no existe.
     */
    public function getMessageById($id)
    {
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
     * Obtiene todos los mensajes enviados por un usuario.
     *
     * @param int $userId ID del usuario que envía el mensaje.
     * @return MessageModel[] Array de mensajes enviados por el usuario.
     */
    public function getMessagesSentByUser($userId)
    {
        $sql = "SELECT * FROM message WHERE sender_id = :user_id ORDER BY sent_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $messages = array_map(function ($row) {
            return new MessageModel(
                $row['id'],
                $row['sender_id'],
                $row['receiver_id'],
                $row['advert_id'],
                $row['subject'],
                $row['content'],
                $row['sent_at']
            );
        }, $stmt->fetchAll(PDO::FETCH_ASSOC));
        return $messages;
    }

    /**
     * Obtiene todos los mensajes recibidos por un usuario.
     *
     * @param int $userId ID del usuario que recibe el mensaje.
     * @return MessageModel[] Array de mensajes recibidos por el usuario.
     */
    public function getMessagesReceivedByUser($userId)
    {
        $sql = "SELECT * FROM message WHERE receiver_id = :user_id ORDER BY sent_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $messages = array_map(function ($row) {
            return new MessageModel(
                $row['id'],
                $row['sender_id'],
                $row['receiver_id'],
                $row['advert_id'],
                $row['subject'],
                $row['content'],
                $row['sent_at']
            );
        }, $stmt->fetchAll(PDO::FETCH_ASSOC));
        return $messages;
    }

    /**
     * Elimina un mensaje por su ID.
     *
     * @param int $id ID del mensaje a eliminar.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteMessageById($id)
    {
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
