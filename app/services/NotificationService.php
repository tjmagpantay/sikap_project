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

    /**
     * Get user notifications - delegates to model
     */
    public function getUserNotifications($userId, $limit = 15, $offset = 0)
    {
        $userType = $this->notification->determineUserType($userId);
        $notifications = $this->notification->getUserNotifications($userId, $userType, $limit, $offset);

        error_log("🔍 NotificationService: Returning " . count($notifications) . " notifications for user $userId (type: $userType)");
        if (!empty($notifications)) {
            error_log("📋 First notification: " . json_encode($notifications[0]));
        }

        return $notifications;
    }

    /**
     * Get unread count - delegates to model
     */
    public function getUnreadCount($userId)
    {
        $userType = $this->notification->determineUserType($userId);
        return $this->notification->getUnreadCount($userId, $userType);
    }

    /**
     * Mark notification as read - delegates to model
     */
    public function markAsRead($notificationId, $userId)
    {
        $userType = $this->notification->determineUserType($userId);
        $result = $this->notification->markAsRead($notificationId, $userId, $userType);

        if ($result) {
            error_log("🔍 NotificationService: Marked notification $notificationId as read for user $userId (type: $userType)");
        }

        return $result;
    }

    /**
     * Mark all notifications as read - delegates to model
     */
    public function markAllAsRead($userId)
    {
        $userType = $this->notification->determineUserType($userId);
        $result = $this->notification->markAllAsRead($userId, $userType);

        if ($result) {
            error_log("🔍 NotificationService: Marked all notifications as read for user $userId (type: $userType)");
        }

        return $result;
    }

    /**
     * Notify all jobseekers about new job post
     */
    public function notifyJobPosted($jobId, $jobTitle, $companyName, $location = '')
    {
        try {
            // Get all active jobseekers from model
            $jobseekers = $this->notification->getActiveJobseekers();

            error_log("🔍 Job Notification: Found " . count($jobseekers) . " jobseekers to notify about job $jobId");

            if (empty($jobseekers)) {
                error_log("ℹ️ No active jobseekers found to notify about job");
                return true;
            }

            $title = "New Job Available: {$jobTitle}";
            $message = "New {$jobTitle} position at {$companyName}" . ($location ? " in {$location}" : "") . ". Apply now!";
            $link = "?page=job-details&job_id={$jobId}";

            $data = [
                'job_id' => $jobId,
                'job_title' => $jobTitle,
                'company_name' => $companyName,
                'location' => $location
            ];

            $notificationCount = 0;
            foreach ($jobseekers as $jobseeker) {
                // Use the notification model's create method with user_type
                $result = $this->notification->create(
                    $jobseeker['user_id'],
                    'jobseeker',
                    'job_post',
                    $title,
                    $message,
                    $link,
                    $data
                );

                if ($result) {
                    $notificationCount++;
                    error_log("✅ Job Notification: Created for user_id {$jobseeker['user_id']} ({$jobseeker['first_name']} {$jobseeker['last_name']})");
                } else {
                    error_log("❌ Job Notification: Failed to create for user_id {$jobseeker['user_id']}");
                }
            }

            error_log("✅ Sent $notificationCount job notifications to jobseekers for job ID: $jobId");
            return true;
        } catch (Exception $e) {
            error_log("❌ Error notifying job posted: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Notify employer about new job application
     */
    public function notifyJobApplication($applicationId, $jobId, $employerId, $jobseekerName)
    {
        try {
            error_log("🔍 DEBUG notifyJobApplication: Starting notification process");
            error_log("   - Application ID: $applicationId");
            error_log("   - Job ID: $jobId");
            error_log("   - Employer ID: $employerId");
            error_log("   - Jobseeker Name: $jobseekerName");

            // Get employer details from model - FIXED to use employer_id correctly
            error_log("🔍 DEBUG: Getting employer details");
            $employer = $this->getEmployerDetailsByEmployerId($employerId, $jobId);

            if (!$employer) {
                error_log("❌ Job Application Notification: Could not find employer details for employer_id: $employerId, job_id: $jobId");

                // ADDITIONAL DEBUG: Let's check what's in the database
                $this->debugEmployerTables($employerId, $jobId);

                return false;
            }

            error_log("✅ DEBUG: Found employer details: " . json_encode($employer));

            $title = "New Job Application";
            $message = "{$jobseekerName} applied for {$employer['job_title']} position at your company.";
            $link = "?page=review-application&application_id={$applicationId}";

            $data = [
                'application_id' => $applicationId,
                'job_id' => $jobId,
                'employer_id' => $employerId,
                'applicant_name' => $jobseekerName,
                'job_title' => $employer['job_title']
            ];

            error_log("🔍 DEBUG: Creating notification");
            error_log("   - Title: $title");
            error_log("   - Message: $message");
            error_log("   - Link: $link");
            error_log("   - Target user_id: {$employer['user_id']}");
            error_log("   - Data: " . json_encode($data));

            // Use the notification model's create method
            $result = $this->notification->create(
                $employer['user_id'],
                'employer',
                'job_application',
                $title,
                $message,
                $link,
                $data
            );

            error_log("🔔 DEBUG: Notification create() returned: " . ($result ? 'TRUE' : 'FALSE'));

            if ($result) {
                error_log("✅ Job Application notification created for employer user_id: {$employer['user_id']} (employer_id: $employerId)");

                // VERIFY: Check if it was actually inserted
                $this->verifyNotificationInserted($employer['user_id'], $applicationId);
            } else {
                error_log("❌ Failed to create job application notification for employer user_id: {$employer['user_id']}");
            }

            return $result;
        } catch (Exception $e) {
            error_log("❌ Error notifying job application: " . $e->getMessage());
            error_log("❌ Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Debug method to check employer tables
     */
    private function debugEmployerTables($employerId, $jobId)
    {
        try {
            error_log("🔍 DEBUG: Checking employer tables for employer_id: $employerId, job_id: $jobId");

            // Check employer table
            $stmt = $this->db->prepare("SELECT * FROM employer WHERE employer_id = ?");
            $stmt->execute([$employerId]);
            $employer = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log("🔍 DEBUG: Employer record: " . json_encode($employer));

            // Check job_post table
            $stmt = $this->db->prepare("SELECT * FROM job_post WHERE job_id = ? AND employer_id = ?");
            $stmt->execute([$jobId, $employerId]);
            $job = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log("🔍 DEBUG: Job post record: " . json_encode($job));

            // Check users table
            if ($employer) {
                $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ?");
                $stmt->execute([$employer['user_id']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                error_log("🔍 DEBUG: User record: " . json_encode($user));
            }
        } catch (Exception $e) {
            error_log("❌ Error debugging employer tables: " . $e->getMessage());
        }
    }

    /**
     * Verify notification was inserted
     */
    private function verifyNotificationInserted($userId, $applicationId)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT notification_id, title, message, created_at 
                FROM notifications 
                WHERE user_id = ? AND type = 'job_application'
                ORDER BY created_at DESC 
                LIMIT 1
            ");
            $stmt->execute([$userId]);
            $notification = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($notification) {
                error_log("✅ VERIFIED: Notification inserted with ID: {$notification['notification_id']}");
                error_log("   - Title: {$notification['title']}");
                error_log("   - Created: {$notification['created_at']}");
            } else {
                error_log("❌ VERIFICATION FAILED: No notification found in database for user_id: $userId");
            }
        } catch (Exception $e) {
            error_log("❌ Error verifying notification: " . $e->getMessage());
        }
    }

    /**
     * Get employer details by employer_id for job application notifications
     */
    private function getEmployerDetailsByEmployerId($employerId, $jobId)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT u.user_id, u.email, 
                       COALESCE(eb.business_name, CONCAT(e.first_name, ' ', e.last_name)) as company_name,
                       jp.job_title,
                       e.employer_id,
                       e.first_name,
                       e.last_name
                FROM employer e
                JOIN users u ON e.user_id = u.user_id
                LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                JOIN job_post jp ON e.employer_id = jp.employer_id
                WHERE e.employer_id = ? AND jp.job_id = ? AND u.status = 'active'
            ");
            $stmt->execute([$employerId, $jobId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            error_log("🔍 DEBUG: Employer lookup query result: " . json_encode($result));

            return $result;
        } catch (Exception $e) {
            error_log("Error getting employer details by employer_id: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Notify jobseeker about application status update
     */
    public function notifyApplicationStatusUpdate($applicationId, $newStatus, $jobTitle, $companyName)
    {
        try {
            // Get jobseeker details from model
            $jobseeker = $this->notification->getJobseekerDetails($applicationId);

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

                $data = [
                    'application_id' => $applicationId,
                    'status' => $newStatus,
                    'job_title' => $jobTitle,
                    'company_name' => $companyName
                ];

                // Use the notification model's create method
                $result = $this->notification->create(
                    $jobseeker['user_id'],
                    'jobseeker',
                    'application_update',
                    $title,
                    $message,
                    $link,
                    $data
                );

                if ($result) {
                    error_log("✅ Status update notification created for jobseeker user_id: {$jobseeker['user_id']}");
                }
            }

            return true;
        } catch (Exception $e) {
            error_log("❌ Error notifying application status update: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Notify jobseekers about new program/event posted by admin
     */
    public function notifyJobseekersAboutNewProgram(int $eventId): bool
    {
        try {
            // Get event details from model
            $event = $this->notification->getEventDetails($eventId);

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

            // Get all active jobseekers from model
            $jobseekers = $this->notification->getActiveJobseekers();

            error_log("🔍 Jobseeker Notification: Found " . count($jobseekers) . " jobseekers to notify about event $eventId");

            if (empty($jobseekers)) {
                error_log("ℹ️ No active jobseekers found to notify about program");
                return true;
            }

            $data = [
                'event_id' => $eventId,
                'event_title' => $event['title'],
                'event_type' => $event['type'],
                'event_date' => $event['time_start'],
                'target_user_type' => 'jobseeker'
            ];

            $notificationCount = 0;
            foreach ($jobseekers as $jobseeker) {
                // Use the notification model's create method
                $result = $this->notification->create(
                    $jobseeker['user_id'],
                    'jobseeker',
                    'program',
                    $title,
                    $message,
                    $link,
                    $data
                );

                if ($result) {
                    $notificationCount++;
                    error_log("✅ Jobseeker Notification: Created for user_id {$jobseeker['user_id']} ({$jobseeker['first_name']} {$jobseeker['last_name']})");
                } else {
                    error_log("❌ Jobseeker Notification: Failed to create for user_id {$jobseeker['user_id']}");
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
            // Get event details from model
            $event = $this->notification->getEventDetails($eventId);

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

            // Get all active verified employers from model
            $employers = $this->notification->getActiveEmployers();

            error_log("🔍 Employer Notification: Found " . count($employers) . " verified employers to notify about event $eventId");

            if (empty($employers)) {
                return true;
            }

            $data = [
                'event_id' => $eventId,
                'event_title' => $event['title'],
                'event_type' => $event['type'],
                'event_date' => $event['time_start'],
                'target_user_type' => 'employer'
            ];

            $notificationCount = 0;
            foreach ($employers as $employer) {
                // Use the notification model's create method
                $result = $this->notification->create(
                    $employer['user_id'],
                    'employer',
                    'program',
                    $title,
                    $message,
                    $link,
                    $data
                );

                if ($result) {
                    $notificationCount++;
                    error_log("✅ Employer Notification: Created for user_id {$employer['user_id']}");
                }
            }

            error_log("✅ Sent $notificationCount program notifications to EMPLOYERS for event ID: $eventId");
            return true;
        } catch (Exception $e) {
            error_log("❌ Error notifying employers about new program: " . $e->getMessage());
            return false;
        }
    }
}
