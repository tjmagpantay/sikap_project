<?php
// filepath: app/controllers/JobApplicationController.php
require_once __DIR__ . '/../models/JobApplication.php';
require_once __DIR__ . '/../models/JobPost.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/User.php';

class JobApplicationController
{
    private $jobApplicationModel;
    private $jobPostModel;
    private $jobseekerModel;
    private $db; // Add this property

    public function __construct()
    {
        $this->jobApplicationModel = new JobApplication();
        $this->jobPostModel = new JobPost();
        $this->jobseekerModel = new Jobseeker();
        
        // Initialize database connection
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

    public function applyForJob()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        $job_id = $_GET['job_id'] ?? null;
        if (!$job_id) {
            header('Location: ?page=browse-jobs&error=' . urlencode('Job not found.'));
            exit;
        }

        // Get jobseeker info
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        if (!$jobseeker) {
            header('Location: ?page=complete-jobseeker-profile&error=' . urlencode('Please complete your profile first.'));
            exit;
        }

        // Get job details
        $job = $this->jobPostModel->getFullJobData($job_id);
        if (!$job || $job['job_status'] !== 'open') {
            header('Location: ?page=browse-jobs&error=' . urlencode('Job not available for application.'));
            exit;
        }

        // Check if already applied
        if ($this->jobApplicationModel->hasApplied($jobseeker['jobseeker_id'], $job_id)) {
            header('Location: ?page=view-job&job_id=' . $job_id . '&error=' . urlencode('You have already applied for this job.'));
            exit;
        }

        // Get screening questions
        $screeningQuestions = $this->jobPostModel->getScreeningQuestions($job_id);
        
        // Get jobseeker documents for resume selection
        $documents = $this->jobseekerModel->getDocuments($_SESSION['user_id']);

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processApplication($job, $jobseeker, $screeningQuestions); // Pass screening questions
            return;
        }

        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        include __DIR__ . '/../views/jobseekers/job-application/apply-job.php';
    }

    private function processApplication($job, $jobseeker, $screeningQuestions = [])
    {
        try {
            $this->db->beginTransaction(); // Changed from $this->pdo to $this->db

            // Prepare application data
            $applicationData = [
                'jobseeker_id' => $jobseeker['jobseeker_id'],
                'job_id' => $job['job_id'],
                'resume_path' => null,
                'cover_letter' => !empty($_POST['cover_letter']) ? trim($_POST['cover_letter']) : null
            ];

            // Handle resume requirement
            if ($job['resume_required']) {
                if (empty($_POST['selected_resume']) && empty($_FILES['new_resume']['name'])) {
                    header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&error=' . urlencode('Resume is required for this job.'));
                    exit;
                }

                // Use selected resume or upload new one
                if (!empty($_POST['selected_resume'])) {
                    $applicationData['resume_path'] = $_POST['selected_resume'];
                } elseif (!empty($_FILES['new_resume']['name'])) {
                    $resumePath = $this->handleResumeUpload($_FILES['new_resume']);
                    if (!$resumePath) {
                        header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&error=' . urlencode('Failed to upload resume.'));
                        exit;
                    }
                    $applicationData['resume_path'] = $resumePath;
                }
            }

            // Create application
            $application_id = $this->jobApplicationModel->createApplication($applicationData);
            if (!$application_id) {
                throw new Exception('Failed to create application');
            }

            // Save screening question answers
            if (!empty($screeningQuestions)) { // Fix: use the variable from applyForJob method
                foreach ($screeningQuestions as $question) {
                    $answer_key = 'question_' . $question['question_id'];
                    if (isset($_POST[$answer_key]) && !empty($_POST[$answer_key])) {
                        $answer = trim($_POST[$answer_key]);
                        if (!$this->jobApplicationModel->saveApplicationAnswer($application_id, $question['question_id'], $answer)) {
                            throw new Exception('Failed to save screening answers');
                        }
                    }
                }
            }

            // Handle additional attachments
            if (!empty($_FILES['attachments']['name'][0])) {
                foreach ($_FILES['attachments']['name'] as $index => $filename) {
                    if (!empty($filename)) {
                        $file = [
                            'name' => $_FILES['attachments']['name'][$index],
                            'type' => $_FILES['attachments']['type'][$index],
                            'tmp_name' => $_FILES['attachments']['tmp_name'][$index],
                            'error' => $_FILES['attachments']['error'][$index],
                            'size' => $_FILES['attachments']['size'][$index]
                        ];
                        
                        $attachmentPath = $this->handleAttachmentUpload($file, $application_id);
                        if ($attachmentPath) {
                            $file_type = $_POST['attachment_types'][$index] ?? 'Others';
                            $this->jobApplicationModel->saveApplicationAttachment($application_id, $attachmentPath, $file_type);
                        }
                    }
                }
            }

            $this->db->commit(); // Changed from $this->pdo to $this->db

            // Redirect to success page
            header('Location: ?page=application-success&application_id=' . $application_id);
            exit;

        } catch (Exception $e) {
            $this->db->rollBack(); // Changed from $this->pdo to $this->db
            error_log('Error processing application: ' . $e->getMessage());
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&error=' . urlencode('Failed to submit application. Please try again.'));
            exit;
        }
    }

    private function handleResumeUpload($file)
    {
        try {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return false;
            }

            // Validate file
            $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            if (!in_array($file['type'], $allowedTypes)) {
                return false;
            }

            $maxSize = 5 * 1024 * 1024; // 5MB
            if ($file['size'] > $maxSize) {
                return false;
            }

            // Create upload directory
            $uploadDir = __DIR__ . '/../../public/uploads/applications/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'resume_' . $_SESSION['user_id'] . '_' . time() . '.' . $extension;
            $uploadPath = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                return 'uploads/applications/' . $filename;
            }

            return false;
        } catch (Exception $e) {
            error_log('Error uploading resume: ' . $e->getMessage());
            return false;
        }
    }

    private function handleAttachmentUpload($file, $application_id)
    {
        try {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return false;
            }

            // Validate file
            $allowedTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'image/jpeg',
                'image/png',
                'image/jpg'
            ];
            
            if (!in_array($file['type'], $allowedTypes)) {
                return false;
            }

            $maxSize = 10 * 1024 * 1024; // 10MB
            if ($file['size'] > $maxSize) {
                return false;
            }

            // Create upload directory
            $uploadDir = __DIR__ . '/../../public/uploads/applications/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'attachment_' . $application_id . '_' . time() . '_' . uniqid() . '.' . $extension;
            $uploadPath = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                return 'uploads/applications/' . $filename;
            }

            return false;
        } catch (Exception $e) {
            error_log('Error uploading attachment: ' . $e->getMessage());
            return false;
        }
    }

    public function applicationSuccess()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        $application_id = $_GET['application_id'] ?? null;
        if (!$application_id) {
            header('Location: ?page=my-applications');
            exit;
        }

        // Get jobseeker info
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        
        // Get application details
        $application = $this->jobApplicationModel->getApplicationDetails($application_id, $jobseeker['jobseeker_id']);
        if (!$application) {
            header('Location: ?page=my-applications&error=' . urlencode('Application not found.'));
            exit;
        }

        include __DIR__ . '/../views/jobseekers/job-application/application-success.php';
    }

    public function myApplications()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker info
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        if (!$jobseeker) {
            header('Location: ?page=complete-jobseeker-profile');
            exit;
        }

        // Get all applications
        $applications = $this->jobApplicationModel->getApplicationsByJobseeker($jobseeker['jobseeker_id']);

        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        include __DIR__ . '/../views/jobseekers/job-application/my-applications.php';
    }

    public function viewApplication()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        $application_id = $_GET['id'] ?? null;
        if (!$application_id) {
            header('Location: ?page=my-applications&error=' . urlencode('Application not found.'));
            exit;
        }

        // Get jobseeker info
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        
        // Get application details
        $application = $this->jobApplicationModel->getApplicationDetails($application_id, $jobseeker['jobseeker_id']);
        if (!$application) {
            header('Location: ?page=my-applications&error=' . urlencode('Application not found.'));
            exit;
        }

        // Get answers and attachments
        $answers = $this->jobApplicationModel->getApplicationAnswers($application_id);
        $attachments = $this->jobApplicationModel->getApplicationAttachments($application_id);

        include __DIR__ . '/../views/jobseekers/job-application/view-application.php';
    }

    public function withdrawApplication()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        $application_id = $_GET['id'] ?? null;
        if (!$application_id) {
            header('Location: ?page=my-applications&error=' . urlencode('Application not found.'));
            exit;
        }

        // Get jobseeker info
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        
        // Withdraw application
        $result = $this->jobApplicationModel->withdrawApplication($application_id, $jobseeker['jobseeker_id']);
        
        if ($result) {
            header('Location: ?page=my-applications&success=' . urlencode('Application withdrawn successfully.'));
        } else {
            header('Location: ?page=my-applications&error=' . urlencode('Unable to withdraw application. It may have already been reviewed.'));
        }
        exit;
    }
}