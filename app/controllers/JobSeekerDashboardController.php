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

        // Get recent jobs - using the same method as JobseekerController
        try {
            $jobs = $this->jobPostModel->getOpenJobs();
            
            // Debug: Log the raw jobs data
            error_log('DEBUG Dashboard: Total jobs from DB: ' . count($jobs));
            
            // Remove duplicates if any (based on job_id)
            $uniqueJobs = [];
            foreach ($jobs as $job) {
                if (!isset($uniqueJobs[$job['job_id']])) {
                    $uniqueJobs[$job['job_id']] = $job;
                }
            }
            $jobs = array_values($uniqueJobs);
            
            // Limit to recent 6 jobs for dashboard
            $jobs = array_slice($jobs, 0, 6);
            
            error_log('DEBUG Dashboard: Jobs after deduplication and limit: ' . count($jobs));
            
            // If profile exists, check application status for each job
            if ($hasProfile && !empty($jobs)) {
                foreach ($jobs as &$job) {
                    try {
                        $job['has_applied'] = $this->jobApplicationModel->hasApplied($jobseeker['jobseeker_id'], $job['job_id']);
                    } catch (Exception $e) {
                        error_log('Error checking application status: ' . $e->getMessage());
                        $job['has_applied'] = false;
                    }
                }
            } else {
                // Set has_applied to false for all jobs if no profile
                foreach ($jobs as &$job) {
                    $job['has_applied'] = false;
                }
            }
            
        } catch (Exception $e) {
            error_log('Error fetching jobs for dashboard: ' . $e->getMessage());
            $jobs = []; // Fallback to empty array
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