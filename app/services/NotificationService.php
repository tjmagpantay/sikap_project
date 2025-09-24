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

            // FIXED: Get employer details from model (following MVC)
            $employer = $this->notification->getEmployerByJobPost($employerId, $jobId);

            if (!$employer) {
                error_log("❌ Job Application Notification: Could not find employer details for employer_id: $employerId, job_id: $jobId");

                // FIXED: Use model method for debugging
                $debugData = $this->notification->debugEmployerData($employerId, $jobId);
                error_log("🔍 DEBUG: Employer debug data: " . json_encode($debugData));

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
                error_log("✅ Job Application notification created for employer user_id: {$employer['user_id']} (employer_id: $employerId)");

                // FIXED: Use model method for verification
                $verification = $this->notification->getLatestNotification($employer['user_id'], 'job_application');
                if ($verification) {
                    error_log("✅ VERIFIED: Notification inserted with ID: {$verification['notification_id']}");
                }
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
     * Notify jobseeker about application status update
     */
    public function notifyApplicationStatusUpdate($applicationId, $newStatus, $jobTitle, $companyName, $remarks = null)
    {
        try {
            error_log("🔍 DEBUG notifyApplicationStatusUpdate: Starting notification process");
            error_log("   - Application ID: $applicationId");
            error_log("   - New Status: $newStatus");
            error_log("   - Job Title: $jobTitle");
            error_log("   - Company: $companyName");
            error_log("   - Remarks: " . ($remarks ?: 'None'));

            // Get jobseeker details from model
            $jobseeker = $this->notification->getJobseekerDetails($applicationId);

            if (!$jobseeker) {
                error_log("❌ Status Update Notification: Could not find jobseeker details for application_id: $applicationId");
                return false;
            }

            error_log("✅ DEBUG: Found jobseeker details: " . json_encode($jobseeker));

            // Create status-specific messages
            $statusMessages = [
                'pending' => [
                    'title' => 'Application Under Review',
                    'message' => "Your application for {$jobTitle} at {$companyName} is being reviewed by the employer."
                ],
                'reviewed' => [
                    'title' => 'Application Reviewed',
                    'message' => "Your application for {$jobTitle} at {$companyName} has been reviewed by the employer."
                ],
                'shortlisted' => [
                    'title' => 'Congratulations! You\'ve Been Shortlisted',
                    'message' => "Great news! You have been shortlisted for {$jobTitle} at {$companyName}. Expect to hear from them soon!"
                ],
                'rejected' => [
                    'title' => 'Application Status Update',
                    'message' => "Thank you for your interest in {$jobTitle} at {$companyName}. Unfortunately, we have decided not to move forward with your application at this time."
                ],
                'hired' => [
                    'title' => 'Congratulations! You\'ve Been Hired',
                    'message' => "Congratulations! You have been hired for {$jobTitle} at {$companyName}. Welcome to the team!"
                ],
                'resigned' => [
                    'title' => 'Employment Status Updated',
                    'message' => "Your employment status for {$jobTitle} at {$companyName} has been updated to resigned."
                ]
            ];

            // Get the appropriate message for the status
            $statusInfo = $statusMessages[$newStatus] ?? [
                'title' => 'Application Status Update',
                'message' => "Your application status for {$jobTitle} at {$companyName} has been updated."
            ];

            $title = $statusInfo['title'];
            $message = $statusInfo['message'];

            // Add remarks if provided
            if (!empty($remarks)) {
                $message .= " Employer notes: " . $remarks;
            }

            $link = "?page=view-application&application_id={$applicationId}";

            $data = [
                'application_id' => $applicationId,
                'status' => $newStatus,
                'job_title' => $jobTitle,
                'company_name' => $companyName,
                'remarks' => $remarks,
                'notification_type' => 'status_update'
            ];

            error_log("🔍 DEBUG: Creating status update notification");
            error_log("   - Title: $title");
            error_log("   - Message: $message");
            error_log("   - Link: $link");
            error_log("   - Target user_id: {$jobseeker['user_id']}");
            error_log("   - Data: " . json_encode($data));

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

            error_log("🔔 DEBUG: Notification create() returned: " . ($result ? 'TRUE' : 'FALSE'));

            if ($result) {
                error_log("✅ Status update notification created for jobseeker user_id: {$jobseeker['user_id']} (application_id: $applicationId)");
            } else {
                error_log("❌ Failed to create status update notification for jobseeker user_id: {$jobseeker['user_id']}");
            }

            return $result;
        } catch (Exception $e) {
            error_log("❌ Error notifying application status update: " . $e->getMessage());
            error_log("❌ Stack trace: " . $e->getTraceAsString());
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

    /**
     * Notify jobseeker about interview scheduled
     */
    public function notifyInterviewScheduled($applicationId, $jobTitle, $companyName, $interviewDateTime, $location, $notes = null)
    {
        try {
            error_log("🔍 DEBUG notifyInterviewScheduled: Starting notification process");
            error_log("   - Application ID: $applicationId");
            error_log("   - Job Title: $jobTitle");
            error_log("   - Company: $companyName");
            error_log("   - Date/Time: $interviewDateTime");
            error_log("   - Location: $location");

            // Get jobseeker details from model
            $jobseeker = $this->notification->getJobseekerDetails($applicationId);

            if (!$jobseeker) {
                error_log("❌ Interview Notification: Could not find jobseeker details for application_id: $applicationId");
                return false;
            }

            error_log("✅ DEBUG: Found jobseeker details: " . json_encode($jobseeker));

            $title = "Interview Scheduled - {$jobTitle}";
            $message = "Your interview for {$jobTitle} at {$companyName} has been scheduled for {$interviewDateTime} at {$location}.";

            if (!empty($notes)) {
                $message .= " Additional notes: " . $notes;
            }

            $message .= " Please be prepared and arrive on time. Good luck!";

            // FIXED: Use the correct parameter name that matches your view-application page
            $link = "?page=view-application&application_id={$applicationId}";

            $data = [
                'application_id' => $applicationId,
                'job_title' => $jobTitle,
                'company_name' => $companyName,
                'interview_datetime' => $interviewDateTime,
                'interview_location' => $location,
                'notes' => $notes,
                'notification_type' => 'interview_scheduled'
            ];

            error_log("🔍 DEBUG: Creating interview notification");
            error_log("   - Title: $title");
            error_log("   - Message: $message");
            error_log("   - Link: $link");
            error_log("   - Target user_id: {$jobseeker['user_id']}");

            // Use the notification model's create method
            $result = $this->notification->create(
                $jobseeker['user_id'],
                'jobseeker',
                'interview',
                $title,
                $message,
                $link,
                $data
            );

            if ($result) {
                error_log("✅ Interview notification created for jobseeker user_id: {$jobseeker['user_id']} (application_id: $applicationId)");

                // ADDED: Verify the notification was actually inserted
                $verification = $this->notification->getLatestNotification($jobseeker['user_id'], 'interview');
                if ($verification) {
                    error_log("✅ VERIFIED: Interview notification inserted with ID: {$verification['notification_id']}");
                    error_log("   - Title: {$verification['title']}");
                    error_log("   - Created: {$verification['created_at']}");
                } else {
                    error_log("❌ VERIFICATION FAILED: Interview notification not found in database");
                }
            } else {
                error_log("❌ Failed to create interview notification for jobseeker user_id: {$jobseeker['user_id']}");
            }

            return $result;
        } catch (Exception $e) {
            error_log("❌ Error notifying interview scheduled: " . $e->getMessage());
            return false;
        }
    }
    public function notifyResignationStatusUpdate($resignationId, $newStatus, $employerNotes = null)
    {
        try {
            error_log("🔍 DEBUG notifyResignationStatusUpdate: Starting notification process");
            error_log("   - Resignation ID: $resignationId");
            error_log("   - New Status: $newStatus");
            error_log("   - Employer Notes: " . ($employerNotes ?: 'None'));

            // Get resignation request details from model
            $resignationDetails = $this->notification->getResignationRequestDetails($resignationId);

            if (!$resignationDetails) {
                error_log("❌ Resignation Status Notification: Could not find resignation details for resignation_id: $resignationId");
                return false;
            }

            error_log("✅ DEBUG: Found resignation details: " . json_encode($resignationDetails));

            // Create status-specific messages
            $statusMessages = [
                'pending' => [
                    'title' => 'Resignation Request Under Review',
                    'message' => "Your resignation request for {$resignationDetails['job_title']} at {$resignationDetails['company_name']} is being reviewed by your employer."
                ],
                'approved' => [
                    'title' => 'Resignation Request Approved',
                    'message' => "Your resignation request for {$resignationDetails['job_title']} at {$resignationDetails['company_name']} has been approved. Your employment status has been updated."
                ],
                'rejected' => [
                    'title' => 'Resignation Request Response',
                    'message' => "Your resignation request for {$resignationDetails['job_title']} at {$resignationDetails['company_name']} has been reviewed by your employer."
                ]
            ];

            // Get the appropriate message for the status
            $statusInfo = $statusMessages[$newStatus] ?? [
                'title' => 'Resignation Request Update',
                'message' => "Your resignation request status has been updated."
            ];

            $title = $statusInfo['title'];
            $message = $statusInfo['message'];

            // Add employer notes if provided
            if (!empty($employerNotes)) {
                $message .= " Employer notes: " . $employerNotes;
            }

            $link = "?page=view-application&application_id={$resignationDetails['application_id']}";

            $data = [
                'resignation_id' => $resignationId,
                'application_id' => $resignationDetails['application_id'],
                'status' => $newStatus,
                'job_title' => $resignationDetails['job_title'],
                'company_name' => $resignationDetails['company_name'],
                'employer_notes' => $employerNotes,
                'notification_type' => 'resignation_update'
            ];

            error_log("🔍 DEBUG: Creating resignation status notification");
            error_log("   - Title: $title");
            error_log("   - Message: $message");
            error_log("   - Link: $link");
            error_log("   - Target user_id: {$resignationDetails['jobseeker_user_id']}");
            error_log("   - Data: " . json_encode($data));

            // Use the notification model's create method
            $result = $this->notification->create(
                $resignationDetails['jobseeker_user_id'],
                'jobseeker',
                'resignation_update',
                $title,
                $message,
                $link,
                $data
            );

            error_log("🔔 DEBUG: Resignation notification create() returned: " . ($result ? 'TRUE' : 'FALSE'));

            if ($result) {
                error_log("✅ Resignation status notification created for jobseeker user_id: {$resignationDetails['jobseeker_user_id']} (resignation_id: $resignationId)");
            } else {
                error_log("❌ Failed to create resignation status notification for jobseeker user_id: {$resignationDetails['jobseeker_user_id']}");
            }

            return $result;
        } catch (Exception $e) {
            error_log("❌ Error notifying resignation status update: " . $e->getMessage());
            error_log("❌ Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
    public function notifyEmployerAboutResignation($applicationId, $resignationId, $jobseekerName, $jobTitle, $companyName, $resignationReason = null)
    {
        try {
            error_log("🔍 DEBUG notifyEmployerAboutResignation: Starting notification process");
            error_log("   - Application ID: $applicationId");
            error_log("   - Resignation ID: $resignationId");
            error_log("   - Jobseeker Name: $jobseekerName");
            error_log("   - Job Title: $jobTitle");
            error_log("   - Company Name: $companyName");

            // Get application details to find the employer
            $applicationDetails = $this->getApplicationDetailsForResignation($applicationId);

            if (!$applicationDetails) {
                error_log("❌ Resignation Notification: Could not find application details for application_id: $applicationId");
                return false;
            }

            error_log("✅ DEBUG: Found application details: " . json_encode($applicationDetails));

            $title = "Resignation Request Submitted";
            $message = "{$jobseekerName} has submitted a resignation request for the {$jobTitle} position at {$companyName}.";

            if (!empty($resignationReason)) {
                $message .= " Please review their request and provide a response.";
            }

            $link = "?page=review-application&application_id={$applicationId}";

            $data = [
                'resignation_id' => $resignationId,
                'application_id' => $applicationId,
                'jobseeker_name' => $jobseekerName,
                'job_title' => $jobTitle,
                'company_name' => $companyName,
                'resignation_reason' => $resignationReason,
                'notification_type' => 'resignation_request'
            ];

            error_log("🔍 DEBUG: Creating resignation request notification for employer");
            error_log("   - Title: $title");
            error_log("   - Message: $message");
            error_log("   - Link: $link");
            error_log("   - Target employer user_id: {$applicationDetails['employer_user_id']}");
            error_log("   - Data: " . json_encode($data));

            // Use the notification model's create method
            $result = $this->notification->create(
                $applicationDetails['employer_user_id'],
                'employer',
                'resignation_update', // Using same type as jobseeker notifications for consistency
                $title,
                $message,
                $link,
                $data
            );

            error_log("🔔 DEBUG: Resignation notification create() returned: " . ($result ? 'TRUE' : 'FALSE'));

            if ($result) {
                error_log("✅ Resignation request notification created for employer user_id: {$applicationDetails['employer_user_id']} (resignation_id: $resignationId)");
            } else {
                error_log("❌ Failed to create resignation request notification for employer user_id: {$applicationDetails['employer_user_id']}");
            }

            return $result;
        } catch (Exception $e) {
            error_log("❌ Error notifying employer about resignation: " . $e->getMessage());
            error_log("❌ Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Helper method to get application details for resignation notifications
     */
    private function getApplicationDetailsForResignation($applicationId)
    {
        try {
            error_log("🔍 DEBUG: Getting application details for resignation notification - application_id: $applicationId");

            $stmt = $this->db->prepare("
            SELECT 
                ja.application_id,
                ja.jobseeker_id,
                e.employer_id,
                e.user_id as employer_user_id,
                e.first_name as employer_first_name,
                e.last_name as employer_last_name,
                u.email as employer_email,
                jp.job_title,
                COALESCE(eb.business_name, e.company_name) as company_name
            FROM job_application ja
            JOIN job_post jp ON ja.job_id = jp.job_id
            JOIN employer e ON jp.employer_id = e.employer_id
            JOIN users u ON e.user_id = u.user_id
            LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
            WHERE ja.application_id = ? AND u.status = 'active'
        ");
            $stmt->execute([$applicationId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            error_log("🔍 DEBUG: Application resignation details query result: " . json_encode($result));

            return $result;
        } catch (Exception $e) {
            error_log("❌ Error getting application details for resignation: " . $e->getMessage());
            return null;
        }
    }
    public function notifyAdminsAboutNewAccreditation($accreditationId, $employerName, $businessName, $businessType = null)
    {
        try {
            error_log("🔍 DEBUG notifyAdminsAboutNewAccreditation: Starting notification process");
            error_log("   - Accreditation ID: $accreditationId");
            error_log("   - Employer Name: $employerName");
            error_log("   - Business Name: $businessName");
            error_log("   - Business Type: " . ($businessType ?: 'N/A'));

            // Get accreditation details for notification
            $accreditationDetails = $this->getAccreditationDetailsForNotification($accreditationId);

            if (!$accreditationDetails) {
                error_log("❌ Accreditation Notification: Could not find accreditation details for accreditation_id: $accreditationId");
                return false;
            }

            error_log("✅ DEBUG: Found accreditation details: " . json_encode($accreditationDetails));

            $title = "New Accreditation Request";
            $message = "{$employerName} from {$businessName}" . ($businessType ? " ({$businessType})" : "") . " has submitted an accreditation request and needs admin review.";

            $link = "?page=admin-review-accreditation&id={$accreditationId}";

            $data = [
                'accreditation_id' => $accreditationId,
                'employer_name' => $employerName,
                'business_name' => $businessName,
                'business_type' => $businessType,
                'employer_id' => $accreditationDetails['employer_id'],
                'notification_type' => 'accreditation_request'
            ];

            // Get all active admins from model
            $admins = $this->notification->getActiveAdmins();

            error_log("🔍 Admin Notification: Found " . count($admins) . " admins to notify about accreditation $accreditationId");

            if (empty($admins)) {
                error_log("ℹ️ No active admins found to notify about accreditation");
                return true;
            }

            $notificationCount = 0;
            foreach ($admins as $admin) {
                error_log("🔍 DEBUG: Creating accreditation notification for admin");
                error_log("   - Title: $title");
                error_log("   - Message: $message");
                error_log("   - Link: $link");
                error_log("   - Target admin user_id: {$admin['user_id']}");
                error_log("   - Data: " . json_encode($data));

                // Use the notification model's create method
                $result = $this->notification->create(
                    $admin['user_id'],
                    'admin',
                    'accreditation',
                    $title,
                    $message,
                    $link,
                    $data
                );

                if ($result) {
                    $notificationCount++;
                    error_log("✅ Accreditation notification created for admin user_id: {$admin['user_id']} ({$admin['admin_name']})");
                } else {
                    error_log("❌ Failed to create accreditation notification for admin user_id: {$admin['user_id']}");
                }
            }

            error_log("✅ Sent $notificationCount accreditation notifications to admins for accreditation ID: $accreditationId");
            return true;
        } catch (Exception $e) {
            error_log("❌ Error notifying admins about accreditation: " . $e->getMessage());
            error_log("❌ Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Helper method to get accreditation details for notifications
     */
    private function getAccreditationDetailsForNotification($accreditationId)
    {
        try {
            error_log("🔍 DEBUG: Getting accreditation details for notification - accreditation_id: $accreditationId");

            $stmt = $this->db->prepare("
            SELECT 
                a.accreditation_id,
                a.employer_id,
                a.status,
                a.created_at,
                e.first_name,
                e.last_name,
                e.company_name,
                e.contact_no,
                e.position,
                u.email,
                eb.business_name,
                eb.business_type,
                eb.business_industry
            FROM accreditation a
            JOIN employer e ON a.employer_id = e.employer_id
            JOIN users u ON e.user_id = u.user_id
            LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
            WHERE a.accreditation_id = ? AND u.status = 'active'
        ");
            $stmt->execute([$accreditationId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            error_log("🔍 DEBUG: Accreditation notification details query result: " . json_encode($result));

            return $result;
        } catch (Exception $e) {
            error_log("❌ Error getting accreditation details for notification: " . $e->getMessage());
            return null;
        }
    }

    public function notifyEmployerAboutAccreditationUpdate($accreditationId, $newStatus, $adminNotes = null)
{
    try {
        error_log("🔍 DEBUG notifyEmployerAboutAccreditationUpdate: Starting notification process");
        error_log("   - Accreditation ID: $accreditationId");
        error_log("   - New Status: $newStatus");
        error_log("   - Admin Notes: " . ($adminNotes ?: 'None'));

        // Get accreditation details from model
        $accreditationDetails = $this->getAccreditationDetailsForEmployerNotification($accreditationId);

        if (!$accreditationDetails) {
            error_log("❌ Employer Accreditation Notification: Could not find accreditation details for accreditation_id: $accreditationId");
            return false;
        }

        error_log("✅ DEBUG: Found accreditation details for employer: " . json_encode($accreditationDetails));

        // Create status-specific messages
        $statusMessages = [
            'pending' => [
                'title' => 'Accreditation Under Review',
                'message' => "Your accreditation request for {$accreditationDetails['business_name']} is being reviewed by our admin team."
            ],
            'approved' => [
                'title' => 'Accreditation Approved - Welcome!',
                'message' => "Congratulations! Your accreditation request for {$accreditationDetails['business_name']} has been approved. You can now post jobs and access all employer features."
            ],
            'rejected' => [
                'title' => 'Accreditation Status Update',
                'message' => "Your accreditation request for {$accreditationDetails['business_name']} has been reviewed. Please contact support if you need assistance."
            ]
        ];

        // Get the appropriate message for the status
        $statusInfo = $statusMessages[$newStatus] ?? [
            'title' => 'Accreditation Status Update',
            'message' => "Your accreditation request status has been updated."
        ];

        $title = $statusInfo['title'];
        $message = $statusInfo['message'];

        // Add admin notes if provided
        if (!empty($adminNotes)) {
            $message .= " Admin notes: " . $adminNotes;
        }

        $link = "?page=profile-employer";

        $data = [
            'accreditation_id' => $accreditationId,
            'status' => $newStatus,
            'business_name' => $accreditationDetails['business_name'],
            'admin_notes' => $adminNotes,
            'notification_type' => 'accreditation_status_update'
        ];

        error_log("🔍 DEBUG: Creating accreditation status notification for employer");
        error_log("   - Title: $title");
        error_log("   - Message: $message");
        error_log("   - Link: $link");
        error_log("   - Target employer user_id: {$accreditationDetails['employer_user_id']}");
        error_log("   - Data: " . json_encode($data));

        // Use the notification model's create method
        $result = $this->notification->create(
            $accreditationDetails['employer_user_id'],
            'employer',
            'accreditation',
            $title,
            $message,
            $link,
            $data
        );

        error_log("🔔 DEBUG: Employer accreditation notification create() returned: " . ($result ? 'TRUE' : 'FALSE'));

        if ($result) {
            error_log("✅ Accreditation status notification created for employer user_id: {$accreditationDetails['employer_user_id']} (accreditation_id: $accreditationId)");
        } else {
            error_log("❌ Failed to create accreditation status notification for employer user_id: {$accreditationDetails['employer_user_id']}");
        }

        return $result;
    } catch (Exception $e) {
        error_log("❌ Error notifying employer about accreditation update: " . $e->getMessage());
        error_log("❌ Stack trace: " . $e->getTraceAsString());
        return false;
    }
}

/**
 * Helper method to get accreditation details for employer notifications
 */
private function getAccreditationDetailsForEmployerNotification($accreditationId)
{
    try {
        error_log("🔍 DEBUG: Getting accreditation details for employer notification - accreditation_id: $accreditationId");

        $stmt = $this->db->prepare("
            SELECT 
                a.accreditation_id,
                a.employer_id,
                a.status,
                a.reviewed_at,
                a.notes,
                e.user_id as employer_user_id,
                e.first_name as employer_first_name,
                e.last_name as employer_last_name,
                u.email as employer_email,
                COALESCE(eb.business_name, e.company_name) as business_name,
                eb.business_type,
                eb.business_industry
            FROM accreditation a
            JOIN employer e ON a.employer_id = e.employer_id
            JOIN users u ON e.user_id = u.user_id
            LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
            WHERE a.accreditation_id = ? AND u.status = 'active'
        ");
        $stmt->execute([$accreditationId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        error_log("🔍 DEBUG: Employer accreditation details query result: " . json_encode($result));

        return $result;
    } catch (Exception $e) {
        error_log("❌ Error getting accreditation details for employer notification: " . $e->getMessage());
        return null;
    }
}
}
