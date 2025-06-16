<?php
// filepath: c:\xampp\htdocs\sikap\app\models\JobPost.php

class JobPost
{
    private $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/sikap_db.php';
        try {
            $this->pdo = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_pass']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            error_log("DEBUG: JobPost database connection established successfully");
        } catch (PDOException $e) {
            error_log("JobPost database connection failed: " . $e->getMessage());
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getJobCategories()
    {
        try {
            $sql = "SELECT * FROM job_category ORDER BY category_name";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting job categories: ' . $e->getMessage());
            return [];
        }
    }

    public function createJobPost($data)
    {
        try {
            $sql = "INSERT INTO job_post (
                employer_id, posted_by_role, job_title, job_category_id, job_status, 
                job_type, salary, location, workplace_option, pay_type, pay_range, 
                show_pay, job_summary, full_description, application_start, application_deadline
            ) VALUES (
                :employer_id, :posted_by_role, :job_title, :job_category_id, :job_status,
                :job_type, :salary, :location, :workplace_option, :pay_type, :pay_range,
                :show_pay, :job_summary, :full_description, :application_start, :application_deadline
            )";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($data);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log('Error creating job post: ' . $e->getMessage());
            return false;
        }
    }

    public function updateJobPost($job_id, $data)
    {
        try {
            // Build dynamic SQL based on provided data
            $fields = [];
            $values = [];

            $allowedFields = [
                'job_title',
                'job_category_id',
                'job_status',
                'job_type',
                'salary',
                'location',
                'workplace_option',
                'pay_type',
                'pay_range',
                'show_pay',
                'job_summary',
                'full_description',
                'application_start',
                'application_deadline'
            ];

            foreach ($data as $field => $value) {
                if (in_array($field, $allowedFields)) {
                    $fields[] = "$field = :$field";
                    $values[$field] = $value;
                }
            }

            if (empty($fields)) {
                return false; // No valid fields to update
            }

            $fields[] = "updated_at = CURRENT_TIMESTAMP";

            $sql = "UPDATE job_post SET " . implode(', ', $fields) . " WHERE job_id = :job_id";
            $values['job_id'] = $job_id;

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            error_log('Error updating job post: ' . $e->getMessage());
            return false;
        }
    }

