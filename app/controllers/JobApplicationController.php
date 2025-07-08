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

    public function __construct()
    {
        $this->jobApplicationModel = new JobApplication();
        $this->jobPostModel = new JobPost();
        $this->jobseekerModel = new Jobseeker();
    }

    // Main entry point for job application
    public function applyForJob()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        $job_id = $_GET['job_id'] ?? null;
        $step = $_GET['step'] ?? 1;
        $application_id = $_GET['application_id'] ?? null;

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

        // Check if already applied (and application is finalized)
        $existingApplication = $this->jobApplicationModel->getApplicationByJobseekerAndJob($jobseeker['jobseeker_id'], $job_id);
        if ($existingApplication && $existingApplication['is_finalized']) {
            header('Location: ?page=view-job&job_id=' . $job_id . '&error=' . urlencode('You have already applied for this job.'));
            exit;
        }

        // If there's an existing draft application, use it
        if ($existingApplication && !$existingApplication['is_finalized']) {
            $application_id = $existingApplication['application_id'];
            $step = $existingApplication['current_step'];
        }

        // Handle form submissions for each step
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleStepSubmission($step, $job, $jobseeker, $application_id);
            return;
        }

        // Route to appropriate step
        switch ($step) {
            case 1:
                $this->showStep1($job, $jobseeker, $application_id);
                break;
            case 2:
                $this->showStep2($job, $jobseeker, $application_id);
                break;
            case 3:
                $this->showStep3($job, $jobseeker, $application_id);
                break;
            case 4:
                $this->showStep4($job, $jobseeker, $application_id);
                break;
            default:
                header('Location: ?page=apply-job&job_id=' . $job_id . '&step=1');
                exit;
        }
    }

    // Step 1: Personal Info & Documents
    private function showStep1($job, $jobseeker, $application_id = null)
    {
        // Get jobseeker documents
        $documents = $this->jobseekerModel->getDocuments($_SESSION['user_id']);

        // Get existing application data if editing
        $applicationData = null;
        if ($application_id) {
            $applicationData = $this->jobApplicationModel->getApplicationDetails($application_id);
        }

        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        include __DIR__ . '/../views/jobseekers/job-application/apply-job-step1.php';
    }

    // Step 2: Screening Questions
    private function showStep2($job, $jobseeker, $application_id)
    {
        if (!$application_id) {
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=1&error=' . urlencode('Please complete Step 1 first.'));
            exit;
        }

        // Get screening questions if enabled
        $screeningQuestions = [];
        if (($job['screening_questions_enabled'] ?? 0) == 1) {
            $screeningQuestions = $this->jobPostModel->getScreeningQuestions($job['job_id']);
        }

        // Get existing answers if any
        $existingAnswers = $this->jobApplicationModel->getApplicationAnswers($application_id);
        $answersArray = [];
        foreach ($existingAnswers as $answer) {
            $answersArray[$answer['question_id']] = $answer['answer'];
        }

        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        include __DIR__ . '/../views/jobseekers/job-application/apply-job-step2.php';
    }

    // Step 3: Eligibility Information
    private function showStep3($job, $jobseeker, $application_id)
    {
        if (!$application_id) {
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=1&error=' . urlencode('Please complete previous steps first.'));
            exit;
        }

        // Get existing eligibility data if any
        $eligibilityData = $this->jobApplicationModel->getApplicationEligibility($application_id);

        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        include __DIR__ . '/../views/jobseekers/job-application/apply-job-step3.php';
    }

    // Step 4: Review & Submit
    private function showStep4($job, $jobseeker, $application_id)
    {
        if (!$application_id) {
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=1&error=' . urlencode('Please complete previous steps first.'));
            exit;
        }

        // Get all application data for review
        $applicationData = $this->jobApplicationModel->getApplicationDetails($application_id);
        $answers = $this->jobApplicationModel->getApplicationAnswers($application_id);
        $attachments = $this->jobApplicationModel->getApplicationAttachments($application_id);
        $eligibility = $this->jobApplicationModel->getApplicationEligibility($application_id);

        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        include __DIR__ . '/../views/jobseekers/job-application/apply-job-step4.php';
    }

    // Handle form submissions for each step
    private function handleStepSubmission($step, $job, $jobseeker, $application_id = null)
    {
        switch ($step) {
            case 1:
                $this->handleStep1($job, $jobseeker, $application_id);
                break;
            case 2:
                $this->handleStep2($job, $jobseeker, $application_id);
                break;
            case 3:
                $this->handleStep3($job, $jobseeker, $application_id);
                break;
            case 4:
                $this->handleStep4($job, $jobseeker, $application_id);
                break;
        }
    }

    // Handle Step 1: Personal Info & Documents
    private function handleStep1($job, $jobseeker, $application_id = null)
    {
        try {
            // If no application exists, create one
            if (!$application_id) {
                $applicationData = [
                    'jobseeker_id' => $jobseeker['jobseeker_id'],
                    'job_id' => $job['job_id']
                ];

                $application_id = $this->jobApplicationModel->createDraftApplication($applicationData);
                if (!$application_id) {
                    throw new Exception('Failed to create application');
                }
            }

            // Clear existing resume attachments for this application
            $this->jobApplicationModel->clearResumeAttachments($application_id);

            // Handle multiple resume selection
            $resumeHandled = false;

            // Handle selected existing resumes
            if (!empty($_POST['selected_resumes'])) {
                foreach ($_POST['selected_resumes'] as $resumePath) {
                    $profileDoc = $this->findProfileDocumentByPath($jobseeker['jobseeker_id'], $resumePath);
                    if ($profileDoc) {
                        // Determine if it's CV or Resume based on file_type
                        $fileType = ucfirst($profileDoc['file_type']); // 'resume' becomes 'Resume', 'cv' becomes 'Cv'
                        if (strtolower($fileType) === 'cv') {
                            $fileType = 'CV';
                        }

                        // Create reference to existing profile document
                        $this->jobApplicationModel->saveApplicationAttachmentReference(
                            $application_id,
                            $profileDoc['document_id'],
                            $fileType
                        );
                        $resumeHandled = true;
                    }
                }
            }

            // Handle new resume upload
            if (!empty($_FILES['new_resume']['name'])) {
                $resumePath = $this->handleResumeUpload($_FILES['new_resume']);
                if ($resumePath) {
                    // Save as application attachment
                    $this->jobApplicationModel->saveApplicationAttachment($application_id, $resumePath, 'Resume');
                    $resumeHandled = true;

                    // Optionally save to profile documents for future use
                    if (isset($_POST['save_to_profile']) && $_POST['save_to_profile'] == '1') {
                        $this->saveToProfile(
                            $jobseeker['jobseeker_id'],
                            $resumePath,
                            'resume',
                            $_FILES['new_resume']['name']
                        );
                    }
                }
            }

            if (!$resumeHandled) {
                throw new Exception('Please select at least one existing document or upload a new resume/CV');
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

            // Update step
            $this->jobApplicationModel->updateApplication($application_id, ['current_step' => 2]);

            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=2&application_id=' . $application_id . '&success=' . urlencode('Step 1 completed successfully!'));
            exit;
        } catch (Exception $e) {
            error_log('Error in handleStep1: ' . $e->getMessage());
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=1&error=' . urlencode($e->getMessage()));
            exit;
        }
    }

    // Handle Step 2: Screening Questions
    private function handleStep2($job, $jobseeker, $application_id)
    {
        try {
            // Get screening questions
            $screeningQuestions = [];
            if (($job['screening_questions_enabled'] ?? 0) == 1) {
                $screeningQuestions = $this->jobPostModel->getScreeningQuestions($job['job_id']);
            }

            // Clear existing answers
            $this->jobApplicationModel->deleteApplicationAnswers($application_id);

            // Save new answers
            foreach ($screeningQuestions as $question) {
                $answer_key = 'question_' . $question['question_id'];
                if (isset($_POST[$answer_key]) && !empty($_POST[$answer_key])) {
                    $answer = trim($_POST[$answer_key]);
                    if (!$this->jobApplicationModel->saveApplicationAnswer($application_id, $question['question_id'], $answer)) {
                        throw new Exception('Failed to save screening answers');
                    }
                }
            }

            // Update current step
            $this->jobApplicationModel->updateApplication($application_id, ['current_step' => 3]);

            // Redirect to step 3
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=3&application_id=' . $application_id . '&success=' . urlencode('Step 2 completed successfully!'));
            exit;
        } catch (Exception $e) {
            error_log('Error in handleStep2: ' . $e->getMessage());
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=2&application_id=' . $application_id . '&error=' . urlencode('Failed to save Step 2. Please try again.'));
            exit;
        }
    }

    // Handle Step 3: Eligibility
    private function handleStep3($job, $jobseeker, $application_id)
    {
        try {
            $eligibilityData = [
                'application_id' => $application_id,
                'interested_program' => $_POST['interested_program'] ?? 'None',
                'priority_sector' => $_POST['priority_sector'] ?? 'None'
            ];

            // Save or update eligibility data
            if (!$this->jobApplicationModel->saveApplicationEligibility($eligibilityData)) {
                throw new Exception('Failed to save eligibility data');
            }

            // Update current step
            $this->jobApplicationModel->updateApplication($application_id, ['current_step' => 4]);

            // Redirect to step 4
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=4&application_id=' . $application_id . '&success=' . urlencode('Step 3 completed successfully!'));
            exit;
        } catch (Exception $e) {
            error_log('Error in handleStep3: ' . $e->getMessage());
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=3&application_id=' . $application_id . '&error=' . urlencode('Failed to save Step 3. Please try again.'));
            exit;
        }
    }

    // Handle Step 4: Final Submission
    private function handleStep4($job, $jobseeker, $application_id)
    {
        try {
            // Finalize the application
            $updateData = [
                'is_finalized' => true,
                'current_step' => 4,
                'applied_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->jobApplicationModel->updateApplication($application_id, $updateData)) {
                throw new Exception('Failed to finalize application');
            }

            // Log the application submission
            $this->jobApplicationModel->logStatusChange($application_id, 'pending', 'jobseeker', 'Application submitted');

            // Redirect to success page
            header('Location: ?page=application-success&application_id=' . $application_id);
            exit;
        } catch (Exception $e) {
            error_log('Error in handleStep4: ' . $e->getMessage());
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=4&application_id=' . $application_id . '&error=' . urlencode('Failed to submit application. Please try again.'));
            exit;
        }
    }

    // Helper methods (keep existing upload methods)
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

    // Update the browseJobs method:
    public function browseJobs()
    {
        // Get jobseeker info to check application status
        $jobseeker = null;
        $jobseeker_id = null;

        if (isset($_SESSION['user_id']) && $_SESSION['role'] == User::ROLE_JOBSEEKER) {
            require_once __DIR__ . '/../models/Jobseeker.php';
            $jobseekerModel = new Jobseeker();
            $jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);
            $jobseeker_id = $jobseeker ? $jobseeker['jobseeker_id'] : null;
        }

        // Use the working method that gets all active jobs properly
        $jobs = $this->jobPostModel->getAllActiveJobs($jobseeker_id);

        // Add saved status to each job
        if ($jobseeker_id) {
            require_once __DIR__ . '/../models/SavedJobs.php';
            $savedJobsModel = new SavedJobs();

            foreach ($jobs as &$job) {
                $job['is_saved'] = $savedJobsModel->isSaved($jobseeker_id, $job['job_id']);
            }
        }

        include __DIR__ . '/../views/jobseekers/job-application/browse-jobs.php';
    }

    // public function viewJob()
    // {
    //     $job_id = $_GET['job_id'] ?? null;
    //     if (!$job_id) {
    //         header('Location: ?page=browse-jobs&error=' . urlencode('Job not found.'));
    //         exit;
    //     }

    //     // Get jobseeker info to check application status
    //     $jobseeker = null;
    //     $jobseeker_id = null;
    //     $hasApplied = false;

    //     if (isset($_SESSION['user_id']) && $_SESSION['role'] == User::ROLE_JOBSEEKER) {
    //         require_once __DIR__ . '/../models/Jobseeker.php';
    //         $jobseekerModel = new Jobseeker();
    //         $jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);
    //         $jobseeker_id = $jobseeker ? $jobseeker['jobseeker_id'] : null;
    //     }

    //     // Get job details with application status using the new method
    //     $job = $this->getJobForJobseeker($job_id, $jobseeker_id);

    //     if (!$job) {
    //         header('Location: ?page=browse-jobs&error=' . urlencode('Job not found.'));
    //         exit;
    //     }

    //     // Set hasApplied for backward compatibility
    //     $hasApplied = isset($job['has_applied']) ? $job['has_applied'] : false;

    //     include __DIR__ . '/../views/jobseekers/job-application/view-job.php';
    // }

    // Update methods that use direct database calls:

    private function saveToProfile($jobseeker_id, $file_path, $file_type, $file_name)
    {
        // Move this to Jobseeker model
        return $this->jobseekerModel->saveDocument($jobseeker_id, $file_path, $file_type, $file_name);
    }

    private function findProfileDocumentByPath($jobseeker_id, $file_path)
    {
        // Move this to Jobseeker model
        return $this->jobseekerModel->findDocumentByPath($jobseeker_id, $file_path);
    }

    // Keep existing methods for viewing applications, success page, etc.
    public function applicationSuccess()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        $application_id = $_GET['application_id'] ?? null;
        if (!$application_id) {
            header('Location: ?page=dashboard&error=' . urlencode('Application not found.'));
            exit;
        }

        // Get application details
        $applicationData = $this->jobApplicationModel->getApplicationDetails($application_id);
        if (!$applicationData) {
            header('Location: ?page=dashboard&error=' . urlencode('Application not found.'));
            exit;
        }

        // Verify the application belongs to the current user
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        if (!$jobseeker || $applicationData['jobseeker_id'] != $jobseeker['jobseeker_id']) {
            header('Location: ?page=dashboard&error=' . urlencode('Unauthorized access.'));
            exit;
        }

        // Get job details
        $job = $this->jobPostModel->getFullJobData($applicationData['job_id']);
        if (!$job) {
            header('Location: ?page=dashboard&error=' . urlencode('Job not found.'));
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
            header('Location: ?page=jobseeker-dashboard&error=' . urlencode('Please complete your profile first.'));
            exit;
        }

        // Get applications
        $applications = $this->jobApplicationModel->getApplicationsByJobseeker($jobseeker['jobseeker_id']);

        // Add saved status to each application
        require_once __DIR__ . '/../models/SavedJobs.php';
        $savedJobsModel = new SavedJobs();

        foreach ($applications as &$application) {
            $application['is_saved'] = $savedJobsModel->isSaved($jobseeker['jobseeker_id'], $application['job_id']);
        }

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

        // Get application details
        $application = $this->jobApplicationModel->getApplicationDetails($application_id);
        if (!$application) {
            header('Location: ?page=my-applications&error=' . urlencode('Application not found.'));
            exit;
        }

        // Verify ownership
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        if (!$jobseeker || $application['jobseeker_id'] != $jobseeker['jobseeker_id']) {
            header('Location: ?page=my-applications&error=' . urlencode('Unauthorized access.'));
            exit;
        }

        // Get application data
        $answers = $this->jobApplicationModel->getApplicationAnswers($application_id);
        $attachments = $this->jobApplicationModel->getApplicationAttachments($application_id);
        $eligibility = $this->jobApplicationModel->getApplicationEligibility($application_id);

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
