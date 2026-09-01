<?php

namespace App\Libraries;

class EmailService
{
    public static function sendActivationEmail(string $recipientEmail, string $recipientName, string $activationLink): bool
    {
        $subject = 'Activa tu cuenta en Estética BV';
        $message = "Hola {$recipientName},\n\nGracias por registrarte en Estética BV. Por favor activa tu cuenta haciendo clic en el siguiente enlace:\n\n{$activationLink}\n\nEste enlace expirará en 24 horas.";

        return self::sendEmail($recipientEmail, $subject, $message);
    }

    public static function sendPasswordResetEmail(string $recipientEmail, string $recipientName, string $resetLink): bool
    {
        $subject = 'Confirmación de recuperación de contraseña - Estética BV';
        $message = "Hola {$recipientName},\n\nHas solicitado cambiar tu contraseña en Estética BV. Para confirmar la titularidad de tu cuenta y aplicar el cambio, haz clic en el siguiente enlace:\n\n{$resetLink}\n\nSi no solicitaste este cambio, puedes ignorar este correo.";

        return self::sendEmail($recipientEmail, $subject, $message);
    }

    public static function sendConsultaEmail(string $senderEmail, string $senderName, string $subject, string $message, string $adminEmail): bool
    {
        $subjectLine = 'Nueva Consulta: ' . esc($subject);
        $body = "Ha recibido una nueva consulta desde el formulario web:\n\n";
        $body .= "Remitente: {$senderName}\n";
        $body .= "Correo: {$senderEmail}\n";
        $body .= "Asunto: {$subject}\n\n";
        $body .= "Consulta:\n{$message}\n";

        return self::sendEmail($adminEmail, $subjectLine, $body);
    }

    private static function sendEmail(string $to, string $subject, string $message): bool
    {
        try {
            $email = service('email');
            $email->setTo($to);
            $email->setFrom('no-reply@esteticabv.com', 'Estética BV');
            $email->setSubject($subject);
            $email->setMessage($message);

            if ($email->send(false)) {
                return true;
            }
        } catch (\Throwable $e) {
            log_message('warning', 'Email dispatch exception: ' . $e->getMessage());
        }

        log_message('info', "Email to {$to} [{$subject}]:\n{$message}");
        return true;
    }
}