    public function addJobSkill($job_id, $skill_name)
    {
        try {
            $sql = "INSERT INTO job_post_skills (job_id, skill_name) VALUES (:job_id, :skill_name)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['job_id' => $job_id, 'skill_name' => $skill_name]);
        } catch (PDOException $e) {
            error_log('Error adding job skill: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteJobSkills($job_id)
    {
        try {
            $sql = "DELETE FROM job_post_skills WHERE job_id = :job_id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['job_id' => $job_id]);
        } catch (PDOException $e) {
            error_log('Error deleting job skills: ' . $e->getMessage());
            return false;
        }
    }

    public function addScreeningQuestion($job_id, $questionData)
    {
        try {
            $sql = "INSERT INTO job_post_questions (job_id, question_text, question_type, question_option) 
                    VALUES (:job_id, :question_text, :question_type, :question_option)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($questionData);
        } catch (PDOException $e) {
            error_log('Error adding screening question: ' . $e->getMessage());
            return false;
        }
    }

    public function getScreeningQuestions($job_id)
    {
        try {
            $sql = "SELECT * FROM job_post_questions 
                    WHERE job_id = :job_id 
                    ORDER BY question_id";
        
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['job_id' => $job_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting screening questions: ' . $e->getMessage());
            return [];
        }
    }

    public function saveApplicationSettings($job_id, $settings)
    {
        try {
            // Check if settings exist
            $sql = "SELECT setting_id FROM job_post_application_settings WHERE job_id = :job_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['job_id' => $job_id]);
            $exists = $stmt->fetch();

            if ($exists) {
                // Update existing settings
                $sql = "UPDATE job_post_application_settings SET 
                        resume_required = :resume_required,
                        allow_cover_letter = :allow_cover_letter,
                        screening_questions_enabled = :screening_questions_enabled,
                        max_applicants = :max_applicants,
                        notify_on_new_application = :notify_on_new_application,
                        is_highlighted = :is_highlighted
                        WHERE job_id = :job_id";
            } else {
                // Insert new settings
                $sql = "INSERT INTO job_post_application_settings (
                        job_id, resume_required, allow_cover_letter, screening_questions_enabled,
                        max_applicants, notify_on_new_application, is_highlighted
                        ) VALUES (
                        :job_id, :resume_required, :allow_cover_letter, :screening_questions_enabled,
                        :max_applicants, :notify_on_new_application, :is_highlighted
                        )";
            }

            $settings['job_id'] = $job_id;
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($settings);
        } catch (PDOException $e) {
            error_log('Error saving application settings: ' . $e->getMessage());
            return false;
        }
    }

    public function getJobById($job_id)
    {
        try {
            $sql = "SELECT jp.*, jc.category_name, jas.* 
                    FROM job_post jp 
                    LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                    LEFT JOIN job_post_application_settings jas ON jp.job_id = jas.job_id
                    WHERE jp.job_id = :job_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['job_id' => $job_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting job by ID: ' . $e->getMessage());
            return false;
        }
    }

    public function getFullJobData($job_id)
    {
        try {
            $sql = "SELECT jp.*, jc.category_name, 
                       e.first_name as employer_first_name, 
                       e.last_name as employer_last_name,
                       eb.business_name as company_name
                FROM job_post jp 
                LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                LEFT JOIN employer e ON jp.employer_id = e.employer_id
                LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                WHERE jp.job_id = :job_id";
        
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['job_id' => $job_id]);
            $job = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Debug: Log what fields are available
            if ($job) {
                error_log('DEBUG: Job data keys: ' . implode(', ', array_keys($job)));
            }
            
            return $job;
        } catch (PDOException $e) {
            error_log('Error getting full job data: ' . $e->getMessage());
            return false;
        }
    }

    public function getJobAttachments($job_id)
    {
        try {
            $sql = "SELECT * FROM job_post_attachments WHERE job_id = :job_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['job_id' => $job_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting job attachments: ' . $e->getMessage());
            return [];
        }
    }

    public function addJobAttachment($job_id, $file_path)
    {
        try {
            $sql = "INSERT INTO job_post_attachments (job_id, file_path) VALUES (:job_id, :file_path)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['job_id' => $job_id, 'file_path' => $file_path]);
        } catch (PDOException $e) {
            error_log('Error adding job attachment: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteScreeningQuestions($job_id)
    {
        try {
            $sql = "DELETE FROM job_post_questions WHERE job_id = :job_id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['job_id' => $job_id]);
        } catch (PDOException $e) {
            error_log('Error deleting screening questions: ' . $e->getMessage());
            return false;
        }
    }

    public function publishJob($job_id)
    {
        try {
            $sql = "UPDATE job_post SET job_status = 'open', updated_at = CURRENT_TIMESTAMP WHERE job_id = :job_id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['job_id' => $job_id]);
        } catch (PDOException $e) {
            error_log('Error publishing job: ' . $e->getMessage());
            return false;
        }
    }

    public function getJobsByEmployer($employer_id) {
        try {
            // First, let's try a simpler query without the application count
            $sql = "SELECT jp.*, jc.category_name
                    FROM job_post jp
                    LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                    WHERE jp.employer_id = :employer_id
                    ORDER BY jp.created_at DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['employer_id' => $employer_id]);
            $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Add application count separately (handle if table doesn't exist)
            foreach ($jobs as &$job) {
                try {
                    $countSql = "SELECT COUNT(*) FROM job_application WHERE job_id = :job_id";
                    $countStmt = $this->pdo->prepare($countSql);
                    $countStmt->execute(['job_id' => $job['job_id']]);
                    $job['application_count'] = $countStmt->fetchColumn();
                } catch (PDOException $e) {
                    // If job_application table doesn't exist, set count to 0
                    $job['application_count'] = 0;
                    error_log('job_application table might not exist: ' . $e->getMessage());
                }
            }
            
            error_log('DEBUG: Found ' . count($jobs) . ' jobs for employer_id: ' . $employer_id);
            return $jobs;
            
        } catch (PDOException $e) {
            error_log('Error getting jobs by employer: ' . $e->getMessage());
            return [];
        }
    }

    public function deleteJob($job_id) {
        try {
            // Start transaction
            $this->pdo->beginTransaction();
            
            // Delete related records first
            $tables = [
                'job_post_skills',
                'job_post_questions', 
                'job_post_attachments',
                'job_post_application_settings'
            ];
            
            foreach ($tables as $table) {
                $sql = "DELETE FROM $table WHERE job_id = :job_id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['job_id' => $job_id]);
            }
            
            // Delete the job post
            $sql = "DELETE FROM job_post WHERE job_id = :job_id";
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute(['job_id' => $job_id]);
            
            $this->pdo->commit();
            return $result;
            
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log('Error deleting job: ' . $e->getMessage());
            return false;
        }
    }

    public function getJobSkills($job_id) {
        try {
            $sql = "SELECT skill_name FROM job_post_skills WHERE job_id = :job_id ORDER BY job_skill_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['job_id' => $job_id]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log('Error getting job skills: ' . $e->getMessage());
            return [];
        }
    }

    public function getOpenJobs()
    {
        try {
            $sql = "SELECT jp.*, jc.category_name, 
                           e.first_name as employer_first_name, e.last_name as employer_last_name,
                           eb.business_name as company_name
                    FROM job_post jp 
                    LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                    LEFT JOIN employer e ON jp.employer_id = e.employer_id
                    LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                    WHERE jp.job_status = 'open'
                    ORDER BY jp.created_at DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting open jobs: ' . $e->getMessage());
            return [];
        }
    }

    public function getJobsByStatus($status)
    {
        try {
            $sql = "SELECT jp.*, jc.category_name, 
                           e.first_name as employer_first_name, e.last_name as employer_last_name,
                           eb.business_name as company_name
                    FROM job_post jp 
                    LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                    LEFT JOIN employer e ON jp.employer_id = e.employer_id
                    LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                    WHERE jp.job_status = :status
                    ORDER BY jp.created_at DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['status' => $status]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting jobs by status: ' . $e->getMessage());
            return [];
        }
    }

    public function getAllJobs()
    {
        try {
            $sql = "SELECT jp.*, jc.category_name, 
                           e.first_name as employer_first_name, e.last_name as employer_last_name,
                           eb.business_name as company_name
                    FROM job_post jp 
                    LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                    LEFT JOIN employer e ON jp.employer_id = e.employer_id
                    LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                    ORDER BY jp.created_at DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting all jobs: ' . $e->getMessage());
            return [];
        }
    }

    // Also make sure you have this method for getting the PDO connection if needed
    public function getPdo()
    {
        return $this->pdo;
    }
}
