<?php
require_once __DIR__ . '/../models/Notification.php';
require_once __DIR__ . '/MailService.php';

class NotificationService
{
    private $notification;
    private $mailService;
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
        $this->notification = new Notification($database);
        $this->mailService = new MailService();
    }

    // Scenario 1: Employer posts a job - notify all jobseekers
    public function notifyJobPosted($jobId, $jobTitle, $companyName)
    {
        try {
            // Get all active jobseekers - Fixed query based on your schema
            $stmt = $this->db->prepare("
                SELECT u.user_id, u.email, j.first_name, j.last_name 
                FROM users u
                JOIN user_roles ur ON u.user_id = ur.user_id
                JOIN roles r ON ur.role_id = r.role_id
                JOIN jobseeker j ON u.user_id = j.user_id
                WHERE r.role_name = 'jobseeker'
                AND u.status = 'active'
            ");
            $stmt->execute();
            $jobseekers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $title = "New Job Available";
            $message = "New job posted: {$jobTitle} at {$companyName}";
            $link = "?page=job-details&id={$jobId}";

            foreach ($jobseekers as $jobseeker) {
                // Create in-app notification
                $this->notification->create(
                    $jobseeker['user_id'],
                    'job_post',
                    $title,
                    $message,
                    $link,
                    ['job_id' => $jobId, 'company_name' => $companyName]
                );

                // Send email notification (optional - can be disabled for testing)
                if (class_exists('MailService')) {
                    $emailSubject = "New Job Opportunity: {$jobTitle}";
                    $emailBody = "
                        <h2>New Job Available</h2>
                        <p>Hi {$jobseeker['first_name']},</p>
                        <p>A new job opportunity has been posted that might interest you:</p>
                        <p><strong>Position:</strong> {$jobTitle}</p>
                        <p><strong>Company:</strong> {$companyName}</p>
                        <p><a href='http://" . $_SERVER['HTTP_HOST'] . "/sikap/?page=job-details&id={$jobId}' 
                           style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>
                           View Job Details
                        </a></p>
                    ";

                    $this->mailService->sendEmail($jobseeker['email'], $emailSubject, $emailBody);
                }
            }

            return true;
        } catch (Exception $e) {
            error_log("Error notifying job posted: " . $e->getMessage());
            return false;
        }
    }

    // Scenario 2: Jobseeker applies to job - notify employer
    public function notifyJobApplication($applicationId, $jobId, $employerId, $jobseekerName)
    {
        try {
            // Get employer details - Fixed query
            $stmt = $this->db->prepare("
                SELECT u.user_id, u.email, 
                       COALESCE(eb.business_name, CONCAT(e.first_name, ' ', e.last_name)) as company_name,
                       jp.job_title
                FROM users u
                JOIN employer e ON u.user_id = e.user_id
                LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                JOIN job_post jp ON e.employer_id = jp.employer_id
                WHERE e.employer_id = ? AND jp.job_id = ?
            ");
            $stmt->execute([$employerId, $jobId]);
            $employer = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($employer) {
                $title = "New Job Application";
                $message = "{$jobseekerName} applied for {$employer['job_title']}";
                $link = "?page=manage-applications&job_id={$jobId}";

                // Create in-app notification
                $this->notification->create(
                    $employer['user_id'],
                    'job_application',
                    $title,
                    $message,
                    $link,
                    ['application_id' => $applicationId, 'job_id' => $jobId]
                );

                // Send email notification
                if (class_exists('MailService')) {
                    $emailSubject = "New Application for {$employer['job_title']}";
                    $emailBody = "
                        <h2>New Job Application</h2>
                        <p>Hi,</p>
                        <p>You have received a new application for your job posting:</p>
                        <p><strong>Position:</strong> {$employer['job_title']}</p>
                        <p><strong>Applicant:</strong> {$jobseekerName}</p>
                        <p><a href='http://" . $_SERVER['HTTP_HOST'] . "/sikap/?page=manage-applications&job_id={$jobId}' 
                           style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>
                           View Application
                        </a></p>
                    ";

                    $this->mailService->sendEmail($employer['email'], $emailSubject, $emailBody);
                }
            }

            return true;
        } catch (Exception $e) {
            error_log("Error notifying job application: " . $e->getMessage());
            return false;
        }
    }

    // Scenario 3: Application status update - notify jobseeker
    public function notifyApplicationStatusUpdate($applicationId, $newStatus, $jobTitle, $companyName)
    {
        try {
            // Get jobseeker details - Fixed query
            $stmt = $this->db->prepare("
                SELECT u.user_id, u.email, j.first_name, j.last_name
                FROM users u
                JOIN jobseeker j ON u.user_id = j.user_id
                JOIN job_application ja ON j.jobseeker_id = ja.jobseeker_id
                WHERE ja.application_id = ?
            ");
            $stmt->execute([$applicationId]);
            $jobseeker = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($jobseeker) {
                $statusMessages = [
                    'pending' => 'Your application is being reviewed',
                    'reviewed' => 'Your application has been reviewed',
                    'shortlisted' => 'Congratulations! You have been shortlisted',
                    'rejected' => 'Your application status has been updated',
                    'hired' => 'Congratulations! You have been hired'
                ];

                $title = "Application Status Update";
                $message = "{$statusMessages[$newStatus]} for {$jobTitle} at {$companyName}";
                $link = "?page=my-applications";

                // Create in-app notification
                $this->notification->create(
                    $jobseeker['user_id'],
                    'application_update',
                    $title,
                    $message,
                    $link,
                    ['application_id' => $applicationId, 'status' => $newStatus]
                );

                // Send email notification
                if (class_exists('MailService')) {
                    $emailSubject = "Application Status Update - {$jobTitle}";
                    $emailBody = "
                        <h2>Application Status Update</h2>
                        <p>Hi {$jobseeker['first_name']},</p>
                        <p>{$statusMessages[$newStatus]} for the position:</p>
                        <p><strong>Position:</strong> {$jobTitle}</p>
                        <p><strong>Company:</strong> {$companyName}</p>
                        <p><strong>New Status:</strong> " . ucfirst($newStatus) . "</p>
                        <p><a href='http://" . $_SERVER['HTTP_HOST'] . "/sikap/?page=my-applications' 
                           style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>
                           View My Applications
                        </a></p>
                    ";

                    $this->mailService->sendEmail($jobseeker['email'], $emailSubject, $emailBody);
                }
            }

            return true;
        } catch (Exception $e) {
            error_log("Error notifying application status update: " . $e->getMessage());
            return false;
        }
    }

    // Scenario 4: Admin notifications for employer accreditation
    public function notifyAccreditationRequest($employerId, $companyName)
    {
        try {
            // Get admin users
            $stmt = $this->db->prepare("
                SELECT u.user_id, u.email 
                FROM users u
                JOIN user_roles ur ON u.user_id = ur.user_id
                JOIN roles r ON ur.role_id = r.role_id
                WHERE r.role_name = 'admin'
                AND u.status = 'active'
            ");
            $stmt->execute();
            $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $title = "New Employer Accreditation Request";
            $message = "New accreditation request from {$companyName}";
            $link = "?page=employer-verification&id={$employerId}";

            foreach ($admins as $admin) {
                $this->notification->create(
                    $admin['user_id'],
                    'accreditation',
                    $title,
                    $message,
                    $link,
                    ['employer_id' => $employerId, 'company_name' => $companyName]
                );
            }

            return true;
        } catch (Exception $e) {
            error_log("Error notifying accreditation request: " . $e->getMessage());
            return false;
        }
    }

    public function notifyAccreditationUpdate($employerId, $status, $companyName)
    {
        try {
            // Get employer user details
            $stmt = $this->db->prepare("
                SELECT u.user_id, u.email, e.first_name, e.last_name
                FROM users u
                JOIN employer e ON u.user_id = e.user_id
                WHERE e.employer_id = ?
            ");
            $stmt->execute([$employerId]);
            $employer = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($employer) {
                $statusMessages = [
                    'approved' => 'Congratulations! Your account has been verified',
                    'rejected' => 'Your accreditation request requires attention'
                ];

                $title = "Accreditation Status Update";
                $message = $statusMessages[$status] ?? "Your accreditation status has been updated";
                $link = "?page=employer-dashboard";

                $this->notification->create(
                    $employer['user_id'],
                    'accreditation',
                    $title,
                    $message,
                    $link,
                    ['employer_id' => $employerId, 'status' => $status]
                );
            }

            return true;
        } catch (Exception $e) {
            error_log("Error notifying accreditation update: " . $e->getMessage());
            return false;
        }
    }

    // Get notifications for a user
    public function getUserNotifications($userId, $limit = 15, $offset = 0)
    {
        $sql = "SELECT notification_id, type, title, message, link, status, data, created_at
                FROM notifications
                WHERE user_id = ?
                ORDER BY created_at DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    // Get unread count
    public function getUnreadCount($userId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND status = 'unread'");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }

    // Mark as read
    public function markAsRead($notificationId, $userId)
    {
        $stmt = $this->db->prepare("UPDATE notifications SET status = 'read' WHERE notification_id = ? AND user_id = ?");
        return $stmt->execute([$notificationId, $userId]);
    }

    // Mark all as read
    public function markAllAsRead($userId)
    {
        $stmt = $this->db->prepare("UPDATE notifications SET status = 'read' WHERE user_id = ? AND status = 'unread'");
        return $stmt->execute([$userId]);
    }

    /**
     * Notify jobseekers about new job post
     */
    public function notifyJobseekersAboutNewJob(int $jobId): bool
    {
        try {
            // Get job details
            $jobStmt = $this->db->prepare("
                SELECT jp.job_title, jp.location, eb.business_name 
                FROM job_post jp
                LEFT JOIN employer e ON jp.employer_id = e.employer_id
                LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                WHERE jp.job_id = ? AND jp.job_status = 'open'
            ");
            $jobStmt->execute([$jobId]);
            $job = $jobStmt->fetch(PDO::FETCH_ASSOC);

            if (!$job) {
                error_log("❌ Job not found or not open: $jobId");
                return false;
            }

            $companyName = $job['business_name'] ?: 'a company';
            $title = "New Job Available: " . $job['job_title'];
            $message = "New {$job['job_title']} position at {$companyName}" .
                ($job['location'] ? " in {$job['location']}" : "") .
                ". Apply now!";
            $link = "?page=job-details&job_id=" . $jobId;

            // Get all active jobseekers
            $jobseekerStmt = $this->db->prepare("
                SELECT j.user_id 
                FROM jobseeker j
                INNER JOIN users u ON j.user_id = u.user_id 
                WHERE u.status = 'active'
            ");
            $jobseekerStmt->execute();
            $jobseekers = $jobseekerStmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($jobseekers)) {
                error_log("ℹ️ No active jobseekers found to notify");
                return true; // No jobseekers to notify, but not an error
            }

            // Insert notifications for all eligible jobseekers
            $insertStmt = $this->db->prepare("
                INSERT INTO notifications (user_id, type, title, message, link, status, data, created_at) 
                VALUES (?, 'job_post', ?, ?, ?, 'unread', ?, NOW())
            ");

            $data = json_encode([
                'job_id' => $jobId,
                'job_title' => $job['job_title'],
                'company_name' => $companyName,
                'location' => $job['location']
            ]);

            $notificationCount = 0;
            foreach ($jobseekers as $jobseeker) {
                if ($insertStmt->execute([
                    $jobseeker['user_id'],
                    $title,
                    $message,
                    $link,
                    $data
                ])) {
                    $notificationCount++;
                }
            }

            error_log("✅ Sent $notificationCount notifications for job ID: $jobId");
            return true;
        } catch (Exception $e) {
            error_log("❌ Error notifying jobseekers about new job: " . $e->getMessage());
            return false;
        }
    }
}
