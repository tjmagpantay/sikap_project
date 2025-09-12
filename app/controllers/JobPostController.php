<?php
// filepath: c:\xampp\htdocs\sikap\app\controllers\JobPostController.php

require_once __DIR__ . '/../models/Employer.php';
require_once __DIR__ . '/../models/JobPost.php';
require_once __DIR__ . '/../models/User.php';

// // FOR FIREBASE NOTIFICATION
// require_once __DIR__ . '/../services/NotificationService.php';
// NotificationService::notifyUsersBySkills($job_id, $job_title, "/public/view-job.php?id={$job_id}");


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
            header('Location: ?page=login-employer');
            exit;
        }

        // Get employer info
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if (!$employer) {
            header('Location: ?page=complete-employer-profile&error=' . urlencode('Please complete your profile first.'));
            exit;
        }

        // Check if employer can post jobs
        $canPost = $this->employerModel->canPostJobs($_SESSION['user_id']);
        if (!$canPost) {
            header('Location: ?page=profile-employer&error=' . urlencode('You must be verified to post jobs.'));
            exit;
        }

        // Get the step from URL parameter
        $step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
        if ($step < 1 || $step > 5) {
            $step = 1;
        }

        // Get job_id for editing (if exists)
        $job_id = isset($_GET['job_id']) ? (int)$_GET['job_id'] : null;
        $isEditing = $job_id !== null;

        // If editing, get existing job data for ALL steps
        $jobData = [];
        $attachments = [];
        $screeningQuestions = [];

        if ($isEditing) {
            // Get basic job data
            $jobData = $this->jobPostModel->getJobById($job_id);
            if (!$jobData || $jobData['employer_id'] !== $employer['employer_id']) {
                header('Location: ?page=manage-jobs&error=' . urlencode('Job not found or access denied.'));
                exit;
            }

            // Get job skills
            $jobData['skills'] = $this->jobPostModel->getJobSkills($job_id);

            // Get attachments for step 2
            $attachments = $this->jobPostModel->getJobAttachments($job_id);

            // Get screening questions for step 3
            $screeningQuestions = $this->jobPostModel->getScreeningQuestions($job_id);

            // For step 5, get full job data including all related data
            if ($step == 5) {
                $jobData = $this->jobPostModel->getFullJobDataForReview($job_id);
                $jobData['attachments'] = $attachments;
                $jobData['screening_questions'] = $screeningQuestions;
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
            // Validate required fields
            $required = ['job_title', 'job_category_id', 'job_type', 'location', 'job_summary'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    header("Location: ?page=post-job&step=1&error=" . urlencode("Please fill in all required fields. Missing: $field"));
                    exit;
                }
            }

            // Validate age requirements if provided
            $minAge = !empty($data['min_age']) ? (int)$data['min_age'] : null;
            $maxAge = !empty($data['max_age']) ? (int)$data['max_age'] : null;

            if ($minAge !== null && ($minAge < 16 || $minAge > 65)) {
                header("Location: ?page=post-job&step=1&error=" . urlencode("Minimum age must be between 16 and 65 years."));
                exit;
            }

            if ($maxAge !== null && ($maxAge < 16 || $maxAge > 65)) {
                header("Location: ?page=post-job&step=1&error=" . urlencode("Maximum age must be between 16 and 65 years."));
                exit;
            }

            if ($minAge !== null && $maxAge !== null && $minAge >= $maxAge) {
                header("Location: ?page=post-job&step=1&error=" . urlencode("Maximum age must be greater than minimum age."));
                exit;
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
                'show_pay' => 1, // Default to show, will be controlled in step 4
                'job_summary' => trim($data['job_summary']),
                'full_description' => !empty($data['full_description']) ? trim($data['full_description']) : null,
                'application_start' => !empty($data['application_start']) ? $data['application_start'] : null,
                'application_deadline' => !empty($data['application_deadline']) ? $data['application_deadline'] : null,
                'min_age' => $minAge,
                'max_age' => $maxAge
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
                } elseif (isset($data['continue_to_step2'])) {
                    // Explicit step 2 progression
                    header("Location: ?page=post-job&step=2&job_id=$currentJobId&success=" . urlencode('Job details saved!'));
                } else {
                    // Redirect to next step (default behavior)
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
        try {
            // Handle file uploads if any
            if (!empty($_FILES['attachments']['name'][0])) {
                $uploadDir = __DIR__ . '/../../uploads/job_attachments/';

                // Create directory if it doesn't exist
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                foreach ($_FILES['attachments']['name'] as $index => $fileName) {
                    if (!empty($fileName) && $_FILES['attachments']['error'][$index] === UPLOAD_ERR_OK) {
                        $tempFile = $_FILES['attachments']['tmp_name'][$index];
                        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                        $newFileName = uniqid() . '_' . time() . '.' . $fileExtension;
                        $filePath = $uploadDir . $newFileName;

                        if (move_uploaded_file($tempFile, $filePath)) {
                            // Save file path to database
                            $this->jobPostModel->addJobAttachment($job_id, 'uploads/job_attachments/' . $newFileName);
                        }
                    }
                }
            }

            // Check if skip step is requested
            if (isset($data['skip_step'])) {
                header("Location: ?page=post-job&step=3&job_id=$job_id&success=" . urlencode('Documentation step skipped.'));
            } else {
                header("Location: ?page=post-job&step=3&job_id=$job_id&success=" . urlencode('Documentation saved!'));
            }
            exit;
        } catch (Exception $e) {
            error_log('Error in handleJobStep2: ' . $e->getMessage());
            header("Location: ?page=post-job&step=2&job_id=$job_id&error=" . urlencode('Failed to save documentation.'));
            exit;
        }
    }

    private function handleJobStep3($job_id, $data)
    {
        try {
            // Skip if no questions or skip step is requested
            if (isset($data['skip_step']) || empty($data['questions'])) {
                header("Location: ?page=post-job&step=4&job_id=$job_id&success=" . urlencode('Screening questions skipped.'));
                exit;
            }

            // Delete existing questions first
            $this->jobPostModel->deleteScreeningQuestions($job_id);

            // Process each question
            $questionsSaved = 0;
            foreach ($data['questions'] as $questionData) {
                if (!empty($questionData['text'])) {
                    $questionInfo = [
                        'job_id' => $job_id,
                        'question_text' => trim($questionData['text']),
                        'question_type' => $questionData['type'] ?? 'text',
                        'question_option' => !empty($questionData['options']) ? trim($questionData['options']) : null
                    ];

                    if ($this->jobPostModel->addScreeningQuestion($job_id, $questionInfo)) {
                        $questionsSaved++;
                    }
                }
            }

            $message = $questionsSaved > 0 ?
                "Screening questions saved! ($questionsSaved questions)" :
                'No valid questions to save.';

            header("Location: ?page=post-job&step=4&job_id=$job_id&success=" . urlencode($message));
            exit;
        } catch (Exception $e) {
            error_log('Error in handleJobStep3: ' . $e->getMessage());
            header("Location: ?page=post-job&step=3&job_id=$job_id&error=" . urlencode('Failed to save screening questions.'));
            exit;
        }
    }

    private function handleJobStep4($job_id, $data)
    {
        try {
            // Check if there are any screening questions
            $hasQuestions = !empty($this->jobPostModel->getScreeningQuestions($job_id));

            // Prepare application settings
            $settings = [
                'resume_required' => isset($data['resume_required']) ? 1 : 0,
                'allow_cover_letter' => isset($data['allow_cover_letter']) ? 1 : 0,
                'screening_questions_enabled' => isset($data['screening_questions_enabled']) && $hasQuestions ? 1 : 0,
                'max_applicants' => !empty($data['max_applicants']) ? (int)$data['max_applicants'] : null,
                'notify_on_new_application' => isset($data['notify_on_new_application']) ? 1 : 0,
                'is_highlighted' => isset($data['is_highlighted']) ? 1 : 0
            ];

            // Handle show_pay setting by updating the job post directly
            $showPay = isset($data['show_pay']) ? 1 : 0;
            $jobUpdateResult = $this->jobPostModel->updateJobPost($job_id, ['show_pay' => $showPay]);

            // Save application settings
            $result = $this->jobPostModel->saveApplicationSettings($job_id, $settings);

            if ($result && $jobUpdateResult) {
                header("Location: ?page=post-job&step=5&job_id=$job_id&success=" . urlencode('Application settings saved!'));
            } else {
                header("Location: ?page=post-job&step=4&job_id=$job_id&error=" . urlencode('Failed to save application settings.'));
            }
            exit;
        } catch (Exception $e) {
            error_log('Error in handleJobStep4: ' . $e->getMessage());
            header("Location: ?page=post-job&step=4&job_id=$job_id&error=" . urlencode('An error occurred while saving settings.'));
            exit;
        }
    }

    private function handleJobStep5($job_id, $data)
    {
        try {
            if (isset($data['publish_job'])) {
                // Publish the job
                $result = $this->jobPostModel->publishJob($job_id);

                if ($result) {
                    // FIXED: Use model method to handle notifications (proper MVC pattern)
                    try {
                        $notificationResult = $this->jobPostModel->notifyJobPosted($job_id);

                        if ($notificationResult) {
                            error_log("✅ Notifications sent for job ID: $job_id");
                        } else {
                            error_log("⚠️ Notifications may have failed for job ID: $job_id");
                        }
                    } catch (Exception $e) {
                        error_log("❌ Failed to send job notifications: " . $e->getMessage());
                        // Don't fail the job publishing if notifications fail
                    }

                    header("Location: ?page=job-post-success&job_id=$job_id");
                    exit;
                } else {
                    header("Location: ?page=post-job&step=5&job_id=$job_id&error=" . urlencode('Failed to publish job.'));
                    exit;
                }
            } elseif (isset($data['save_draft'])) {
                // Save as draft
                $draftData = ['job_status' => 'draft'];
                $result = $this->jobPostModel->updateJobPost($job_id, $draftData);

                if ($result) {
                    header("Location: ?page=manage-jobs&success=" . urlencode('Job saved as draft!'));
                    exit;
                } else {
                    header("Location: ?page=post-job&step=5&job_id=$job_id&error=" . urlencode('Failed to save draft.'));
                    exit;
                }
            } else {
                // Just viewing/navigating - no action needed
                header("Location: ?page=post-job&step=5&job_id=$job_id");
                exit;
            }
        } catch (Exception $e) {
            error_log('Error in handleJobStep5: ' . $e->getMessage());
            header("Location: ?page=post-job&step=5&job_id=$job_id&error=" . urlencode('An error occurred.'));
            exit;
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

        // Get all jobs for this employer (now includes employer profile data)
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

        // Get job details with application statistics
        $job = $this->jobPostModel->getJobWithApplicationStats($job_id, $employer['employer_id']);
        if (!$job) {
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
        $profileCompleted = false;
        $incompleteApplication = null;
        $applicationStatus = null;
        $applicationData = null;

        if (isset($_SESSION['user_id']) && $_SESSION['role'] == User::ROLE_JOBSEEKER) {
            try {
                require_once __DIR__ . '/../models/JobApplication.php';
                require_once __DIR__ . '/../models/Jobseeker.php';

                $jobApplicationModel = new JobApplication();
                $jobseekerModel = new Jobseeker();
                $jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);

                if ($jobseeker) {
                    // Check if profile is completed
                    $profileCompleted = !empty($jobseeker['profile_completed']) && $jobseeker['profile_completed'] == 1;
                    error_log("DEBUG JobPostController: Profile completed field: " . ($jobseeker['profile_completed'] ?? 'NULL'));
                    error_log("DEBUG JobPostController: Profile completed boolean: " . ($profileCompleted ? 'true' : 'false'));

                    // Check for any application (complete or incomplete)
                    $application = $jobApplicationModel->getApplicationByJobseekerAndJob($jobseeker['jobseeker_id'], $job_id);

                    if ($application) {
                        $hasApplied = true;
                        $applicationData = $application;

                        if ($application['is_finalized'] == 1) {
                            // Complete application
                            $applicationStatus = $application['application_status'] ?? 'pending';
                        } else {
                            // Incomplete application
                            $incompleteApplication = $application;
                        }
                    } else {
                        $hasApplied = $jobApplicationModel->hasApplied($jobseeker['jobseeker_id'], $job['job_id']);
                    }
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

        // Debug output
        error_log("DEBUG JobPostController FINAL: hasApplied=" . ($hasApplied ? 'true' : 'false'));
        error_log("DEBUG JobPostController FINAL: incompleteApplication=" . ($incompleteApplication ? 'exists' : 'null'));
        error_log("DEBUG JobPostController FINAL: applicationStatus=" . ($applicationStatus ?? 'null'));
        error_log("DEBUG JobPostController FINAL: profileCompleted=" . ($profileCompleted ? 'true' : 'false'));

        include __DIR__ . '/../views/jobseekers/job-application/view-job.php';
    }

    public function browseJobs()
    {
        // Get jobseeker info and initialize recommendation service
        $jobseeker_id = null;
        $jobseeker = null;
        $recommendationService = null;

        // Get jobseeker ID if logged in as jobseeker
        if (isset($_SESSION['user_id']) && $_SESSION['role'] == User::ROLE_JOBSEEKER) {
            require_once __DIR__ . '/../models/Jobseeker.php';
            $jobseekerModel = new Jobseeker();
            $jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);
            if ($jobseeker && !empty($jobseeker['first_name']) && !empty($jobseeker['last_name'])) {
                $jobseeker_id = $jobseeker['jobseeker_id'];

                // Initialize recommendation service for match percentages
                require_once __DIR__ . '/../services/JobRecommendationService.php';
                $recommendationService = new JobRecommendationService();
            }
        }

        // Check for employer filter
        $employer_id = $_GET['employer_id'] ?? null;
        $employer = null;

        if ($employer_id) {
            // Get employer info for display
            $employer = $this->jobPostModel->getEmployerProfileData($employer_id);
            // Get jobs from specific employer only
            $jobs = $this->jobPostModel->getEmployerActiveJobs($employer_id);

            // Add application status for jobseeker
            if ($jobseeker_id && !empty($jobs)) {
                require_once __DIR__ . '/../models/JobApplication.php';
                $jobApplicationModel = new JobApplication();
                foreach ($jobs as &$job) {
                    $job['has_applied'] = $jobApplicationModel->hasApplied($jobseeker_id, $job['job_id']);
                }
            }
        } else {
            // Get all active jobs
            $jobs = $this->jobPostModel->getAllActiveJobs($jobseeker_id);
        }

        // ENHANCED: Get real recommendation percentages if jobseeker is logged in
        if ($jobseeker_id && $recommendationService && !empty($jobs)) {
            try {
                error_log("🎯 Getting recommendation percentages for jobseeker {$jobseeker_id}");

                // FIXED: Check for cached recommendations first
                $cacheKey = "recommendations_{$jobseeker_id}_" . md5(serialize(array_column($jobs, 'job_id')));
                $cachedRecommendations = null;

                // Simple file-based cache (you can replace with Redis/Memcached later)
                $cacheFile = sys_get_temp_dir() . "/sikap_rec_" . $cacheKey . ".json";
                if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < 3600) { // Cache for 1 hour
                    $cachedRecommendations = json_decode(file_get_contents($cacheFile), true);
                    error_log("📄 Using cached recommendations");
                }

                if ($cachedRecommendations) {
                    $matchPercentages = $cachedRecommendations;
                } else {
                    // Get fresh recommendations
                    $recommendationResult = $recommendationService->getRecommendations($jobseeker_id, 50);

                    if ($recommendationResult['success'] && !empty($recommendationResult['recommendations'])) {
                        // Create a lookup map of job_id => match_percentage
                        $matchPercentages = [];
                        foreach ($recommendationResult['recommendations'] as $rec) {
                            $matchPercentages[$rec['job_id']] = $rec['match_percentage'];
                        }

                        // Cache the results
                        file_put_contents($cacheFile, json_encode($matchPercentages));
                        error_log("💾 Cached recommendations for future use");
                    } else {
                        $matchPercentages = [];
                    }
                }

                error_log("📊 Found " . count($matchPercentages) . " job matches");

                // Update jobs with real match percentages
                foreach ($jobs as &$job) {
                    if (isset($matchPercentages[$job['job_id']])) {
                        // Use the real/cached recommendation percentage
                        $job['match_percentage'] = round($matchPercentages[$job['job_id']], 1);
                        $job['has_recommendation'] = true;
                        error_log("✅ Job {$job['job_id']}: {$job['match_percentage']}% match");
                    } else {
                        // Calculate a consistent fallback percentage
                        $job['match_percentage'] = $this->calculateBasicMatch($job, $jobseeker);
                        $job['has_recommendation'] = false;
                        error_log("📈 Job {$job['job_id']}: {$job['match_percentage']}% fallback match");
                    }
                }

                // Sort jobs by match percentage (highest first) for better UX
                usort($jobs, function ($a, $b) {
                    return ($b['match_percentage'] ?? 0) <=> ($a['match_percentage'] ?? 0);
                });

                error_log("🔄 Sorted jobs by match percentage");
            } catch (Exception $e) {
                error_log("❌ Error getting recommendations: " . $e->getMessage());
                // Apply consistent fallback matching
                foreach ($jobs as &$job) {
                    $job['match_percentage'] = $this->calculateBasicMatch($job, $jobseeker);
                    $job['has_recommendation'] = false;
                }
            }
        } else {
            // For non-logged-in users - use consistent seed
            foreach ($jobs as &$job) {
                mt_srand($job['job_id']); // Consistent seed
                $job['match_percentage'] = mt_rand(60, 95);
                mt_srand(); // Reset
                $job['has_recommendation'] = false;
            }
        }

        // Add saved status if user is logged in as jobseeker
        if ($jobseeker_id && !empty($jobs)) {
            require_once __DIR__ . '/../models/SavedJobs.php';
            $savedJobsModel = new SavedJobs();
            foreach ($jobs as &$job) {
                $job['is_saved'] = $savedJobsModel->isSaved($jobseeker_id, $job['job_id']);
            }
        }

        include __DIR__ . '/../views/jobseekers/job-application/browse-jobs.php';
    }

    /**
     * Calculate basic match percentage as fallback when ML recommendation is unavailable
     */
    private function calculateBasicMatch($job, $jobseeker)
    {
        if (!$jobseeker) {
            // FIXED: Use job_id as seed for consistent results for guests
            mt_srand($job['job_id']);
            $percentage = mt_rand(70, 90);
            mt_srand(); // Reset seed
            return $percentage;
        }

        // FIXED: Use consistent seed based on jobseeker_id and job_id
        $seed = $jobseeker['jobseeker_id'] * 1000 + $job['job_id'];
        mt_srand($seed);

        $matchScore = 40; // Base score

        // Location preference (basic implementation)
        if (!empty($jobseeker['preferred_location']) && !empty($job['location'])) {
            if (stripos($job['location'], $jobseeker['preferred_location']) !== false) {
                $matchScore += 15;
            }
        }

        // Job type preference
        if (!empty($jobseeker['preferred_job_type']) && !empty($job['job_type'])) {
            if (strtolower($jobseeker['preferred_job_type']) === strtolower($job['job_type'])) {
                $matchScore += 10;
            }
        }

        // FIXED: Use seeded randomization for consistent results
        $randomVariation = mt_rand(-3, 20);
        $matchScore += $randomVariation;

        // Reset random seed
        mt_srand();

        // Ensure score is within reasonable bounds with 20% minimum
        return max(15, min(95, round($matchScore, 1)));
    }

    public function editJob()
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

        // Verify job ownership
        $job = $this->jobPostModel->getJobById($job_id);
        if (!$job || $job['employer_id'] != $employer['employer_id']) {
            header('Location: ?page=manage-jobs&error=' . urlencode('Job not found or access denied.'));
            exit;
        }

        // Redirect to post-job with edit mode
        header("Location: ?page=post-job&step=1&job_id=$job_id");
        exit;
    }

    public function toggleJobStatus()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }

        $job_id = $_GET['id'] ?? null;
        $new_status = $_GET['status'] ?? null;

        if (!$job_id || !$new_status) {
            header('Location: ?page=manage-jobs&error=' . urlencode('Invalid request.'));
            exit;
        }

        // Validate status
        $allowed_statuses = ['open', 'paused', 'closed'];
        if (!in_array($new_status, $allowed_statuses)) {
            header('Location: ?page=manage-jobs&error=' . urlencode('Invalid status.'));
            exit;
        }

        // Get employer info
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if (!$employer) {
            header('Location: ?page=complete-employer-profile');
            exit;
        }

        // Verify job ownership
        $job = $this->jobPostModel->getJobById($job_id);
        if (!$job || $job['employer_id'] != $employer['employer_id']) {
            header('Location: ?page=manage-jobs&error=' . urlencode('Job not found or access denied.'));
            exit;
        }

        // Update job status
        $result = $this->jobPostModel->updateJobPost($job_id, ['job_status' => $new_status]);

        if ($result) {
            // FIXED: Use model method for notifications when job is reopened
            if ($new_status === 'open') {
                try {
                    $notificationResult = $this->jobPostModel->notifyJobPosted($job_id);

                    if ($notificationResult) {
                        error_log("✅ Reopened job notifications sent for job ID: $job_id");
                    } else {
                        error_log("⚠️ Reopened job notifications may have failed for job ID: $job_id");
                    }
                } catch (Exception $e) {
                    error_log("❌ Failed to send job reopened notifications: " . $e->getMessage());
                }
            }

            $action = $new_status === 'open' ? 'reopened' : $new_status;
            header('Location: ?page=view-employer-job&id=' . $job_id . '&success=' . urlencode("Job $action successfully!"));
        } else {
            header('Location: ?page=view-employer-job&id=' . $job_id . '&error=' . urlencode('Failed to update job status.'));
        }
        exit;
    }

    public function deleteJob()
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

        // Verify job ownership
        $job = $this->jobPostModel->getJobById($job_id);
        if (!$job || $job['employer_id'] != $employer['employer_id']) {
            header('Location: ?page=manage-jobs&error=' . urlencode('Job not found or access denied.'));
            exit;
        }

        // Check if job has applications
        try {
            require_once __DIR__ . '/../models/JobApplication.php';
            $jobApplicationModel = new JobApplication();
            $hasApplications = $jobApplicationModel->jobHasApplications($job_id);

            if ($hasApplications) {
                header('Location: ?page=manage-jobs&error=' . urlencode('Cannot delete job with existing applications. Consider closing it instead.'));
                exit;
            }
        } catch (Exception $e) {
            error_log('Error checking applications: ' . $e->getMessage());
            // Continue with deletion if we can't check applications
        }

        // Delete the job
        $result = $this->jobPostModel->deleteJob($job_id);

        if ($result) {
            header('Location: ?page=manage-jobs&success=' . urlencode('Job deleted successfully!'));
        } else {
            header('Location: ?page=manage-jobs&error=' . urlencode('Failed to delete job.'));
        }
        exit;
    }

    public function viewEmployerProfileForJobseeker()
    {
        $employer_id = $_GET['employer_id'] ?? null;
        if (!$employer_id) {
            header('Location: ?page=browse-jobs&error=' . urlencode('Employer not found.'));
            exit;
        }

        // Get employer profile data
        $employer = $this->jobPostModel->getEmployerProfileData($employer_id);
        if (!$employer) {
            header('Location: ?page=browse-jobs&error=' . urlencode('Employer profile not found.'));
            exit;
        }

        // Get active jobs from this employer
        $activeJobs = $this->jobPostModel->getEmployerActiveJobs($employer_id);

        include __DIR__ . '/../views/jobseekers/view-employer-profile.php';
    }
    public function exploreCompanies()
    {
        // Get all employers with business profiles
        $employers = $this->jobPostModel->getAllEmployers();

        include __DIR__ . '/../views/jobseekers/explore-companies.php';
    }
}
