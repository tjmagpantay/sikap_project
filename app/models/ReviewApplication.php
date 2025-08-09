<?php
class ReviewApplication
{
    protected $db;

    public function __construct()
    {
        // Update DSN as needed for your environment
        $this->db = new PDO('mysql:host=localhost;dbname=sikap_db;charset=utf8mb4', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getApplication($application_id)
    {
        $stmt = $this->db->prepare("
            SELECT ja.*, 
                   js.first_name, js.last_name, js.middle_name, js.suffix,
                   js.date_of_birth, js.sex, js.address, js.contact_no,
                   js.profile_picture, js.profile_completion, js.created_at as jobseeker_created_at,
                   js.updated_at as jobseeker_updated_at, js.profile_completed,
                   u.email, u.created_at as user_created_at, u.status as user_status,
                   jp.job_title, jp.job_summary, jp.job_type, jp.location, jp.pay_range,
                   jae.interested_program, jae.priority_sector
            FROM job_application ja
            LEFT JOIN jobseeker js ON ja.jobseeker_id = js.jobseeker_id
            LEFT JOIN users u ON js.user_id = u.user_id
            LEFT JOIN job_post jp ON ja.job_id = jp.job_id
            LEFT JOIN job_application_eligibility jae ON ja.application_id = jae.application_id
            WHERE ja.application_id = ?
        ");
        $stmt->execute([$application_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
            LEFT JOIN job_questions jq ON jaa.question_id = jq.question_id
            WHERE jaa.application_id = ?
            ORDER BY jaa.question_id
        ");
        $stmt->execute([$application_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFullApplicationDetails($application_id)
    {
        $application = $this->getApplication($application_id);

        if ($application && !empty($application['jobseeker_id'])) {
            $jobseeker_id = $application['jobseeker_id'];

            $application['education'] = $this->getJobseekerEducation($jobseeker_id);
            $application['work_experience'] = $this->getJobseekerWorkExperience($jobseeker_id);
            $application['skills'] = $this->getJobseekerSkills($jobseeker_id);
            $application['certificates'] = $this->getJobseekerCertificates($jobseeker_id);
            $application['documents'] = $this->getJobseekerDocuments($jobseeker_id);
            $application['answers'] = $this->getApplicationAnswers($application_id);
        }

        return $application;
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
        // Check if interview already exists
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
}
