<?php
// filepath: c:\xampp\htdocs\sikap\app\models\Notification.php
class Notification
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    /**
     * Create a new notification
     */
    public function create($userId, $userType, $type, $title, $message, $link = null, $data = null)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO notifications (user_id, user_type, type, title, message, link, data, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
            ");

            $dataJson = $data ? json_encode($data) : null;
            return $stmt->execute([$userId, $userType, $type, $title, $message, $link, $dataJson]);
        } catch (Exception $e) {
            error_log("Error creating notification: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user notifications with user_type filtering
     */
    public function getUserNotifications($userId, $userType, $limit = 15, $offset = 0)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT notification_id, type, title, message, link, status, data, created_at
                FROM notifications 
                WHERE user_id = ? AND user_type = ?
                ORDER BY created_at DESC 
                LIMIT ? OFFSET ?
            ");
            $stmt->bindValue(1, $userId, PDO::PARAM_INT);
            $stmt->bindValue(2, $userType, PDO::PARAM_STR);
            $stmt->bindValue(3, $limit, PDO::PARAM_INT);
            $stmt->bindValue(4, $offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (Exception $e) {
            error_log("Error fetching notifications: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get unread count for specific user and user_type
     */
    public function getUnreadCount($userId, $userType)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) as count FROM notifications 
                WHERE user_id = ? AND user_type = ? AND status = 'unread'
            ");
            $stmt->execute([$userId, $userType]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($result['count'] ?? 0);
        } catch (Exception $e) {
            error_log("Error getting unread count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($notificationId, $userId, $userType)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE notifications 
                SET status = 'read', updated_at = NOW() 
                WHERE notification_id = ? AND user_id = ? AND user_type = ?
            ");
            return $stmt->execute([$notificationId, $userId, $userType]);
        } catch (Exception $e) {
            error_log("Error marking notification as read: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead($userId, $userType)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE notifications 
                SET status = 'read', updated_at = NOW() 
                WHERE user_id = ? AND user_type = ? AND status = 'unread'
            ");
            return $stmt->execute([$userId, $userType]);
        } catch (Exception $e) {
            error_log("Error marking all notifications as read: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a notification
     */
    public function delete($notificationId, $userId, $userType)
    {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM notifications 
                WHERE notification_id = ? AND user_id = ? AND user_type = ?
            ");
            return $stmt->execute([$notificationId, $userId, $userType]);
        } catch (Exception $e) {
            error_log("Error deleting notification: " . $e->getMessage());
            return false;
        }
    }

    /**
     * FIXED: Add the missing determineUserType method
     */
    public function determineUserType($userId)
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
     * Get all active jobseekers for notifications
     */
    public function getActiveJobseekers()
    {
        try {
            // FIXED: Simplified query to get ALL active jobseekers
            $stmt = $this->db->prepare("
                SELECT j.user_id, j.jobseeker_id, j.first_name, j.last_name, u.email
                FROM jobseeker j
                INNER JOIN users u ON j.user_id = u.user_id 
                WHERE u.status = 'active'
                ORDER BY j.user_id
            ");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // DEBUG: Log the jobseekers we found
            error_log("🔍 DEBUG getActiveJobseekers: Found " . count($results) . " active jobseekers:");
            foreach ($results as $jobseeker) {
                error_log("   - Jobseeker ID: {$jobseeker['jobseeker_id']}, User ID: {$jobseeker['user_id']}, Name: {$jobseeker['first_name']} {$jobseeker['last_name']}, Email: {$jobseeker['email']}");
            }

            return $results;
        } catch (Exception $e) {
            error_log("❌ Error getting active jobseekers: " . $e->getMessage());
            error_log("❌ SQL Error: " . print_r($this->db->errorInfo(), true));
            return [];
        }
    }

    /**
     * Get all active verified employers for notifications
     */
    public function getActiveEmployers()
    {
        try {
            $stmt = $this->db->prepare("
                SELECT e.user_id, e.first_name, e.last_name, u.email
                FROM employer e
                INNER JOIN users u ON e.user_id = u.user_id 
                WHERE u.status = 'active' 
                AND e.status = 'verified'
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting active employers: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get event details for notifications
     */
    public function getEventDetails($eventId)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT title, description, type, time_start, status
                FROM events 
                WHERE event_id = ? AND status = 'show'
            ");
            $stmt->execute([$eventId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting event details: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get employer details for job application notifications
     */
    public function getEmployerDetails($employerId, $jobId)
    {
        try {
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
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting employer details: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get jobseeker details for application status notifications
     */
    public function getJobseekerDetails($applicationId)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT u.user_id, u.email, j.first_name, j.last_name
                FROM users u
                JOIN jobseeker j ON u.user_id = j.user_id
                JOIN job_application ja ON j.jobseeker_id = ja.jobseeker_id
                WHERE ja.application_id = ?
            ");
            $stmt->execute([$applicationId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting jobseeker details: " . $e->getMessage());
            return null;
        }
    }
}
