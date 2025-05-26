<?php

namespace facades;

use services\MessageService;
use services\UserService;
use services\MailService;
use converters\MessageConverter;
use dtos\MessageDto;

/**
 * Facade para la gestión de mensajes.
 * Orquesta la lógica de negocio relacionada con los mensajes entre usuarios y su conversión entre modelos y DTOs.
 */
class MessageFacade
{
    private $messageService;
    private $userService;
    private $mailService;
    private $messageConverter;

    /**
     * Constructor de MessageFacade.
     *
     * @param MessageService $messageService Servicio de mensajes.
     * @param MailService $mailService Servicio de envío de mensajes mediante PHPMailer.
     * @param MessageConverter $messageConverter Conversor de mensajes.
     */
    public function __construct(MessageService $messageService, UserService $userService, MailService $mailService, MessageConverter $messageConverter)
    {
        $this->messageService = $messageService;
        $this->userService = $userService;
        $this->mailService = $mailService;
        $this->messageConverter = $messageConverter;
    }

    /**
     * Registra un mensaje en la base de datos y envía un correo al receptor.
     *
     * @param MessageDto $messageDto DTO del mensaje a enviar.
     * @return string Mensaje de éxito o error.
     */
    public function sendMessage(MessageDto $messageDto)
    {
        $messageModel = $this->messageConverter->dtoToModel($messageDto);
        $messageCreated = $this->messageService->createMessage($messageModel);

        if ($messageCreated) {
            $receiverEmail = $this->userService->getUserById($messageModel->getReceiverId())->getEmail();
            $senderEmail = $this->userService->getUserById($messageModel->getSenderId())->getEmail();

            if ($receiverEmail && $senderEmail) {
                $body = $messageModel->getContent() . "\n\n" .
                    "Puedes contactarme a través de mi email: " . $senderEmail;

                try {
                    $this->mailService->sendEmail('messaging.houspecial@gmail.com', $receiverEmail, $messageModel->getSubject(), $body);
                    return "Mensaje enviado correctamente.";
                } catch (\Exception $e) {
                    //error_log("Error al enviar el correo: " . $e->getMessage());
                    return "Se ha producido un error al enviar el mensaje. Por favor, inténtalo de nuevo más tarde.";
                }
            } else return "Se ha producido un error al enviar el mensaje. Por favor, inténtalo de nuevo más tarde.";
        }
    }

    /**
     * Obtiene un mensaje por su ID.
     *
     * @param int $id ID del mensaje.
     * @return MessageDto|null DTO del mensaje o null si no existe.
     */
    public function getMessageById($id)
    {
        $messageModel = $this->messageService->getMessageById($id);
        if (!$messageModel) {
            return null;
        }
        return $this->messageConverter->modelToDto($messageModel);
    }

    /**
     * Obtiene todos los mensajes enviados por un usuario.
     *
     * @param int $userId ID del usuario.
     * @return MessageDto[] Array de DTOs de mensajes enviados por el usuario.
     */
    public function getMessagesSentByUser($userId)
    {
        $messageModels = $this->messageService->getMessagesSentByUser($userId);
        return array_map([$this->messageConverter, 'modelToDto'], $messageModels);
    }

    /**
     * Obtiene todos los mensajes recibidos por un usuario.
     *
     * @param int $userId ID del usuario.
     * @return MessageDto[] Array de DTOs de mensajes recibidos por el usuario.
     */
    public function getMessagesReceivedByUser($userId)
    {
        $messageModels = $this->messageService->getMessagesReceivedByUser($userId);
        return array_map([$this->messageConverter, 'modelToDto'], $messageModels);
    }

    /**
     * Elimina un mensaje por su ID.
     *
     * @param int $id ID del mensaje.
     * @return bool True si la eliminación fue exitosa, false en caso contrario.
     */
    public function deleteMessageById($id)
    {
        return $this->messageService->deleteMessageById($id);
    }
}
