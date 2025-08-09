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
                   js.profile_picture, js.profile_completion,
                   u.email,
                   jp.job_title, jp.job_summary, jp.job_type, jp.location
            FROM job_application ja
            JOIN jobseeker js ON ja.jobseeker_id = js.jobseeker_id
            JOIN users u ON js.user_id = u.user_id
            JOIN job_post jp ON ja.job_id = jp.job_id
            WHERE ja.application_id = ?
        ");
        $stmt->execute([$application_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
