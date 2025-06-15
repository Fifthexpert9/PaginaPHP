<?php

namespace facades;

use services\MessageService;
use services\UserService;
use services\MailService;
use converters\MessageConverter;
use dtos\MessageDto;

/**
 * Facade para la gestión de mensajes entre usuarios.
 *
 * Orquesta la lógica de negocio relacionada con los mensajes y su conversión entre modelos y DTOs.
 * Proporciona una interfaz simplificada para registrar, obtener y eliminar mensajes,
 * delegando la lógica a los servicios y conversores correspondientes.
 *
 * Métodos:
 * - __construct: Inicializa el facade con los servicios y conversores necesarios.
 * - registerMessage: Registra un mensaje en la base de datos y envía un correo al receptor.
 * - getMessageById: Obtiene un mensaje por su ID.
 * - getMessagesSentByUser: Obtiene todos los mensajes enviados por un usuario.
 * - getMessagesReceivedByUser: Obtiene todos los mensajes recibidos por un usuario.
 * - deleteMessageById: Elimina un mensaje por su ID.
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
     * @param MailService $mailService Servicio de envío de mensajes mediante PHPMailer.
     * @param MessageConverter $messageConverter Conversor de mensajes.
     */
    public function __construct(MailService $mailService, MessageConverter $messageConverter)
    {
        $this->messageService = MessageService::getInstance();
        $this->userService = UserService::getInstance();
        $this->mailService = $mailService;
        $this->messageConverter = $messageConverter;
    }

    /**
     * Registra un mensaje en la base de datos y envía un correo al receptor.
     *
     * @param MessageDto $messageDto DTO del mensaje a enviar.
     * @return string Mensaje de éxito o error.
     */
    public function registerMessage(MessageDto $messageDto)
    {
        $messageModel = $this->messageConverter->dtoToModel($messageDto);
        
        return $this->messageService->createMessage($messageModel);
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
