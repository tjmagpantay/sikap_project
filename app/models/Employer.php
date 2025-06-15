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
        try {
            $sql = "SELECT * FROM employer WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error finding employer by user ID: ' . $e->getMessage());
            return false;
        }
    }

    public function getBusiness($employer_id) {
        $stmt = $this->db->prepare("SELECT * FROM employers_business WHERE employer_id = ? LIMIT 1");
        $stmt->execute([$employer_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDocuments($employer_id) {
        try {
            // Get the document record for this employer
            $stmt = $this->db->prepare("SELECT * FROM employer_documents WHERE employer_id = ? LIMIT 1");
            $stmt->execute([$employer_id]);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$record) {
                return [];
            }
            
            // Extract document paths from the columns
            $documents = [];
            $documentColumns = [
                'letter_of_intent',
                'company_profile', 
                'business_permit',
                'cert_of_no_pending_case',
                'dole_registration',
                'cert_no_objection',
                'poea_reg',
                'job_vaccancies_qual',
                'phil_jobnet_reg'
            ];
            
            foreach ($documentColumns as $column) {
                if (!empty($record[$column])) {
                    $documents[$column] = $record[$column];
                }
            }
            
            error_log("DEBUG: Retrieved documents: " . print_r($documents, true));
            return $documents;
            
        } catch (PDOException $e) {
            error_log('Error getting documents: ' . $e->getMessage());
            return [];
        }
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

    public function saveDocument($employer_id, $document_type, $file_path, $original_filename = null, $file_size = null)
    {
        try {
            error_log("DEBUG: saveDocument called with employer_id=$employer_id, type=$document_type, path=$file_path");
            
            // Check if a record exists for this employer
            $sql = "SELECT req_doc_id FROM employer_documents WHERE employer_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employer_id]);
            $existing = $stmt->fetch();
            
            if ($existing) {
                // Update existing record - update the specific document column
                $sql = "UPDATE employer_documents SET {$document_type} = ?, upload_date = NOW() WHERE employer_id = ?";
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute([$file_path, $employer_id]);
                error_log("DEBUG: Updating existing record with SQL: $sql");
            } else {
                // Insert new record - create new row with this document
                $sql = "INSERT INTO employer_documents (employer_id, {$document_type}, upload_date) VALUES (?, ?, NOW())";
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute([$employer_id, $file_path]);
                error_log("DEBUG: Inserting new record with SQL: $sql");
            }
            
            if (!$result) {
                error_log("DEBUG: SQL execution failed: " . print_r($stmt->errorInfo(), true));
            } else {
                error_log("DEBUG: Document saved successfully: $document_type for employer $employer_id");
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log('Error saving document: ' . $e->getMessage());
            return false;
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

    public function markProfileCompleted($employer_id)
    {
        try {
            error_log("DEBUG: Marking profile completed for employer_id: $employer_id");
            
            $sql = "UPDATE employer SET profile_completed = 1, status = 'pending_verification', updated_at = CURRENT_TIMESTAMP WHERE employer_id = :employer_id";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute(['employer_id' => $employer_id]);
            
            if ($result) {
                error_log("DEBUG: Profile marked as completed successfully");
            } else {
                error_log("DEBUG: Failed to mark profile as completed: " . print_r($stmt->errorInfo(), true));
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log('Error marking profile as completed: ' . $e->getMessage());
            return false;
        }
    }
}