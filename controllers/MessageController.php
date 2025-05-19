<?php

namespace controllers;

use services\MessageService;
use models\MessageModel;

class MessageController {
    private $messageService;

    public function __construct(MessageService $messageService) {
        $this->messageService = $messageService;
    }

    /**
     * Crea un nuevo mensaje.
     * @param array $data Datos del mensaje (sender_id, receiver_id, advert_id, subject, content, sent_at)
     * @return bool True si se creó correctamente
     */
    public function createMessage($data) {
        $message = new MessageModel(
            null,
            $data['sender_id'],
            $data['receiver_id'],
            $data['advert_id'],
            $data['subject'],
            $data['content'],
            $data['sent_at']
        );
        return $this->messageService->createMessage($message);
    }

    /**
     * Obtiene un mensaje por su ID.
     * @param int $id
     * @return MessageModel|null
     */
    public function getMessageById($id) {
        return $this->messageService->getMessageById($id);
    }

    /**
     * Obtiene todos los mensajes de un usuario (enviados o recibidos).
     * @param int $user_id
     * @return MessageModel[]
     */
    public function getMessagesByUserId($user_id) {
        return $this->messageService->getMessagesByUserId($user_id);
    }

    /**
     * Actualiza un mensaje.
     * @param int $id
     * @param array $fields Campos a actualizar
     * @return bool
     */
    public function updateMessage($id, $fields) {
        return $this->messageService->updateMessage($id, $fields);
    }

    /**
     * Elimina un mensaje por su ID.
     * @param int $id
     * @return bool
     */
    public function deleteMessage($id) {
        return $this->messageService->deleteMessage($id);
    }
}