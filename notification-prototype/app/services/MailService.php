<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);

        // SMTP settings
        $this->mailer->isSMTP();
        $this->mailer->Host       = 'smtp.hostinger.com'; // change if using Gmail/other
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = 'your-email@yourdomain.com';
        $this->mailer->Password   = 'your-email-password';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port       = 587;

        $this->mailer->setFrom('your-email@yourdomain.com', 'Job Portal');
    }

    public function send($to, $subject, $body) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: {$this->mailer->ErrorInfo}");
            return false;
        }
    }
}
