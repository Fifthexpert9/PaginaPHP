<?php

namespace models;

class MessageModel {
    private $id;
    private $sender_id;
    private $receiver_id;
    private $advert_id;
    private $subject;
    private $content;
    private $sent_at;

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
    public function getId() { return $this->id; }
    public function getSenderId() { return $this->sender_id; }
    public function getReceiverId() { return $this->receiver_id; }
    public function getAdvertId() { return $this->advert_id; }
    public function getSubject() { return $this->subject; }
    public function getContent() { return $this->content; }
    public function getSentAt() { return $this->sent_at; }

    // Setters
    public function setSenderId($sender_id) { $this->sender_id = $sender_id; }
    public function setReceiverId($receiver_id) { $this->receiver_id = $receiver_id; }
    public function setAdvertId($advert_id) { $this->advert_id = $advert_id; }
    public function setSubject($subject) { $this->subject = $subject; }
    public function setContent($content) { $this->content = $content; }
    public function setSentAt($sent_at) { $this->sent_at = $sent_at; }

}
