<?php
// filepath: app/controllers/JobSeekerDashboardController.php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/JobPost.php';
require_once __DIR__ . '/../models/JobApplication.php';

class JobSeekerDashboardController
{
    private $userModel;
    private $jobseekerModel;
    private $jobPostModel;
    private $jobApplicationModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->jobseekerModel = new Jobseeker();
        $this->jobPostModel = new JobPost();
        $this->jobApplicationModel = new JobApplication();
    }

    public function dashboard()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker info
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        $hasProfile = !empty($jobseeker['first_name']) && !empty($jobseeker['last_name']);

        // Get ALL active jobs using the same method as browse-jobs
        try {
            $jobseeker_id = $hasProfile ? $jobseeker['jobseeker_id'] : null;
            
            // Use getAllActiveJobs instead of getOpenJobs (same as browse-jobs)
            $jobs = $this->jobPostModel->getAllActiveJobs($jobseeker_id);
            
            // Debug: Log the jobs data
            error_log('=== DASHBOARD DEBUG ===');
            error_log('Dashboard jobs from getAllActiveJobs: ' . count($jobs));
            foreach ($jobs as $job) {
                error_log("Job ID: {$job['job_id']}, Title: {$job['job_title']}");
            }
            error_log('=== END DASHBOARD DEBUG ===');
            
            // No need for manual deduplication since getAllActiveJobs handles it
            // No need to manually check has_applied since getAllActiveJobs sets it
            
        } catch (Exception $e) {
            error_log('Error fetching jobs for dashboard: ' . $e->getMessage());
            $jobs = [];
        }

        // Get application statistics if profile exists
        $applicationStats = [];
        if ($hasProfile) {
            try {
                $applications = $this->jobApplicationModel->getApplicationsByJobseeker($jobseeker['jobseeker_id']);
                
                $applicationStats = [
                    'total' => count($applications),
                    'pending' => count(array_filter($applications, function($app) { 
                        return isset($app['application_status']) && $app['application_status'] === 'pending'; 
                    })),
                    'shortlisted' => count(array_filter($applications, function($app) { 
                        return isset($app['application_status']) && $app['application_status'] === 'shortlisted'; 
                    })),
                    'hired' => count(array_filter($applications, function($app) { 
                        return isset($app['application_status']) && $app['application_status'] === 'hired'; 
                    }))
                ];
            } catch (Exception $e) {
                error_log('Error fetching application stats: ' . $e->getMessage());
                $applicationStats = ['total' => 0, 'pending' => 0, 'shortlisted' => 0, 'hired' => 0];
            }
        }

        include __DIR__ . '/../views/jobseekers/dashboard.php';
    }
}