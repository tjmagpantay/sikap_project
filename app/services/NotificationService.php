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

    // FIXED: Scenario 1: Employer posts a job - notify all jobseekers
    public function notifyJobPosted($jobId, $jobTitle, $companyName)
    {
        try {
            // Get all active jobseekers - CORRECTED query
            $stmt = $this->db->prepare("
                SELECT j.user_id, j.first_name, j.last_name, u.email
                FROM jobseeker j
                INNER JOIN users u ON j.user_id = u.user_id 
                WHERE u.status = 'active'
            ");
            $stmt->execute();
            $jobseekers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            error_log("🔍 Job Notification: Found " . count($jobseekers) . " jobseekers to notify about job $jobId");

            if (empty($jobseekers)) {
                error_log("ℹ️ No active jobseekers found to notify about job");
                return true;
            }

            $title = "New Job Available: {$jobTitle}";
            $message = "New {$jobTitle} position at {$companyName}. Apply now!";
            $link = "?page=job-details&job_id={$jobId}";

            // FIXED: Insert notifications with user_type
            $insertStmt = $this->db->prepare("
                INSERT INTO notifications (user_id, user_type, type, title, message, link, status, data, created_at) 
                VALUES (?, 'jobseeker', 'job_post', ?, ?, ?, 'unread', ?, NOW())
            ");

            $data = json_encode([
                'job_id' => $jobId,
                'job_title' => $jobTitle,
                'company_name' => $companyName
            ]);

            $notificationCount = 0;
            foreach ($jobseekers as $jobseeker) {
                $result = $insertStmt->execute([
                    $jobseeker['user_id'],
                    $title,
                    $message,
                    $link,
                    $data
                ]);

                if ($result) {
                    $notificationCount++;
                    error_log("✅ Job Notification: Inserted for user_id {$jobseeker['user_id']} ({$jobseeker['first_name']} {$jobseeker['last_name']})");
                } else {
                    error_log("❌ Job Notification: Failed to insert for user_id {$jobseeker['user_id']}");
                }
            }

            error_log("✅ Sent $notificationCount job notifications to jobseekers for job ID: $jobId");
            return true;
        } catch (Exception $e) {
            error_log("❌ Error notifying job posted: " . $e->getMessage());
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
                INSERT INTO notifications (user_id, user_type, type, title, message, link, status, data, created_at) 
                VALUES (?, 'jobseeker', 'job_post', ?, ?, ?, 'unread', ?, NOW())
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

    /**
     * Notify jobseekers about new program/event posted by admin
     */
    public function notifyJobseekersAboutNewProgram(int $eventId): bool
    {
        try {
            // Get event/program details
            $eventStmt = $this->db->prepare("
                SELECT title, description, type, time_start, status
                FROM events 
                WHERE event_id = ? AND status = 'show'
            ");
            $eventStmt->execute([$eventId]);
            $event = $eventStmt->fetch(PDO::FETCH_ASSOC);

            if (!$event) {
                error_log("❌ Jobseeker Notification: Event not found or not visible: $eventId");
                return false;
            }

            // Create appropriate notification based on event type
            $eventType = ucfirst($event['type']);
            $title = "New {$eventType}: " . $event['title'];

            $eventDate = new DateTime($event['time_start']);
            $formattedDate = $eventDate->format('F j, Y \a\t g:i A');

            $message = "A new {$eventType} has been posted. Join us on {$formattedDate}. Don't miss out!";
            $link = "?page=programs-jobseeker#event-" . $eventId;

            // Get all active jobseekers
            $jobseekerStmt = $this->db->prepare("
                SELECT j.user_id, j.first_name, j.last_name
                FROM jobseeker j
                INNER JOIN users u ON j.user_id = u.user_id 
                LEFT JOIN jobseeker_settings js ON j.jobseeker_id = js.jobseeker_id
                WHERE u.status = 'active' 
                AND COALESCE(js.programs_news, 1) = 1
            ");
            $jobseekerStmt->execute();
            $jobseekers = $jobseekerStmt->fetchAll(PDO::FETCH_ASSOC);

            error_log("🔍 Jobseeker Notification: Found " . count($jobseekers) . " jobseekers to notify about event $eventId");

            if (empty($jobseekers)) {
                error_log("ℹ️ No active jobseekers found to notify about program");
                return true;
            }

            // FIXED: Insert notifications with user_type specified
            $insertStmt = $this->db->prepare("
                INSERT INTO notifications (user_id, user_type, type, title, message, link, status, data, created_at) 
                VALUES (?, 'jobseeker', 'program', ?, ?, ?, 'unread', ?, NOW())
            ");

            $data = json_encode([
                'event_id' => $eventId,
                'event_title' => $event['title'],
                'event_type' => $event['type'],
                'event_date' => $event['time_start'],
                'target_user_type' => 'jobseeker'
            ]);

            $notificationCount = 0;
            foreach ($jobseekers as $jobseeker) {
                $result = $insertStmt->execute([
                    $jobseeker['user_id'],
                    $title,
                    $message,
                    $link,
                    $data
                ]);

                if ($result) {
                    $notificationCount++;
                    error_log("✅ Jobseeker Notification: Inserted for user_id {$jobseeker['user_id']} ({$jobseeker['first_name']} {$jobseeker['last_name']})");
                } else {
                    error_log("❌ Jobseeker Notification: Failed to insert for user_id {$jobseeker['user_id']}");
                }
            }

            error_log("✅ Sent $notificationCount program notifications to JOBSEEKERS for event ID: $eventId");
            return true;
        } catch (Exception $e) {
            error_log("❌ Error notifying jobseekers about new program: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Notify employers about new program/event posted by admin
     */
    public function notifyEmployersAboutNewProgram(int $eventId): bool
    {
        try {
            // Get event/program details
            $eventStmt = $this->db->prepare("
                SELECT title, description, type, time_start, status
                FROM events 
                WHERE event_id = ? AND status = 'show'
            ");
            $eventStmt->execute([$eventId]);
            $event = $eventStmt->fetch(PDO::FETCH_ASSOC);

            if (!$event) {
                error_log("❌ Employer Notification: Event not found or not visible: $eventId");
                return false;
            }

            // Create appropriate notification based on event type
            $eventType = ucfirst($event['type']);
            $title = "New {$eventType}: " . $event['title'];

            $eventDate = new DateTime($event['time_start']);
            $formattedDate = $eventDate->format('F j, Y \a\t g:i A');

            $message = "A new {$eventType} has been posted. Join us on {$formattedDate}. Network with other employers!";
            $link = "?page=employer-programs#event-" . $eventId;

            // Get all active verified employers
            $employerStmt = $this->db->prepare("
                SELECT e.user_id, e.status as employer_status, u.status as user_status, e.first_name, e.last_name
                FROM employer e
                INNER JOIN users u ON e.user_id = u.user_id 
                WHERE u.status = 'active' 
                AND e.status = 'verified'
            ");
            $employerStmt->execute();
            $employers = $employerStmt->fetchAll(PDO::FETCH_ASSOC);

            error_log("🔍 Employer Notification: Found " . count($employers) . " verified employers to notify about event $eventId");

            if (empty($employers)) {
                error_log("ℹ️ No active verified employers found to notify about program");
                return true;
            }

            // FIXED: Insert notifications with user_type specified
            $insertStmt = $this->db->prepare("
                INSERT INTO notifications (user_id, user_type, type, title, message, link, status, data, created_at) 
                VALUES (?, 'employer', 'program', ?, ?, ?, 'unread', ?, NOW())
            ");

            $data = json_encode([
                'event_id' => $eventId,
                'event_title' => $event['title'],
                'event_type' => $event['type'],
                'event_date' => $event['time_start'],
                'target_user_type' => 'employer'
            ]);

            $notificationCount = 0;
            foreach ($employers as $employer) {
                $result = $insertStmt->execute([
                    $employer['user_id'],
                    $title,
                    $message,
                    $link,
                    $data
                ]);

                if ($result) {
                    $notificationCount++;
                    error_log("✅ Employer Notification: Inserted for user_id {$employer['user_id']} ({$employer['first_name']} {$employer['last_name']})");
                } else {
                    error_log("❌ Employer Notification: Failed to insert for user_id {$employer['user_id']}");
                }
            }

            error_log("✅ Sent $notificationCount program notifications to EMPLOYERS for event ID: $eventId");
            return true;
        } catch (Exception $e) {
            error_log("❌ Error notifying employers about new program: " . $e->getMessage());
            return false;
        }
    }

    // Update other notification methods to include user_type
    public function getUserNotifications($userId, $limit = 15, $offset = 0)
    {
        try {
            // FIXED: Get user type from session or determine from user_id
            $userType = $this->determineUserType($userId);

            $sql = "SELECT notification_id, type, title, message, link, status, data, created_at
                    FROM notifications
                    WHERE user_id = ? AND user_type = ?
                    ORDER BY created_at DESC
                    LIMIT ? OFFSET ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(1, $userId, PDO::PARAM_INT);
            $stmt->bindValue(2, $userType, PDO::PARAM_STR);
            $stmt->bindValue(3, $limit, PDO::PARAM_INT);
            $stmt->bindValue(4, $offset, PDO::PARAM_INT);
            $stmt->execute();

            $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

            error_log("🔍 NotificationService: Returning " . count($notifications) . " notifications for user $userId (type: $userType)");
            if (!empty($notifications)) {
                error_log("📋 First notification: " . json_encode($notifications[0]));
            }

            return $notifications;
        } catch (Exception $e) {
            error_log("❌ Error getting user notifications: " . $e->getMessage());
            return [];
        }
    }

    public function getUnreadCount($userId)
    {
        try {
            $userType = $this->determineUserType($userId);

            $sql = "SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND user_type = ? AND status = 'unread'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$userId, $userType]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$result['count'];
        } catch (Exception $e) {
            error_log("❌ Error getting unread count: " . $e->getMessage());
            return 0;
        }
    }

    private function determineUserType($userId)
    {
        try {
            // Check if user is a jobseeker
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM jobseeker WHERE user_id = ?");
            $stmt->execute([$userId]);
            $jobseekerCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            if ($jobseekerCount > 0) {
                return 'jobseeker';
            }

            // Check if user is an employer
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM employer WHERE user_id = ?");
            $stmt->execute([$userId]);
            $employerCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            if ($employerCount > 0) {
                return 'employer';
            }

            // Check if user is an admin
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM admin WHERE user_id = ?");
            $stmt->execute([$userId]);
            $adminCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            if ($adminCount > 0) {
                return 'admin';
            }

            // Default to jobseeker if none found
            error_log("⚠️ Could not determine user type for user_id: $userId, defaulting to jobseeker");
            return 'jobseeker';
        } catch (Exception $e) {
            error_log("❌ Error determining user type: " . $e->getMessage());
            return 'jobseeker';
        }
    }

    /**
     * Mark a specific notification as read
     */
    public function markAsRead($notificationId, $userId = null)
    {
        try {
            if ($userId) {
                // Verify the notification belongs to this user and get user type
                $userType = $this->determineUserType($userId);
                $sql = "UPDATE notifications 
                        SET status = 'read', updated_at = NOW() 
                        WHERE notification_id = ? AND user_id = ? AND user_type = ?";
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute([$notificationId, $userId, $userType]);

                error_log("🔍 NotificationService: Marked notification $notificationId as read for user $userId (type: $userType)");
                return $result;
            } else {
                // Just mark by notification ID (less secure)
                $sql = "UPDATE notifications SET status = 'read', updated_at = NOW() WHERE notification_id = ?";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([$notificationId]);
            }
        } catch (Exception $e) {
            error_log("❌ Error marking notification as read: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead($userId)
    {
        try {
            $userType = $this->determineUserType($userId);
            $sql = "UPDATE notifications 
                    SET status = 'read', updated_at = NOW() 
                    WHERE user_id = ? AND user_type = ? AND status = 'unread'";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$userId, $userType]);

            error_log("🔍 NotificationService: Marked all notifications as read for user $userId (type: $userType)");
            return $result;
        } catch (Exception $e) {
            error_log("❌ Error marking all notifications as read: " . $e->getMessage());
            return false;
        }
    }
}
