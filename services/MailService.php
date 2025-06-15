<?php

namespace services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Servicio para el envío de correos electrónicos mediante PHPMailer.
 *
 * Esta clase encapsula la lógica necesaria para enviar correos electrónicos utilizando el servidor SMTP de Gmail.
 * Permite configurar el remitente, destinatario, asunto y cuerpo del mensaje, así como el formato HTML y la codificación.
 *
 * Métodos:
 * - sendEmail($from, $to, $subject, $body): Envía un correo electrónico con los parámetros especificados.
 */
class MailService
{
    /**
     * Envía un correo electrónico utilizando PHPMailer y SMTP de Gmail.
     *
     * @param string $from    Dirección de correo del remitente.
     * @param string $to      Dirección de correo del destinatario.
     * @param string $subject Asunto del correo.
     * @param string $body    Cuerpo del mensaje (HTML permitido).
     * @throws \Exception Si ocurre un error durante el envío.
     */
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
