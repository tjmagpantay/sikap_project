<?php
// filepath: c:\xampp\htdocs\sikap\app\controllers\JobRecommendationController.php

require_once __DIR__ . '/../services/JobRecommendationService.php';
require_once __DIR__ . '/../models/Jobseeker.php';

class JobRecommendationController
{
    private $recommendationService;
    private $jobseekerModel;

    public function __construct()
    {
        $this->recommendationService = new JobRecommendationService();
        $this->jobseekerModel = new Jobseeker();
    }

    public function index()
    {
        try {
            // Get all jobseekers for dropdown
            $jobseekers = $this->recommendationService->getAllJobseekers();

            // Initialize variables
            $recommendations = null;
            $selectedJobseeker = null;
            $error = null;
            $success = null;

            // Check if a jobseeker is selected for recommendations
            if (isset($_GET['jobseeker_id']) && !empty($_GET['jobseeker_id'])) {
                $jobseeker_id = (int)$_GET['jobseeker_id'];
                $top_k = isset($_GET['top_k']) ? (int)$_GET['top_k'] : 10;

                // Validate jobseeker exists
                $selectedJobseeker = $this->jobseekerModel->findById($jobseeker_id);

                if (!$selectedJobseeker) {
                    $error = "Jobseeker not found.";
                } else {
                    // Get recommendations
                    $result = $this->recommendationService->getRecommendations($jobseeker_id, $top_k);

                    if ($result['success']) {
                        $recommendations = $result;
                        $success = "Found {$result['total_found']} job recommendations for {$result['jobseeker']['name']}.";
                    } else {
                        $error = $result['error'];
                    }
                }
            }

            // Load the view
            $this->loadView('jobseekers/recommendations', [
                'jobseekers' => $jobseekers,
                'recommendations' => $recommendations,
                'selectedJobseeker' => $selectedJobseeker,
                'error' => $error,
                'success' => $success,
                'selectedJobseekerId' => $_GET['jobseeker_id'] ?? '',
                'topK' => $_GET['top_k'] ?? 10
            ]);
        } catch (Exception $e) {
            error_log('JobRecommendationController Error: ' . $e->getMessage());

            $this->loadView('jobseekers/recommendations', [
                'jobseekers' => [],
                'recommendations' => null,
                'selectedJobseeker' => null,
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'success' => null,
                'selectedJobseekerId' => '',
                'topK' => 10
            ]);
        }
    }

