<?php

namespace converters;

use models\MessageModel;
use dtos\MessageDto;

/**
 * Clase encargada de convertir entre MessageModel y MessageDto
 * para la transferencia de datos de mensajes.
 */
class MessageConverter {
    /**
     * Convierte un MessageModel en MessageDto.
     *
     * @param MessageModel $model Modelo de dominio con los datos del mensaje.
     * @return MessageDto DTO resultante con la información del mensaje.
     */
    public static function modelToDto(MessageModel $model): MessageDto {        
        return new MessageDto(
            $model->getId(),
            $model->getSenderId(),
            $model->getReceiverId(),
            $model->getAdvertId(),
            $model->getSubject(),
            $model->getContent(),
            $model->getSentAt()
        );
    }

    /**
     * Convierte un MessageDto en MessageModel.
     *
     * @param MessageDto $dto DTO con los datos del mensaje.
     * @return MessageModel Modelo de dominio con los datos del mensaje.
     */
    public static function dtoToModel(MessageDto $dto): MessageModel {
        return new MessageModel(
            $dto->id,
            $dto->sender_id,
            $dto->receiver_id,
            $dto->advert_id,
            $dto->subject,
            $dto->content,
            $dto->sent_at
        );
    }
}