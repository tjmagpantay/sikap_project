<?php
// Check if user is logged in and is an employer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
    header('Location: ?page=login-employer');
    exit;
}

$employerModel = new Employer();
$jobPostModel = new JobPost();

// Get employer info
$employer = $employerModel->findByUserId($_SESSION['user_id']);
if (!$employer) {
    header('Location: ?page=complete-employer-profile&error=' . urlencode('Please complete your profile first.'));
    exit;
}

// Check if employer can post jobs (is verified)
if (!$employerModel->canPostJobs($_SESSION['user_id'])) {
    header('Location: ?page=profile-employer&error=' . urlencode('You must be verified to post jobs. Please complete your profile and wait for verification.'));
    exit;
}

// Get the step from URL parameter
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

// Validate step range
if ($step < 1 || $step > 5) {
    $step = 1;
}

// Get job_id for editing (if exists)
$job_id = isset($_GET['job_id']) ? (int)$_GET['job_id'] : null;
$isEditing = $job_id !== null;

// If editing, get existing job data
$jobData = [];
if ($isEditing) {
    $jobData = $jobPostModel->getJobById($job_id);
    if (!$jobData || $jobData['employer_id'] !== $employer['employer_id']) {
        header('Location: ?page=manage-jobs&error=' . urlencode('Job not found or access denied.'));
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../../controllers/JobPostController.php';
    $controller = new JobPostController();
    $controller->handleStepSubmission($step, $job_id);
    return;
}

// Get categories for step 1
if ($step == 1) {
    $categories = $jobPostModel->getJobCategories();
}

// Get existing data for step 3 (screening questions)
if ($step == 3 && $job_id) {
    $screeningQuestions = $jobPostModel->getScreeningQuestions($job_id);
}

// Get existing data for step 2 (attachments)
if ($step == 2 && $job_id) {
    $attachments = $jobPostModel->getJobAttachments($job_id);
}

// Get all data for step 5 (review)
if ($step == 5 && $job_id) {
    $jobData = $jobPostModel->getFullJobData($job_id);
}

// Get any error/success messages
$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';

// Include the specific step
switch ($step) {
    case 1:
        include __DIR__ . '/post-job/post-job-step1.php';
        break;
    case 2:
        include __DIR__ . '/post-job/post-job-step2.php';
        break;
    case 3:
        include __DIR__ . '/post-job/post-job-step3.php';
        break;
    case 4:
        include __DIR__ . '/post-job/post-job-step4.php';
        break;
    case 5:
        include __DIR__ . '/post-job/post-job-step5.php';
        break;
    default:
        include __DIR__ . '/post-job/post-job-step1.php';
}
?>