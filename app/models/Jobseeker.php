<?php
require_once __DIR__ . '/../../config/sikap_db.php';

class Jobseeker
{
    private $db;

    public function __construct($pdo = null)
    {
        if ($pdo) {
            $this->db = $pdo;
        } else {
            // Create connection if not provided
            $config = require __DIR__ . '/../../config/sikap_db.php';
            $dsn = "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4";
            $this->db = new PDO($dsn, $config['db_user'], $config['db_pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 30
            ]);
        }
    }

    public function getPdo()
    {
        return $this->db;
    }

    public function create($user_id, $first_name, $last_name, $contact_no, $middle_name = null, $suffix = null, $date_of_birth = null, $sex = null, $address = null)
    {
        $stmt = $this->db->prepare("
            INSERT INTO jobseeker (user_id, first_name, middle_name, last_name, suffix, date_of_birth, sex, address, contact_no, profile_completion, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, NOW(), NOW())
        ");
        return $stmt->execute([$user_id, $first_name, $middle_name, $last_name, $suffix, $date_of_birth, $sex, $address, $contact_no]);
    }


    public function createMinimal($userId, $firstName, $lastName, $email, $contactNumber = null)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO jobseeker (user_id, first_name, last_name, contact_no, created_at, updated_at) 
                VALUES (?, ?, ?, ?, NOW(), NOW())
            ");
            $result = $stmt->execute([$userId, $firstName, $lastName, $contactNumber]);
            return $result;
        } catch (Exception $e) {
            error_log('Error creating minimal jobseeker profile: ' . $e->getMessage());
            return false;
        }
    }

    public function hasPassword($user_id)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT password, auth_method
            FROM users 
            WHERE user_id = ?
        ");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                return false;
            }

            // If it's a Google user, they don't have a "real" password
            if ($result['auth_method'] === 'google') {
                return false;
            }

            // Check if password exists and is not empty
            return !empty($result['password']);
        } catch (PDOException $e) {
            error_log('Error checking password status: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update jobseeker account status
     */
    public function updateAccountStatus($userId, $status)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE jobseeker 
                SET acc_status = ?, updated_at = CURRENT_TIMESTAMP 
                WHERE user_id = ?
            ");

            return $stmt->execute([$status, $userId]);
        } catch (PDOException $e) {
            error_log("Error updating jobseeker account status: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Find jobseeker by user ID
     */
    public function findByUserId($userId)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM jobseeker 
                WHERE user_id = ? 
                LIMIT 1
            ");

            $stmt->execute([$userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error finding jobseeker by user ID: " . $e->getMessage());
            return false;
        }
    }

    public function updateProfile($user_id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE jobseeker 
            SET first_name = ?, middle_name = ?, last_name = ?, suffix = ?, date_of_birth = ?, sex = ?, address = ?, contact_no = ?, updated_at = NOW() 
            WHERE user_id = ?
        ");
        return $stmt->execute([
            $data['first_name'],
            $data['middle_name'],
            $data['last_name'],
            $data['suffix'],
            $data['date_of_birth'],
            $data['sex'],
            $data['address'],
            $data['contact_no'],
            $user_id
        ]);
    }

    public function createOrUpdateProfile($user_id, $data)
    {
        $existing = $this->findByUserId($user_id);

        if ($existing) {
            return $this->updateProfile($user_id, $data);
        } else {
            return $this->create(
                $user_id,
                $data['first_name'],
                $data['last_name'],
                $data['contact_no'],
                $data['middle_name'],
                $data['suffix'],
                $data['date_of_birth'],
                $data['sex'],
                $data['address']
            );
        }
    }

    public function saveDocument($jobseeker_id, $file_path, $file_type, $file_name)
    {
        try {
            $sql = "INSERT INTO jobseeker_documents (jobseeker_id, file_name, file_path, file_type) 
                    VALUES (:jobseeker_id, :file_name, :file_path, :file_type)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'jobseeker_id' => $jobseeker_id,
                'file_name' => $file_name,
                'file_path' => $file_path,
                'file_type' => $file_type
            ]);
        } catch (PDOException $e) {
            error_log('Error saving document to profile: ' . $e->getMessage());
            return false;
        }
    }

    public function findDocumentById($document_id)
    {
        try {
            $sql = "SELECT * FROM jobseeker_documents WHERE document_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$document_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error finding document by ID: ' . $e->getMessage());
            return null;
        }
    }

    public function findDocumentByType($jobseeker_id, $file_type)
    {
        try {
            $sql = "SELECT * FROM jobseeker_documents 
                    WHERE jobseeker_id = ? AND LOWER(file_type) = LOWER(?) 
                    ORDER BY uploaded_at DESC LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$jobseeker_id, $file_type]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error finding document by type: ' . $e->getMessage());
            return null;
        }
    }

    public function updateDocument($document_id, $file_path, $file_name)
    {
        try {
            $sql = "UPDATE jobseeker_documents 
                    SET file_path = ?, file_name = ?, uploaded_at = NOW() 
                    WHERE document_id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$file_path, $file_name, $document_id]);
        } catch (PDOException $e) {
            error_log('Error updating document: ' . $e->getMessage());
            return false;
        }
    }

    public function findDocumentByPath($jobseeker_id, $file_path)
    {
        try {
            $sql = "SELECT * FROM jobseeker_documents 
                    WHERE jobseeker_id = ? AND file_path = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$jobseeker_id, $file_path]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error finding document by path: ' . $e->getMessage());
            return null;
        }
    }

    public function saveEducation($jobseeker_id, $data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO jobseeker_education (jobseeker_id, school_name, education_level, field_of_study, start_date, end_date) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $jobseeker_id,
            $data['school_name'],
            $data['education_level'],
            $data['field_of_study'],
            $data['start_date'],
            $data['end_date']
        ]);
    }

    public function updateEducation($jobseeker_id, $eduData, $education_id)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE jobseeker_education 
                SET school_name = ?, education_level = ?, field_of_study = ?, start_date = ?, end_date = ?
                WHERE education_id = ? AND jobseeker_id = ?
            ");

            return $stmt->execute([
                $eduData['school_name'],
                $eduData['education_level'],
                $eduData['field_of_study'],
                $eduData['start_date'],
                $eduData['end_date'],
                $education_id,
                $jobseeker_id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating education: " . $e->getMessage());
            return false;
        }
    }

    public function saveWorkExperience($jobseeker_id, $data)
    {
        try {

            $stmt = $this->db->prepare("
            INSERT INTO jobseeker_work_experience 
            (jobseeker_id, job_title, company_name, employment_type, start_date, end_date, currently_working, experience_type, responsibilities) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

            $result = $stmt->execute([
                $jobseeker_id,
                $data['job_title'],
                $data['company_name'],
                $data['employment_type'],
                $data['start_date'],
                $data['end_date'],
                $data['currently_working'],
                $data['experience_type'] ?? 'previous',
                $data['responsibilities'] ?? ''
            ]);

            return $result;
        } catch (PDOException $e) {
            error_log("Error saving work experience: " . $e->getMessage());
            return false;
        }
    }

    public function deleteWorkExperience($jobseeker_id, $experience_id)
    {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM jobseeker_work_experience 
                WHERE jobseeker_id = ? AND experience_id = ?
            ");
            return $stmt->execute([$jobseeker_id, $experience_id]);
        } catch (PDOException $e) {
            error_log("Error deleting work experience: " . $e->getMessage());
            return false;
        }
    }

    public function getWorkExperienceById($jobseeker_id, $experience_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM jobseeker_work_experience 
                WHERE jobseeker_id = ? AND experience_id = ?
            ");
            $stmt->execute([$jobseeker_id, $experience_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching work experience by ID: " . $e->getMessage());
            return false;
        }
    }

    public function hasCurrentJob($jobseeker_id)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT COUNT(*) as count FROM jobseeker_work_experience 
            WHERE jobseeker_id = ? AND currently_working = 'Yes'
        ");
            $stmt->execute([$jobseeker_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Error checking current job: " . $e->getMessage());
            return false;
        }
    }

    public function getCurrentJob($jobseeker_id)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT * FROM jobseeker_work_experience 
            WHERE jobseeker_id = ? AND currently_working = 'Yes' 
            LIMIT 1
        ");
            $stmt->execute([$jobseeker_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching current job: " . $e->getMessage());
            return false;
        }
    }


    public function updateWorkExperience($jobseeker_id, $data, $experience_id)
    {
        try {

            $stmt = $this->db->prepare("
            UPDATE jobseeker_work_experience 
            SET job_title = ?, company_name = ?, employment_type = ?, 
                start_date = ?, end_date = ?, currently_working = ?, 
                experience_type = ?, responsibilities = ?
            WHERE experience_id = ? AND jobseeker_id = ?
        ");

            $result = $stmt->execute([
                $data['job_title'],
                $data['company_name'],
                $data['employment_type'],
                $data['start_date'],
                $data['end_date'],
                $data['currently_working'],
                $data['experience_type'] ?? 'previous',
                $data['responsibilities'] ?? '',
                $experience_id,
                $jobseeker_id
            ]);

            return $result;
        } catch (PDOException $e) {
            error_log("Error updating work experience: " . $e->getMessage());
            return false;
        }
    }


    public function deleteDocumentByType($jobseeker_id, $type)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM jobseeker_documents WHERE jobseeker_id = ? AND file_type = ?");
            return $stmt->execute([$jobseeker_id, $type]);
        } catch (PDOException $e) {
            error_log("Error deleting document: " . $e->getMessage());
            return false;
        }
    }

    public function saveSkill($jobseeker_id, $skillData)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO jobseeker_skills (jobseeker_id, skill_name, proficiency_level, esco_uri) 
                VALUES (?, ?, ?, ?)
            ");

            return $stmt->execute([
                $jobseeker_id,
                $skillData['skill_name'],
                $skillData['proficiency_level'] ?? 'Intermediate',
                $skillData['esco_uri'] ?? null
            ]);
        } catch (PDOException $e) {
            error_log("Error saving skill: " . $e->getMessage());
            return false;
        }
    }

    public function deleteSkills($jobseeker_id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM jobseeker_skills WHERE jobseeker_id = ?");
            return $stmt->execute([$jobseeker_id]);
        } catch (PDOException $e) {
            error_log("Error deleting skills: " . $e->getMessage());
            return false;
        }
    }

    public function deleteSkillById($jobseeker_id, $skill_id)
    {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM jobseeker_skills 
                WHERE jobseeker_id = ? AND skill_id = ?
            ");
            return $stmt->execute([$jobseeker_id, $skill_id]);
        } catch (PDOException $e) {
            error_log("Error deleting skill: " . $e->getMessage());
            return false;
        }
    }

    public function saveCertificate($jobseeker_id, $certData)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO jobseeker_certificates (jobseeker_id, certificate_title, issuing_organization, date_issued) 
                VALUES (?, ?, ?, ?)
            ");

            return $stmt->execute([
                $jobseeker_id,
                $certData['certificate_title'],
                $certData['issuing_organization'] ?? 'Unknown',
                $certData['date_issued'] ?? date('Y-m-d')
            ]);
        } catch (PDOException $e) {
            error_log("Error saving certificate: " . $e->getMessage());
            return false;
        }
    }

    public function updateCertificate($jobseeker_id, $certData, $certificate_id)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE jobseeker_certificates 
                SET certificate_title = ?, issuing_organization = ?, date_issued = ?
                WHERE certificate_id = ? AND jobseeker_id = ?
            ");

            return $stmt->execute([
                $certData['certificate_title'],
                $certData['issuing_organization'],
                $certData['date_issued'],
                $certificate_id,
                $jobseeker_id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating certificate: " . $e->getMessage());
            return false;
        }
    }

    public function getSkills($user_id)
    {
        try {
            // Get jobseeker_id first
            $jobseeker = $this->findByUserId($user_id);
            if (!$jobseeker) {
                return [];
            }

            $stmt = $this->db->prepare("
                SELECT * FROM jobseeker_skills 
                WHERE jobseeker_id = ? 
                ORDER BY created_at DESC
            ");
            $stmt->execute([$jobseeker['jobseeker_id']]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching skills: " . $e->getMessage());
            return [];
        }
    }

    public function getCertificates($user_id)
    {
        try {
            // Get jobseeker_id first
            $jobseeker = $this->findByUserId($user_id);
            if (!$jobseeker) {
                return [];
            }

            $stmt = $this->db->prepare("
            SELECT * FROM jobseeker_certificates 
            WHERE jobseeker_id = ? 
            ORDER BY date_issued DESC
        ");
            $stmt->execute([$jobseeker['jobseeker_id']]);
            $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Return empty array if no certificates found
            return $certificates ?: [];
        } catch (PDOException $e) {
            error_log("Error fetching certificates: " . $e->getMessage());
            return [];
        }
    }

    public function hasCertificates($user_id)
    {
        try {
            $jobseeker = $this->findByUserId($user_id);
            if (!$jobseeker) {
                return false;
            }

            $stmt = $this->db->prepare("
            SELECT COUNT(*) as count FROM jobseeker_certificates 
            WHERE jobseeker_id = ?
        ");
            $stmt->execute([$jobseeker['jobseeker_id']]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Error checking certificates: " . $e->getMessage());
            return false;
        }
    }

    public function getWorkExperience($user_id)
    {
        try {
            // Get jobseeker_id first
            $jobseeker = $this->findByUserId($user_id);
            if (!$jobseeker) {
                return [];
            }

            $stmt = $this->db->prepare("
                SELECT * FROM jobseeker_work_experience 
                WHERE jobseeker_id = ? 
                ORDER BY start_date DESC
            ");
            $stmt->execute([$jobseeker['jobseeker_id']]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching work experience: " . $e->getMessage());
            return [];
        }
    }

    public function updateProfilePicture($user_id, $relativePath)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE jobseeker 
                SET profile_picture = ? 
                WHERE user_id = ?
            ");
            return $stmt->execute([$relativePath, $user_id]);
        } catch (PDOException $e) {
            error_log("Error updating profile picture: " . $e->getMessage());
            return false;
        }
    }

    public function markProfileComplete($user_id)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE jobseeker 
                SET profile_completed = 1 
                WHERE user_id = ?
            ");
            return $stmt->execute([$user_id]);
        } catch (PDOException $e) {
            error_log("Error marking profile complete: " . $e->getMessage());
            return false;
        }
    }

    public function calculateProfileCompletion($user_id)
    {
        try {
            $jobseeker = $this->findByUserId($user_id);
            if (!$jobseeker) {
                return 0;
            }

            $completionFields = 0;
            $totalRequiredFields = 7; // Only required fields for 100% completion

            // STEP 1: Documents (Resume Required) - 1 field
            $documents = $this->getDocuments($user_id);
            $hasResume = false;
            if ($documents && is_array($documents)) {
                foreach ($documents as $doc) {
                    if ($doc['file_type'] === 'resume') {
                        $hasResume = true;
                        break;
                    }
                }
            }
            if ($hasResume) $completionFields++;

            // STEP 2: Basic Personal Information (Required) - 5 fields
            if (!empty($jobseeker['first_name']) && trim($jobseeker['first_name']) !== '') $completionFields++;
            if (!empty($jobseeker['last_name']) && trim($jobseeker['last_name']) !== '') $completionFields++;
            if (!empty($jobseeker['date_of_birth']) && $jobseeker['date_of_birth'] !== '0000-00-00') $completionFields++;
            if (!empty($jobseeker['sex']) && $jobseeker['sex'] !== '') $completionFields++;
            if (!empty($jobseeker['address']) && trim($jobseeker['address']) !== '') $completionFields++;
            if (!empty($jobseeker['contact_no']) && trim($jobseeker['contact_no']) !== '') $completionFields++;

            // STEP 3: Education (Required) - 1 field
            $education = $this->getEducation($user_id);
            if (!empty($education) && is_array($education) && count($education) > 0) {
                // Check if there's at least one valid education entry
                $hasValidEducation = false;
                foreach ($education as $edu) {
                    if (!empty($edu['degree']) || !empty($edu['institution']) || !empty($edu['field_of_study'])) {
                        $hasValidEducation = true;
                        break;
                    }
                }
                if ($hasValidEducation) $completionFields++;
            }

            // Calculate completion percentage (cap at 100%)
            $completionPercentage = ($completionFields / $totalRequiredFields) * 100;

            // IMPORTANT: Cap at 100% - Optional fields don't increase percentage beyond 100%
            return min(100, round($completionPercentage));
        } catch (PDOException $e) {
            error_log("Error calculating profile completion: " . $e->getMessage());
            return 0;
        }
    }

    public function updateProfileCompletion($user_id, $percentage)
    {
        try {
            // Ensure percentage is between 0-100
            $percentage = min(100, max(0, $percentage));

            $sql = "UPDATE jobseeker SET profile_completion = ? WHERE user_id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$percentage, $user_id]);
        } catch (PDOException $e) {
            error_log('Error updating profile completion: ' . $e->getMessage());
            return false;
        }
    }

    public function getDocuments($user_id)
    {
        try {
            $jobseeker = $this->findByUserId($user_id);
            if (!$jobseeker) {
                return [];
            }

            $stmt = $this->db->prepare("
                SELECT * FROM jobseeker_documents 
                WHERE jobseeker_id = ? 
                ORDER BY uploaded_at DESC
            ");
            $stmt->execute([$jobseeker['jobseeker_id']]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching documents: " . $e->getMessage());
            return [];
        }
    }

    public function getEducation($user_id)
    {
        try {
            $jobseeker = $this->findByUserId($user_id);
            if (!$jobseeker) {
                return [];
            }

            $stmt = $this->db->prepare("
                SELECT * FROM jobseeker_education 
                WHERE jobseeker_id = ? 
                ORDER BY end_date DESC
            ");
            $stmt->execute([$jobseeker['jobseeker_id']]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching education: " . $e->getMessage());
            return [];
        }
    }

    public function getProfilePicture($user_id)
    {
        try {
            $sql = "SELECT profile_picture FROM jobseeker WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['profile_picture'] : null;
        } catch (PDOException $e) {
            error_log('Error getting profile picture: ' . $e->getMessage());
            return null;
        }
    }

    public function getPreviousJobs($jobseeker_id)
    {
        $sql = "SELECT * FROM jobseeker_work_experience 
                WHERE jobseeker_id = ? AND currently_working = 'No' 
                ORDER BY start_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$jobseeker_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSkillsArray($jobseeker_id)
    {
        try {
            $sql = "SELECT skill_name FROM jobseeker_skills 
                    WHERE jobseeker_id = ? 
                    ORDER BY proficiency_level DESC, skill_name ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$jobseeker_id]);
            $skills = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Clean and normalize skills
            $cleanSkills = [];
            foreach ($skills as $skill) {
                $cleanSkill = trim(strtolower($skill));
                if (!empty($cleanSkill) && $cleanSkill !== 'n/a') {
                    $cleanSkills[] = $cleanSkill;
                }
            }

            return $cleanSkills;
        } catch (PDOException $e) {
            error_log('Error getting jobseeker skills array: ' . $e->getMessage());
            return [];
        }
    }

    public function findById($jobseeker_id)
    {
        try {
            $sql = "SELECT * FROM jobseeker WHERE jobseeker_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$jobseeker_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error finding jobseeker by ID: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteCertificate($jobseeker_id, $certificate_id)
    {
        try {

            // First check if the certificate exists
            $checkStmt = $this->db->prepare("
            SELECT * FROM jobseeker_certificates 
            WHERE certificate_id = ? AND jobseeker_id = ?
        ");
            $checkStmt->execute([$certificate_id, $jobseeker_id]);
            $certificate = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if (!$certificate) {
                return false;
            }

            // Now delete it
            $deleteStmt = $this->db->prepare("
            DELETE FROM jobseeker_certificates 
            WHERE certificate_id = ? AND jobseeker_id = ?
        ");

            $result = $deleteStmt->execute([$certificate_id, $jobseeker_id]);
            $rowsAffected = $deleteStmt->rowCount();

            return $result && $rowsAffected > 0;
        } catch (PDOException $e) {
            error_log("ERROR: Database error in deleteCertificate: " . $e->getMessage());
            return false;
        }
    }

    public function updateCertificateById($certificate_id, $jobseeker_id, $certData)
    {
        try {

            $stmt = $this->db->prepare("
            UPDATE jobseeker_certificates 
            SET certificate_title = ?, issuing_organization = ?, date_issued = ?
            WHERE certificate_id = ? AND jobseeker_id = ?
        ");

            $result = $stmt->execute([
                $certData['certificate_title'],
                $certData['issuing_organization'] ?? 'Unknown',
                $certData['date_issued'] ?? date('Y-m-d'),
                $certificate_id,
                $jobseeker_id
            ]);

            $rowsAffected = $stmt->rowCount();

            return $result && $rowsAffected > 0;
        } catch (PDOException $e) {
            error_log("ERROR: Database error in updateCertificateById: " . $e->getMessage());
            return false;
        }
    }

    public function getCertificateById($certificate_id, $jobseeker_id)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT * FROM jobseeker_certificates 
            WHERE certificate_id = ? AND jobseeker_id = ?
        ");
            $stmt->execute([$certificate_id, $jobseeker_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ERROR: Database error in getCertificateById: " . $e->getMessage());
            return false;
        }
    }

    public function getRecommendationData($jobseeker_id)
    {
        try {
            // Get basic jobseeker info
            $jobseeker = $this->findById($jobseeker_id);
            if (!$jobseeker) {
                return null;
            }

            // Get skills
            $skills = $this->getJobseekerSkills($jobseeker_id);

            // Get work experience
            $workExperience = $this->getJobseekerWorkExperience($jobseeker_id);

            // Get education
            $education = $this->getJobseekerEducation($jobseeker_id);

            return [
                'jobseeker_id' => $jobseeker_id,
                'full_name' => trim($jobseeker['first_name'] . ' ' . $jobseeker['last_name']),
                'skills' => $skills,
                'work_experience' => $workExperience,
                'education' => $education
            ];
        } catch (PDOException $e) {
            error_log('Error getting recommendation data: ' . $e->getMessage());
            return null;
        }
    }

    public function getJobseekerSkills($jobseeker_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT skill_name, proficiency_level, esco_uri
                FROM jobseeker_skills 
                WHERE jobseeker_id = ?
                ORDER BY proficiency_level DESC, skill_name ASC
            ");
            $stmt->execute([$jobseeker_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting jobseeker skills: ' . $e->getMessage());
            return [];
        }
    }

    public function getJobseekerWorkExperience($jobseeker_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT job_title, company_name, start_date, end_date, 
                       responsibilities, employment_type, currently_working, experience_type
                FROM jobseeker_work_experience 
                WHERE jobseeker_id = ?
                ORDER BY start_date DESC
            ");
            $stmt->execute([$jobseeker_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting jobseeker work experience: ' . $e->getMessage());
            return [];
        }
    }

    public function getJobseekerEducation($jobseeker_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT school_name, education_level, start_date, end_date, field_of_study
                FROM jobseeker_education 
                WHERE jobseeker_id = ?
                ORDER BY end_date DESC
            ");
            $stmt->execute([$jobseeker_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting jobseeker education: ' . $e->getMessage());
            return [];
        }
    }

    public function getAllJobseekers()
    {
        try {
            $stmt = $this->db->prepare("
                SELECT j.jobseeker_id, j.first_name, j.last_name, u.email
                FROM jobseeker j
                JOIN users u ON j.user_id = u.user_id
                WHERE u.status = 'active'
                ORDER BY j.first_name, j.last_name
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting all jobseekers: ' . $e->getMessage());
            return [];
        }
    }
    public function findByJobseekerId($jobseekerId)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT j.*, u.email 
            FROM jobseeker j
            LEFT JOIN users u ON j.user_id = u.user_id
            WHERE j.jobseeker_id = ? 
            LIMIT 1
        ");

            $stmt->execute([$jobseekerId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error finding jobseeker by ID: " . $e->getMessage());
            return false;
        }
    }

    public function getAllWithBasicInfo()
    {
        try {
            $stmt = $this->db->prepare("
            SELECT 
                j.jobseeker_id, 
                j.user_id,
                j.first_name, 
                j.middle_name,
                j.last_name, 
                j.date_of_birth,
                j.sex,
                j.address,
                j.contact_no,
                j.acc_status,
                j.profile_completion,
                j.created_at,
                u.email,
                u.status as user_status,
                CONCAT(j.first_name, ' ', COALESCE(j.middle_name, ''), ' ', j.last_name) as full_name
            FROM jobseeker j
            JOIN users u ON j.user_id = u.user_id
            WHERE u.status = 'active' 
            AND j.acc_status != 'disabled'
            ORDER BY j.first_name, j.last_name
        ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting jobseekers with basic info: ' . $e->getMessage());
            return [];
        }
    }
}
