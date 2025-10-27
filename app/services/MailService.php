<?php
// filepath: c:\xampp\htdocs\sikap\app\services\MailService.php
class MailService
{
    private $mailerConfig;

    public function __construct()
    {
        $this->mailerConfig = require __DIR__ . '/../../config/mailer.php';
    }

    public function sendEmail($to, $subject, $body)
    {
        // For development, log emails
        error_log("EMAIL TO: {$to} | SUBJECT: {$subject} | BODY: " . strip_tags($body));

        // TODO: Implement actual email sending using mailerConfig
        // You can use PHPMailer here with the config values
        /*
        require_once __DIR__ . '/../../vendor/autoload.php';
        use PHPMailer\PHPMailer\PHPMailer;
        
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $this->mailerConfig['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $this->mailerConfig['username'];
        $mail->Password = $this->mailerConfig['password'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $this->mailerConfig['port'];
        
        $mail->setFrom($this->mailerConfig['from_email'], $this->mailerConfig['from_name']);
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        
        return $mail->send();
        */

        return true; // Return true for testing
    }
}
