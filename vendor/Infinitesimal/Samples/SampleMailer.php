<?php

namespace Infinitesimal\Samples;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class SampleMailer
{
    private const SMTP_HOST = 'smtp.gmail.com';
    private const FROM_MAIL = 'from@example.org';
    private const FROM_NAME = 'Example Name';

    public function mail(array $to, string $subject, string $body): bool
    {
        try
        {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = self::SMTP_HOST;
            $mail->Username = self::FROM_MAIL;
            $mail->Password = getenv('SMTP_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom(self::FROM_MAIL, self::FROM_NAME);
            foreach ($to as $recipient) $mail->addAddress($recipient);

            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->send();

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}