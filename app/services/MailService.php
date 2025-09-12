<?php
class MailService {
    public function sendEmail($to, $subject, $body) {
        // For now, just log emails instead of sending them
        // You can implement actual email sending later
        error_log("EMAIL TO: {$to} | SUBJECT: {$subject} | BODY: " . strip_tags($body));
        
        // Uncomment below if you have mail configured
        /*
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: no-reply@sikap.com" . "\r\n";
        
        return mail($to, $subject, $body, $headers);
        */
        
        return true; // Return true for testing
    }
}