<?php
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

use services\MailService;
use facades\UserFacade;
use facades\MessageFacade;
use converters\UserConverter;
use converters\MessageConverter;
use dtos\MessageDto;

if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $advertsUserId = $_POST['adverts_user_id'] ?? null;
    $advertId = $_POST['advert_id'] ?? null;

    $userMessage = nl2br(htmlspecialchars($_POST['message'] ?? ''));
    $fromEmail = htmlspecialchars($_SESSION['user']->email);
    $fromUser = htmlspecialchars($_SESSION['user']->username);

    $backgroundUrl = 'https://i.imgur.com/NJydr4l.png';

    $messageText = '
        <div style="
            background: url(' . $backgroundUrl . ') repeat-y center top, #ffffff;
            padding: 24px 0;
            margin: 0;
            width: 100%;
        ">
            <div style="
                max-width:500px;
                margin: auto;
                background: white;
                border-radius: 16px;
                box-shadow: 0 2px 16px #bbb;
                padding: 35px 28px;
                display: flex;
                flex-direction: column;
                align-items: center;
            ">
                <img src="https://i.imgur.com/qRiik2a.png" alt="Houspecial" style="height:50px; margin-bottom:18px;">
                <h2 style="font-family:Arial,sans-serif; font-size:1.6em; margin:0 0 18px 0; text-align:center;">¡Alguien tiene interés en tu anuncio!</h2>
                <p style="color:#333; font-family:Arial,sans-serif; font-size:1.1em; margin-bottom:8px;">
                    <strong>De:</strong> ' . $fromUser . ' (' . $fromEmail . ')
                </p>
                <div style="
                    background:#f1f3fa;
                    border-radius:8px;
                    padding:18px 14px;
                    margin:18px 0 18px 0;
                    color:#222;
                    width:100%;
                    font-size:1.1em;
                    font-family:Arial,sans-serif;
                    text-align:left;
                    word-break:break-word;
                ">
                    ' . $userMessage . '
                </div>
                <a href="http://localhost:8080" style="text-decoration:none; font-family:Arial,sans-serif; font-size:1.1em; margin-bottom:12px;">Ir a <u>Houspecial</u></a>
                <hr style="border:none; border-top:1px solid #eee; margin:24px 0; width:100%;">
                <div style="text-align:center; color:#aaa; font-size:0.95em; font-family:Arial,sans-serif;">
                    Este mensaje ha sido enviado automáticamente desde <strong>Houspecial</strong>.<br>
                    Por favor, no respondas a este correo.<br>
                    <strong>Si deseas contactar con el usuario</strong>, responde directamente a través del email facilitado en este correo electrónico.
                </div>
            </div>
        </div>
    ';

    $userFacade = new UserFacade(new UserConverter());
    $messageFacade = new MessageFacade(new MailService(), new MessageConverter());

    $from = $_SESSION['user']->email;
    $to = $userFacade->getUserById($advertsUserId)->email ?? null;
    $subject = "Nuevo mensaje sobre tu anuncio en Houspecial";
    $body = $messageText;

    $messageDto = new MessageDto(
        null,
        $_SESSION['user']->id,
        $advertsUserId,
        $advertId,
        "Mensaje desde Houspecial",
        $body,
        null
    );

    if ($to && $body) {
        try {
            $mailService = new MailService();
            $mailService->sendEmail($from, $to, $subject, $body);
            $messageFacade->registerMessage($messageDto);

            $_SESSION['message'] = "Mensaje enviado correctamente.";
        } catch (\Exception $e) {
            $_SESSION['message'] = "Error al enviar el mensaje: " . $e->getMessage();
        }
    } else {
        $_SESSION['message'] = "Faltan datos para enviar el mensaje.";
    }

    header('Location: /message');
    exit;
}
