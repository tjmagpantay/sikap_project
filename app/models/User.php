<?php
require_once __DIR__ . '/../../config/sikap_db.php';

class User {
    private $db; 

    const ROLE_ADMIN = 1;
    const ROLE_EMPLOYER = 2;
    const ROLE_JOBSEEKER = 3;

    public function __construct() {
        $config = require __DIR__ . '/../../config/sikap_db.php';
        try {
            $this->db = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_pass']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function create($email, $password, $role_id, $status = 'active') {
        try {
            $this->db->beginTransaction();
            
            // Check if email exists
            $existingUser = $this->findByEmail($email);
            if ($existingUser) {
                $this->db->rollback();
                return false;
            }
            
            // Create user
            $stmt = $this->db->prepare("INSERT INTO users (email, password, status, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$email, $password, $status]);
            $user_id = $this->db->lastInsertId();
            
            // Delete any existing roles first (shouldn't exist, but just in case)
            $deleteStmt = $this->db->prepare("DELETE FROM user_roles WHERE user_id = ?");
            $deleteStmt->execute([$user_id]);
            
            // Assign new role
            $stmt = $this->db->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)");
            $stmt->execute([$user_id, $role_id]);
            
            $this->db->commit();
            return $user_id;
        } catch(Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("
            SELECT u.*, ur.role_id, r.role_name,
                   CASE 
                       WHEN ur.role_id = 2 THEN 'employer'
                       WHEN ur.role_id = 3 THEN 'jobseeker'
                       WHEN ur.role_id = 1 THEN 'admin'
                   END as user_type
            FROM users u 
            LEFT JOIN (
                SELECT user_id, MAX(role_id) as role_id
                FROM user_roles
                GROUP BY user_id
            ) ur ON u.user_id = ur.user_id 
            LEFT JOIN roles r ON ur.role_id = r.role_id 
            WHERE u.email = ?
            LIMIT 1
        ");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function hasCompleteProfile($user_id, $role_id) {
        switch($role_id) {
            case self::ROLE_ADMIN:
                $stmt = $this->db->prepare("SELECT admin_id FROM admin WHERE user_id = ?");
                break;
            case self::ROLE_EMPLOYER:
                $stmt = $this->db->prepare("SELECT employer_id FROM employer WHERE user_id = ?");
                break;
            case self::ROLE_JOBSEEKER:
                $stmt = $this->db->prepare("SELECT jobseeker_id FROM jobseeker WHERE user_id = ?");
                break;
            default:
                return false;
        }
        
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function deleteUser($user_id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE user_id = ?");
        return $stmt->execute([$user_id]);
    }

     /**
     * Find user by Google ID (now just by email, since we do not store google_id)
     */
    public function findByGoogleId($googleIdOrEmail) {
        // For compatibility, just call findByEmail
        return $this->findByEmail($googleIdOrEmail);
    }

    /**
     * Create user with Google info (no google_id stored)
     */
    public function createWithGoogle($email, $googleId, $name, $role_id, $status = 'active') {
        try {
            $this->db->beginTransaction();
            
            // First check if email exists with any role
            $stmt = $this->db->prepare("
                SELECT u.user_id, u.email, ur.role_id
                FROM users u
                LEFT JOIN user_roles ur ON u.user_id = ur.user_id
                WHERE u.email = ?
            ");
            $stmt->execute([$email]);
            $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($existingUser) {
                $this->db->rollback();
                error_log("Attempt to create duplicate account for email: " . $email);
                return false;
            }
            
            // Use a random password for Google users
            $randomPassword = bin2hex(random_bytes(16));
            $hashedPassword = password_hash($randomPassword, PASSWORD_DEFAULT);
            
            // Create user
            $stmt = $this->db->prepare("
                INSERT INTO users (email, password, status, created_at)
                VALUES (?, ?, ?, NOW())
            ");
            $stmt->execute([$email, $hashedPassword, $status]);
            $user_id = $this->db->lastInsertId();
            
            // Insert role with a check to prevent duplicates
            $stmt = $this->db->prepare("
                INSERT INTO user_roles (user_id, role_id)
                SELECT ?, ?
                WHERE NOT EXISTS (
                    SELECT 1 FROM user_roles WHERE user_id = ?
                )
            ");
            $stmt->execute([$user_id, $role_id, $user_id]);
            
            // If role wasn't inserted, rollback everything
            if ($stmt->rowCount() === 0) {
                $this->db->rollback();
                error_log("Failed to assign role for user: " . $user_id);
                return false;
            }
            
            $this->db->commit();
            return $user_id;
        } catch(Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    /**
     * Find user by email and return user info + user type (jobseeker/employer)
     */
    public function findUserByEmail($email) {
        $stmt = $this->db->prepare("
            SELECT u.*, 
                   CASE 
                       WHEN j.jobseeker_id IS NOT NULL THEN 'jobseeker'
                       WHEN e.employer_id IS NOT NULL THEN 'employer'
                   END as user_type
            FROM users u
            LEFT JOIN jobseeker j ON u.user_id = j.user_id
            LEFT JOIN employer e ON u.user_id = e.user_id
            WHERE u.email = ?
        ");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update user password by user_id
     */
    public function updatePassword($userId, $hashedPassword) {
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        return $stmt->execute([$hashedPassword, $userId]);
    }

    public function updateGoogleId($userId, $googleId) {
        $stmt = $this->db->prepare("UPDATE users SET google_id = ? WHERE user_id = ?");
        return $stmt->execute([$googleId, $userId]);
    }

    public function getDb() {
        return $this->db;
    }
    
    /**
     * Clean up duplicate roles in the database
     */
    public function cleanupDuplicateRoles() {
        try {
            $this->db->beginTransaction();
            
            // Find users with multiple roles
            $findDuplicates = $this->db->query("
                SELECT user_id, COUNT(*) as role_count
                FROM user_roles
                GROUP BY user_id
                HAVING role_count > 1
            ");
            
            while ($row = $findDuplicates->fetch(PDO::FETCH_ASSOC)) {
                // For each user with multiple roles, keep only the most recent one
                $stmt = $this->db->prepare("
                    DELETE ur1 FROM user_roles ur1
                    INNER JOIN (
                        SELECT user_id, MAX(id) as max_id
                        FROM user_roles
                        WHERE user_id = ?
                        GROUP BY user_id
                    ) ur2 ON ur1.user_id = ur2.user_id
                    WHERE ur1.id < ur2.max_id
                ");
                $stmt->execute([$row['user_id']]);
            }
            
            $this->db->commit();
            return true;
        } catch(Exception $e) {
            $this->db->rollback();
            error_log("Error cleaning up duplicate roles: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Ensures a user has only one role and returns the current role
     */
    private function ensureSingleRole($user_id) {
        try {
            $this->db->beginTransaction();
            
            // Check for multiple roles
            $checkStmt = $this->db->prepare("
                SELECT COUNT(*) as role_count
                FROM user_roles
                WHERE user_id = ?
            ");
            $checkStmt->execute([$user_id]);
            $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['role_count'] > 1) {
                // Keep only the most recent role
                $cleanupStmt = $this->db->prepare("
                    DELETE ur1 FROM user_roles ur1
                    INNER JOIN user_roles ur2 
                    WHERE ur1.user_id = ur2.user_id 
                    AND ur1.user_id = ?
                    AND ur1.id < ur2.id
                ");
                $cleanupStmt->execute([$user_id]);
            }
            
            $this->db->commit();
            return true;
        } catch(Exception $e) {
            $this->db->rollback();
            error_log("Error ensuring single role: " . $e->getMessage());
            return false;
        }
    }
}

