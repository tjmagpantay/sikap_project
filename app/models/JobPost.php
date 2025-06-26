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
            // Single query with LEFT JOIN to get application counts efficiently
            $sql = "SELECT jp.*, jc.category_name,
                           COALESCE(app_counts.application_count, 0) as application_count,
                           COALESCE(app_counts.pending_count, 0) as pending_count,
                           COALESCE(app_counts.shortlisted_count, 0) as shortlisted_count,
                           COALESCE(app_counts.hired_count, 0) as hired_count
                    FROM job_post jp
                    LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                    LEFT JOIN (
                        SELECT job_id, 
                               COUNT(*) as application_count,
                               SUM(CASE WHEN application_status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                               SUM(CASE WHEN application_status = 'shortlisted' THEN 1 ELSE 0 END) as shortlisted_count,
                               SUM(CASE WHEN application_status = 'hired' THEN 1 ELSE 0 END) as hired_count
                        FROM job_application 
                        WHERE is_finalized = 1
                        GROUP BY job_id
                    ) app_counts ON jp.job_id = app_counts.job_id
                    WHERE jp.employer_id = :employer_id
                    ORDER BY jp.created_at DESC";
        
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['employer_id' => $employer_id]);
            $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            error_log('DEBUG: Found ' . count($jobs) . ' jobs for employer_id: ' . $employer_id);
            return $jobs;
            
        } catch (PDOException $e) {
            error_log('Error getting jobs by employer: ' . $e->getMessage());
            // Fallback to simple query without application counts
            try {
                $sql = "SELECT jp.*, jc.category_name, 0 as application_count, 0 as pending_count, 0 as shortlisted_count, 0 as hired_count
                        FROM job_post jp
                        LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                        WHERE jp.employer_id = :employer_id
                        ORDER BY jp.created_at DESC";
                
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['employer_id' => $employer_id]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e2) {
                error_log('Fallback query also failed: ' . $e2->getMessage());
                return [];
            }
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
            // Simple query without unnecessary GROUP BY
            $sql = "SELECT DISTINCT jp.job_id, jp.job_title, jp.job_summary, jp.location, jp.job_type, 
                        jp.salary, jp.show_pay, jp.job_status, jp.created_at,
                        jc.category_name, 
                        e.first_name as employer_first_name, 
                        e.last_name as employer_last_name,
                        COALESCE(eb.business_name, CONCAT(e.first_name, ' ', e.last_name)) as company_name
                    FROM job_post jp 
                    LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                    LEFT JOIN employer e ON jp.employer_id = e.employer_id
                    LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                    WHERE jp.job_status = 'open'
                    AND (jp.application_deadline IS NULL OR jp.application_deadline > NOW())
                    ORDER BY jp.created_at DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug: Log what we found
            error_log('DEBUG getOpenJobs: Found ' . count($jobs) . ' jobs');
            foreach ($jobs as $job) {
                error_log('Job ID: ' . $job['job_id'] . ', Title: ' . $job['job_title'] . ', Created: ' . $job['created_at']);
            }
            
            return $jobs;
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

    public function getJobWithApplicationStats($job_id, $employer_id = null) {
        try {
            $sql = "SELECT jp.*, jc.category_name,
                           e.first_name as employer_first_name, 
                           e.last_name as employer_last_name,
                           eb.business_name as company_name,
                           jas.*,
                           COALESCE(app_stats.total_applications, 0) as total_applications,
                           COALESCE(app_stats.pending_count, 0) as pending_count,
                           COALESCE(app_stats.reviewed_count, 0) as reviewed_count,
                           COALESCE(app_stats.shortlisted_count, 0) as shortlisted_count,
                           COALESCE(app_stats.rejected_count, 0) as rejected_count,
                           COALESCE(app_stats.hired_count, 0) as hired_count
                    FROM job_post jp 
                    LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                    LEFT JOIN employer e ON jp.employer_id = e.employer_id
                    LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                    LEFT JOIN job_post_application_settings jas ON jp.job_id = jas.job_id
                    LEFT JOIN (
                        SELECT job_id,
                               COUNT(*) as total_applications,
                               SUM(CASE WHEN application_status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                               SUM(CASE WHEN application_status = 'reviewed' THEN 1 ELSE 0 END) as reviewed_count,
                               SUM(CASE WHEN application_status = 'shortlisted' THEN 1 ELSE 0 END) as shortlisted_count,
                               SUM(CASE WHEN application_status = 'rejected' THEN 1 ELSE 0 END) as rejected_count,
                               SUM(CASE WHEN application_status = 'hired' THEN 1 ELSE 0 END) as hired_count
                        FROM job_application 
                        WHERE is_finalized = 1
                        GROUP BY job_id
                    ) app_stats ON jp.job_id = app_stats.job_id
                    WHERE jp.job_id = :job_id";
        
            // Add employer verification if provided
            if ($employer_id) {
                $sql .= " AND jp.employer_id = :employer_id";
            }
        
            $stmt = $this->pdo->prepare($sql);
            $params = ['job_id' => $job_id];
            if ($employer_id) {
                $params['employer_id'] = $employer_id;
            }
        
            $stmt->execute($params);
            $job = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // Get job skills
            if ($job) {
                $job['skills'] = $this->getJobSkills($job_id);
            }
        
            return $job;
        } catch (PDOException $e) {
            error_log('Error getting job with application stats: ' . $e->getMessage());
            return false;
        }
    }

    public function getAllActiveJobs($jobseeker_id = null) {
        try {
            $sql = "SELECT DISTINCT jp.job_id, jp.job_title, jp.job_summary, jp.location, 
                       jp.job_type, jp.salary, jp.show_pay, jp.created_at, jp.job_status,
                       jc.category_name,
                       e.first_name as employer_first_name, 
                       e.last_name as employer_last_name,
                       eb.business_name as company_name";
        
            // Add application check if jobseeker_id is provided
            if ($jobseeker_id) {
                $sql .= ", CASE WHEN ja.application_id IS NOT NULL THEN 1 ELSE 0 END as has_applied";
            } else {
                $sql .= ", 0 as has_applied";
            }
        
            $sql .= " FROM job_post jp
                      LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                      LEFT JOIN employer e ON jp.employer_id = e.employer_id
                      LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id";
        
            // Add application check JOIN if jobseeker_id is provided
            if ($jobseeker_id) {
                $sql .= " LEFT JOIN job_application ja ON jp.job_id = ja.job_id 
                          AND ja.jobseeker_id = :jobseeker_id 
                          AND ja.is_finalized = 1";
            }
        
            $sql .= " WHERE jp.job_status = 'open' 
                      AND jp.application_deadline > NOW()
                      ORDER BY jp.created_at DESC";
        
            $stmt = $this->pdo->prepare($sql);
        
            if ($jobseeker_id) {
                $stmt->execute(['jobseeker_id' => $jobseeker_id]);
            } else {
                $stmt->execute();
            }
        
            $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            // Debug: Log the results
            error_log('getAllActiveJobs found ' . count($jobs) . ' unique jobs');
        
            return $jobs;
        
        } catch (PDOException $e) {
            error_log('Error getting active jobs: ' . $e->getMessage());
            return [];
        }
    }

    // Also make sure you have this method for getting the PDO connection if needed
    public function getPdo()
    {
        return $this->pdo;
    }

    // Add this method for getting single job details:
    public function getJobForJobseeker($job_id, $jobseeker_id = null) {
        try {
            $sql = "SELECT jp.*, jc.category_name,
                       e.first_name as employer_first_name, 
                       e.last_name as employer_last_name,
                       eb.business_name as company_name";
        
            // Add application check if jobseeker_id is provided
            if ($jobseeker_id) {
                $sql .= ", CASE WHEN ja.application_id IS NOT NULL THEN 1 ELSE 0 END as has_applied";
            } else {
                $sql .= ", 0 as has_applied";
            }
        
            $sql .= " FROM job_post jp
                      LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                      LEFT JOIN employer e ON jp.employer_id = e.employer_id
                      LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id";
        
            // Add application check JOIN if jobseeker_id is provided
            if ($jobseeker_id) {
                $sql .= " LEFT JOIN job_application ja ON jp.job_id = ja.job_id 
                          AND ja.jobseeker_id = :jobseeker_id 
                          AND ja.is_finalized = 1";
            }
        
            $sql .= " WHERE jp.job_id = :job_id";
        
            $stmt = $this->pdo->prepare($sql);
            $params = ['job_id' => $job_id];
        
            if ($jobseeker_id) {
                $params['jobseeker_id'] = $jobseeker_id;
            }
        
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        
        } catch (PDOException $e) {
            error_log('Error getting job for jobseeker: ' . $e->getMessage());
            return false;
        }
    }

    // Add this method for Step 5 review:
    public function getFullJobDataForReview($job_id)
    {
        try {
            $sql = "SELECT jp.*, jc.category_name, 
                       e.first_name as employer_first_name, 
                       e.last_name as employer_last_name,
                       eb.business_name as company_name,
                       jas.*
                FROM job_post jp 
                LEFT JOIN job_category jc ON jp.job_category_id = jc.job_category_id
                LEFT JOIN employer e ON jp.employer_id = e.employer_id
                LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                LEFT JOIN job_post_application_settings jas ON jp.job_id = jas.job_id
                WHERE jp.job_id = :job_id";
        
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['job_id' => $job_id]);
            $job = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($job) {
                // Add skills
                $job['skills'] = $this->getJobSkills($job_id);
            }
        
            return $job;
        } catch (PDOException $e) {
            error_log('Error getting full job data for review: ' . $e->getMessage());
            return false;
        }
    }
}
