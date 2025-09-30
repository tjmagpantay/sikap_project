<?php
class LandingPageController
{
    private $jobPostModel;

    public function __construct()
    {
        require_once __DIR__ . '/../models/JobPost.php';
        $this->jobPostModel = new JobPost();
    }

    public function getTopCompanies($limit = 4)
    {
        try {
            // Get top companies based on active jobs count and verification status
            $companies = $this->jobPostModel->getAllEmployers($limit);

            return $companies;
        } catch (Exception $e) {
            error_log("Error fetching top companies: " . $e->getMessage());
            return [];
        }
    }

    public function getPopularJobs($limit = 6)
    {
        try {
            // Get popular jobs - active jobs without jobseeker-specific data
            $jobs = $this->jobPostModel->getAllActiveJobs();

            // Limit the results for landing page display
            $jobs = array_slice($jobs, 0, $limit);

            return $jobs;
        } catch (Exception $e) {
            error_log("Error fetching popular jobs: " . $e->getMessage());
            return [];
        }
    }

    public function viewCompanyPublic($employerId)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Store the intended destination in session
            $_SESSION['redirect_after_login'] = "?page=view-employer-profile&employer_id=" . $employerId;

            // Redirect to login with message
            $_SESSION['login_message'] = "Please log in to view company details.";
            header('Location: ?page=login');
            exit();
        }

        // If logged in, redirect to the actual company profile
        header("Location: ?page=view-employer-profile&employer_id=" . $employerId);
        exit();
    }

    public function viewJobPublic($jobId)
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Store the intended destination in session
            $_SESSION['redirect_after_login'] = "?page=view-job&job_id=" . $jobId;

            // Redirect to login with message
            $_SESSION['login_message'] = "Please log in to view job details.";
            header('Location: ?page=login');
            exit();
        }

        // If logged in and is jobseeker, redirect to job details
        if ($_SESSION['role'] == 'jobseeker') {
            header("Location: ?page=view-job&job_id=" . $jobId);
        } else {
            // Other roles redirect to browse jobs
            header("Location: ?page=browse-jobs");
        }
        exit();
    }
}