    public function getRecommendationsAPI()
    {
        header('Content-Type: application/json');

        try {
            // Check if request method is GET
            if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
                return;
            }

            // Validate required parameters
            if (!isset($_GET['jobseeker_id']) || empty($_GET['jobseeker_id'])) {
                http_response_code(400);
                echo json_encode(['error' => 'jobseeker_id parameter is required']);
                return;
            }

            $jobseeker_id = (int)$_GET['jobseeker_id'];
            $top_k = isset($_GET['top_k']) ? (int)$_GET['top_k'] : 10;

            // Validate jobseeker exists
            $jobseeker = $this->jobseekerModel->findById($jobseeker_id);
            if (!$jobseeker) {
                http_response_code(404);
                echo json_encode(['error' => 'Jobseeker not found']);
                return;
            }

            // Get recommendations
            $result = $this->recommendationService->getRecommendations($jobseeker_id, $top_k);

            if ($result['success']) {
                echo json_encode($result);
            } else {
                http_response_code(500);
                echo json_encode(['error' => $result['error']]);
            }
        } catch (Exception $e) {
            error_log('API Error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    }

    public function testConnection()
    {
        header('Content-Type: application/json');

        try {
            // Check if the method exists
            if (!method_exists($this->recommendationService, 'testConnection')) {
                // Fallback to testPythonScript if testConnection doesn't exist
                if (method_exists($this->recommendationService, 'testPythonScript')) {
                    $result = $this->recommendationService->testPythonScript();
                } else {
                    // Manual test if no test methods exist
                    $result = [
                        'success' => false,
                        'message' => 'No test methods available in JobRecommendationService'
                    ];
                }
            } else {
                $result = $this->recommendationService->testConnection();
            }

            if ($result['success']) {
                echo json_encode([
                    'success' => true,
                    'message' => $result['message'],
                    'timestamp' => date('Y-m-d H:i:s'),
                    'details' => $result['python_response'] ?? null
                ]);
            } else {
                http_response_code(503);
                echo json_encode([
                    'success' => false,
                    'message' => $result['message'],
                    'timestamp' => date('Y-m-d H:i:s'),
                    'debug_info' => $result
                ]);
            }
        } catch (Exception $e) {
            error_log('Connection Test Error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage(),
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function getJobseekerProfile()
    {
        header('Content-Type: application/json');

        try {
            if (!isset($_GET['jobseeker_id']) || empty($_GET['jobseeker_id'])) {
                http_response_code(400);
                echo json_encode(['error' => 'jobseeker_id parameter is required']);
                return;
            }

            $jobseeker_id = (int)$_GET['jobseeker_id'];
            $profileData = $this->jobseekerModel->getRecommendationData($jobseeker_id);

            if ($profileData) {
                echo json_encode([
                    'success' => true,
                    'data' => $profileData
                ]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Jobseeker not found or no profile data']);
            }
        } catch (Exception $e) {
            error_log('Get Profile Error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    }

    public function recommendedJobs()
    {
        try {
            // Ensure user is logged in
            if (!isset($_SESSION['user_id'])) {
                header('Location: ?page=login-jobseeker');
                exit;
            }

            // Get current jobseeker
            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
            if (!$jobseeker) {
                header('Location: ?page=complete-jobseeker-profile&error=profile_incomplete');
                exit;
            }

            $jobseeker_id = $jobseeker['jobseeker_id'];
            $top_k = isset($_GET['top_k']) ? (int)$_GET['top_k'] : 10;

            // Get recommendations
            $result = $this->recommendationService->getRecommendations($jobseeker_id, $top_k);

            $recommendations = null;
            $error = null;
            $success = null;

            if ($result['success']) {
                $recommendations = $result;
                $success = "Found {$result['total_found']} job recommendations for you.";
            } else {
                $error = $result['error'];
            }

            // Load the personalized view with jobseeker data for navbar
            $this->loadView('jobseekers/my-recommendations', [
                'recommendations' => $recommendations,
                'selectedJobseeker' => $jobseeker,
                'jobseeker' => $jobseeker,  // Add this for navbar
                'error' => $error,
                'success' => $success,
                'selectedJobseekerId' => $jobseeker_id,
                'topK' => $top_k
            ]);
        } catch (Exception $e) {
            error_log('Recommended Jobs Error: ' . $e->getMessage());

            $this->loadView('jobseekers/my-recommendations', [
                'recommendations' => null,
                'selectedJobseeker' => null,
                'jobseeker' => null,  // Add this
                'error' => 'An unexpected error occurred: ' . $e->getMessage(),
                'success' => null,
                'selectedJobseekerId' => '',
                'topK' => 10
            ]);
        }
    }

    // NEW METHOD: Enhanced recommendations with detailed job data
    public function getRecommendationsWithEnhancedDisplay()
    {
        try {
            $jobseeker_id = (int)$_GET['jobseeker_id'];
            $top_k = isset($_GET['top_k']) ? (int)$_GET['top_k'] : 10;

            // Get recommendations with new system
            $result = $this->recommendationService->getRecommendations($jobseeker_id, $top_k);

            if ($result['success']) {
                // NEW: Enhanced job data processing
                $enhancedJobs = [];

                foreach ($result['recommendations'] as $recommendation) {
                    // Merge job data with recommendation metadata
                    $jobData = $this->getJobPostDetails($recommendation['job_id']);

                    if ($jobData) {
                        $jobData['recommendation_data'] = [
                            'match_percentage' => $recommendation['match_percentage'],
                            'match_quality' => $recommendation['match_quality'],
                            'algorithm_type' => $recommendation['algorithm_type'] ?? 'enhanced',
                            'scoring_breakdown' => $recommendation['scoring_breakdown'],
                            'matched_skills' => $recommendation['matched_skills']
                        ];
                        $jobData['has_recommendation'] = true;
                        $enhancedJobs[] = $jobData;
                    }
                }

                // Load enhanced view
                $this->loadView('jobseekers/enhanced-recommendations', [
                    'jobs' => $enhancedJobs,
                    'jobseeker' => $result['jobseeker'],
                    'debug_info' => $result['debug_info'],
                    'quality_metrics' => $result['quality_metrics'],
                    'total_analyzed' => $result['total_jobs_analyzed'],
                    'total_filtered' => $result['jobs_after_filter']
                ]);
            } else {
                // Handle error
                $this->loadView('jobseekers/recommendations-error', [
                    'error' => $result['error']
                ]);
            }
        } catch (Exception $e) {
            error_log('Enhanced Recommendations Error: ' . $e->getMessage());
            // Fallback to regular recommendations
            $this->index();
        }
    }

    private function getJobPostDetails($job_id)
    {
        try {
            require_once __DIR__ . '/../models/JobPost.php';
            $jobModel = new JobPost();
            return $jobModel->getFullJobData($job_id);
        } catch (Exception $e) {
            error_log('Error getting job post details: ' . $e->getMessage());
            return null;
        }
    }

    private function loadView($viewPath, $data = [])
    {
        // Extract data variables for use in view
        extract($data);

        // Construct full view path
        $fullViewPath = __DIR__ . '/../views/' . $viewPath . '.php';

        // Check if view file exists
        if (!file_exists($fullViewPath)) {
            throw new Exception("View file not found: $fullViewPath");
        }

        // Include the view
        include $fullViewPath;
    }

    public function handleRequest()
    {
        $action = $_GET['action'] ?? 'index';
        $page = $_GET['page'] ?? '';

        // Handle page-based routing
        if ($page === 'recommended-jobs') {
            $this->recommendedJobs();
            return;
        }

        // Handle action-based routing
        switch ($action) {
            case 'index':
            case 'recommendations':
                $this->index();
                break;

            case 'my-recommendations':
                $this->recommendedJobs();
                break;

            case 'api':
                $this->getRecommendationsAPI();
                break;

            case 'test':
                $this->testConnection();
                break;

            case 'profile':
                $this->getJobseekerProfile();
                break;

            default:
                http_response_code(404);
                echo "Action not found";
                break;
        }
    }
}

if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    $controller = new JobRecommendationController();
    $controller->handleRequest();
}
