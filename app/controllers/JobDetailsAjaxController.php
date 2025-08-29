<?php
require_once __DIR__ . '/../models/JobPost.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/SavedJobs.php';
require_once __DIR__ . '/../models/JobApplication.php';
require_once __DIR__ . '/../models/JobseekerDashboard.php';

class JobDetailsAjaxController
{
    private $jobPost;
    private $jobseeker;
    private $jobseekerDashboard;

    public function __construct()
    {
        // Initialize models only
        $this->jobPost = new JobPost();
        $this->jobseeker = new Jobseeker();
        $this->jobseekerDashboard = new JobseekerDashboard();
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

            // Get job details with application count and jobseeker-specific data
            $selectedJob = $this->jobseekerDashboard->getJobDetailsForJobseeker($jobId, $jobseekerId);

            if (!$selectedJob) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Job not found']);
                exit;
            }

            // Capture template output - make sure $hasProfile is available in the template
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
        } catch (Exception $e) {
            error_log("Error in AJAX controller: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Server error occurred']);
            exit;
        }
    }
}
