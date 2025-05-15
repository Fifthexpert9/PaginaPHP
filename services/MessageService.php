<?php

namespace services;

use models\MessageModel;
use models\DatabaseModel;
use PDO;
use PDOException;

class MessageService {
    private $db;

    public function __construct(DatabaseModel $databaseModel) {
        $this->db = $databaseModel->db;
    }

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