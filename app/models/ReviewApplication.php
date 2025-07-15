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
        $stmt = $this->db->prepare("SELECT * FROM job_application WHERE application_id = ?");
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
