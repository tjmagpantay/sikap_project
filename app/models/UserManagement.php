<?php

class UserManagement
{
    private $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/sikap_db.php';
        try {
            $this->db = new PDO(
                "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4", // FIXED: Added port
                $config['db_user'],
                $config['db_pass'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_TIMEOUT => 30
                ]
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getUsersByType($type)
    {
        if ($type === 'employer') {
            $stmt = $this->db->prepare("
                SELECT e.employer_id, e.user_id, e.first_name, e.middle_name, e.last_name, 
                       e.position, e.contact_no, e.company_name, e.about_us, e.created_at, 
                       e.updated_at, e.profile_completed, e.status,
                       eb.business_address
                FROM employer e
                LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else if ($type === 'jobseeker') {
            $stmt = $this->db->prepare("
                SELECT 
                    j.jobseeker_id, 
                    j.user_id, 
                    j.first_name, 
                    j.middle_name, 
                    j.last_name, 
                    j.suffix, 
                    j.date_of_birth, 
                    j.sex, 
                    j.address, 
                    j.contact_no,
                    j.acc_status,
                    j.created_at
                FROM jobseeker j
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public function getUserById($id, $type)
    {
        if ($type === 'employer') {
            $stmt = $this->db->prepare("
                SELECT employer_id, user_id, first_name, middle_name, last_name, position, contact_no, company_name, about_us, created_at, updated_at, profile_completed, status
                FROM employer
                WHERE user_id = ?
            ");
        } else if ($type === 'jobseeker') {
            $stmt = $this->db->prepare("
                SELECT jobseeker_id, user_id, first_name, middle_name, last_name, suffix, date_of_birth, sex, address, contact_no, profile_completion, created_at, updated_at, profile_completed
                FROM jobseeker
                WHERE user_id = ?
            ");
        } else {
            return null;
        }
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get database connection
     * @return PDO
     */

    public function getConnection()
    {
        return $this->db;
    }

    /**
     * Update employer status
     * @param int $user_id
     * @param string $action - 'suspend', 'unsuspend', or 'activate'
     * @return bool
     */
    public function updateEmployerStatus($user_id, $action)
    {
        try {
            $new_status = $action === 'suspend' ? 'suspended' : 'verified';
            $stmt = $this->db->prepare("UPDATE employer SET status = ? WHERE user_id = ?");
            return $stmt->execute([$new_status, $user_id]);
        } catch (Exception $e) {
            error_log("Error updating employer status: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update jobseeker status (if needed in the future)
     * @param int $user_id
     * @param string $status
     * @return bool
     */
    public function updateJobseekerStatus($user_id, $status)
    {
        try {

            // Verify the user exists first
            $check = $this->db->prepare("SELECT jobseeker_id FROM jobseeker WHERE user_id = ?");
            $check->execute([$user_id]);
            if (!$check->fetch()) {
                error_log("No jobseeker found with user_id: {$user_id}");
                return false;
            }

            $stmt = $this->db->prepare("UPDATE jobseeker SET acc_status = ? WHERE user_id = ?");
            $result = $stmt->execute([$status, $user_id]);

            // Log the result
            error_log("Update result: " . ($result ? "success" : "failed") . ", rows affected: " . $stmt->rowCount());

            return $result;
        } catch (Exception $e) {
            error_log("Error updating jobseeker status: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generic method to update user status for any user type
     * @param int $user_id
     * @param string $status
     * @param string $user_type - 'employer' or 'jobseeker'
     * @return bool
     */
    public function updateUserStatus($user_id, $status, $user_type = 'employer')
    {
        try {
            $table = $user_type === 'jobseeker' ? 'jobseeker' : 'employer';

            $stmt = $this->db->prepare("UPDATE {$table} SET status = ? WHERE user_id = ?");
            return $stmt->execute([$status, $user_id]);
        } catch (Exception $e) {
            error_log("Error updating user status: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get employer by user_id with status
     * @param int $user_id
     * @return array|null
     */
    public function getEmployerByUserId($user_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT employer_id, user_id, first_name, middle_name, last_name, position, 
                       contact_no, company_name, about_us, created_at, updated_at, 
                       profile_completed, status
                FROM employer 
                WHERE user_id = ?
            ");
            $stmt->execute([$user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting employer by user_id: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get jobseeker by user_id
     * @param int $user_id
     * @return array|null
     */
    public function getJobseekerByUserId($user_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT jobseeker_id, user_id, first_name, middle_name, last_name, suffix, 
                       date_of_birth, sex, address, contact_no, profile_completion, 
                       created_at, updated_at, profile_completed
                FROM jobseeker 
                WHERE user_id = ?
            ");
            $stmt->execute([$user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting jobseeker by user_id: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get total count of users by type
     * @param string $type - 'employer' or 'jobseeker'
     * @return int
     */
    public function getUserCountByType($type)
    {
        try {
            $table = $type === 'jobseeker' ? 'jobseeker' : 'employer';
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM {$table}");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['count'];
        } catch (Exception $e) {
            error_log("Error getting user count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get users by status (for employers)
     * @param string $status - 'verified', 'suspended', 'pending', etc.
     * @return array
     */
    public function getEmployersByStatus($status)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT employer_id, user_id, first_name, middle_name, last_name, position, 
                       contact_no, company_name, about_us, created_at, updated_at, 
                       profile_completed, status
                FROM employer 
                WHERE status = ?
                ORDER BY created_at DESC
            ");
            $stmt->execute([$status]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error getting employers by status: " . $e->getMessage());
            return [];
        }
    }
}
