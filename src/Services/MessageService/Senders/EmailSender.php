<?php

namespace App\Services\MessageService\Senders;

use PHPMailer\PHPMailer\PHPMailer;

class SMTPMailer
{
    private string $host;

    public function send(string $subject, string $message, string $from, string $to)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $this->host;
        $mail->SMTPAuth = true;
        $mail->Username = 'username';
        $mail->Password = 'password';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom($from);
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
    }

    public function __construct(string $host)
    {
        $this->host = $host;
    }
}