<?php
require_once __DIR__ . '/../models/JobPost.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/SavedJobs.php';

class JobDetailsAjaxController
{
    private $jobPost;
    private $jobseeker;
    private $savedJobs;

    public function __construct()
    {
        // Get database connection from config
        $config = require __DIR__ . '/../../config/sikap_db.php';

        try {
            $conn = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_pass']
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }

        // Initialize models - JobPost model creates its own connection
        $this->jobPost = new JobPost();
        $this->jobseeker = new Jobseeker();
        $this->savedJobs = new SavedJobs();
    }

    public function getJobDetails()
    {
        // Clear any previous output buffers and prevent output
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Set headers first
        header('Content-Type: application/json');

        try {
            // Validate input
            if (!isset($_GET['job_id']) || !is_numeric($_GET['job_id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Invalid job ID']);
                exit;
            }

            $jobId = (int)$_GET['job_id'];
            $userId = $_SESSION['user_id'] ?? null;

            // Get jobseeker ID if user is logged in
            $jobseekerId = null;
            $hasProfile = false;

            if ($userId) {
                $jobseekerData = $this->jobseeker->findByUserId($userId);
                $hasProfile = $jobseekerData && !empty($jobseekerData['first_name']);
                $jobseekerId = $hasProfile ? $jobseekerData['jobseeker_id'] : null;
            }

            // Get job details with application status
            $job = $this->jobPost->getJobForJobseeker($jobId, $jobseekerId);

            if (!$job) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Job not found']);
                exit;
            }

            // Check if job is saved
            $isSaved = false;
            if ($jobseekerId) {
                $isSaved = $this->savedJobs->isSaved($jobseekerId, $jobId);
            }

            // Prepare data for template
            $selectedJob = $job;
            $selectedJob['is_saved'] = $isSaved;

            // Capture template output
            ob_start();
            include __DIR__ . '/../views/jobseekers/job-details-ajax.php';
            $html = ob_get_clean();

            // Return successful response
            echo json_encode([
                'success' => true,
                'html' => $html,
                'job_id' => $jobId
            ]);
            exit;
        } catch (PDOException $e) {
            error_log("Database Error in AJAX controller: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error occurred']);
            exit;
        } catch (Exception $e) {
            error_log("Error in AJAX controller: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Server error occurred']);
            exit;
        }
    }
}
