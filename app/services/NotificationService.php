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

    public function getUserNotifications($userId, $limit = 15, $offset = 0)
    {
        $userType = $this->notification->determineUserType($userId);
        $notifications = $this->notification->getUserNotifications($userId, $userType, $limit, $offset);

        return $notifications;
    }

    public function getUnreadCount($userId)
    {
        $userType = $this->notification->determineUserType($userId);
        return $this->notification->getUnreadCount($userId, $userType);
    }

    public function markAsRead($notificationId, $userId)
    {
        $userType = $this->notification->determineUserType($userId);
        $result = $this->notification->markAsRead($notificationId, $userId, $userType);

        return $result;
    }

    public function markAllAsRead($userId)
    {
        $userType = $this->notification->determineUserType($userId);
        $result = $this->notification->markAllAsRead($userId, $userType);

        return $result;
    }

    public function notifyJobPosted($jobId, $jobTitle, $companyName, $location = '')
    {
        try {
            // Get all active jobseekers from model
            $jobseekers = $this->notification->getActiveJobseekers();

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
                }
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function notifyJobApplication($applicationId, $jobId, $employerId, $jobseekerName)
    {
        try {
            // Get employer details from model
            $employer = $this->notification->getEmployerByJobPost($employerId, $jobId);

            if (!$employer) {
                return false;
            }

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

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function notifyApplicationStatusUpdate($applicationId, $newStatus, $jobTitle, $companyName, $remarks = null)
    {
        try {
            // Get jobseeker details from model
            $jobseeker = $this->notification->getJobseekerDetails($applicationId);

            if (!$jobseeker) {
                return false;
            }

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

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function notifyJobseekersAboutNewProgram(int $eventId): bool
    {
        try {
            // Get event details from model
            $event = $this->notification->getEventDetails($eventId);

            if (!$event) {
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

            if (empty($jobseekers)) {
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
                }
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function notifyEmployersAboutNewProgram(int $eventId): bool
    {
        try {
            // Get event details from model
            $event = $this->notification->getEventDetails($eventId);

            if (!$event) {
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
                }
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function notifyInterviewScheduled($applicationId, $jobTitle, $companyName, $interviewDateTime, $location, $notes = null)
    {
        try {
            // Get jobseeker details from model
            $jobseeker = $this->notification->getJobseekerDetails($applicationId);

            if (!$jobseeker) {
                return false;
            }

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

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function notifyResignationStatusUpdate($resignationId, $newStatus, $employerNotes = null)
    {
        try {

            // Get resignation request details from model
            $resignationDetails = $this->notification->getResignationRequestDetails($resignationId);

            if (!$resignationDetails) {
                return false;
            }

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

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function notifyEmployerAboutResignation($applicationId, $resignationId, $jobseekerName, $jobTitle, $companyName, $resignationReason = null)
    {
        try {
            // Get application details to find the employer
            $applicationDetails = $this->getApplicationDetailsForResignation($applicationId);

            if (!$applicationDetails) {
                return false;
            }

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

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    private function getApplicationDetailsForResignation($applicationId)
    {
        try {
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

            return $result;
        } catch (Exception $e) {
            return null;
        }
    }
    public function notifyAdminsAboutNewAccreditation($accreditationId, $employerName, $businessName, $businessType = null)
    {
        try {
            // Get accreditation details for notification
            $accreditationDetails = $this->getAccreditationDetailsForNotification($accreditationId);

            if (!$accreditationDetails) {
                return false;
            }

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

            if (empty($admins)) {
                return true;
            }

            $notificationCount = 0;
            foreach ($admins as $admin) {
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
                }
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function getAccreditationDetailsForNotification($accreditationId)
    {
        try {
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

            return $result;
        } catch (Exception $e) {
            return null;
        }
    }

    public function notifyEmployerAboutAccreditationUpdate($accreditationId, $newStatus, $adminNotes = null)
    {
        try {
            // Get accreditation details from model
            $accreditationDetails = $this->getAccreditationDetailsForEmployerNotification($accreditationId);

            if (!$accreditationDetails) {
                return false;
            }

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

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    private function getAccreditationDetailsForEmployerNotification($accreditationId)
    {
        try {
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

            return $result;
        } catch (Exception $e) {
            return null;
        }
    }
}
