<?php

namespace services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    public function sendEmail($from, $to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'messaging.houspecial@gmail.com';
            $mail->Password = 'khjr ewzs lhca gfhj';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom($from, 'Houspecial');
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);

            // Enviar el correo
            $mail->send();
        } catch (Exception $e) {
            throw new \Exception("No se pudo enviar el correo: " . $mail->ErrorInfo);
        }
    }
}
