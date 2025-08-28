<?php
// filepath: app/controllers/JobSeekerDashboardController.php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/JobPost.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/JobApplication.php';
require_once __DIR__ . '/../models/JobseekerDashboard.php';

class JobSeekerDashboardController
{
    private $jobPostModel;
    private $jobseekerModel;
    private $jobApplicationModel;
    private $dashboardModel;

    public function __construct()
    {
        $this->jobPostModel = new JobPost();
        $this->jobseekerModel = new Jobseeker();
        $this->jobApplicationModel = new JobApplication();
        $this->dashboardModel = new JobseekerDashboard();
    }

    public function dashboard()
    {
        // Debug logging
        error_log("JobSeekerDashboardController Debug:");
        error_log("Session user_id: " . ($_SESSION['user_id'] ?? 'NOT SET'));
        error_log("Session role: " . ($_SESSION['role'] ?? 'NOT SET'));
        error_log("User::ROLE_JOBSEEKER constant: " . User::ROLE_JOBSEEKER);
        error_log("Role comparison result: " . (($_SESSION['role'] ?? null) == User::ROLE_JOBSEEKER ? 'TRUE' : 'FALSE'));
        
        // Authentication check
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            error_log("Auth failed - redirecting to login-jobseeker");
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker profile
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        $hasProfile = !empty($jobseeker['first_name']) && !empty($jobseeker['last_name']);

        // Get jobseeker ID if profile exists
        $jobseeker_id = $hasProfile ? $jobseeker['jobseeker_id'] : null;

        // Use the working JobPost model to get jobs (like the old working controller)
        $jobs = $this->jobPostModel->getAllActiveJobs($jobseeker_id);

        // Get dashboard stats from the dashboard model
        $stats = $this->dashboardModel->getJobseekerStats($jobseeker_id);
        $recentApplications = $this->dashboardModel->getRecentApplications($jobseeker_id);
        $profileCompletion = $this->dashboardModel->getProfileCompletion($jobseeker_id);

        // Convert stats to the format expected by the view (for backward compatibility)
        $applicationStats = [
            'total' => $stats['total_applications'],
            'pending' => $stats['pending_applications'],
            'shortlisted' => $stats['shortlisted_applications'],
            'hired' => $stats['hired_applications']
        ];

        // Select job for preview (maintaining existing functionality)
        $selectedJobId = $_GET['job_id'] ?? ($jobs[0]['job_id'] ?? null);
        $selectedJob = null;
        foreach ($jobs as $job) {
            if ($job['job_id'] == $selectedJobId) {
                $selectedJob = $job;
                break;
            }
        }

        // Include the view
        include __DIR__ . '/../views/jobseekers/dashboard.php';
    }
}
