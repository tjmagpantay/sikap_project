<?php
// filepath: c:\xampp\htdocs\sikap\app\models\Notification.php
class Notification
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function create($userId, $userType, $type, $title, $message, $link = null, $data = null)
    {
        try {


            $stmt = $this->db->prepare("
                INSERT INTO notifications (user_id, user_type, type, title, message, link, data, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
            ");

            $dataJson = $data ? json_encode($data) : null;

            $result = $stmt->execute([$userId, $userType, $type, $title, $message, $link, $dataJson]);

            return $result;
        } catch (Exception $e) {
            error_log("Error creating notification: " . $e->getMessage());

            return false;
        }
    }

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
            return 'admin';
        } catch (Exception $e) {
            error_log("Error determining user type: " . $e->getMessage());
            return 'admin';
        }
    }

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

            return $results;
        } catch (Exception $e) {
            error_log("Error getting active jobseekers: " . $e->getMessage());
            return [];
        }
    }

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


            return $results;
        } catch (Exception $e) {
            error_log("Error getting active admins: " . $e->getMessage());
            return [];
        }
    }

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

    public function getEmployerByJobPost($employerId, $jobId)
    {
        try {

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

            return $result;
        } catch (Exception $e) {
            error_log("Error getting employer by job post: " . $e->getMessage());
            return null;
        }
    }

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
            error_log("Error getting latest notification: " . $e->getMessage());
            return null;
        }
    }

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
            error_log("Error debugging employer data: " . $e->getMessage());
            return [];
        }
    }

    public function getJobseekerDetails($applicationId)
    {
        try {

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

            return $result;
        } catch (Exception $e) {
            error_log("❌ Error getting jobseeker details for application: " . $e->getMessage());
            return null;
        }
    }
    public function getResignationRequestDetails($resignationId)
    {
        try {

            $stmt = $this->db->prepare("
            SELECT 
                rr.resignation_id,
                rr.application_id,
                rr.jobseeker_id,
                rr.employer_id,
                rr.request_status,
                rr.employer_notes,
                rr.reviewed_at,
                js.user_id as jobseeker_user_id,
                js.first_name,
                js.last_name,
                u.email as jobseeker_email,
                jp.job_title,
                COALESCE(eb.business_name, e.company_name) as company_name
            FROM resignation_requests rr
            JOIN jobseeker js ON rr.jobseeker_id = js.jobseeker_id
            JOIN users u ON js.user_id = u.user_id
            JOIN job_application ja ON rr.application_id = ja.application_id
            JOIN job_post jp ON ja.job_id = jp.job_id
            JOIN employer e ON rr.employer_id = e.employer_id
            LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
            WHERE rr.resignation_id = ? AND u.status = 'active'
        ");
            $stmt->execute([$resignationId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $e) {
            error_log("Error getting resignation request details: " . $e->getMessage());
            return null;
        }
    }
}
