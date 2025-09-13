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
            // Get employer details from model
            $employer = $this->notification->getEmployerDetails($employerId, $jobId);

            if ($employer) {
                $title = "New Job Application";
                $message = "{$jobseekerName} applied for {$employer['job_title']} position";
                $link = "?page=manage-applications&job_id={$jobId}";

                $data = [
                    'application_id' => $applicationId,
                    'job_id' => $jobId,
                    'applicant_name' => $jobseekerName
                ];

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

                if ($result) {
                    error_log("✅ Application notification created for employer user_id: {$employer['user_id']}");
                }
            }

            return true;
        } catch (Exception $e) {
            error_log("❌ Error notifying job application: " . $e->getMessage());
            return false;
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
