<?php

require_once __DIR__ . '/../../config/sikap_db.php';

class JobApplicants
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
            error_log("DEBUG: JobPost database connection established successfully");
        } catch (PDOException $e) {
            error_log("JobPost database connection failed: " . $e->getMessage());
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getAllApplicantsGroupedByJob()
    {
        $sql = "SELECT 
                    ja.application_id,
                    ja.jobseeker_id,
                    ja.job_id,
                    ja.application_status,
                    ja.applied_at,
                    js.first_name,
                    js.last_name,
                    u.email,
                    js.profile_picture,
                    jp.job_title
                FROM job_application ja
                JOIN jobseeker js ON ja.jobseeker_id = js.jobseeker_id
                JOIN users u ON js.user_id = u.user_id
                JOIN job_post jp ON ja.job_id = jp.job_id
                ORDER BY jp.job_title, ja.applied_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Group by job title
        $grouped = [];
        foreach ($results as $applicant) {
            $jobTitle = $applicant['job_title'];
            if (!isset($grouped[$jobTitle])) {
                $grouped[$jobTitle] = [];
            }
            $grouped[$jobTitle][] = $applicant;
        }

        return $grouped;
    }

    public function getAllApplicants()
    {
        $sql = "SELECT 
                    ja.application_id,
                    ja.jobseeker_id,
                    ja.job_id,
                    ja.application_status,
                    ja.applied_at,
                    js.first_name,
                    js.last_name,
                    js.profile_picture
                FROM job_application ja
                JOIN jobseeker js ON ja.jobseeker_id = js.jobseeker_id
                ORDER BY ja.applied_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getApplicantsByJob($job_id)
    {
        $sql = "SELECT 
                    ja.application_id,
                    ja.jobseeker_id,
                    ja.application_status,
                    ja.applied_at,
                    js.first_name,
                    js.last_name,
                    js.profile_picture
                FROM job_application ja
                JOIN jobseeker js ON ja.jobseeker_id = js.jobseeker_id
                WHERE ja.job_id = ?
                ORDER BY ja.applied_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$job_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
