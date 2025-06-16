<?php
// filepath: c:\xampp\htdocs\sikap\app\controllers\JobPostController.php

require_once __DIR__ . '/../models/Employer.php';
require_once __DIR__ . '/../models/JobPost.php';
require_once __DIR__ . '/../models/User.php';

class JobPostController
{
    private $employerModel;
    private $jobPostModel;

    public function __construct()
    {
        $this->employerModel = new Employer();
        $this->jobPostModel = new JobPost();
    }

    public function postJob()
    {
        // Check if user is logged in and is an employer
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            error_log("DEBUG: Access denied - User ID: " . ($_SESSION['user_id'] ?? 'not set') . ", Role: " . ($_SESSION['role'] ?? 'not set'));
            header('Location: ?page=login-employer');
            exit;
        }

        error_log("DEBUG: PostJob called - User ID: " . $_SESSION['user_id'] . ", Role: " . $_SESSION['role']);

        // Get employer info
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if (!$employer) {
            error_log("DEBUG: No employer found for user");
            header('Location: ?page=complete-employer-profile&error=' . urlencode('Please complete your profile first.'));
            exit;
        }

        error_log("DEBUG: Employer found: " . $employer['employer_id']);

        // Check if employer can post jobs (is verified)
        $canPost = $this->employerModel->canPostJobs($_SESSION['user_id']);
        error_log("DEBUG: Can post jobs: " . ($canPost ? 'YES' : 'NO'));

        if (!$canPost) {
            header('Location: ?page=profile-employer&error=' . urlencode('You must be verified to post jobs. Please complete your profile and wait for verification.'));
            exit;
        }

        // Get the step from URL parameter
        $step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

        // Validate step range
        if ($step < 1 || $step > 5) {
            $step = 1;
        }

        error_log("DEBUG: Current step: $step");

        // Get job_id for editing (if exists)
        $job_id = isset($_GET['job_id']) ? (int)$_GET['job_id'] : null;
        $isEditing = $job_id !== null;

