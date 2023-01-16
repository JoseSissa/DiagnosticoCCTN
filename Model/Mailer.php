<?php

namespace Model;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
	private $mail;

    public function __construct()
    {
        try
        {
            $this->mail = new PHPMailer(true);

			$this->mail->CharSet = "utf-8";
			$this->mail->Encoding = 'base64';
            $this->mail->isSMTP();
            $this->mail->Host = getenv('SMTP_HOST');
            $this->mail->SMTPAuth = true;
            $this->mail->Username = getenv('SMTP_USER');
            $this->mail->Password = getenv('SMTP_PASSWORD');
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;

			$this->mail->setFrom(getenv('SMTP_USER'), getenv('SMTP_NAME'));
        }
        catch (Exception $e)
        {
            error_log($e->getMessage(), 0);
        }
    }
	
	public function sendMail(array $to, array $bcc, string $subject, string $body) {
		try {
			foreach ($to as $recipient) $this->mail->addAddress($recipient);
			foreach ($bcc as $bcc_recipient) $this->mail->addBCC($bcc_recipient);
			
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            $this->mail->send();
			return true;
		}
		catch (Exception $e)
        {
            return false;
        }
	}
	
	public function sendMailWithStringAttachment(array $to, array $bcc, string $subject, string $body, string $data, string $filename, string $encoding, string $type) {
		try {
			foreach ($to as $recipient) $this->mail->addAddress($recipient);
			foreach ($bcc as $bcc_recipient) $this->mail->addBCC($bcc_recipient);
			
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
			$this->mail->AddStringAttachment(base64_decode($data), $filename, $encoding, $type);
            $this->mail->send();
			return true;
		}
		catch (Exception $e)
        {
            return false;
        }
	}
}