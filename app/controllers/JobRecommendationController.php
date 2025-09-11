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

    /**
     * Main recommendations page
     */
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

    /**
     * API endpoint for AJAX requests
     */
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

    /**
     * Test Flask API connection
     */
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

    /**
     * Get jobseeker profile data for debugging
     */
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

    /**
     * Get recommendations for current logged-in jobseeker (for navbar route)
     */
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

    /**
     * Get recommendations for current logged-in jobseeker (for debug view)
     */
    public function recommendedJobsDebug()
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

            // FIXED: Debug skill extraction using jobseekerModel instead of direct DB access
            echo "<h3>🔍 DEBUG: Skills Analysis</h3>";
            echo "<div style='background: #f5f5f5; padding: 15px; margin: 10px 0; border-radius: 5px;'>";

            // Get skills using the existing model method
            $skills_debug = $this->jobseekerModel->getSkills($_SESSION['user_id']);

            echo "<h4>Raw Skills from Database:</h4>";
            echo "<pre>";
            if ($skills_debug && !empty($skills_debug)) {
                print_r($skills_debug);

                // Show normalized skills
                echo "\nNormalized Skills for Matching:\n";
                $normalizedSkills = [];
                foreach ($skills_debug as $skill) {
                    $skillName = $skill['skill_name'];
                    $proficiency = $skill['proficiency_level'] ?? 'N/A';

                    // Show what the Python system should receive
                    $normalized = strtolower(trim($skillName));
                    $normalizedSkills[] = $normalized;

                    echo "- {$skillName} ({$proficiency}) -> '{$normalized}'\n";
                }

                echo "\nFinal Skills String for Python: '" . implode(', ', $normalizedSkills) . "'\n";
            } else {
                echo "❌ NO SKILLS FOUND! This explains the poor matching.\n";
                echo "User needs to complete their skills in Step 5 of profile completion.\n";
            }
            echo "</pre>";

            // Get work experience for context
            $experience_debug = $this->jobseekerModel->getWorkExperience($_SESSION['user_id']);
            echo "<h4>Work Experience:</h4>";
            echo "<pre>";
            if ($experience_debug && !empty($experience_debug)) {
                foreach ($experience_debug as $exp) {
                    echo "- {$exp['job_title']} at {$exp['company_name']}\n";
                }
            } else {
                echo "No work experience found.\n";
            }
            echo "</pre>";

            // Get education for context  
            $education_debug = $this->jobseekerModel->getEducation($_SESSION['user_id']);
            echo "<h4>Education:</h4>";
            echo "<pre>";
            if ($education_debug && !empty($education_debug)) {
                foreach ($education_debug as $edu) {
                    echo "- {$edu['education_level']} in {$edu['field_of_study']} from {$edu['school_name']}\n";
                }
            } else {
                echo "No education found.\n";
            }
            echo "</pre>";

            echo "</div>";

            // Test the Python service call
            echo "<h3>🚀 Python Recommendation Service Results:</h3>";
            $result = $this->recommendationService->getRecommendations($jobseeker_id, $top_k);

            $recommendations = null;
            $error = null;
            $success = null;

            if ($result['success']) {
                $recommendations = $result;
                $success = "Analysis complete. Found {$result['total_found']} recommendations.";

                // Additional debug info
                echo "<div style='background: #e8f5e9; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
                echo "<h4>✅ Python Service Response:</h4>";
                echo "<pre>";
                echo "Total Jobs Analyzed: {$result['total_jobs_analyzed']}\n";
                echo "Recommendations Found: {$result['total_found']}\n";
                if (isset($result['debug_info'])) {
                    echo "Jobseeker Skills Count: {$result['debug_info']['jobseeker_skills_count']}\n";
                    echo "Average Skill Match: " . number_format($result['debug_info']['avg_skill_ratio'] * 100, 2) . "%\n";
                    echo "Best Skill Match: " . number_format($result['debug_info']['best_skill_match'] * 100, 2) . "%\n";
                }
                echo "</pre>";
                echo "</div>";
            } else {
                $error = $result['error'];

                echo "<div style='background: #ffebee; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
                echo "<h4>❌ Python Service Error:</h4>";
                echo "<pre>{$error}</pre>";
                echo "</div>";
            }

            // Load DEBUG view
            $this->loadView('jobseekers/my-recommendations-debug', [
                'recommendations' => $recommendations,
                'selectedJobseeker' => $jobseeker,
                'jobseeker' => $jobseeker,
                'error' => $error,
                'success' => $success,
                'selectedJobseekerId' => $jobseeker_id,
                'topK' => $top_k
            ]);
        } catch (Exception $e) {
            error_log('Debug Recommendations Error: ' . $e->getMessage());

            echo "<div style='background: #ffebee; padding: 15px; margin: 10px 0; border-radius: 5px;'>";
            echo "<h3>❌ Debug Error:</h3>";
            echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
            echo "<h4>Stack Trace:</h4>";
            echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
            echo "</div>";

            $this->loadView('jobseekers/my-recommendations-debug', [
                'recommendations' => null,
                'error' => 'Debug error: ' . $e->getMessage(),
                'jobseeker' => null
            ]);
        }
    }

    /**
     * Load view with data
     */
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

    /**
     * Handle different routes (for routing system)
     */
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

// If this file is accessed directly, handle the request
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    $controller = new JobRecommendationController();
    $controller->handleRequest();
}
