<?php

namespace App\Services\MessageService\Senders;

require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\Services\ConfigReader;
use PHPMailer\PHPMailer\PHPMailer;

class EmailSender
{
    private ConfigReader $configReader;
    private array $config;

    public function __construct()
    {
        $this->configReader = new ConfigReader();
        $this->config = $this->configReader->read()['smtp'];
    }

    public function send(string $subject, string $message, string | array $to): void
    {
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = $this->config['Host'];
        $mail->SMTPAuth = true;
        $mail->Username = $this->config['Username'];
        $mail->Password = $this->config['Password'];
        $mail->SMTPSecure = $this->config['Encryption'];
        $mail->Port = $this->config['Port'];
        $mail->setFrom($this->config['Username']);
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
    }
}

$EmailSender = new EmailSender();
$EmailSender->send('Тема письма', 'Текст письма', 'den-nety@mail.ru', 'den-nety@mail.ru');