<?php
namespace App\Models;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    public static function sendOTP($to, $otp) {
        $config = require __DIR__ . '/../../config/mailer.php';
        $mail = new PHPMailer(true);
        try {
            
            $mail->isSMTP();
            $mail->Host = $config['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['username'];
            $mail->Password = $config['password'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = $config['port'];

            $mail->setFrom($config['from_email'], $config['from_name']);
            $mail->addAddress($to);
            $mail->Subject = 'Your Reset Password Code';
            $mail->Body = "Your OTP reset password code is: <b>$otp</b>. It will expire in 5 minutes.";
            $mail->isHTML(true);

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>