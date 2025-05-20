<?php

namespace models;

/**
 * Modelo de dominio para representar un mensaje entre usuarios.
 */
class MessageModel {
    /**
     * @var int ID del mensaje.
     */
    private $id;
    /**
     * @var int ID del usuario remitente.
     */
    private $sender_id;
    /**
     * @var int ID del usuario destinatario.
     */
    private $receiver_id;
    /**
     * @var int ID del anuncio relacionado (si aplica).
     */
    private $advert_id;
    /**
     * @var string Asunto del mensaje.
     */
    private $subject;
    /**
     * @var string Contenido del mensaje.
     */
    private $content;
    /**
     * @var string Fecha y hora de envío del mensaje.
     */
    private $sent_at;

    /**
     * Constructor de MessageModel.
     *
     * @param int $id ID del mensaje.
     * @param int $sender_id ID del usuario remitente.
     * @param int $receiver_id ID del usuario destinatario.
     * @param int $advert_id ID del anuncio relacionado.
     * @param string $subject Asunto del mensaje.
     * @param string $content Contenido del mensaje.
     * @param string $sent_at Fecha y hora de envío del mensaje.
     */
    public function __construct(
        $id,
        $sender_id,
        $receiver_id,
        $advert_id,
        $subject,
        $content,
        $sent_at
    ) {
        $this->id = $id;
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->advert_id = $advert_id;
        $this->subject = $subject;
        $this->content = $content;
        $this->sent_at = $sent_at;
    }

    // Getters
    /**
     * @return int
     */
    public function getId() { return $this->id; }
    /**
     * @return int
     */
    public function getSenderId() { return $this->sender_id; }
    /**
     * @return int
     */
    public function getReceiverId() { return $this->receiver_id; }
    /**
     * @return int
     */
    public function getAdvertId() { return $this->advert_id; }
    /**
     * @return string
     */
    public function getSubject() { return $this->subject; }
    /**
     * @return string
     */
    public function getContent() { return $this->content; }
    /**
     * @return string
     */
    public function getSentAt() { return $this->sent_at; }

    // Setters
    /**
     * @param int $sender_id
     */
    public function setSenderId($sender_id) { $this->sender_id = $sender_id; }
    /**
     * @param int $receiver_id
     */
    public function setReceiverId($receiver_id) { $this->receiver_id = $receiver_id; }
    /**
     * @param int $advert_id
     */
    public function setAdvertId($advert_id) { $this->advert_id = $advert_id; }
    /**
     * @param string $subject
     */
    public function setSubject($subject) { $this->subject = $subject; }
    /**
     * @param string $content
     */
    public function setContent($content) { $this->content = $content; }
    /**
     * @param string $sent_at
     */
    public function setSentAt($sent_at) { $this->sent_at = $sent_at; }

}
