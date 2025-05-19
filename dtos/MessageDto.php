<?php

namespace dtos;

class MessageDto {
    public $id;
    public $sender_id;
    public $receiver_id;
    public $advert_id;
    public $subject;
    public $content;
    public $sent_at;

    public function __construct($id, $sender_id, $receiver_id, $advert_id, $subject, $content, $sent_at) {
        $this->id = $id;
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->advert_id = $advert_id;
        $this->subject = $subject;
        $this->content = $content;
        $this->sent_at = $sent_at;
    }

    public function toArray() {
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