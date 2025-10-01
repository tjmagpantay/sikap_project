<?php
include_once __DIR__ . '/../models/JobseekerSettings.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Jobseeker.php';

class JobseekerSettingsController
{
    private $jobseekerModel;

    public function __construct()
    {
        $this->jobseekerModel = new Jobseeker();
    }

    public function showSettings()
    {
        // Check authentication
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker data for navbar
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        if (!$jobseeker) {
            header('Location: ?page=complete-jobseeker-profile');
            exit;
        }

        // Since we only have password/account management settings now,
        // we don't need to load complex settings
        include __DIR__ . '/../views/jobseekers/settings-jobseeker.php';
    }

    // Removed updateSettings method since we're handling password change, 
    // deactivation, and deletion directly in JobseekerController
}
