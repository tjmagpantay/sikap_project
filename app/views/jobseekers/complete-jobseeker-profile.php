<?php
// filepath: c:\xampp\htdocs\sikap\app\views\jobseekers\complete-jobseeker-profile.php
require_once __DIR__ . '/../../models/Jobseeker.php';

$jobseekerModel = new Jobseeker();
$jobseeker = $jobseekerModel->findByUserId($_SESSION['user_id']);

// Get the step from URL parameter
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

// Validate step range
if ($step < 1 || $step > 8) {
    $step = 1;
}

// Get data based on current step (only load what's needed)
switch ($step) {
    case 1:
        $documents = $jobseekerModel->getDocuments($_SESSION['user_id']);
        if ($documents === false) $documents = [];
        break;
    case 4:
        $education = $jobseekerModel->getEducation($_SESSION['user_id']);
        if ($education === false) $education = [];
        break;
    case 5:
        $workExperience = $jobseekerModel->getWorkExperience($_SESSION['user_id']);
        if ($workExperience === false) $workExperience = [];
        break;
    case 6:
        $skills = $jobseekerModel->getSkills($_SESSION['user_id']);
        if ($skills === false) $skills = [];
        break;
    case 7:
        $certificates = $jobseekerModel->getCertificates($_SESSION['user_id']);
        if ($certificates === false) $certificates = [];
        break;
}

// Calculate completion percentage
$completionPercentage = $jobseekerModel->calculateProfileCompletion($_SESSION['user_id']);
if ($completionPercentage === false) $completionPercentage = 0;

// Include the specific step
include __DIR__ . '/profile-completion/complete-profile-step' . $step . '.php';
?>