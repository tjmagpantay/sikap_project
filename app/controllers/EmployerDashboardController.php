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

        // If no employer profile exists, create a basic one or handle gracefully
        if (!$employer) {
            $employer = [
                'employer_id' => null,
                'first_name' => '',
                'last_name' => '',
                'company_name' => ''
            ];
        }

        // Get filter parameters
        $statusFilter = $_GET['status'] ?? null;
        $currentPage = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
        $limit = 5;

        // Get filtered jobs (only if employer exists)
        $jobsData = ['jobs' => [], 'total' => 0, 'total_pages' => 0];
        if ($employer['employer_id']) {
            $jobsData = $this->getFilteredJobs($employer['employer_id'], $statusFilter, $currentPage, $limit);
        }

        // Extract job data
        $jobs = $jobsData['jobs'];
        $totalJobCount = $jobsData['total'];
        $totalPages = $jobsData['total_pages'];

        // Calculate pagination
        $hasNextPage = $currentPage < $totalPages;
        $hasPrevPage = $currentPage > 1;

        // Calculate statistics (handle null employer_id)
        $stats = [
            'total_jobs' => 0,
            'active_jobs' => 0,
            'total_applications' => 0,
            'pending_reviews' => 0
        ];

        if ($employer['employer_id']) {
            $stats = $this->dashboardModel->getEmployerStats($employer['employer_id']);

            // FIXED: Get ALL jobs to calculate proper active job count
            require_once __DIR__ . '/../models/JobPost.php';
            $jobPostModel = new JobPost();
            $allJobs = $jobPostModel->getJobsByEmployerWithStatus($employer['employer_id']);

            // Calculate proper active jobs count (jobs with actual_status = 'open')
            $actualActiveJobs = 0;
            foreach ($allJobs as $job) {
                $actualStatus = $job['actual_status'] ?? $job['job_status'];
                if ($actualStatus == 'open') {
                    $actualActiveJobs++;
                }
            }

            // Override the active_jobs count with the correct calculation
            $stats['active_jobs'] = $actualActiveJobs;

            // Make allJobs available to the view
            $allJobsForView = $allJobs;
        } else {
            $allJobsForView = [];
        }

        // Add calculated fields to job posts
        foreach ($jobs as &$job) {
            $job['days_remaining'] = $this->dashboardModel->calculateDaysRemaining($job['application_deadline']);
        }

        // Extract variables for the view
        $totalJobs = $stats['total_jobs'];
        $activeJobs = $stats['active_jobs'];
        $totalApplications = $stats['total_applications'];
        $pendingReviews = $stats['pending_reviews'];

        // Profile status for quick actions
        $hasProfile = $employer && !empty($employer['first_name']);
        $canPostJobs = $employer['employer_id'] ? $this->employerModel->canPostJobs($_SESSION['user_id']) : false;

        // Add allJobs to available variables
        $allJobs = $allJobsForView;

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
            'limit' => $_GET['limit'] ?? 5
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
    public function getFilteredJobs($employer_id, $status = null, $page = 1, $limit = 5)
    {
        if (!$employer_id) {
            return [];
        }

        // Get all jobs with proper status handling like manage-jobs.php
        require_once __DIR__ . '/../models/JobPost.php';
        $jobPostModel = new JobPost();
        $allJobs = $jobPostModel->getJobsByEmployerWithStatus($employer_id);

        // Filter jobs by status with proper expiry handling (same logic as manage-jobs.php)
        $filteredJobs = array_filter($allJobs, function ($job) use ($status) {
            $actualStatus = $job['actual_status'] ?? $job['job_status'];

            if (!$status) {
                return true; // Show all if no status filter
            }

            switch ($status) {
                case 'open':
                    // Show only truly active jobs (open and not expired)
                    return $actualStatus == 'open';
                case 'expired':
                    // Show jobs that are expired (had deadline and passed it)
                    return $actualStatus == 'expired';
                case 'closed':
                    // Show manually closed jobs
                    return $job['job_status'] == 'closed';
                case 'draft':
                    // Show draft jobs
                    return $job['job_status'] == 'draft';
                default:
                    return $actualStatus == $status;
            }
        });

        // Apply pagination
        $totalCount = count($filteredJobs);
        $offset = ($page - 1) * $limit;
        $paginatedJobs = array_slice($filteredJobs, $offset, $limit);

        return [
            'jobs' => $paginatedJobs,
            'total' => $totalCount,
            'total_pages' => ceil($totalCount / $limit)
        ];
    }
}
