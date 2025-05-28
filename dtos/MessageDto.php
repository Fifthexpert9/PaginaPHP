<?php

namespace dtos;

/**
 * DTO para exponer información de un mensaje entre usuarios.
 *
 * @property int $id ID del mensaje.
 * @property int $sender_id ID del usuario remitente.
 * @property int $receiver_id ID del usuario destinatario.
 * @property int $advert_id ID del anuncio relacionado (si aplica).
 * @property string $subject Asunto del mensaje.
 * @property string $content Contenido del mensaje.
 * @property string $sent_at Fecha y hora de envío del mensaje.
 */
class MessageDto
{
    public $id;
    public $sender_id;
    public $receiver_id;
    public $advert_id;
    public $subject;
    public $content;
    public $sent_at;

    /**
     * Constructor de MessageDto.
     *
     * @param int $id ID del mensaje.
     * @param int $sender_id ID del usuario remitente.
     * @param int $receiver_id ID del usuario destinatario.
     * @param int $advert_id ID del anuncio relacionado.
     * @param string $subject Asunto del mensaje.
     * @param string $content Contenido del mensaje.
     * @param string $sent_at Fecha y hora de envío del mensaje.
     */
    public function __construct($id, $sender_id, $receiver_id, $advert_id, $subject, $content, $sent_at)
    {
        $this->id = $id;
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->advert_id = $advert_id;
        $this->subject = $subject;
        $this->content = $content;
        $this->sent_at = $sent_at;
    }

    /**
     * Devuelve el mensaje como un array asociativo.
     *
     * @return array<string, mixed> Datos del mensaje.
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'advert_id' => $this->advert_id,
            'subject' => $this->subject,
            'content' => $this->content,
            'sent_at' => $this->sent_at
        ];
    }
}
