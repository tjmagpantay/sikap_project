<?php
// filepath: app/models/JobApplication.php
require_once __DIR__ . '/../../config/sikap_db.php';

class JobApplication
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

    public function createApplication($data)
    {
        try {
            $sql = "INSERT INTO job_application (
                jobseeker_id, job_id, application_status, resume_path, cover_letter, applied_at
            ) VALUES (
                :jobseeker_id, :job_id, 'pending', :resume_path, :cover_letter, NOW()
            )";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log('Error creating job application: ' . $e->getMessage());
            return false;
        }
    }

    public function saveApplicationAnswer($application_id, $question_id, $answer)
    {
        try {
            $sql = "INSERT INTO job_application_answers (application_id, question_id, answer) 
                    VALUES (:application_id, :question_id, :answer)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'application_id' => $application_id,
                'question_id' => $question_id,
                'answer' => $answer
            ]);
        } catch (PDOException $e) {
            error_log('Error saving application answer: ' . $e->getMessage());
            return false;
        }
    }

    public function saveApplicationAttachment($application_id, $file_path, $file_type)
    {
        try {
            $sql = "INSERT INTO application_attachments (application_id, file_path, file_type, uploaded_at) 
                    VALUES (:application_id, :file_path, :file_type, NOW())";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'application_id' => $application_id,
                'file_path' => $file_path,
                'file_type' => $file_type
            ]);
        } catch (PDOException $e) {
            error_log('Error saving application attachment: ' . $e->getMessage());
            return false;
        }
    }

    public function hasApplied($jobseeker_id, $job_id)
    {
        try {
            $sql = "SELECT application_id FROM job_application 
                    WHERE jobseeker_id = :jobseeker_id AND job_id = :job_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['jobseeker_id' => $jobseeker_id, 'job_id' => $job_id]);
            return $stmt->fetch() !== false;
        } catch (PDOException $e) {
            error_log('Error checking if user has applied: ' . $e->getMessage());
            return false;
        }
    }

    public function getApplicationsByJobseeker($jobseeker_id)
    {
        try {
            $sql = "SELECT ja.*, jp.job_title, jp.job_type, jp.location, 
                           e.first_name as employer_first_name, e.last_name as employer_last_name,
                           eb.business_name as company_name
                    FROM job_application ja
                    JOIN job_post jp ON ja.job_id = jp.job_id
                    JOIN employer e ON jp.employer_id = e.employer_id
                    LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                    WHERE ja.jobseeker_id = :jobseeker_id
                    ORDER BY ja.applied_at DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['jobseeker_id' => $jobseeker_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting applications by jobseeker: ' . $e->getMessage());
            return [];
        }
    }

    public function getApplicationDetails($application_id, $jobseeker_id = null)
    {
        try {
            $sql = "SELECT ja.*, jp.job_title, jp.job_summary, jp.job_type, jp.location, jp.salary, jp.show_pay,
                           e.first_name as employer_first_name, e.last_name as employer_last_name,
                           eb.business_name as company_name, eb.business_desc
                    FROM job_application ja
                    JOIN job_post jp ON ja.job_id = jp.job_id
                    JOIN employer e ON jp.employer_id = e.employer_id
                    LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                    WHERE ja.application_id = :application_id";
            
            if ($jobseeker_id) {
                $sql .= " AND ja.jobseeker_id = :jobseeker_id";
            }
            
            $stmt = $this->db->prepare($sql);
            $params = ['application_id' => $application_id];
            if ($jobseeker_id) {
                $params['jobseeker_id'] = $jobseeker_id;
            }
            
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting application details: ' . $e->getMessage());
            return false;
        }
    }

    public function getApplicationAnswers($application_id)
    {
        try {
            $sql = "SELECT jaa.*, jpq.question_text, jpq.question_type
                    FROM job_application_answers jaa
                    JOIN job_post_questions jpq ON jaa.question_id = jpq.question_id
                    WHERE jaa.application_id = :application_id
                    ORDER BY jpq.question_id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['application_id' => $application_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting application answers: ' . $e->getMessage());
            return [];
        }
    }

    public function getApplicationAttachments($application_id)
    {
        try {
            $sql = "SELECT * FROM application_attachments 
                    WHERE application_id = :application_id
                    ORDER BY uploaded_at";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['application_id' => $application_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting application attachments: ' . $e->getMessage());
            return [];
        }
    }

    public function updateApplicationStatus($application_id, $status, $employer_id = null)
    {
        try {
            $sql = "UPDATE job_application ja
                    JOIN job_post jp ON ja.job_id = jp.job_id
                    SET ja.application_status = :status, ja.reviewed_at = NOW()
                    WHERE ja.application_id = :application_id";
            
            if ($employer_id) {
                $sql .= " AND jp.employer_id = :employer_id";
            }
            
            $stmt = $this->db->prepare($sql);
            $params = ['application_id' => $application_id, 'status' => $status];
            if ($employer_id) {
                $params['employer_id'] = $employer_id;
            }
            
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log('Error updating application status: ' . $e->getMessage());
            return false;
        }
    }

    public function withdrawApplication($application_id, $jobseeker_id)
    {
        try {
            // Only allow withdrawal if status is pending
            $sql = "DELETE FROM job_application 
                    WHERE application_id = :application_id 
                    AND jobseeker_id = :jobseeker_id 
                    AND application_status = 'pending'";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'application_id' => $application_id,
                'jobseeker_id' => $jobseeker_id
            ]);
        } catch (PDOException $e) {
            error_log('Error withdrawing application: ' . $e->getMessage());
            return false;
        }
    }
}