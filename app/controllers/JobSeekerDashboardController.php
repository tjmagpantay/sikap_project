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
            $jobs = $this->jobPostModel->getAllActiveJobs($jobseeker_id);
        } catch (Exception $e) {
            error_log('Error fetching jobs for dashboard: ' . $e->getMessage());
            $jobs = [];
        }

        // Select job for preview (fix: must be after jobs are loaded)
        $selectedJobId = $_GET['job_id'] ?? ($jobs[0]['job_id'] ?? null);
        $selectedJob = null;
        foreach ($jobs as $job) {
            if ($job['job_id'] == $selectedJobId) {
                $selectedJob = $job;
                break;
            }
        }

        // Get application statistics if profile exists
        $applicationStats = [];
        if ($hasProfile) {
            try {
                $applications = $this->jobApplicationModel->getApplicationsByJobseeker($jobseeker['jobseeker_id']);
                $applicationStats = [
                    'total' => count($applications),
                    'pending' => count(array_filter($applications, function ($app) {
                        return isset($app['application_status']) && $app['application_status'] === 'pending';
                    })),
                    'shortlisted' => count(array_filter($applications, function ($app) {
                        return isset($app['application_status']) && $app['application_status'] === 'shortlisted';
                    })),
                    'hired' => count(array_filter($applications, function ($app) {
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
