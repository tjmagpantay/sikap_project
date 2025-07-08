<?php
// filepath: app/controllers/EmployerDashboardController.php

require_once __DIR__ . '/../models/User.php';

class EmployerDashboardController
{
    private $employerModel;
    private $dashboardModel;

    public function __construct()
    {
        require_once __DIR__ . '/../models/Employer.php';
        require_once __DIR__ . '/../models/EmployerDashboard.php';
        
        $this->employerModel = new Employer();
        $this->dashboardModel = new EmployerDashboard();
    }

    public function dashboard()
    {
        // Check if user is logged in as employer
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

        // Get employer's job posts
        $jobPosts = $this->dashboardModel->getEmployerJobPosts($employer['employer_id']);
        
        // FIX: Add this line to make $jobs variable available for the view
        $jobs = $jobPosts;
        $totalJobPosts = count($jobs);
        
        // Calculate statistics
        $stats = $this->dashboardModel->getEmployerStats($employer['employer_id']);
        
        // Add calculated fields to job posts
        foreach ($jobPosts as &$job) {
            $job['days_remaining'] = $this->dashboardModel->calculateDaysRemaining($job['application_deadline']);
        }

        // Extract variables for the view
        $totalJobs = $stats['total_jobs'];
        $activeJobs = $stats['active_jobs'];
        $totalApplications = $stats['total_applications'];
        $pendingReviews = $stats['pending_reviews'];
        
        // Profile status for quick actions
        $hasProfile = $employer && !empty($employer['first_name']);
        $canPostJobs = $this->employerModel->canPostJobs($_SESSION['user_id']);

        // Debug logging - check what's actually in $jobs
        error_log('=== EMPLOYER DASHBOARD CONTROLLER DEBUG ===');
        error_log('Employer ID: ' . $employer['employer_id']);
        error_log('JobPosts count: ' . count($jobPosts));
        error_log('Jobs count: ' . count($jobs));
        error_log('TotalJobPosts: ' . $totalJobPosts);
        
        if (!empty($jobs)) {
            error_log('First job title: ' . $jobs[0]['job_title']);
            error_log('First job keys: ' . implode(', ', array_keys($jobs[0])));
        } else {
            error_log('Jobs array is EMPTY!');
        }
        error_log('=== END DEBUG ===');

        include __DIR__ . '/../views/employers/dashboard.php';
    }

    public function expireJob()
    {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        $job_id = $_POST['job_id'] ?? null;
        if (!$job_id) {
            echo json_encode(['success' => false, 'message' => 'Job ID is required']);
            exit;
        }

        // Get employer info
        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if (!$employer) {
            echo json_encode(['success' => false, 'message' => 'Employer profile not found']);
            exit;
        }

        // Expire the job
        $result = $this->dashboardModel->expireJob($job_id, $employer['employer_id']);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Job expired successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to expire job']);
        }
        exit;
    }

    public function filterJobs()
    {
        // This method can be used for AJAX filtering
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_EMPLOYER) {
            header('Location: ?page=login-employer');
            exit;
        }

        $employer = $this->employerModel->findByUserId($_SESSION['user_id']);
        if (!$employer) {
            header('Location: ?page=complete-employer-profile');
            exit;
        }

        $filters = [
            'status' => $_GET['status'] ?? '',
            'sort' => $_GET['sort'] ?? 'recent',
            'page' => $_GET['page'] ?? 1,
            'limit' => $_GET['limit'] ?? 10
        ];

        $jobPosts = $this->dashboardModel->getJobPostsWithFilters($employer['employer_id'], $filters);
        
        // Add calculated fields
        foreach ($jobPosts as &$job) {
            $job['days_remaining'] = $this->dashboardModel->calculateDaysRemaining($job['application_deadline']);
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'jobs' => $jobPosts]);
        exit;
    }
}
?>