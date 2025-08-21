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
                jobseeker_id, job_id, application_status, applied_at
            ) VALUES (
                :jobseeker_id, :job_id, 'pending', NOW()
            )";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($data);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log('Error creating job application: ' . $e->getMessage());
            return false;
        }
    }

    public function createDraftApplication($data)
    {
        try {
            $sql = "INSERT INTO job_application (
                jobseeker_id, job_id, application_status, 
                current_step, is_finalized, applied_at
            ) VALUES (
                :jobseeker_id, :job_id, 'pending', 
                1, FALSE, NULL
            )";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                'jobseeker_id' => $data['jobseeker_id'],
                'job_id' => $data['job_id']
            ]);

            return $result ? $this->db->lastInsertId() : false;
        } catch (PDOException $e) {
            error_log('Error creating draft application: ' . $e->getMessage());
            return false;
        }
    }

    public function saveApplicationAnswer($application_id, $question_id, $answer)
    {
        try {
            $sql = "INSERT INTO job_application_answers (application_id, question_id, answer) 
                    VALUES (:application_id, :question_id, :answer)
                    ON DUPLICATE KEY UPDATE answer = :answer";
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
            $sql = "INSERT INTO application_attachments (application_id, file_path, file_type) 
                    VALUES (:application_id, :file_path, :file_type)";
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

    public function saveApplicationAttachmentReference($application_id, $profile_document_id, $file_type)
    {
        try {
            // Get the file path from profile document
            $sql = "SELECT file_path FROM jobseeker_documents WHERE document_id = :document_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['document_id' => $profile_document_id]);
            $doc = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$doc) {
                return false;
            }

            // Insert into application_attachments with reference
            $sql = "INSERT INTO application_attachments (application_id, file_path, file_type, profile_document_id) 
                    VALUES (:application_id, :file_path, :file_type, :profile_document_id)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'application_id' => $application_id,
                'file_path' => $doc['file_path'],
                'file_type' => $file_type,
                'profile_document_id' => $profile_document_id
            ]);
        } catch (PDOException $e) {
            error_log('Error saving application attachment reference: ' . $e->getMessage());
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
                           eb.business_name as company_name,
                           jam.interview_date, jam.interview_location, jam.notes
                    FROM job_application ja
                    JOIN job_post jp ON ja.job_id = jp.job_id
                    JOIN employer e ON jp.employer_id = e.employer_id
                    LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                    LEFT JOIN job_application_management jam ON ja.application_id = jam.application_id
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
                    LEFT JOIN job_post_questions jpq ON jaa.question_id = jpq.question_id
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

    public function updateApplication($application_id, $data)
    {
        try {
            $setParts = [];
            $params = ['application_id' => $application_id];

            foreach ($data as $key => $value) {
                $setParts[] = "$key = :$key";
                $params[$key] = $value;
            }

            $sql = "UPDATE job_application SET " . implode(', ', $setParts) . " WHERE application_id = :application_id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log('Error updating application: ' . $e->getMessage());
            return false;
        }
    }

    public function getApplicationByJobseekerAndJob($jobseeker_id, $job_id)
    {
        try {
            $sql = "SELECT * FROM job_application 
                WHERE jobseeker_id = :jobseeker_id AND job_id = :job_id 
                ORDER BY application_id DESC LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['jobseeker_id' => $jobseeker_id, 'job_id' => $job_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting application by jobseeker and job: ' . $e->getMessage());
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

    public function deleteApplicationAnswers($application_id)
    {
        try {
            $sql = "DELETE FROM job_application_answers WHERE application_id = :application_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['application_id' => $application_id]);
        } catch (PDOException $e) {
            error_log('Error deleting application answers: ' . $e->getMessage());
            return false;
        }
    }

    public function saveApplicationEligibility($data)
    {
        try {
            // First try to update existing record
            $sql = "UPDATE job_application_eligibility 
                SET interested_program = :interested_program, priority_sector = :priority_sector
                WHERE application_id = :application_id";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute($data);

            // If no rows affected, insert new record
            if ($stmt->rowCount() == 0) {
                $sql = "INSERT INTO job_application_eligibility (application_id, interested_program, priority_sector) 
                    VALUES (:application_id, :interested_program, :priority_sector)";
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute($data);
            }

            return $result;
        } catch (PDOException $e) {
            error_log('Error saving application eligibility: ' . $e->getMessage());
            return false;
        }
    }

    public function getApplicationEligibility($application_id)
    {
        try {
            $sql = "SELECT * FROM job_application_eligibility WHERE application_id = :application_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['application_id' => $application_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting application eligibility: ' . $e->getMessage());
            return false;
        }
    }

    public function logStatusChange($application_id, $status, $changed_by_role, $remarks = null)
    {
        try {
            $sql = "INSERT INTO job_application_status_logs (application_id, status, changed_by_role, remarks) 
                VALUES (:application_id, :status, :changed_by_role, :remarks)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'application_id' => $application_id,
                'status' => $status,
                'changed_by_role' => $changed_by_role,
                'remarks' => $remarks
            ]);
        } catch (PDOException $e) {
            error_log('Error logging status change: ' . $e->getMessage());
            return false;
        }
    }

    public function clearResumeAttachments($application_id)
    {
        try {
            $sql = "DELETE FROM application_attachments 
                    WHERE application_id = :application_id 
                    AND file_type IN ('Resume', 'resume')";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['application_id' => $application_id]);
        } catch (PDOException $e) {
            error_log('Error clearing resume attachments: ' . $e->getMessage());
            return false;
        }
    }

    public function clearCvAttachments($application_id)
    {
        try {
            $sql = "DELETE FROM application_attachments 
                    WHERE application_id = :application_id 
                    AND file_type IN ('CV', 'cv')";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['application_id' => $application_id]);
        } catch (PDOException $e) {
            error_log('Error clearing CV attachments: ' . $e->getMessage());
            return false;
        }
    }

    public function jobHasApplications($job_id)
    {
        try {
            $sql = "SELECT COUNT(*) FROM job_application WHERE job_id = :job_id AND is_finalized = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['job_id' => $job_id]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log('Error checking job applications: ' . $e->getMessage());
            return false;
        }
    }

    public function updateCurrentStep($application_id, $step)
    {
        try {
            $sql = "UPDATE job_application SET current_step = :step WHERE application_id = :application_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'step' => $step,
                'application_id' => $application_id
            ]);
        } catch (PDOException $e) {
            error_log('Error updating current step: ' . $e->getMessage());
            return false;
        }
    }
}
