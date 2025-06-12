<?php
require_once __DIR__ . '/../../config/sikap_db.php';

class Employer {
    private $db;

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

    public function create($user_id, $first_name, $last_name, $contact_no, $middle_name = null, $position = null) {
        $stmt = $this->db->prepare("
            INSERT INTO employer (user_id, first_name, middle_name, last_name, position, contact_no, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        return $stmt->execute([$user_id, $first_name, $middle_name, $last_name, $position, $contact_no]);
    }

    public function findByUserId($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM employer WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isValidated($user_id) {
        // Since there's no validation field in your employer table,
        // you might need to add this or use the user status
        $stmt = $this->db->prepare("SELECT status FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['status'] === 'active';
    }
}