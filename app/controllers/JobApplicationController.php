<?php
// filepath: c:\xampp\htdocs\sikap\app\controllers\JobApplicationController.php
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
        $restart = $_GET['restart'] ?? false;

        if (!$job_id) {
            header('Location: ?page=browse-jobs&error=' . urlencode('Job not found.'));
            exit;
        }

        // If restarting, delete the incomplete application
        if ($restart && $application_id) {
            $this->jobApplicationModel->deleteApplication($application_id);
            $application_id = null;
        }

        // Get or create application
        if ($application_id) {
            // Resume existing application
            $application = $this->jobApplicationModel->getApplicationById($application_id);
            if (!$application) {
                header('Location: ?page=view-job&job_id=' . $job_id . '&error=' . urlencode('Application not found.'));
                exit;
            }
        } else {
            // Check if user already has an application for this job
            if (isset($_SESSION['user_id']) && $_SESSION['role'] == User::ROLE_JOBSEEKER) {
                $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
                if ($jobseeker) {
                    $existingApp = $this->jobApplicationModel->getApplicationByJobseekerAndJob(
                        $jobseeker['jobseeker_id'],
                        $job_id
                    );
                    if ($existingApp && !$restart) {
                        // Redirect to resume existing application
                        header('Location: ?page=apply-job&job_id=' . $job_id . '&application_id=' . $existingApp['application_id'] . '&step=' . $existingApp['current_step']);
                        exit;
                    }
                }
            }
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

        // Check age eligibility
        $ageCheck = $this->checkAgeEligibility($job, $jobseeker);
        if (!$ageCheck['eligible']) {
            header('Location: ?page=view-job&job_id=' . $job_id . '&error=' . urlencode($ageCheck['message']));
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
            // Allow user to navigate to any step they've reached or go backwards
            // Don't override the step from URL unless it's invalid
            if ($step > $existingApplication['current_step']) {
                $step = $existingApplication['current_step'];
            }

            // Update current_step if user is moving to a new step they haven't reached
            // but only if it's not going backwards
            if ($step <= $existingApplication['current_step'] && $step != $existingApplication['current_step']) {
                // User is navigating backwards, update the step in database for tracking
                $this->jobApplicationModel->updateCurrentStep($application_id, $step);
            }
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
        $existingAttachments = [];
        if ($application_id) {
            $applicationData = $this->jobApplicationModel->getApplicationDetails($application_id);
            $existingAttachments = $this->jobApplicationModel->getApplicationAttachments($application_id);
        }

        $error = $_GET['error'] ?? '';
        $success = $_GET['success'] ?? '';

        include __DIR__ . '/../views/jobseekers/job-application/apply-job-step1.php';
    }

    // Step 2: Screening Questions
    private function showStep2($job, $jobseeker, $application_id)
    {
        // Debug logging
        error_log("DEBUG Step2: job_id = " . $job['job_id']);
        error_log("DEBUG Step2: screening_questions_enabled = " . ($job['screening_questions_enabled'] ?? 'not set'));

        // Get screening questions if enabled
        $screeningQuestions = [];
        if (($job['screening_questions_enabled'] ?? 0) == 1) {
            $screeningQuestions = $this->jobPostModel->getScreeningQuestions($job['job_id']);
            error_log("DEBUG Step2: Found " . count($screeningQuestions) . " screening questions");
            foreach ($screeningQuestions as $q) {
                error_log("DEBUG Step2: Question - " . $q['question_text'] . " (Type: " . $q['question_type'] . ")");
            }
        } else {
            error_log("DEBUG Step2: Screening questions not enabled");
        }

        // Allow navigation to step 2 if application exists and user has reached at least step 2
        if (!$application_id) {
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=1&error=' . urlencode('Please complete Step 1 first.'));
            exit;
        }

        // Check if user has reached this step (only block if they've never reached step 2)
        $applicationData = $this->jobApplicationModel->getApplicationDetails($application_id);
        if ($applicationData && $applicationData['current_step'] < 2) {
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=1&error=' . urlencode('Please complete Step 1 first.'));
            exit;
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
        // Allow navigation to step 3 if application exists and user has reached at least step 3
        if (!$application_id) {
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=1&error=' . urlencode('Please complete previous steps first.'));
            exit;
        }

        // Check if user has reached this step (only block if they've never reached step 3)
        $applicationData = $this->jobApplicationModel->getApplicationDetails($application_id);
        if ($applicationData && $applicationData['current_step'] < 3) {
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=' . $applicationData['current_step'] . '&application_id=' . $application_id . '&error=' . urlencode('Please complete previous steps first.'));
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
        // Allow navigation to step 4 if application exists and user has reached step 4
        if (!$application_id) {
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=1&error=' . urlencode('Please complete previous steps first.'));
            exit;
        }

        // Check if user has reached this step
        $applicationData = $this->jobApplicationModel->getApplicationDetails($application_id);
        if ($applicationData && $applicationData['current_step'] < 4) {
            header('Location: ?page=apply-job&job_id=' . $job['job_id'] . '&step=' . $applicationData['current_step'] . '&application_id=' . $application_id . '&error=' . urlencode('Please complete previous steps first.'));
            exit;
        }

        // Get all application data for review
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

            // Get current attachments to check what's already attached
            $currentAttachments = $this->jobApplicationModel->getApplicationAttachments($application_id);

            // Create arrays to track what's currently attached
            $currentResumeAttachments = [];
            $currentCvAttachments = [];
            $currentAdditionalAttachments = [];

            foreach ($currentAttachments as $attachment) {
                $fileType = strtolower($attachment['file_type']);
                if ($fileType === 'resume') {
                    $currentResumeAttachments[] = $attachment;
                } elseif ($fileType === 'cv') {
                    $currentCvAttachments[] = $attachment;
                } else {
                    $currentAdditionalAttachments[] = $attachment;
                }
            }

            error_log("DEBUG Step1: Current resume attachments: " . count($currentResumeAttachments));
            error_log("DEBUG Step1: Current CV attachments: " . count($currentCvAttachments));

            $resumeHandled = false;
            $cvHandled = false;

            // === HANDLE RESUME (Only one allowed) ===

            // Check what user wants to do with resume
            $newResumeUploaded = !empty($_FILES['new_resume']['name']) && $_FILES['new_resume']['error'] === UPLOAD_ERR_OK;
            $selectedResumes = $_POST['selected_resumes'] ?? [];

            error_log("DEBUG Step1: New resume uploaded: " . ($newResumeUploaded ? 'yes' : 'no'));
            error_log("DEBUG Step1: Selected resumes: " . json_encode($selectedResumes));

            if ($newResumeUploaded) {
                // NEW RESUME UPLOAD - Clear all existing resume attachments and add new one
                $this->jobApplicationModel->clearResumeAttachments($application_id);

                $resumePath = $this->handleResumeUpload($_FILES['new_resume']);
                if ($resumePath) {
                    $this->jobApplicationModel->saveApplicationAttachment($application_id, $resumePath, 'Resume');
                    $resumeHandled = true;

                    // Optionally save to profile
                    if (isset($_POST['save_resume_to_profile']) && $_POST['save_resume_to_profile'] == '1') {
                        $this->saveOrUpdateProfileDocument($jobseeker['jobseeker_id'], $resumePath, 'resume', $_FILES['new_resume']['name']);
                    }

                    error_log("DEBUG Step1: New resume uploaded and attached");
                }
            } elseif (!empty($selectedResumes)) {
                // SELECTED EXISTING RESUME - Check if it's already attached
                $selectedResumePath = $selectedResumes[0]; // Only take first one

                // Check if this resume is already attached
                $alreadyAttached = false;
                foreach ($currentResumeAttachments as $attachment) {
                    if ($attachment['file_path'] === $selectedResumePath) {
                        $alreadyAttached = true;
                        break;
                    }

                    // Also check profile document reference
                    if (!empty($attachment['profile_document_id'])) {
                        $profileDoc = $this->findProfileDocumentById($attachment['profile_document_id']);
                        if ($profileDoc && $profileDoc['file_path'] === $selectedResumePath) {
                            $alreadyAttached = true;
                            break;
                        }
                    }
                }

                if (!$alreadyAttached) {
                    // Clear existing resume attachments and add the selected one
                    $this->jobApplicationModel->clearResumeAttachments($application_id);

                    $profileDoc = $this->findProfileDocumentByPath($jobseeker['jobseeker_id'], $selectedResumePath);
                    if ($profileDoc) {
                        $this->jobApplicationModel->saveApplicationAttachmentReference(
                            $application_id,
                            $profileDoc['document_id'],
                            'Resume'
                        );
                        error_log("DEBUG Step1: Selected resume attached (not duplicate)");
                    } else {
                        // Fallback: direct file attachment
                        $this->jobApplicationModel->saveApplicationAttachment($application_id, $selectedResumePath, 'Resume');
                        error_log("DEBUG Step1: Selected resume attached as direct file");
                    }
                } else {
                    error_log("DEBUG Step1: Selected resume is already attached - skipping");
                }

                $resumeHandled = true;
            } else {
                // NO NEW SELECTION - Keep existing resume attachments if any
                if (!empty($currentResumeAttachments)) {
                    $resumeHandled = true;
                    error_log("DEBUG Step1: Keeping existing resume attachments");
                }
            }

            // === HANDLE CV (Only one allowed) ===

            // Check what user wants to do with CV
            $newCvUploaded = !empty($_FILES['new_cv']['name']) && $_FILES['new_cv']['error'] === UPLOAD_ERR_OK;
            $selectedCvs = $_POST['selected_cvs'] ?? [];

            error_log("DEBUG Step1: New CV uploaded: " . ($newCvUploaded ? 'yes' : 'no'));
            error_log("DEBUG Step1: Selected CVs: " . json_encode($selectedCvs));

            if ($newCvUploaded) {
                // NEW CV UPLOAD - Clear all existing CV attachments and add new one
                $this->jobApplicationModel->clearCvAttachments($application_id);

                $cvPath = $this->handleResumeUpload($_FILES['new_cv']);
                if ($cvPath) {
                    $this->jobApplicationModel->saveApplicationAttachment($application_id, $cvPath, 'CV');
                    $cvHandled = true;

                    // Optionally save to profile
                    if (isset($_POST['save_cv_to_profile']) && $_POST['save_cv_to_profile'] == '1') {
                        $this->saveOrUpdateProfileDocument($jobseeker['jobseeker_id'], $cvPath, 'cv', $_FILES['new_cv']['name']);
                    }

                    error_log("DEBUG Step1: New CV uploaded and attached");
                }
            } elseif (!empty($selectedCvs)) {
                // SELECTED EXISTING CV - Check if it's already attached
                $selectedCvPath = $selectedCvs[0]; // Only take first one

                // Check if this CV is already attached
                $alreadyAttached = false;
                foreach ($currentCvAttachments as $attachment) {
                    if ($attachment['file_path'] === $selectedCvPath) {
                        $alreadyAttached = true;
                        break;
                    }

                    // Also check profile document reference
                    if (!empty($attachment['profile_document_id'])) {
                        $profileDoc = $this->findProfileDocumentById($attachment['profile_document_id']);
                        if ($profileDoc && $profileDoc['file_path'] === $selectedCvPath) {
                            $alreadyAttached = true;
                            break;
                        }
                    }
                }

                if (!$alreadyAttached) {
                    // Clear existing CV attachments and add the selected one
                    $this->jobApplicationModel->clearCvAttachments($application_id);

                    $profileDoc = $this->findProfileDocumentByPath($jobseeker['jobseeker_id'], $selectedCvPath);
                    if ($profileDoc) {
                        $this->jobApplicationModel->saveApplicationAttachmentReference(
                            $application_id,
                            $profileDoc['document_id'],
                            'CV'
                        );
                        error_log("DEBUG Step1: Selected CV attached (not duplicate)");
                    } else {
                        // Fallback: direct file attachment
                        $this->jobApplicationModel->saveApplicationAttachment($application_id, $selectedCvPath, 'CV');
                        error_log("DEBUG Step1: Selected CV attached as direct file");
                    }
                } else {
                    error_log("DEBUG Step1: Selected CV is already attached - skipping");
                }

                $cvHandled = true;
            } else {
                // NO NEW SELECTION - Keep existing CV attachments if any
                if (!empty($currentCvAttachments)) {
                    $cvHandled = true;
                    error_log("DEBUG Step1: Keeping existing CV attachments");
                }
            }

            // Require at least one document (resume or CV)
            if (!$resumeHandled && !$cvHandled) {
                throw new Exception('Please select at least one existing document or upload a new resume/CV');
            }

            // === HANDLE ADDITIONAL ATTACHMENTS ===
            // Only add new additional attachments if any files are uploaded
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
                            error_log("DEBUG Step1: Additional attachment uploaded: $file_type");
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

                if (isset($_POST[$answer_key])) {
                    $answer = $_POST[$answer_key];

                    // Handle checkbox arrays (multiple selections)
                    if (is_array($answer)) {
                        $answer = implode(',', array_map('trim', $answer));
                    } else {
                        $answer = trim($answer);
                    }

                    if (!empty($answer)) {
                        if (!$this->jobApplicationModel->saveApplicationAnswer($application_id, $question['question_id'], $answer)) {
                            throw new Exception('Failed to save screening answers');
                        }
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
            error_log("🔍 DEBUG handleStep4: Starting final submission");
            error_log("   - Application ID: $application_id");
            error_log("   - Job ID: {$job['job_id']}");
            error_log("   - Employer ID: {$job['employer_id']}");
            error_log("   - Jobseeker: {$jobseeker['first_name']} {$jobseeker['last_name']}");

            // FIXED: Finalize the application while keeping current_step for tracking
            $updateData = [
                'is_finalized' => 1,
                'current_step' => 4,  // ✅ Keep this - shows they completed all steps
                'applied_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->jobApplicationModel->updateApplication($application_id, $updateData)) {
                throw new Exception('Failed to finalize application');
            }

            error_log("✅ DEBUG: Application finalized successfully");

            // Log the application submission
            $this->jobApplicationModel->logStatusChange($application_id, 'pending', 'jobseeker', 'Application submitted');

            error_log("🔔 DEBUG: Starting notification process");

            // ADDED: Send notification to employer about new job application
            try {
                require_once __DIR__ . '/../services/NotificationService.php';
                require_once __DIR__ . '/../../config/sikap_db.php';

                error_log("🔍 DEBUG: Loading NotificationService");

                $config = require __DIR__ . '/../../config/sikap_db.php';
                $pdo = new PDO(
                    "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                    $config['db_user'],
                    $config['db_pass']
                );
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $notificationService = new NotificationService($pdo);

                // Get jobseeker's full name
                $jobseekerName = trim($jobseeker['first_name'] . ' ' . $jobseeker['last_name']);

                error_log("🔔 DEBUG: About to call notifyJobApplication");
                error_log("   - Application ID: $application_id");
                error_log("   - Job ID: {$job['job_id']}");
                error_log("   - Employer ID: {$job['employer_id']}");
                error_log("   - Jobseeker Name: $jobseekerName");

                // Send notification to employer
                $notificationResult = $notificationService->notifyJobApplication(
                    $application_id,
                    $job['job_id'],
                    $job['employer_id'],
                    $jobseekerName
                );

                error_log("🔔 DEBUG: notifyJobApplication returned: " . ($notificationResult ? 'TRUE' : 'FALSE'));

                if ($notificationResult) {
                    error_log("✅ Job application notification sent to employer for application ID: $application_id");
                } else {
                    error_log("❌ Failed to send job application notification to employer for application ID: $application_id");
                }
            } catch (Exception $e) {
                error_log("❌ Error sending job application notification: " . $e->getMessage());
                error_log("❌ Stack trace: " . $e->getTraceAsString());
                // Don't fail the application submission if notification fails
            }

            error_log("✅ DEBUG: Redirecting to success page");

            // Redirect to success page
            header('Location: ?page=application-success&application_id=' . $application_id);
            exit;
        } catch (Exception $e) {
            error_log('❌ Error in handleStep4: ' . $e->getMessage());
            error_log('❌ Stack trace: ' . $e->getTraceAsString());
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
            $uploadDir = __DIR__ . '/../../uploads/applications/';
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
            $uploadDir = __DIR__ . '/../../uploads/applications/';
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
            $savedJobsModelPath = __DIR__ . '/../models/SavedJobs.php';
            if (file_exists($savedJobsModelPath)) {
                require_once $savedJobsModelPath;
                $savedJobsModel = new SavedJobs();

                foreach ($jobs as &$job) {
                    $job['is_saved'] = $savedJobsModel->isSaved($jobseeker_id, $job['job_id']);
                }
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

    private function findProfileDocumentById($document_id)
    {
        try {
            return $this->jobseekerModel->findDocumentById($document_id);
        } catch (Exception $e) {
            error_log("Error finding profile document by ID: " . $e->getMessage());
            return null;
        }
    }

    private function findProfileDocumentByPath($jobseeker_id, $file_path)
    {
        try {
            return $this->jobseekerModel->findDocumentByPath($jobseeker_id, $file_path);
        } catch (Exception $e) {
            error_log("Error finding profile document by path: " . $e->getMessage());
            return null;
        }
    }

    // Keep existing methods for viewing applications, success page, etc.

    public function viewJob()
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

        // Initialize application-related variables
        $hasApplied = false;
        $incompleteApplication = null;
        $applicationStatus = null;
        $applicationData = null;
        $profileCompleted = false;

        // Check application status if user is logged in as jobseeker
        if (isset($_SESSION['user_id']) && $_SESSION['role'] == User::ROLE_JOBSEEKER) {
            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);

            if ($jobseeker) {
                // Check if profile is completed
                $profileCompleted = !empty($jobseeker['profile_completed']) && $jobseeker['profile_completed'] == 1;
                error_log("DEBUG viewJob: Profile completed: " . ($profileCompleted ? 'true' : 'false'));

                // Check for any application (complete or incomplete)
                $application = $this->jobApplicationModel->getApplicationByJobseekerAndJob($jobseeker['jobseeker_id'], $job_id);

                if ($application) {
                    $hasApplied = true;
                    $applicationData = $application;

                    if ($application['is_finalized'] == 1) {
                        // Complete application
                        $applicationStatus = $application['application_status'] ?? 'pending';
                        error_log("DEBUG viewJob: Complete application found - status: $applicationStatus");
                    } else {
                        // Incomplete application
                        $incompleteApplication = $application;
                        error_log("DEBUG viewJob: Incomplete application found - step: {$application['current_step']}");
                    }
                } else {
                    error_log("DEBUG viewJob: No application found for jobseeker_id={$jobseeker['jobseeker_id']}, job_id=$job_id");
                }
            } else {
                error_log("DEBUG viewJob: No jobseeker record found for user_id: " . $_SESSION['user_id']);
            }
        } else {
            error_log("DEBUG viewJob: No active jobseeker session - user_id: " . ($_SESSION['user_id'] ?? 'not set') . ", role: " . ($_SESSION['role'] ?? 'not set'));
        }

        // Debug output
        error_log("DEBUG viewJob FINAL: hasApplied=" . ($hasApplied ? 'true' : 'false'));
        error_log("DEBUG viewJob FINAL: incompleteApplication=" . ($incompleteApplication ? 'exists' : 'null'));
        error_log("DEBUG viewJob FINAL: applicationStatus=" . ($applicationStatus ?? 'null'));
        error_log("DEBUG viewJob FINAL: profileCompleted=" . ($profileCompleted ? 'true' : 'false'));

        // Load view with all variables
        include __DIR__ . '/../views/jobseekers/job-application/view-job.php';
    }

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
        $savedJobsModelPath = __DIR__ . '/../models/SavedJobs.php';
        if (file_exists($savedJobsModelPath)) {
            require_once $savedJobsModelPath;
            $savedJobsModel = new SavedJobs();

            // Use index-based loop instead of foreach with reference
            for ($i = 0; $i < count($applications); $i++) {
                $applications[$i]['is_saved'] = $savedJobsModel->isSaved($jobseeker['jobseeker_id'], $applications[$i]['job_id']);

                // Debug each application after adding saved status
                error_log("CONTROLLER DEBUG SavedJobs: Index $i - App ID: {$applications[$i]['application_id']}, Job ID: {$applications[$i]['job_id']}, Job Title: {$applications[$i]['job_title']}");
            }
        } else {
            // Fallback: mark all as not saved
            for ($i = 0; $i < count($applications); $i++) {
                $applications[$i]['is_saved'] = false;
            }
        }

        // Debug: Check what's being passed to the view
        error_log("CONTROLLER DEBUG: Before view - Applications count: " . count($applications));
        foreach ($applications as $index => $app) {
            error_log("CONTROLLER DEBUG: Index $index - App ID: {$app['application_id']}, Job ID: {$app['job_id']}, Job Title: {$app['job_title']}");
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

        // Get resignation request data (if any)
        $resignationRequest = null;
        try {
            require_once __DIR__ . '/../models/ResignationRequest.php';
            $resignationModel = new ResignationRequest();
            $resignationRequest = $resignationModel->getResignationRequestByApplication($application_id);
        } catch (Exception $e) {
            error_log('Error loading resignation request: ' . $e->getMessage());
            // Continue without resignation data
            $resignationRequest = null;
        }

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

    public function resignFromJob()
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
        if (!$jobseeker) {
            header('Location: ?page=my-applications&error=' . urlencode('Jobseeker profile not found.'));
            exit;
        }

        // Check if jobseeker can resign (must be hired)
        if (!$this->jobApplicationModel->canResign($application_id, $jobseeker['jobseeker_id'])) {
            header('Location: ?page=my-applications&error=' . urlencode('You can only resign from jobs where you have been hired.'));
            exit;
        }

        // Check if there's already a pending resignation request
        require_once __DIR__ . '/../models/ResignationRequest.php';
        $resignationModel = new ResignationRequest();

        $existingRequest = $resignationModel->getResignationRequestByApplication($application_id);
        if ($existingRequest && $existingRequest['request_status'] === 'pending') {
            header('Location: ?page=view-application&id=' . $application_id . '&error=' . urlencode('You already have a pending resignation request for this position.'));
            exit;
        }

        // Handle resignation request submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_resignation'])) {
            error_log('Processing resignation request for application: ' . $application_id);

            try {
                // Get application details to find employer
                $application = $this->jobApplicationModel->getApplicationDetails($application_id, $jobseeker['jobseeker_id']);
                if (!$application) {
                    error_log('Application not found for ID: ' . $application_id);
                    throw new Exception('Application not found.');
                }

                error_log('Application found - Employer ID: ' . $application['employer_id']);

                $resignationData = [
                    'application_id' => $application_id,
                    'jobseeker_id' => $jobseeker['jobseeker_id'],
                    'employer_id' => $application['employer_id'],
                    'resignation_reason' => trim($_POST['resignation_reason']) ?: null
                ];

                error_log('Resignation data: ' . json_encode($resignationData));

                $result = $resignationModel->createResignationRequest($resignationData);

                error_log('Resignation creation result: ' . ($result ? 'SUCCESS' : 'FAILED'));

                if ($result) {
                    error_log('Redirecting to success page');
                    header('Location: ?page=view-application&id=' . $application_id . '&success=' . urlencode('Your resignation request has been submitted and is pending employer approval.'));
                } else {
                    throw new Exception('Failed to submit resignation request.');
                }
            } catch (Exception $e) {
                error_log('Error in resignation submission: ' . $e->getMessage());
                header('Location: ?page=resign-from-job&id=' . $application_id . '&error=' . urlencode($e->getMessage()));
            }
            exit;
        }

        // Show resignation confirmation page
        $application = $this->jobApplicationModel->getApplicationDetails($application_id, $jobseeker['jobseeker_id']);
        if (!$application) {
            header('Location: ?page=my-applications&error=' . urlencode('Application not found.'));
            exit;
        }

        include __DIR__ . '/../views/jobseekers/job-application/resign-confirmation.php';
    }

    // Update the viewJob method in JobApplicationController.php:

    private function saveOrUpdateProfileDocument($jobseeker_id, $file_path, $file_type, $file_name)
    {
        try {
            // Check if user already has this type of document in profile
            $existingDoc = $this->jobseekerModel->findDocumentByType($jobseeker_id, $file_type);

            if ($existingDoc) {
                // Update existing document
                $this->jobseekerModel->updateDocument($existingDoc['document_id'], $file_path, $file_name);
                error_log("DEBUG: Updated existing $file_type in profile");
            } else {
                // Create new profile document
                $this->jobseekerModel->saveDocument($jobseeker_id, $file_path, $file_type, $file_name);
                error_log("DEBUG: Created new $file_type in profile");
            }

            return true;
        } catch (Exception $e) {
            error_log("Error saving/updating profile document: " . $e->getMessage());
            return false;
        }
    }

    // Add this method to check age eligibility:

    private function checkAgeEligibility($job, $jobseeker)
    {
        // Skip if no age requirements
        if (empty($job['min_age']) && empty($job['max_age'])) {
            return ['eligible' => true, 'message' => ''];
        }

        // Get jobseeker's age from date_of_birth
        if (empty($jobseeker['date_of_birth'])) {
            return ['eligible' => true, 'message' => 'Age verification not required - no birth date on file'];
        }

        $birthdate = new DateTime($jobseeker['date_of_birth']);
        $today = new DateTime();
        $age = $today->diff($birthdate)->y;

        $ageRequirement = '';
        if (!empty($job['min_age']) && !empty($job['max_age'])) {
            $ageRequirement = "between {$job['min_age']} and {$job['max_age']} years old";
            $eligible = $age >= $job['min_age'] && $age <= $job['max_age'];
        } elseif (!empty($job['min_age'])) {
            $ageRequirement = "at least {$job['min_age']} years old";
            $eligible = $age >= $job['min_age'];
        } elseif (!empty($job['max_age'])) {
            $ageRequirement = "no more than {$job['max_age']} years old";
            $eligible = $age <= $job['max_age'];
        }

        $message = $eligible
            ? "You meet the age requirement ($ageRequirement)"
            : "This position requires applicants to be $ageRequirement. Your current age is $age.";

        return ['eligible' => $eligible, 'message' => $message, 'age' => $age];
    }

    // Add this method to finalize application submission:
    private function finalizeApplication($application_id, $job, $jobseeker)
    {
        try {
            // Update application as finalized
            $updateData = [
                'is_finalized' => 1,
                'current_step' => 4,
                'applied_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->jobApplicationModel->updateApplication($application_id, $updateData)) {
                throw new Exception('Failed to finalize application');
            }

            // Log status change
            $this->jobApplicationModel->logStatusChange($application_id, 'pending', 'jobseeker', 'Application submitted');

            // FIXED: Send notification to employer
            try {
                require_once __DIR__ . '/../services/NotificationService.php';
                require_once __DIR__ . '/../../config/sikap_db.php';

                $config = require __DIR__ . '/../../config/sikap_db.php';
                $pdo = new PDO(
                    "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                    $config['db_user'],
                    $config['db_pass']
                );
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $notificationService = new NotificationService($pdo);

                // Get jobseeker's full name
                $jobseekerName = trim($jobseeker['first_name'] . ' ' . $jobseeker['last_name']);

                error_log("🔔 DEBUG: Sending job application notification");
                error_log("   - Application ID: $application_id");
                error_log("   - Job ID: {$job['job_id']}");
                error_log("   - Employer ID: {$job['employer_id']}");
                error_log("   - Jobseeker Name: $jobseekerName");

                // Send notification to employer
                $notificationResult = $notificationService->notifyJobApplication(
                    $application_id,
                    $job['job_id'],
                    $job['employer_id'],
                    $jobseekerName
                );

                if ($notificationResult) {
                    error_log("✅ Job application notification sent to employer for application ID: $application_id");
                } else {
                    error_log("❌ Failed to send job application notification to employer for application ID: $application_id");
                }
            } catch (Exception $e) {
                error_log("❌ Error sending job application notification: " . $e->getMessage());
                // Don't fail the application if notification fails
            }

            return true;
        } catch (Exception $e) {
            error_log('❌ Error finalizing application: ' . $e->getMessage());
            return false;
        }
    }
}
