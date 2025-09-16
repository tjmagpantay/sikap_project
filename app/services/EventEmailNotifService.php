<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EventEmailNotifService {
    private $mailerConfig;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->mailerConfig = require __DIR__ . '/../../config/mailer.php';
    }

    public function notifyJobseekersAboutNewProgram($eventId) {
        try {
            // Get event details
            $stmt = $this->db->prepare("SELECT * FROM events WHERE event_id = ?");
            $stmt->execute([$eventId]);
            $event = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$event) {
                throw new Exception("Event not found");
            }

            // Get all jobseeker emails
            $stmt = $this->db->prepare("
                SELECT DISTINCT u.email, j.first_name, j.last_name 
                FROM jobseeker j
                JOIN users u ON j.user_id = u.user_id
                WHERE j.acc_status = 'enabled'
            ");
            $stmt->execute();
            $jobseekers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Initialize mailer without debug output
            $mailer = new PHPMailer(true);
            $mailer->SMTPDebug = 0; // Disable debug output
            $mailer->isSMTP();
            $mailer->Host = 'smtp.gmail.com';
            $mailer->SMTPAuth = true;
            $mailer->Username = 'peso.sikap.dev2025@gmail.com';
            $mailer->Password = 'hqod pqlk nayf dbed';
            $mailer->SMTPSecure = 'tls'; // Use TLS encryption
            $mailer->Port = 587;
            
            // Set sender info
            $mailer->setFrom('peso.sikap.dev2025@gmail.com', 'PESO SIKAP');
            
            // Set character encoding
            $mailer->CharSet = 'UTF-8';
            
            // Disable SSL certificate verification (only for development)
            $mailer->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Format dates
            $startDate = new DateTime($event['time_start']);
            $endDate = new DateTime($event['time_end']);

            // Create email template
            $emailTemplate = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                    <h2 style='color: #092C4C;'>New {$event['type']} Announcement</h2>
                    <h3 style='color: #333;'>{$event['title']}</h3>
                    
                    <div style='background: #f5f5f5; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                        <p><strong>Date:</strong> {$startDate->format('F j, Y')}</p>
                        <p><strong>Time:</strong> {$startDate->format('g:i A')} - {$endDate->format('g:i A')}</p>
                        <p><strong>Type:</strong> " . ucfirst($event['type']) . "</p>
                    </div>

                    <div style='margin: 20px 0;'>
                        <h4>Description:</h4>
                        <p style='line-height: 1.6;'>{$event['description']}</p>
                    </div>

                    <div style='margin-top: 30px; text-align: center;'>
                        <a href='http://localhost/sikap/public/index.php?page=event-info&id={$event['event_id']}' 
                           style='background: #092C4C; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>
                            View Event Details
                        </a>
                    </div>
                </div>
            ";

            // Send to each jobseeker
            foreach ($jobseekers as $jobseeker) {
                try {
                    $mailer->clearAddresses();
                    $mailer->addAddress($jobseeker['email']);
                    $mailer->isHTML(true);
                    $mailer->Subject = "New " . ucfirst($event['type']) . ": {$event['title']}";
                    $mailer->Body = $emailTemplate;
                    $mailer->send();
                    
                    error_log("✅ Event notification sent to {$jobseeker['email']}");
                } catch (Exception $e) {
                    error_log("❌ Failed to send event notification to {$jobseeker['email']}: " . $e->getMessage());
                    continue;
                }
            }

            return true;

        } catch (Exception $e) {
            error_log("❌ Error in notification service: " . $e->getMessage());
            return false;
        }
    }
}