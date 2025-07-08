<?php
// filepath: c:\xampp\htdocs\sikap\app\models\SavedJobs.php
require_once __DIR__ . '/../../config/sikap_db.php';

class SavedJobs
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
            error_log("SavedJobs database connection failed: " . $e->getMessage());
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function saveJob($jobseeker_id, $job_id)
    {
        try {
            // Check if already saved - prevent duplicate saves
            if ($this->isSaved($jobseeker_id, $job_id)) {
                error_log("DEBUG: Job $job_id already saved by jobseeker $jobseeker_id");
                return false; // Already saved - return false to indicate no action taken
            }

            // Add unique constraint check as extra safety
            $sql = "INSERT IGNORE INTO jobseeker_saved_jobs (jobseeker_id, job_id) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$jobseeker_id, $job_id]);
            
            if ($result && $stmt->rowCount() > 0) {
                error_log("DEBUG: Successfully saved job $job_id for jobseeker $jobseeker_id");
                return true;
            } else {
                error_log("DEBUG: No rows affected - job $job_id may already be saved for jobseeker $jobseeker_id");
                return false;
            }
        } catch (PDOException $e) {
            error_log('Error saving job: ' . $e->getMessage());
            return false;
        }
    }

    public function unsaveJob($jobseeker_id, $job_id)
    {
        try {
            $sql = "DELETE FROM jobseeker_saved_jobs WHERE jobseeker_id = ? AND job_id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$jobseeker_id, $job_id]);
        } catch (PDOException $e) {
            error_log('Error unsaving job: ' . $e->getMessage());
            return false;
        }
    }

    public function isSaved($jobseeker_id, $job_id)
    {
        try {
            $sql = "SELECT COUNT(*) FROM jobseeker_saved_jobs WHERE jobseeker_id = ? AND job_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$jobseeker_id, $job_id]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log('Error checking if job is saved: ' . $e->getMessage());
            return false;
        }
    }

    public function getSavedJobs($jobseeker_id)
    {
        try {
            $sql = "SELECT jp.job_id, jp.job_title, jp.job_summary, jp.location, jp.job_type, 
                           jp.salary, jp.show_pay, jp.job_status, jp.created_at, jp.application_deadline,
                           jc.category_name, 
                           e.first_name as employer_first_name, 
                           e.last_name as employer_last_name,
                           COALESCE(eb.business_name, CONCAT(e.first_name, ' ', e.last_name)) as company_name,
                           jsj.saved_at
                    FROM jobseeker_saved_jobs jsj
                    JOIN job_post jp ON jsj.job_id = jp.job_id
                    LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                    LEFT JOIN employer e ON jp.employer_id = e.employer_id
                    LEFT JOIN (
                        SELECT employer_id, MIN(business_name) as business_name
                        FROM employers_business
                        GROUP BY employer_id
                    ) eb ON e.employer_id = eb.employer_id
                    WHERE jsj.jobseeker_id = ?
                    AND jp.job_status = 'open'
                    AND (jp.application_deadline IS NULL OR jp.application_deadline > NOW())
                    ORDER BY jsj.saved_at DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$jobseeker_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting saved jobs: ' . $e->getMessage());
            return [];
        }
    }

    public function getSavedJobsCount($jobseeker_id)
    {
        try {
            $sql = "SELECT COUNT(*) FROM jobseeker_saved_jobs jsj
                    JOIN job_post jp ON jsj.job_id = jp.job_id
                    WHERE jsj.jobseeker_id = ? 
                    AND jp.job_status = 'open'
                    AND (jp.application_deadline IS NULL OR jp.application_deadline > NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$jobseeker_id]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log('Error getting saved jobs count: ' . $e->getMessage());
            return 0;
        }
    }
}