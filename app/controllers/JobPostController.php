<?php
// filepath: c:\xampp\htdocs\sikap\app\controllers\JobPostController.php
require_once __DIR__ . '/../models/JobPost.php';
require_once __DIR__ . '/../models/Employer.php';

class JobPostController
{
    private $jobPostModel;
    private $employerModel;

    public function __construct()
    {
        $this->jobPostModel = new JobPost();
        $this->employerModel = new Employer();
    }

    public function handleStepSubmission($step, $job_id = null)
    {
        switch ($step) {
            case 1:
                $this->saveJobDetails($job_id);
                break;
            case 2:
                $this->saveJobAttachments($job_id);
                break;
            case 3:
                $this->saveScreeningQuestions($job_id);
                break;
            case 4:
                $this->saveApplicationSettings($job_id);
                break;
            case 5:
                $this->publishJob($job_id);
                break;
        }
    }

    public function saveJobDetails($job_id = null)
    {
        try {
            // Get employer info
            $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
            if (!$employer) {
                throw new Exception('Employer not found');
            }

            // Validate required fields
            $requiredFields = ['job_title', 'job_category_id', 'job_type', 'location', 'job_summary'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    header('Location: ?page=post-job&step=1' . ($job_id ? '&job_id=' . $job_id : '') . '&error=' . urlencode('Please fill in all required fields.'));
                    exit;
                }
            }

            // Prepare data
            $data = [
                'employer_id' => $employer['employer_id'],
                'posted_by_role' => 'employer',
                'job_title' => trim($_POST['job_title']),
                'job_category_id' => (int)$_POST['job_category_id'],
                'job_status' => $_POST['job_status'] ?? 'draft',
                'job_type' => $_POST['job_type'],
                'salary' => !empty($_POST['salary']) ? (float)$_POST['salary'] : null,
                'location' => trim($_POST['location']),
                'workplace_option' => $_POST['workplace_option'] ?? 'onsite',
                'pay_type' => $_POST['pay_type'] ?? null,
                'pay_range' => trim($_POST['pay_range'] ?? ''),
                'show_pay' => isset($_POST['show_pay']) ? 1 : 0,
                'job_summary' => trim($_POST['job_summary']),
                'full_description' => trim($_POST['full_description'] ?? ''),
                'application_start' => $_POST['application_start'] ?? date('Y-m-d H:i:s'),
                'application_deadline' => $_POST['application_deadline'] ?? null
            ];

            if ($job_id) {
                // Update existing job
                $result = $this->jobPostModel->updateJobPost($job_id, $data);
                $current_job_id = $job_id;
            } else {
                // Create new job
                $current_job_id = $this->jobPostModel->createJobPost($data);
                $result = $current_job_id !== false;
            }

            if ($result) {
                // Handle skills
                if (!empty($_POST['skills'])) {
                    // Delete existing skills first
                    $this->jobPostModel->deleteJobSkills($current_job_id);
                    
                    // Add new skills
                    $skills = explode(',', $_POST['skills']);
                    foreach ($skills as $skill) {
                        $skill = trim($skill);
                        if (!empty($skill)) {
                            $this->jobPostModel->addJobSkill($current_job_id, $skill);
                        }
                    }
                }

                // Redirect to step 2
                header('Location: ?page=post-job&step=2&job_id=' . $current_job_id . '&success=' . urlencode('Job details saved successfully!'));
            } else {
                header('Location: ?page=post-job&step=1' . ($job_id ? '&job_id=' . $job_id : '') . '&error=' . urlencode('Failed to save job details.'));
            }

        } catch (Exception $e) {
            error_log('Error saving job details: ' . $e->getMessage());
            header('Location: ?page=post-job&step=1' . ($job_id ? '&job_id=' . $job_id : '') . '&error=' . urlencode('An error occurred. Please try again.'));
        }
        exit;
    }

    public function saveJobAttachments($job_id)
    {
        try {
            if (!$job_id) {
                throw new Exception('Job ID is required');
            }

            // Handle file uploads if any
            if (isset($_FILES['attachments']) && !empty($_FILES['attachments']['name'][0])) {
                $uploadDir = __DIR__ . '/../../uploads/job_attachments/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $allowedTypes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
                $maxSize = 5 * 1024 * 1024; // 5MB

                foreach ($_FILES['attachments']['name'] as $key => $filename) {
                    if ($_FILES['attachments']['error'][$key] === 0) {
                        $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                        $fileSize = $_FILES['attachments']['size'][$key];

                        if (in_array($fileExt, $allowedTypes) && $fileSize <= $maxSize) {
                            $newFilename = uniqid() . '_' . $filename;
                            $filePath = $uploadDir . $newFilename;

                            if (move_uploaded_file($_FILES['attachments']['tmp_name'][$key], $filePath)) {
                                $this->jobPostModel->addJobAttachment($job_id, 'uploads/job_attachments/' . $newFilename);
                            }
                        }
                    }
                }
            }

            // Redirect to step 3
            header('Location: ?page=post-job&step=3&job_id=' . $job_id . '&success=' . urlencode('Attachments saved successfully!'));

        } catch (Exception $e) {
            error_log('Error saving job attachments: ' . $e->getMessage());
            header('Location: ?page=post-job&step=2&job_id=' . $job_id . '&error=' . urlencode('An error occurred while uploading files.'));
        }
        exit;
    }

    public function saveScreeningQuestions($job_id)
    {
        try {
            if (!$job_id) {
                throw new Exception('Job ID is required');
            }

            // Handle screening questions if provided
            if (!empty($_POST['questions'])) {
                // Delete existing questions first using a proper method
                $this->jobPostModel->deleteScreeningQuestions($job_id);

                // Add new questions
                foreach ($_POST['questions'] as $index => $question) {
                    if (!empty($question['text'])) {
                        $questionData = [
                            'job_id' => $job_id,
                            'question_text' => trim($question['text']),
                            'question_type' => $question['type'] ?? 'text',
                            'question_option' => !empty($question['options']) ? $question['options'] : null
                        ];
                        $this->jobPostModel->addScreeningQuestion($job_id, $questionData);
                    }
                }
            }

            // Redirect to step 4
            header('Location: ?page=post-job&step=4&job_id=' . $job_id . '&success=' . urlencode('Screening questions saved successfully!'));

        } catch (Exception $e) {
            error_log('Error saving screening questions: ' . $e->getMessage());
            header('Location: ?page=post-job&step=3&job_id=' . $job_id . '&error=' . urlencode('An error occurred while saving questions.'));
        }
        exit;
    }

    public function saveApplicationSettings($job_id)
    {
        try {
            if (!$job_id) {
                throw new Exception('Job ID is required');
            }

            $settings = [
                'resume_required' => isset($_POST['resume_required']) ? 1 : 0,
                'allow_cover_letter' => isset($_POST['allow_cover_letter']) ? 1 : 0,
                'screening_questions_enabled' => isset($_POST['screening_questions_enabled']) ? 1 : 0,
                'max_applicants' => !empty($_POST['max_applicants']) ? (int)$_POST['max_applicants'] : null,
                'notify_on_new_application' => isset($_POST['notify_on_new_application']) ? 1 : 0,
                'is_highlighted' => isset($_POST['is_highlighted']) ? 1 : 0
            ];

            $result = $this->jobPostModel->saveApplicationSettings($job_id, $settings);

            if ($result) {
                // Redirect to step 5 (review)
                header('Location: ?page=post-job&step=5&job_id=' . $job_id . '&success=' . urlencode('Application settings saved successfully!'));
            } else {
                header('Location: ?page=post-job&step=4&job_id=' . $job_id . '&error=' . urlencode('Failed to save application settings.'));
            }

        } catch (Exception $e) {
            error_log('Error saving application settings: ' . $e->getMessage());
            header('Location: ?page=post-job&step=4&job_id=' . $job_id . '&error=' . urlencode('An error occurred while saving settings.'));
        }
        exit;
    }

    public function publishJob($job_id)
    {
        try {
            if (!$job_id) {
                throw new Exception('Job ID is required');
            }

            // Use the model method instead of direct SQL
            $result = $this->jobPostModel->publishJob($job_id);

            if ($result) {
                header('Location: ?page=job-post-success&job_id=' . $job_id);
            } else {
                header('Location: ?page=post-job&step=5&job_id=' . $job_id . '&error=' . urlencode('Failed to publish job.'));
            }

        } catch (Exception $e) {
            error_log('Error publishing job: ' . $e->getMessage());
            header('Location: ?page=post-job&step=5&job_id=' . $job_id . '&error=' . urlencode('An error occurred while publishing job.'));
        }
        exit;
    }
}
?>