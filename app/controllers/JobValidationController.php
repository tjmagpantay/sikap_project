<?php
require_once __DIR__ . '/../models/JobPost.php';

class JobValidationController
{
    private $jobPostModel;

    public function __construct()
    {
        // Initialize database connection through the model
        require_once __DIR__ . '/../../config/sikap_db.php';
        $config = require __DIR__ . '/../../config/sikap_db.php';
        
        try {
            $pdo = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_pass']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->jobPostModel = new JobPost($pdo);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            header('Location: ?page=browse-jobs&error=Database connection error');
            exit;
        }
    }

    /**
     * Validate and redirect to job details
     */
    public function validateJobDetails()
    {
        // Check if job_id is provided
        if (!isset($_GET['job_id'])) {
            header('Location: ?page=browse-jobs&error=Job not specified');
            exit;
        }

        $jobId = $_GET['job_id'];

        try {
            // Use the model to check if job exists and is active
            $jobExists = $this->jobPostModel->isJobActiveById($jobId);

            if ($jobExists) {
                // Job exists and is active, redirect to view-job
                header('Location: ?page=view-job&id=' . $jobId);
            } else {
                // Job doesn't exist or is not active
                header('Location: ?page=browse-jobs&error=Job not found or no longer available');
            }
        } catch (Exception $e) {
            error_log("Error validating job: " . $e->getMessage());
            header('Location: ?page=browse-jobs&error=Unable to load job details');
        }
        
        exit;
    }

    /**
     * Validate and redirect to applications page
     */
    public function validateApplicationsAccess()
    {
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Redirect based on user type
        if (isset($_SESSION['user_id'])) {
            header('Location: ?page=my-applications');
        } elseif (isset($_SESSION['employer_id'])) {
            header('Location: ?page=view-all-applicants');
        } else {
            header('Location: ?page=login-jobseeker');
        }
        exit;
    }

    /**
     * Validate and redirect to job posts page
     */
    public function validateJobPostsAccess()
    {
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // For employers viewing their job posts
        if (isset($_SESSION['employer_id']) || isset($_SESSION['user_id'])) {
            header('Location: ?page=manage-jobs');
        } else {
            header('Location: ?page=login-employer');
        }
        exit;
    }

    /**
     * Validate and redirect to employer programs page
     */
    public function validateEmployerProgramsAccess()
    {
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Redirect to programs for employers
        if (isset($_SESSION['employer_id']) || isset($_SESSION['user_id'])) {
            header('Location: ?page=program-events');
        } else {
            header('Location: ?page=login-employer');
        }
        exit;
    }
}