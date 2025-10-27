<?php
require_once __DIR__ . '/Jobseeker.php';

class ReviewApplication
{
    protected $db;
    private $jobseekerModel;

    public function __construct()
    {
        // Use the same config as Jobseeker model for consistency
        $config = require __DIR__ . '/../../config/sikap_db.php';
        try {
            // FIXED: Add Railway port to DSN
            $this->db = new PDO(
                "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4",
                $config['db_user'],
                $config['db_pass'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_TIMEOUT => 30
                ]
            );
        } catch (PDOException $e) {
            error_log("ReviewApplication database connection failed: " . $e->getMessage());
            die("Connection failed: " . $e->getMessage());
        }

        $this->jobseekerModel = new Jobseeker();
    }

    public function getApplication($application_id)
    {
        $stmt = $this->db->prepare("
        SELECT 
            ja.*,
            -- Jobseeker basic info
            js.first_name, 
            js.middle_name, 
            js.last_name, 
            js.suffix,
            js.date_of_birth, 
            js.sex, 
            js.address, 
            js.contact_no,
            js.profile_picture, 
            js.profile_completion, 
            js.created_at as jobseeker_created_at,
            js.updated_at as jobseeker_updated_at, 
            js.profile_completed, 
            js.user_id,
            -- User info
            u.user_id as user_id, 
            u.email, 
            u.created_at as user_created_at, 
            u.status as user_status,
            -- Job post info
            jp.job_title, 
            jp.job_summary, 
            jp.job_type, 
            jp.location, 
            jp.pay_range,
            -- Application eligibility (FIXED: Added to GROUP BY)
            MAX(jae.interested_program) as interested_program, 
            MAX(jae.priority_sector) as priority_sector,
            -- Education data
            GROUP_CONCAT(DISTINCT CONCAT_WS('|', e.education_id, e.school_name, e.education_level, e.field_of_study, e.start_date, e.end_date) SEPARATOR ';;') as education_data,
            -- Skills data
            GROUP_CONCAT(DISTINCT CONCAT_WS('|', s.skill_id, s.skill_name, s.proficiency_level) SEPARATOR ';;') as skills_data,
            -- Work experience data
            GROUP_CONCAT(DISTINCT CONCAT_WS('|', w.experience_id, w.job_title, w.company_name, w.start_date, w.end_date, w.responsibilities, w.achievements, w.employment_type, w.currently_working) SEPARATOR ';;') as work_experience_data,
            -- Certificates data
            GROUP_CONCAT(DISTINCT CONCAT_WS('|', c.certificate_id, c.certificate_title, c.issuing_organization, c.date_issued) SEPARATOR ';;') as certificates_data
        FROM job_application ja
        LEFT JOIN jobseeker js ON ja.jobseeker_id = js.jobseeker_id
        LEFT JOIN users u ON js.user_id = u.user_id
        LEFT JOIN job_post jp ON ja.job_id = jp.job_id
        LEFT JOIN job_application_eligibility jae ON ja.application_id = jae.application_id
        LEFT JOIN jobseeker_education e ON js.jobseeker_id = e.jobseeker_id
        LEFT JOIN jobseeker_skills s ON js.jobseeker_id = s.jobseeker_id
        LEFT JOIN jobseeker_work_experience w ON js.jobseeker_id = w.jobseeker_id
        LEFT JOIN jobseeker_certificates c ON js.jobseeker_id = c.jobseeker_id
        WHERE ja.application_id = ?
        GROUP BY 
            ja.application_id, ja.jobseeker_id, ja.job_id, ja.application_status, ja.applied_at, ja.reviewed_at,
            js.jobseeker_id, js.first_name, js.middle_name, js.last_name, js.suffix, js.date_of_birth, 
            js.sex, js.address, js.contact_no, js.profile_picture, js.profile_completion, 
            js.created_at, js.updated_at, js.profile_completed, js.user_id,
            u.user_id, u.email, u.created_at, u.status,
            jp.job_id, jp.job_title, jp.job_summary, jp.job_type, jp.location, jp.pay_range
    ");
        $stmt->execute([$application_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Parse the concatenated data into arrays
            $result['education'] = $this->parseEducationData($result['education_data'] ?? '');
            $result['skills'] = $this->parseSkillsData($result['skills_data'] ?? '');
            $result['work_experience'] = $this->parseWorkExperienceData($result['work_experience_data'] ?? '');
            $result['certificates'] = $this->parseCertificatesData($result['certificates_data'] ?? '');

            // Clean up the raw concatenated data
            unset($result['education_data'], $result['skills_data'], $result['work_experience_data'], $result['certificates_data']);
        }

        return $result;
    }

    public function getJobseekerEducation($jobseeker_id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM jobseeker_education 
            WHERE jobseeker_id = ? 
            ORDER BY start_date DESC
        ");
        $stmt->execute([$jobseeker_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJobseekerWorkExperience($jobseeker_id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM jobseeker_work_experience 
            WHERE jobseeker_id = ? 
            ORDER BY start_date DESC
        ");
        $stmt->execute([$jobseeker_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJobseekerSkills($jobseeker_id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM jobseeker_skills 
            WHERE jobseeker_id = ? 
            ORDER BY proficiency_level DESC, skill_name ASC
        ");
        $stmt->execute([$jobseeker_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJobseekerCertificates($jobseeker_id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM jobseeker_certificates 
            WHERE jobseeker_id = ? 
            ORDER BY date_issued DESC
        ");
        $stmt->execute([$jobseeker_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJobseekerDocuments($jobseeker_id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM jobseeker_documents 
            WHERE jobseeker_id = ? 
            ORDER BY uploaded_at DESC
        ");
        $stmt->execute([$jobseeker_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getApplicationAnswers($application_id)
    {
        $stmt = $this->db->prepare("
            SELECT jaa.*, jq.question_text, jq.question_type 
            FROM job_application_answers jaa
            LEFT JOIN job_post_questions jq ON jaa.question_id = jq.question_id
            WHERE jaa.application_id = ?
            ORDER BY jaa.question_id;
        ");
        $stmt->execute([$application_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFullApplicationDetails($application_id)
    {
        $application = $this->getApplication($application_id);

        if ($application && !empty($application['jobseeker_id'])) {
            $jobseeker_id = $application['jobseeker_id'];
            $user_id = $application['user_id'] ?? null;

            $application['documents'] = $this->getJobseekerDocuments($jobseeker_id);
            $application['answers'] = $this->getApplicationAnswers($application_id);

            // Get REAL profile completion percentage using Jobseeker model
            if ($user_id) {
                $application['profile_completion_percentage'] = $this->jobseekerModel->calculateProfileCompletion($user_id);
            } else {
                $application['profile_completion_percentage'] = 0;
            }

            // Get resume/CV documents specifically
            $application['resume_documents'] = $this->getResumeDocuments($jobseeker_id);
        }

        return $application;
    }

    public function getResumeDocuments($jobseeker_id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM jobseeker_documents 
            WHERE jobseeker_id = ? 
            AND (file_type LIKE '%resume%' OR file_type LIKE '%cv%' OR file_name LIKE '%resume%' OR file_name LIKE '%cv%')
            ORDER BY uploaded_at DESC
        ");
        $stmt->execute([$jobseeker_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProfileCompletionPercentage($user_id)
    {
        return $this->jobseekerModel->calculateProfileCompletion($user_id);
    }

    public function getInterview($application_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM job_application_management WHERE application_id = ?");
        $stmt->execute([$application_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($application_id, $status, $changed_by_role = 'employer', $remarks = null)
    {
        $stmt = $this->db->prepare("UPDATE job_application SET application_status = ?, reviewed_at = NOW() WHERE application_id = ?");
        $result = $stmt->execute([$status, $application_id]);
        if ($result) {
            $this->logStatusChange($application_id, $status, $changed_by_role, $remarks);
        }
        return $result;
    }

    public function scheduleInterview($application_id, $date, $location, $notes, $managed_by_user_id)
    {
        $stmt = $this->db->prepare("SELECT job_manage_id FROM job_application_management WHERE application_id = ?");
        $stmt->execute([$application_id]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Update existing interview
            $stmt = $this->db->prepare("UPDATE job_application_management SET interview_date = ?, interview_location = ?, notes = ?, managed_by_user_id = ? WHERE application_id = ?");
            return $stmt->execute([$date, $location, $notes, $managed_by_user_id, $application_id]);
        } else {
            // Insert new interview
            $stmt = $this->db->prepare("INSERT INTO job_application_management (application_id, interview_date, interview_location, notes, managed_by_user_id) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$application_id, $date, $location, $notes, $managed_by_user_id]);
        }
    }

    public function logStatusChange($application_id, $status, $changed_by_role, $remarks = null)
    {
        $stmt = $this->db->prepare("INSERT INTO job_application_status_logs (application_id, status, changed_by_role, changed_at, remarks) VALUES (?, ?, ?, NOW(), ?)");
        return $stmt->execute([$application_id, $status, $changed_by_role, $remarks]);
    }

    public function getApplicationBasic($application_id)
    {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    ja.application_id,
                    ja.jobseeker_id,
                    ja.job_id,
                    ja.application_status,
                    ja.applied_at,
                    jp.job_title,
                    jp.employer_id,
                    js.user_id as jobseeker_user_id,
                    js.first_name,
                    js.last_name
                FROM job_application ja
                JOIN job_post jp ON ja.job_id = jp.job_id
                JOIN jobseeker js ON ja.jobseeker_id = js.jobseeker_id
                WHERE ja.application_id = ?
            ");
            $stmt->execute([$application_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);


            return $result;
        } catch (Exception $e) {
            error_log("Error getting basic application details: " . $e->getMessage());
            return null;
        }
    }

    private function parseEducationData($data)
    {
        if (empty($data)) return [];

        $items = explode(';;', $data);
        $education = [];

        foreach ($items as $item) {
            if (empty($item)) continue;
            $parts = explode('|', $item);
            if (count($parts) >= 6) {
                $education[] = [
                    'education_id' => $parts[0],
                    'school_name' => $parts[1],
                    'education_level' => $parts[2],
                    'field_of_study' => $parts[3],
                    'start_date' => $parts[4],
                    'end_date' => $parts[5]
                ];
            }
        }

        return $education;
    }

    private function parseSkillsData($data)
    {
        if (empty($data)) return [];

        $items = explode(';;', $data);
        $skills = [];

        foreach ($items as $item) {
            if (empty($item)) continue;
            $parts = explode('|', $item);
            if (count($parts) >= 3) {
                $skills[] = [
                    'skill_id' => $parts[0],
                    'skill_name' => $parts[1],
                    'proficiency_level' => $parts[2]
                ];
            }
        }

        return $skills;
    }

    private function parseWorkExperienceData($data)
    {
        if (empty($data)) return [];

        $items = explode(';;', $data);
        $work_experience = [];

        foreach ($items as $item) {
            if (empty($item)) continue;
            $parts = explode('|', $item);
            if (count($parts) >= 9) {
                $work_experience[] = [
                    'work_experience_id' => $parts[0],
                    'job_title' => $parts[1],
                    'company_name' => $parts[2],
                    'start_date' => $parts[3],
                    'end_date' => $parts[4],
                    'responsibilities' => $parts[5],
                    'achievements' => $parts[6],
                    'employment_type' => $parts[7],
                    'currently_working' => $parts[8]
                ];
            }
        }

        return $work_experience;
    }

    private function parseCertificatesData($data)
    {
        if (empty($data)) return [];

        $items = explode(';;', $data);
        $certificates = [];

        foreach ($items as $item) {
            if (empty($item)) continue;
            $parts = explode('|', $item);
            if (count($parts) >= 4) {
                $certificates[] = [
                    'certificate_id' => $parts[0],
                    'certificate_title' => $parts[1],
                    'issuing_organization' => $parts[2],
                    'date_issued' => $parts[3]
                ];
            }
        }

        return $certificates;
    }

    public function getPendingApplicationsWithExpiredInterview()
    {
        $stmt = $this->db->prepare("
            SELECT 
                ja.application_id,
                ja.application_status,
                jam.interview_date,
                e.employer_id,
                e.company_name AS employer_name,
                u.email AS employer_email,
                CONCAT(js.first_name, ' ', js.last_name) AS jobseeker_name
            FROM job_application ja
            INNER JOIN job_application_management jam 
                ON ja.application_id = jam.application_id
            INNER JOIN job_post jp 
                ON ja.job_id = jp.job_id
            INNER JOIN employer e 
                ON jp.employer_id = e.employer_id
            INNER JOIN users u 
                ON e.user_id = u.user_id
            INNER JOIN jobseeker js 
                ON ja.jobseeker_id = js.jobseeker_id
            WHERE ja.application_status = 'shortlisted'
              AND DATE(jam.interview_date) <= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
