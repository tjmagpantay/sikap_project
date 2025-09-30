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
        } catch (PDOException $e) {
            error_log("JobPost database connection failed: " . $e->getMessage());
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getAllApplicantsGroupedByJob($employer_id = null)
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
                JOIN job_post jp ON ja.job_id = jp.job_id";

        // Add WHERE clause if employer_id is provided
        if ($employer_id !== null) {
            $sql .= " WHERE jp.employer_id = ?";
        }

        $sql .= " ORDER BY jp.job_title, ja.applied_at DESC";

        $stmt = $this->db->prepare($sql);

        if ($employer_id !== null) {
            $stmt->execute([$employer_id]);
        } else {
            $stmt->execute();
        }

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

    public function getAllApplicants($employer_id = null)
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
                JOIN jobseeker js ON ja.jobseeker_id = js.jobseeker_id";

        // Add JOIN with job_post if we need to filter by employer
        if ($employer_id !== null) {
            $sql .= " JOIN job_post jp ON ja.job_id = jp.job_id WHERE jp.employer_id = ?";
        }

        $sql .= " ORDER BY ja.applied_at DESC";

        $stmt = $this->db->prepare($sql);

        if ($employer_id !== null) {
            $stmt->execute([$employer_id]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getApplicantsByJob($job_id, $employer_id = null)
    {
        $sql = "SELECT 
                    ja.application_id,
                    ja.jobseeker_id,
                    ja.application_status,
                    ja.applied_at,
                    js.first_name,
                    js.last_name,
                    js.profile_picture,
                    u.email
                FROM job_application ja
                JOIN jobseeker js ON ja.jobseeker_id = js.jobseeker_id
                JOIN users u ON js.user_id = u.user_id";

        // Add JOIN with job_post to verify employer ownership
        if ($employer_id !== null) {
            $sql .= " JOIN job_post jp ON ja.job_id = jp.job_id
                     WHERE ja.job_id = ? AND jp.employer_id = ? AND ja.is_finalized = 1";
        } else {
            $sql .= " WHERE ja.job_id = ? AND ja.is_finalized = 1";
        }

        $sql .= " ORDER BY ja.applied_at DESC";

        $stmt = $this->db->prepare($sql);

        if ($employer_id !== null) {
            $stmt->execute([$job_id, $employer_id]);
        } else {
            $stmt->execute([$job_id]);
        }

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
}
