<?php
// filepath: c:\xampp\htdocs\sikap\app\models\JobPost.php
require_once __DIR__ . '/../../config/sikap_db.php';

class JobPost
{
    private $pdo;

    public function __construct()
    {
        global $pdo; // Get the PDO connection from sikap_db.php
        $this->pdo = $pdo;
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
            $sql = "UPDATE job_post SET 
                job_title = :job_title, 
                job_category_id = :job_category_id, 
                job_status = :job_status,
                job_type = :job_type, 
                salary = :salary, 
                location = :location, 
                workplace_option = :workplace_option,
                pay_type = :pay_type, 
                pay_range = :pay_range, 
                show_pay = :show_pay,
                job_summary = :job_summary, 
                full_description = :full_description,
                application_start = :application_start, 
                application_deadline = :application_deadline,
                updated_at = CURRENT_TIMESTAMP
                WHERE job_id = :job_id";

            $data['job_id'] = $job_id;
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
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
            $sql = "SELECT * FROM job_post_questions WHERE job_id = :job_id ORDER BY question_id";
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
            // Get main job data
            $job = $this->getJobById($job_id);
            if ($job) {
                // Get skills
                $sql = "SELECT skill_name FROM job_post_skills WHERE job_id = :job_id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['job_id' => $job_id]);
                $job['skills'] = $stmt->fetchAll(PDO::FETCH_COLUMN);

                // Get attachments
                $job['attachments'] = $this->getJobAttachments($job_id);

                // Get screening questions
                $job['screening_questions'] = $this->getScreeningQuestions($job_id);
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

    // Also make sure you have this method for getting the PDO connection if needed
    public function getPdo()
    {
        return $this->pdo;
    }
}
