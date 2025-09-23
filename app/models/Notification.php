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
            error_log("🔍 DEBUG Notification::create() called:");
            error_log("   - user_id: $userId");
            error_log("   - user_type: $userType");
            error_log("   - type: $type");
            error_log("   - title: $title");
            error_log("   - message: $message");
            error_log("   - link: $link");
            error_log("   - data: " . ($data ? json_encode($data) : 'null'));

            $stmt = $this->db->prepare("
                INSERT INTO notifications (user_id, user_type, type, title, message, link, data, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
            ");

            $dataJson = $data ? json_encode($data) : null;

            error_log("🔍 DEBUG: About to execute SQL INSERT");
            error_log("   - SQL: INSERT INTO notifications (user_id, user_type, type, title, message, link, data, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            error_log("   - Parameters: " . json_encode([$userId, $userType, $type, $title, $message, $link, $dataJson]));

            $result = $stmt->execute([$userId, $userType, $type, $title, $message, $link, $dataJson]);

            if ($result) {
                $notificationId = $this->db->lastInsertId();
                error_log("✅ DEBUG Notification::create() SUCCESS: Inserted notification ID: $notificationId");
            } else {
                error_log("❌ DEBUG Notification::create() FAILED");
                error_log("   - Error Info: " . json_encode($stmt->errorInfo()));
            }

            return $result;
        } catch (Exception $e) {
            error_log("❌ Error creating notification: " . $e->getMessage());
            error_log("❌ Stack trace: " . $e->getTraceAsString());

            // Additional database error info
            if (isset($stmt)) {
                error_log("❌ SQL Error Info: " . json_encode($stmt->errorInfo()));
            }

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
            // Check if user is an admin first
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM admin WHERE user_id = ?");
            $stmt->execute([$userId]);
            $adminCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            if ($adminCount > 0) {
                return 'admin';
            }

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

            // Default to admin if none found (fallback for admin session)
            error_log("⚠️ Could not determine user type for user_id: $userId, defaulting to admin");
            return 'admin';
        } catch (Exception $e) {
            error_log("❌ Error determining user type: " . $e->getMessage());
            return 'admin';
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
     * Get all active admins for notifications
     */
    public function getActiveAdmins()
    {
        try {
            $stmt = $this->db->prepare("
                SELECT a.user_id, a.admin_id, a.admin_name, u.email
                FROM admin a
                INNER JOIN users u ON a.user_id = u.user_id 
                WHERE u.status = 'active'
                ORDER BY a.user_id
            ");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // DEBUG: Log the admins we found
            error_log("🔍 DEBUG getActiveAdmins: Found " . count($results) . " active admins:");
            foreach ($results as $admin) {
                error_log("   - Admin ID: {$admin['admin_id']}, User ID: {$admin['user_id']}, Name: {$admin['admin_name']}, Email: {$admin['email']}");
            }

            return $results;
        } catch (Exception $e) {
            error_log("❌ Error getting active admins: " . $e->getMessage());
            error_log("❌ SQL Error: " . print_r($this->db->errorInfo(), true));
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
     * Get employer details by employer_id and job_id (for job application notifications)
     */
    public function getEmployerByJobPost($employerId, $jobId)
    {
        try {
            error_log("🔍 DEBUG: Getting employer details for employer_id: $employerId, job_id: $jobId");

            $stmt = $this->db->prepare("
                SELECT 
                    u.user_id, 
                    u.email, 
                    e.employer_id,
                    e.first_name,
                    e.last_name,
                    jp.job_title,
                    COALESCE(eb.business_name, CONCAT(e.first_name, ' ', e.last_name)) as company_name
                FROM employer e
                JOIN users u ON e.user_id = u.user_id
                LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                JOIN job_post jp ON e.employer_id = jp.employer_id
                WHERE e.employer_id = ? 
                AND jp.job_id = ? 
                AND u.status = 'active'
                LIMIT 1
            ");
            $stmt->execute([$employerId, $jobId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            error_log("🔍 DEBUG: Employer lookup query result: " . json_encode($result));

            return $result;
        } catch (Exception $e) {
            error_log("❌ Error getting employer by job post: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Verify notification was inserted (for debugging)
     */
    public function getLatestNotification($userId, $type)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT notification_id, title, message, created_at 
                FROM notifications 
                WHERE user_id = ? AND type = ?
                ORDER BY created_at DESC 
                LIMIT 1
            ");
            $stmt->execute([$userId, $type]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("❌ Error getting latest notification: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Debug employer tables (for troubleshooting)
     */
    public function debugEmployerData($employerId, $jobId = null)
    {
        try {
            $debug = [];

            // Check employer table
            $stmt = $this->db->prepare("SELECT * FROM employer WHERE employer_id = ?");
            $stmt->execute([$employerId]);
            $debug['employer'] = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($jobId) {
                // Check job_post table
                $stmt = $this->db->prepare("SELECT * FROM job_post WHERE job_id = ? AND employer_id = ?");
                $stmt->execute([$jobId, $employerId]);
                $debug['job_post'] = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            // Check users table
            if ($debug['employer']) {
                $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ?");
                $stmt->execute([$debug['employer']['user_id']]);
                $debug['user'] = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            return $debug;
        } catch (Exception $e) {
            error_log("❌ Error debugging employer data: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get jobseeker details for application notifications
     */
    public function getJobseekerDetails($applicationId)
    {
        try {
            error_log("🔍 DEBUG: Getting jobseeker details for application_id: $applicationId");

            $stmt = $this->db->prepare("
                SELECT 
                    js.jobseeker_id,
                    js.user_id,
                    js.first_name,
                    js.last_name,
                    u.email,
                    u.status as user_status
                FROM job_application ja
                JOIN jobseeker js ON ja.jobseeker_id = js.jobseeker_id
                JOIN users u ON js.user_id = u.user_id
                WHERE ja.application_id = ? AND u.status = 'active'
            ");
            $stmt->execute([$applicationId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            error_log("🔍 DEBUG: Jobseeker details query result: " . json_encode($result));

            return $result;
        } catch (Exception $e) {
            error_log("❌ Error getting jobseeker details for application: " . $e->getMessage());
            return null;
        }
    }
}
