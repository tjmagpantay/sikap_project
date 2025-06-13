<?php
// filepath: c:\xampp\htdocs\sikap\app\models\Employer.php
require_once __DIR__ . '/../../config/sikap_db.php';

class Employer {
    private $db;
    private $table_name = "employer";

    public function __construct() {
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

    public function findByUserId($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM " . $this->table_name . " WHERE user_id = ? LIMIT 1");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBusiness($employer_id) {
        $stmt = $this->db->prepare("SELECT * FROM employers_business WHERE employer_id = ? LIMIT 1");
        $stmt->execute([$employer_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDocuments($employer_id) {
        $stmt = $this->db->prepare("SELECT * FROM employers_document WHERE employer_id = ? LIMIT 1");
        $stmt->execute([$employer_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function calculateProfileCompletion($user_id) {
        $employer = $this->findByUserId($user_id);
        if (!$employer) {
            return 0;
        }

        $completion = 0;
        $totalFields = 7;

        if (!empty($employer['first_name'])) $completion++;
        if (!empty($employer['last_name'])) $completion++;
        if (!empty($employer['position'])) $completion++;
        if (!empty($employer['contact_no'])) $completion++;
        
        $business = $this->getBusiness($employer['employer_id']);
        if ($business) {
            if (!empty($business['business_name'])) $completion++;
            if (!empty($business['business_desc'])) $completion++;
            if (!empty($business['business_industry'])) $completion++;
        }

        return round(($completion / $totalFields) * 100);
    }

    public function isVerified($user_id) {
        $employer = $this->findByUserId($user_id);
        return $employer && isset($employer['is_verified']) && $employer['is_verified'] == 1;
    }

    public function canPostJobs($user_id) {
        return $this->isVerified($user_id) && $this->calculateProfileCompletion($user_id) >= 80;
    }

    public function updateProfilePhoto($user_id, $photo_path) {
        $stmt = $this->db->prepare("UPDATE " . $this->table_name . " SET profile_photo = ? WHERE user_id = ?");
        return $stmt->execute([$photo_path, $user_id]);
    }

    public function create($user_id, $first_name, $last_name, $position, $contact_no, $middle_name = null, $company_name = null, $about_us = null) {
        $stmt = $this->db->prepare("
            INSERT INTO " . $this->table_name . " (user_id, first_name, middle_name, last_name, position, contact_no, company_name, about_us, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        return $stmt->execute([$user_id, $first_name, $middle_name, $last_name, $position, $contact_no, $company_name, $about_us]);
    }

    public function updateProfile($user_id, $data) {
        $stmt = $this->db->prepare("
            UPDATE " . $this->table_name . " 
            SET first_name = ?, middle_name = ?, last_name = ?, position = ?, contact_no = ?, company_name = ?, about_us = ?, updated_at = NOW() 
            WHERE user_id = ?
        ");
        return $stmt->execute([
            $data['first_name'],
            $data['middle_name'],
            $data['last_name'],
            $data['position'],
            $data['contact_no'],
            $data['company_name'],
            $data['about_us'],
            $user_id
        ]);
    }

    public function createOrUpdateProfile($user_id, $data) {
        $existing = $this->findByUserId($user_id);

        if ($existing) {
            return $this->updateProfile($user_id, $data);
        } else {
            return $this->create(
                $user_id,
                $data['first_name'],
                $data['last_name'],
                $data['position'],
                $data['contact_no'],
                $data['middle_name'],
                $data['company_name'],
                $data['about_us']
            );
        }
    }

    public function createOrUpdateBusiness($employer_id, $data) {
        $existing = $this->getBusiness($employer_id);
        
        if ($existing) {
            return $this->updateBusiness($employer_id, $data);
        } else {
            return $this->createBusiness($employer_id, $data);
        }
    }

    public function createBusiness($employer_id, $data) {
        $fields = ['employer_id'];
        $values = [$employer_id];
        $placeholders = ['?'];
        
        foreach ($data as $field => $value) {
            $fields[] = $field;
            $values[] = $value;
            $placeholders[] = '?';
        }
        
        $fields[] = 'created_at';
        $fields[] = 'updated_at';
        $placeholders[] = 'NOW()';
        $placeholders[] = 'NOW()';
        
        $sql = "INSERT INTO employers_business (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute($values);
    }

    public function updateBusiness($employer_id, $data) {
        if (empty($data)) {
            return true;
        }
        
        $fields = [];
        $values = [];
        
        foreach ($data as $field => $value) {
            $fields[] = "$field = ?";
            $values[] = $value;
        }
        
        $fields[] = "updated_at = NOW()";
        $values[] = $employer_id;
        
        $sql = "UPDATE employers_business SET " . implode(', ', $fields) . " WHERE employer_id = ?";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute($values);
    }

    public function saveDocument($employer_id, $document_type, $file_path) {
        $existing = $this->getDocuments($employer_id);
        
        if ($existing) {
            $sql = "UPDATE employers_document SET $document_type = ?, updated_at = NOW() WHERE employer_id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$file_path, $employer_id]);
        } else {
            $sql = "INSERT INTO employers_document (employer_id, $document_type, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$employer_id, $file_path]);
        }
    }

    public function createProfile($data)
    {
        try {
            $sql = "INSERT INTO employers (user_id, first_name, middle_name, last_name, position, contact_no, company_name, about_us, created_at) 
                    VALUES (:user_id, :first_name, :middle_name, :last_name, :position, :contact_no, :company_name, :about_us, NOW())";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log('Error creating employer profile: ' . $e->getMessage());
            return false;
        }
    }
}