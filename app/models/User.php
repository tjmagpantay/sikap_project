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
            
            // Create user
            $stmt = $this->db->prepare("INSERT INTO users (email, password, status, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$email, $password, $status]);
            $user_id = $this->db->lastInsertId();
            
            // Assign role
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
            SELECT u.*, ur.role_id, r.role_name 
            FROM users u 
            LEFT JOIN user_roles ur ON u.user_id = ur.user_id 
            LEFT JOIN roles r ON ur.role_id = r.role_id 
            WHERE u.email = ?
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
}