        // If editing, get existing job data
        $jobData = [];
        if ($isEditing) {
            $jobData = $this->jobPostModel->getJobById($job_id);
            if (!$jobData || $jobData['employer_id'] !== $employer['employer_id']) {
                header('Location: ?page=manage-jobs&error=' . urlencode('Job not found or access denied.'));
                exit;
            }
        }

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleStepSubmission($step, $job_id);
            return;
        }

        // Get categories for step 1
        $categories = [];
        if ($step == 1) {
            $categories = $this->jobPostModel->getJobCategories();
        }

        // Get any error/success messages
        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        // Include the specific step
        switch ($step) {
            case 1:
                include __DIR__ . '/../views/employers/post-job/post-job-step1.php';
                break;
            case 2:
                include __DIR__ . '/../views/employers/post-job/post-job-step2.php';
                break;
            case 3:
                include __DIR__ . '/../views/employers/post-job/post-job-step3.php';
                break;
            case 4:
                include __DIR__ . '/../views/employers/post-job/post-job-step4.php';
                break;
            case 5:
                include __DIR__ . '/../views/employers/post-job/post-job-step5.php';
                break;
            default:
                include __DIR__ . '/../views/employers/post-job/post-job-step1.php';
        }
    }

    public function handleStepSubmission($step, $job_id)
    {
        // Add the same check here too
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }

        $data = $_POST;

        switch ($step) {
            case 1:
                $this->handleJobStep1($job_id, $data);
                break;
            case 2:
                $this->handleJobStep2($job_id, $data);
                break;
            case 3:
                $this->handleJobStep3($job_id, $data);
                break;
            case 4:
                $this->handleJobStep4($job_id, $data);
                break;
            case 5:
                $this->handleJobStep5($job_id, $data);
                break;
        }
    }

    private function handleJobStep1($job_id, $data)
    {
        // Get employer
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);

        try {
            error_log("DEBUG: handleJobStep1 called");

            // Validate required fields
            $required = ['job_title', 'job_category_id', 'job_type', 'location', 'job_summary'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    header("Location: ?page=post-job&step=1&error=" . urlencode("Please fill in all required fields. Missing: $field"));
                    exit;
                }
            }

            // Prepare job data
            $jobData = [
                'employer_id' => $employer['employer_id'],
                'posted_by_role' => 'employer',
                'job_title' => trim($data['job_title']),
                'job_category_id' => (int)$data['job_category_id'],
                'job_type' => $data['job_type'],
                'job_status' => $data['job_status'] ?? 'draft',
                'location' => trim($data['location']),
                'workplace_option' => $data['workplace_option'] ?? 'onsite',
                'pay_type' => !empty($data['pay_type']) ? $data['pay_type'] : null,
                'pay_range' => !empty($data['pay_range']) ? trim($data['pay_range']) : null,
                'salary' => !empty($data['salary']) ? floatval($data['salary']) : null,
                'show_pay' => isset($data['show_pay']) ? 1 : 0,
                'job_summary' => trim($data['job_summary']),
                'full_description' => !empty($data['full_description']) ? trim($data['full_description']) : null,
                'application_start' => !empty($data['application_start']) ? $data['application_start'] : null,
                'application_deadline' => !empty($data['application_deadline']) ? $data['application_deadline'] : null
            ];

            if ($job_id) {
                // Update existing job - use updateJobPost method
                $result = $this->jobPostModel->updateJobPost($job_id, $jobData);
                $currentJobId = $job_id;
            } else {
                // Create new job - use createJobPost method
                $currentJobId = $this->jobPostModel->createJobPost($jobData);
                $result = $currentJobId !== false;
            }

            if ($result) {
                // Handle skills if provided
                if (!empty($data['skills'])) {
                    $skills = array_map('trim', explode(',', $data['skills']));
                    $skills = array_filter($skills); // Remove empty values

                    // Delete existing skills first
                    $this->jobPostModel->deleteJobSkills($currentJobId);

                    // Add new skills
                    foreach ($skills as $skill) {
                        if (!empty($skill)) {
                            $this->jobPostModel->addJobSkill($currentJobId, $skill);
                        }
                    }
                }

                // Check if it's a draft save
                if (isset($data['save_draft'])) {
                    header("Location: ?page=post-job&step=1&job_id=$currentJobId&success=" . urlencode('Job saved as draft successfully!'));
                } else {
                    // Redirect to next step
                    header("Location: ?page=post-job&step=2&job_id=$currentJobId&success=" . urlencode('Job details saved!'));
                }
                exit;
            } else {
                header("Location: ?page=post-job&step=1&error=" . urlencode('Failed to save job details. Please try again.'));
                exit;
            }
        } catch (Exception $e) {
            error_log('Error in handleJobStep1: ' . $e->getMessage());
            header("Location: ?page=post-job&step=1&error=" . urlencode('An error occurred while saving job details.'));
            exit;
        }
    }

    private function handleJobStep2($job_id, $data)
    {
        // Handle attachments/documentation (placeholder for now)
        header("Location: ?page=post-job&step=3&job_id=$job_id&success=" . urlencode('Documentation saved!'));
        exit;
    }

    private function handleJobStep3($job_id, $data)
    {
        // Handle screening questions (placeholder for now)
        header("Location: ?page=post-job&step=4&job_id=$job_id&success=" . urlencode('Screening questions saved!'));
        exit;
    }

    private function handleJobStep4($job_id, $data)
    {
        // Handle application settings (placeholder for now)
        header("Location: ?page=post-job&step=5&job_id=$job_id&success=" . urlencode('Application settings saved!'));
        exit;
    }

    private function handleJobStep5($job_id, $data)
    {
        // Handle final review and publish
        if (isset($data['publish_job'])) {
            // Publish the job - use publishJob method
            $result = $this->jobPostModel->publishJob($job_id);

            if ($result) {
                header("Location: ?page=job-post-success&job_id=$job_id");
                exit;
            } else {
                header("Location: ?page=post-job&step=5&job_id=$job_id&error=" . urlencode('Failed to publish job.'));
                exit;
            }
        } elseif (isset($data['save_draft'])) {
            // Save as draft - create data array for updateJobPost
            $draftData = [
                'job_status' => 'draft'
            ];
            $result = $this->jobPostModel->updateJobPost($job_id, $draftData);

            if ($result) {
                header("Location: ?page=post-job&step=5&job_id=$job_id&success=" . urlencode('Job saved as draft!'));
                exit;
            } else {
                header("Location: ?page=post-job&step=5&job_id=$job_id&error=" . urlencode('Failed to save draft.'));
                exit;
            }
        }
    }

    public function jobPostSuccess()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }

        $job_id = $_GET['job_id'] ?? null;
        $jobData = null;

        if ($job_id) {
            $jobData = $this->jobPostModel->getJobById($job_id);
        }

        include __DIR__ . '/../views/employers/post-job/job-post-success.php';
    }

    public function manageJobs()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }

        // Get employer info
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if (!$employer) {
            header('Location: ?page=complete-employer-profile');
            exit;
        }

        // Get all jobs for this employer
        $jobs = $this->jobPostModel->getJobsByEmployer($employer['employer_id']);

        // Get any messages
        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        include __DIR__ . '/../views/employers/manage-jobs.php';
    }

    // This method is for EMPLOYERS to view their own jobs
    public function viewEmployerJob()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }

        $job_id = $_GET['id'] ?? null;
        if (!$job_id) {
            header('Location: ?page=manage-jobs&error=' . urlencode('Job not found.'));
            exit;
        }

        // Get employer info
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if (!$employer) {
            header('Location: ?page=complete-employer-profile');
            exit;
        }

        // Get job details
        $job = $this->jobPostModel->getFullJobData($job_id);
        if (!$job || $job['employer_id'] != $employer['employer_id']) {
            header('Location: ?page=manage-jobs&error=' . urlencode('Job not found or access denied.'));
            exit;
        }

        include __DIR__ . '/../views/employers/view-job.php';
    }

    // This method is for JOBSEEKERS to view jobs they want to apply for
    public function viewJobForJobseeker()
    {
        $job_id = $_GET['job_id'] ?? null;
        if (!$job_id) {
            header('Location: ?page=browse-jobs&error=' . urlencode('Job not found.'));
            exit;
        }

        // Get job details
        $job = $this->jobPostModel->getFullJobData($job_id);
        if (!$job) {
            header('Location: ?page=browse-jobs&error=' . urlencode('Job not found.'));
            exit;
        }

        // Only show open jobs to jobseekers
        if ($job['job_status'] !== 'open') {
            header('Location: ?page=browse-jobs&error=' . urlencode('This job is no longer available.'));
            exit;
        }

        // Check if user has already applied (if logged in as jobseeker)
        $hasApplied = false;
        if (isset($_SESSION['user_id']) && $_SESSION['role'] == User::ROLE_JOBSEEKER) {
            try {
                require_once __DIR__ . '/../models/JobApplication.php';
                require_once __DIR__ . '/../models/Jobseeker.php';
                
                $jobApplicationModel = new JobApplication();
                $jobseekerModel = new Jobseeker();
                $jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);
                
                if ($jobseeker) {
                    $hasApplied = $jobApplicationModel->hasApplied($jobseeker['jobseeker_id'], $job['job_id']);
                }
            } catch (Exception $e) {
                error_log('Error checking application status: ' . $e->getMessage());
                $hasApplied = false;
            }
        }

        // Get screening questions if the method exists
        $screeningQuestions = [];
        if (method_exists($this->jobPostModel, 'getScreeningQuestions')) {
            try {
                $screeningQuestions = $this->jobPostModel->getScreeningQuestions($job_id);
            } catch (Exception $e) {
                error_log('Error getting screening questions: ' . $e->getMessage());
                $screeningQuestions = [];
            }
        }

        include __DIR__ . '/../views/jobseekers/job-application/view-job.php';
    }

    public function browseJobs()
    {
        // Get all open jobs
        $jobs = $this->jobPostModel->getOpenJobs();

        // If user is logged in as jobseeker, check application status for each job
        if (isset($_SESSION['user_id']) && $_SESSION['role'] == User::ROLE_JOBSEEKER) {
            try {
                require_once __DIR__ . '/../models/JobApplication.php';
                require_once __DIR__ . '/../models/Jobseeker.php';
                
                $jobApplicationModel = new JobApplication();
                $jobseekerModel = new Jobseeker();
                $jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);
                
                if ($jobseeker && !empty($jobs)) {
                    foreach ($jobs as &$job) {
                        try {
                            $job['has_applied'] = $jobApplicationModel->hasApplied($jobseeker['jobseeker_id'], $job['job_id']);
                        } catch (Exception $e) {
                            error_log('Error checking application status for job ' . $job['job_id'] . ': ' . $e->getMessage());
                            $job['has_applied'] = false;
                        }
                    }
                } else {
                    // Set has_applied to false for all jobs if no jobseeker profile
                    foreach ($jobs as &$job) {
                        $job['has_applied'] = false;
                    }
                }
            } catch (Exception $e) {
                error_log('Error in browseJobs application check: ' . $e->getMessage());
                // Set has_applied to false for all jobs if error occurs
                foreach ($jobs as &$job) {
                    $job['has_applied'] = false;
                }
            }
        } else {
            // User not logged in or not a jobseeker - set has_applied to false
            foreach ($jobs as &$job) {
                $job['has_applied'] = false;
            }
        }

        include __DIR__ . '/../views/jobseekers/job-application/browse-jobs.php';
    }
}
