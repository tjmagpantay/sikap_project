<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/SavedJobs.php';

class SaveJobController
{
    private $jobseekerModel;
    private $savedJobsModel;

    public function __construct()
    {
        $this->jobseekerModel = new Jobseeker();
        $this->savedJobsModel = new SavedJobs();
    }

    public function saveJob()
    {
        // Clear any output buffer and set headers first
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Set JSON header
        header('Content-Type: application/json');

        try {
            // Check if user is logged in as jobseeker
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Please login as a jobseeker']);
                exit;
            }

            // Get jobseeker info
            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
            if (!$jobseeker) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Please complete your profile first']);
                exit;
            }

            // Get job ID from POST data
            $job_id = $_POST['job_id'] ?? null;
            if (!$job_id) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Job ID is required']);
                exit;
            }

            // Check if job is already saved
            if ($this->savedJobsModel->isSaved($jobseeker['jobseeker_id'], $job_id)) {
                echo json_encode(['success' => false, 'message' => 'Job is already saved']);
                exit;
            }

            // Save the job
            $result = $this->savedJobsModel->saveJob($jobseeker['jobseeker_id'], $job_id);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Job saved successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to save job']);
            }
        } catch (Exception $e) {
            error_log('Error in saveJob: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Server error occurred']);
        }
        exit;
    }

    public function unsaveJob()
    {
        // Clear any output buffer and set headers first
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Set JSON header
        header('Content-Type: application/json');

        try {
            // Check if user is logged in as jobseeker
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Please login as a jobseeker']);
                exit;
            }

            // Get jobseeker info
            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
            if (!$jobseeker) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Jobseeker profile not found']);
                exit;
            }

            // Get job ID from POST data
            $job_id = $_POST['job_id'] ?? null;
            if (!$job_id) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Job ID is required']);
                exit;
            }

            // Unsave the job
            $result = $this->savedJobsModel->unsaveJob($jobseeker['jobseeker_id'], $job_id);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Job removed from saved jobs']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove job from saved jobs']);
            }
        } catch (Exception $e) {
            error_log('Error in unsaveJob: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Server error occurred']);
        }
        exit;
    }
}
