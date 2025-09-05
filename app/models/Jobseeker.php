<?php
require_once __DIR__ . '/../../config/sikap_db.php';

class Jobseeker
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


    public function findByUserId($user_id)
    {
        $stmt = $this->db->prepare("
            SELECT j.*, u.email, u.status 
            FROM jobseeker j 
            JOIN users u ON j.user_id = u.user_id 
            WHERE j.user_id = ?
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function updateEducation($jobseeker_id, $data, $education_id)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE jobseeker_education 
                SET school_name = ?, education_level = ?, field_of_study = ?, start_date = ?, end_date = ?, updated_at = NOW()
                WHERE education_id = ? AND jobseeker_id = ?
            ");
            return $stmt->execute([
                $data['school_name'],
                $data['education_level'],
                $data['field_of_study'],
                $data['start_date'],
                $data['end_date'],
                $education_id,
                $jobseeker_id
            ]);
        } catch (PDOException $e) {
            error_log('Error updating education: ' . $e->getMessage());
            return false;
        }
    }

    public function saveWorkExperience($jobseeker_id, $data)
    {
        // If it's a current job, first remove any existing current job
        if ($data['currently_working'] == 1) {
            $removeCurrentSql = "UPDATE jobseeker_work_experience 
                           SET currently_working = 0 
                           WHERE jobseeker_id = ? AND currently_working = 1";
            $stmt = $this->db->prepare($removeCurrentSql);
            $stmt->execute([$jobseeker_id]);
        }

        $sql = "INSERT INTO jobseeker_work_experience 
                (jobseeker_id, job_title, company_name, employment_type, start_date, end_date, 
                 currently_working, responsibilities) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $jobseeker_id,
            $data['job_title'],
            $data['company_name'],
            $data['employment_type'],
            $data['start_date'],
            $data['end_date'],
            $data['currently_working'],
            $data['responsibilities']
        ]);
    }

    public function deleteWorkExperience($jobseeker_id, $experience_id)
    {
        $sql = "DELETE FROM jobseeker_work_experience WHERE experience_id = ? AND jobseeker_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$experience_id, $jobseeker_id]);
    }

    public function getWorkExperienceById($jobseeker_id, $experience_id)
    {
        $sql = "SELECT * FROM jobseeker_work_experience WHERE experience_id = ? AND jobseeker_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$experience_id, $jobseeker_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function hasCurrentJob($jobseeker_id)
    {
        $sql = "SELECT COUNT(*) FROM jobseeker_work_experience 
                WHERE jobseeker_id = ? AND currently_working = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$jobseeker_id]);
        return $stmt->fetchColumn() > 0;
    }

    public function getCurrentJob($jobseeker_id)
    {
        $sql = "SELECT * FROM jobseeker_work_experience 
                WHERE jobseeker_id = ? AND currently_working = 1 
                ORDER BY start_date DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$jobseeker_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateWorkExperience($jobseeker_id, $data, $experience_id)
    {
        $sql = "UPDATE jobseeker_work_experience SET 
                job_title = ?, 
                company_name = ?, 
                employment_type = ?, 
                start_date = ?, 
                end_date = ?, 
                currently_working = ?, 
                responsibilities = ? 
                WHERE experience_id = ? AND jobseeker_id = ?";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['job_title'],
            $data['company_name'],
            $data['employment_type'],
            $data['start_date'],
            $data['end_date'],
            $data['currently_working'],
            $data['responsibilities'],
            $experience_id,
            $jobseeker_id
        ]);
    }

    public function deleteSkills($jobseeker_id)
    {
        $sql = "DELETE FROM jobseeker_skills WHERE jobseeker_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$jobseeker_id]);
    }

    public function saveSkill($jobseeker_id, $data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO jobseeker_skills (jobseeker_id, skill_name, proficiency_level) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$jobseeker_id, $data['skill_name'], $data['proficiency_level']]);
    }

    public function saveCertificate($jobseeker_id, $data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO jobseeker_certificates (jobseeker_id, certificate_title, issuing_organization, date_issued) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$jobseeker_id, $data['certificate_title'], $data['issuing_organization'], $data['date_issued']]);
    }

    public function markProfileComplete($user_id)
    {
        try {
            $sql = "UPDATE jobseeker SET profile_completed = 1, updated_at = CURRENT_TIMESTAMP WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['user_id' => $user_id]);
        } catch (PDOException $e) {
            error_log('Error marking profile as complete: ' . $e->getMessage());
            return false;
        }
    }

    public function getEducation($user_id)
    {
        $jobseeker = $this->findByUserId($user_id);
        if (!$jobseeker) return [];

        $stmt = $this->db->prepare("
            SELECT * FROM jobseeker_education 
            WHERE jobseeker_id = ? 
            ORDER BY start_date DESC
        ");
        $stmt->execute([$jobseeker['jobseeker_id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWorkExperience($user_id)
    {
        $jobseeker = $this->findByUserId($user_id);
        if (!$jobseeker) return [];

        $stmt = $this->db->prepare("
            SELECT * FROM jobseeker_work_experience 
            WHERE jobseeker_id = ? 
            ORDER BY start_date DESC
        ");
        $stmt->execute([$jobseeker['jobseeker_id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSkills($user_id)
    {
        $jobseeker = $this->findByUserId($user_id);
        if (!$jobseeker) return [];

        $stmt = $this->db->prepare("
            SELECT * FROM jobseeker_skills 
            WHERE jobseeker_id = ? 
            ORDER BY proficiency_level DESC, skill_name ASC
        ");
        $stmt->execute([$jobseeker['jobseeker_id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCertificates($user_id)
    {
        $jobseeker = $this->findByUserId($user_id);
        if (!$jobseeker) return [];

        $stmt = $this->db->prepare("
            SELECT * FROM jobseeker_certificates 
            WHERE jobseeker_id = ? 
            ORDER BY date_issued DESC
        ");
        $stmt->execute([$jobseeker['jobseeker_id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDocuments($user_id)
    {
        try {
            // First get the jobseeker_id from user_id
            $jobseeker = $this->findByUserId($user_id);
            if (!$jobseeker) {
                return [];
            }

            $sql = "SELECT * FROM jobseeker_documents 
                    WHERE jobseeker_id = :jobseeker_id 
                    ORDER BY uploaded_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['jobseeker_id' => $jobseeker['jobseeker_id']]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting jobseeker documents: ' . $e->getMessage());
            return [];
        }
    }

    public function calculateProfileCompletion($user_id)
    {
        $jobseeker = $this->findByUserId($user_id);
        if (!$jobseeker) {
            return 0;
        }

        $completionScore = 0;

        // Basic profile info (first_name, last_name, contact_no) - 20%
        $fields = ['first_name', 'last_name', 'contact_no'];
        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($jobseeker[$field])) {
                $filled++;
            }
        }
        $basicScore = ($filled / count($fields)) * 20;
        $completionScore += $basicScore;

        // Documents (15%)
        $documents = $this->getDocuments($user_id);
        if (!empty($documents)) {
            $completionScore += 15;
        }

        // Education (15%)
        $education = $this->getEducation($user_id);
        if (!empty($education)) {
            $completionScore += 15;
        }

        // Work Experience (20%)
        $workExp = $this->getWorkExperience($user_id);
        if (!empty($workExp)) {
            $completionScore += 20;
        }

        // Skills (15%)
        $skills = $this->getSkills($user_id);
        if (!empty($skills)) {
            $completionScore += 15;
        }

        // Certificates (10%)
        $certificates = $this->getCertificates($user_id);
        if (!empty($certificates)) {
            $completionScore += 10;
        }

        // Address (5%)
        if (!empty($jobseeker['address'])) {
            $completionScore += 5;
        }

        $finalScore = min(100, round($completionScore));

        // Debug log only when there's a discrepancy
        error_log("ProfileCompletion Debug - User ID: $user_id, Final Score: $finalScore");

        return $finalScore;
    }
    public function getDocumentById($documentId)
    {
        try {
            $sql = "SELECT * FROM jobseeker_documents WHERE document_id = :document_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['document_id' => $documentId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting document by ID: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteDocumentByType($jobseeker_id, $file_type)
    {
        try {
            // Get the file path first to delete the physical file
            $stmt = $this->db->prepare("SELECT file_path FROM jobseeker_documents WHERE jobseeker_id = ? AND file_type = ?");
            $stmt->execute([$jobseeker_id, $file_type]);
            $doc = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$doc) {
                return true; // Document doesn't exist
            }

            // Delete the physical file
            if ($doc['file_path'] && file_exists(__DIR__ . '/../../' . $doc['file_path'])) {
                unlink(__DIR__ . '/../../' . $doc['file_path']);
            }

            // Delete from database (CASCADE will handle application_attachments)
            $stmt = $this->db->prepare("DELETE FROM jobseeker_documents WHERE jobseeker_id = ? AND file_type = ?");
            return $stmt->execute([$jobseeker_id, $file_type]);
        } catch (PDOException $e) {
            error_log('Error deleting document: ' . $e->getMessage());
            return false;
        }
    }

    public function updateProfilePhoto($user_id, $photo_path)
    {
        $stmt = $this->db->prepare("UPDATE jobseeker SET profile_picture = ? WHERE user_id = ?");
        return $stmt->execute([$photo_path, $user_id]);
    }

    public function updateProfilePicture($user_id, $profile_picture_path)
    {
        try {
            $sql = "UPDATE jobseeker SET profile_picture = ?, updated_at = NOW() WHERE user_id = ?";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$profile_picture_path, $user_id]);

            if ($result) {
                error_log("DEBUG: Profile picture updated in database for user_id: $user_id, path: $profile_picture_path");
            } else {
                error_log("DEBUG: Failed to update profile picture in database for user_id: $user_id");
            }

            return $result;
        } catch (PDOException $e) {
            error_log('Error updating profile picture: ' . $e->getMessage());
            return false;
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

    public function updateCertificate($jobseeker_id, $data, $certificate_id)
    {
        $sql = "UPDATE jobseeker_certificates SET 
                certificate_title = ?, 
                issuing_organization = ?, 
                date_issued = ? 
                WHERE certificate_id = ? AND jobseeker_id = ?";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['certificate_title'],
            $data['issuing_organization'],
            $data['date_issued'],
            $certificate_id,
            $jobseeker_id
        ]);
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
            $sql = "SELECT * FROM jobseekers WHERE jobseeker_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$jobseeker_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error finding jobseeker by ID: ' . $e->getMessage());
            return false;
        }
    }
}
