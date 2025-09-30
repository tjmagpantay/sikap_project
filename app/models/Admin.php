<?php
class Admin
{
    private $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/sikap_db.php';
        try {
            $this->db = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_pass']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function authenticate($email, $password)
    {
        try {
            $sql = "SELECT u.user_id, u.email, u.password, u.status, 
                          a.admin_id, a.admin_name,
                          r.role_name
                   FROM users u
                   JOIN user_roles ur ON u.user_id = ur.user_id
                   JOIN roles r ON ur.role_id = r.role_id
                   JOIN admin a ON u.user_id = a.user_id
                   WHERE u.email = :email 
                   AND r.role_name = 'admin'
                   AND u.status = 'active'";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['password'])) {
                // Don't return password
                unset($admin['password']);
                return $admin;
            }

            return false;
        } catch (PDOException $e) {
            error_log('Error authenticating admin: ' . $e->getMessage());
            return false;
        }
    }

    public function findById($adminId)
    {
        try {
            $sql = "SELECT u.user_id, u.email, u.status,
                          a.admin_id, a.admin_name, a.createdAt,
                          r.role_name
                   FROM admin a
                   JOIN users u ON a.user_id = u.user_id
                   JOIN user_roles ur ON u.user_id = ur.user_id
                   JOIN roles r ON ur.role_id = r.role_id
                   WHERE a.admin_id = :admin_id
                   AND r.role_name = 'admin'";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error finding admin by ID: ' . $e->getMessage());
            return false;
        }
    }

    public function create($user_id, $admin_name)
    {
        $stmt = $this->db->prepare("INSERT INTO admin (user_id, admin_name, createdAt, updatedAt) VALUES (?, ?, NOW(), NOW())");
        return $stmt->execute([$user_id, $admin_name]);
    }

    public function findByUserId($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPendingAccreditations()
    {
        try {
            $sql = "SELECT 
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
                WHERE a.status = 'pending'
                ORDER BY a.created_at ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            error_log("DEBUG: Found " . count($results) . " pending accreditations");
            return $results;
        } catch (PDOException $e) {
            error_log('Error getting pending accreditations: ' . $e->getMessage());
            return [];
        }
    }

    public function getAccreditationDetails($accreditation_id)
    {
        try {
            $sql = "SELECT 
                    a.*,
                    e.*,
                    u.email,
                    eb.*,
                    admin.admin_name as reviewed_by_name
                FROM accreditation a
                JOIN employer e ON a.employer_id = e.employer_id
                JOIN users u ON e.user_id = u.user_id
                LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                LEFT JOIN admin ON a.reviewed_by = admin.admin_id
                WHERE a.accreditation_id = ?";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$accreditation_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting accreditation details: ' . $e->getMessage());
            return null;
        }
    }

    public function updateAccreditationStatus($accreditation_id, $status, $admin_id, $notes = '')
    {
        try {
            // If status is being reset to pending, clear the review data
            if ($status === 'pending') {
                $sql = "UPDATE accreditation 
                        SET status = ?, reviewed_by = NULL, reviewed_at = NULL, notes = ?, updated_at = NOW()
                        WHERE accreditation_id = ?";
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute([$status, $notes, $accreditation_id]);

                // Also reset employer status to pending_verification
                if ($result) {
                    $this->resetEmployerToPending($accreditation_id);
                }
            } else {
                $sql = "UPDATE accreditation 
                        SET status = ?, reviewed_by = ?, reviewed_at = NOW(), notes = ?, updated_at = NOW()
                        WHERE accreditation_id = ?";
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute([$status, $admin_id, $notes, $accreditation_id]);

                if ($result && $status === 'approved') {
                    // Update employer status to verified
                    $this->approveEmployer($accreditation_id);
                } elseif ($result && $status === 'rejected') {
                    // Update employer status to rejected
                    $this->rejectEmployer($accreditation_id);
                }
            }

            return $result;
        } catch (PDOException $e) {
            error_log('Error updating accreditation status: ' . $e->getMessage());
            return false;
        }
    }

    private function approveEmployer($accreditation_id)
    {
        try {
            $sql = "UPDATE employer e
                    JOIN accreditation a ON e.employer_id = a.employer_id
                    SET e.status = 'verified', e.updated_at = NOW()
                    WHERE a.accreditation_id = ?";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$accreditation_id]);
        } catch (PDOException $e) {
            error_log('Error approving employer: ' . $e->getMessage());
            return false;
        }
    }

    private function resetEmployerToPending($accreditation_id)
    {
        try {
            $sql = "UPDATE employer e
                    JOIN accreditation a ON e.employer_id = a.employer_id
                    SET e.status = 'pending_verification', e.updated_at = NOW()
                    WHERE a.accreditation_id = ?";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$accreditation_id]);
        } catch (PDOException $e) {
            error_log('Error resetting employer to pending: ' . $e->getMessage());
            return false;
        }
    }

    private function rejectEmployer($accreditation_id)
    {
        try {
            $sql = "UPDATE employer e
                    JOIN accreditation a ON e.employer_id = a.employer_id
                    SET e.status = 'rejected', e.updated_at = NOW()
                    WHERE a.accreditation_id = ?";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$accreditation_id]);
        } catch (PDOException $e) {
            error_log('Error rejecting employer: ' . $e->getMessage());
            return false;
        }
    }

    public function getAllAccreditations()
    {
        try {
            $sql = "SELECT 
                    a.accreditation_id,
                    a.employer_id,
                    a.status,
                    a.created_at,
                    a.reviewed_at,
                    a.notes,
                    e.first_name,
                    e.last_name,
                    e.company_name,
                    e.contact_no,
                    e.position,
                    u.email,
                    eb.business_name,
                    eb.business_type,
                    eb.business_industry,
                    admin.admin_name as reviewed_by_name
                FROM accreditation a
                JOIN employer e ON a.employer_id = e.employer_id
                JOIN users u ON e.user_id = u.user_id
                LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                LEFT JOIN admin admin ON a.reviewed_by = admin.admin_id
                ORDER BY a.created_at DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (PDOException $e) {
            error_log('Error getting all accreditations: ' . $e->getMessage());
            return [];
        }
    }


    public function syncEmployerStatus($accreditation_id, $accreditation_status)
    {
        try {
            // Get employer_id from accreditation
            $stmt = $this->db->prepare("SELECT employer_id FROM accreditation WHERE accreditation_id = ?");
            $stmt->execute([$accreditation_id]);
            $accreditation = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$accreditation) {
                return false;
            }

            // Map accreditation status to employer status
            $employerStatusMap = [
                'approved' => 'verified',
                'rejected' => 'rejected',
                'pending' => 'pending_verification'
            ];

            $employerStatus = $employerStatusMap[$accreditation_status] ?? 'incomplete';

            // Update employer status
            $stmt = $this->db->prepare("UPDATE employer SET status = ?, updated_at = NOW() WHERE employer_id = ?");
            return $stmt->execute([$employerStatus, $accreditation['employer_id']]);
        } catch (PDOException $e) {
            error_log("Error syncing employer status: " . $e->getMessage());
            return false;
        }
    }
}
