<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EventEmailNotifService
{
    private $mailerConfig;
    private $db;

    public function __construct($db)
    {
        $this->db = $db; // This assumes $db is already connected
        $this->mailerConfig = require __DIR__ . '/../../config/mailer.php';
    }

    public function notifyJobseekersAboutNewProgram($eventId)
    {
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

            // Collect, validate and deduplicate emails
            $emails = [];
            foreach ($jobseekers as $jobseeker) {
                $email = trim($jobseeker['email']);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emails[$email] = true; // use associative keys for dedupe
                } else {
                    error_log("⚠️ Skipping invalid email: {$email}");
                }
            }

            $recipientList = array_keys($emails);

            // Ensure we only send jobseeker notifications once per event.
            // Create a tiny tracking table if it doesn't exist, then check flag.
            try {
                $this->db->exec("CREATE TABLE IF NOT EXISTS event_notifications (
                    event_id INT PRIMARY KEY,
                    jobseeker_notified TINYINT DEFAULT 0,
                    last_sent DATETIME DEFAULT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

                $checkStmt = $this->db->prepare("SELECT jobseeker_notified FROM event_notifications WHERE event_id = ?");
                $checkStmt->execute([$eventId]);
                $existing = $checkStmt->fetch(PDO::FETCH_ASSOC);
                if ($existing && !empty($existing['jobseeker_notified'])) {
                    error_log("ℹ️ Jobseeker notifications already sent for event_id={$eventId}, skipping duplicate send.");
                    return true;
                }
            } catch (Exception $e) {
                // If table creation/check fails, log but continue to attempt send (avoid blocking notifications)
                error_log("⚠️ Could not verify prior notifications: " . $e->getMessage());
            }

            if (empty($recipientList)) {
                error_log('❌ No valid jobseeker emails to send notifications');
                return false;
            }

            // Add a To address (use configured from or fallback) because some SMTP servers require a To recipient
            $toAddress = $this->mailerConfig['from_email'] ?? 'peso.sikap.dev2025@gmail.com';
            $mailer->addAddress($toAddress);

            // Add all jobseekers as BCC
            foreach ($recipientList as $bcc) {
                $mailer->addBCC($bcc);
            }

            // Finalize and send a single email
            $mailer->isHTML(true);
            $mailer->Subject = "New " . ucfirst($event['type']) . ": {$event['title']}";
            $mailer->Body = $emailTemplate;

            try {
                $mailer->send();
                error_log("✅ Event notification sent to " . count($recipientList) . " recipients (BCC)");

                // Mark as sent in event_notifications table
                try {
                    $now = (new DateTime())->format('Y-m-d H:i:s');
                    $upsert = $this->db->prepare("INSERT INTO event_notifications (event_id, jobseeker_notified, last_sent) VALUES (?, 1, ?) ON DUPLICATE KEY UPDATE jobseeker_notified = 1, last_sent = VALUES(last_sent)");
                    $upsert->execute([$eventId, $now]);
                } catch (Exception $e) {
                    error_log("⚠️ Failed to mark event as notified: " . $e->getMessage());
                }

                return true;
            } catch (Exception $e) {
                error_log("❌ Failed to send bulk event notification: " . $e->getMessage());
                return false;
            }
        } catch (Exception $e) {
            error_log("❌ Error in notification service: " . $e->getMessage());
            return false;
        }
    }
}
