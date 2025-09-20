<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/SavedJobs.php';

class SaveJobController
{
    private $savedJobsModel;
    private $jobseekerModel;

    public function __construct()
    {
        $this->savedJobsModel = new SavedJobs();
        $this->jobseekerModel = new Jobseeker();
    }

    public function saveJob()
    {
        // Clear any output buffers and set headers first
        while (ob_get_level()) {
            ob_end_clean();
        }

        ob_start(); // Start fresh buffer
        header('Content-Type: application/json');

        try {
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
                http_response_code(401);
                $this->sendJsonAndExit(['success' => false, 'message' => 'Unauthorized']);
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                $this->sendJsonAndExit(['success' => false, 'message' => 'Method not allowed']);
            }

            $job_id = $_POST['job_id'] ?? null;

            if (!$job_id) {
                http_response_code(400);
                $this->sendJsonAndExit(['success' => false, 'message' => 'Job ID is required']);
            }

            // Get jobseeker
            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
            if (!$jobseeker) {
                http_response_code(400);
                $this->sendJsonAndExit(['success' => false, 'message' => 'Jobseeker profile not found']);
            }

            $result = $this->savedJobsModel->saveJob($jobseeker['jobseeker_id'], $job_id);

            if ($result) {
                $this->sendJsonAndExit(['success' => true, 'message' => 'Job saved successfully']);
            } else {
                $this->sendJsonAndExit(['success' => false, 'message' => 'Job is already saved or could not be saved']);
            }
        } catch (Exception $e) {
            error_log('Save job error: ' . $e->getMessage());
            http_response_code(500);
            $this->sendJsonAndExit(['success' => false, 'message' => 'Internal server error']);
        }
    }

    public function unsaveJob()
    {
        // Clear any output buffers and set headers first
        while (ob_get_level()) {
            ob_end_clean();
        }

        ob_start(); // Start fresh buffer
        header('Content-Type: application/json');

        try {
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
                http_response_code(401);
                $this->sendJsonAndExit(['success' => false, 'message' => 'Unauthorized']);
            }

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                $this->sendJsonAndExit(['success' => false, 'message' => 'Method not allowed']);
            }

            $job_id = $_POST['job_id'] ?? null;

            if (!$job_id) {
                http_response_code(400);
                $this->sendJsonAndExit(['success' => false, 'message' => 'Job ID is required']);
            }

            // Get jobseeker
            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
            if (!$jobseeker) {
                http_response_code(400);
                $this->sendJsonAndExit(['success' => false, 'message' => 'Jobseeker profile not found']);
            }

            $result = $this->savedJobsModel->unsaveJob($jobseeker['jobseeker_id'], $job_id);

            if ($result) {
                $this->sendJsonAndExit(['success' => true, 'message' => 'Job removed from saved jobs']);
            } else {
                $this->sendJsonAndExit(['success' => false, 'message' => 'Job was not saved or could not be removed']);
            }
        } catch (Exception $e) {
            error_log('Unsave job error: ' . $e->getMessage());
            http_response_code(500);
            $this->sendJsonAndExit(['success' => false, 'message' => 'Internal server error']);
        }
    }

    private function sendJsonAndExit($data)
    {
        // Clear any previous output
        ob_clean();

        // Encode and output JSON
        echo json_encode($data);

        // Flush and exit
        ob_end_flush();
        exit;
    }

    public function showSavedJobs()
    {
        // Check if user is logged in and is a jobseeker
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            header('Location: ?page=login-jobseeker');
            exit;
        }

        // Get jobseeker ID
        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);

        if (!$jobseeker) {
            header('Location: ?page=complete-jobseeker-profile');
            exit;
        }

        // Get saved jobs
        $savedJobs = $this->savedJobsModel->getSavedJobs($jobseeker['jobseeker_id']);

        // Include the view
        include __DIR__ . '/../views/jobseekers/saved-jobs.php';
    }

    public function checkIfSaved($job_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != User::ROLE_JOBSEEKER) {
            return false;
        }

        $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
        if (!$jobseeker) {
            return false;
        }

        return $this->savedJobsModel->isSaved($jobseeker['jobseeker_id'], $job_id);
    }
}
