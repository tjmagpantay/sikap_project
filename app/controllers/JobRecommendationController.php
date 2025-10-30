<?php
// filepath: c:\xampp\htdocs\sikap\app\controllers\JobRecommendationController.php
require_once __DIR__ . '/../services/JobRecommendationService.php';
require_once __DIR__ . '/../models/Jobseeker.php';
require_once __DIR__ . '/../models/JobPost.php';

class JobRecommendationController
{
    private $recommendationService;
    private $jobseekerModel;
    private $jobPostModel;

    public function __construct()
    {
        $this->recommendationService = new JobRecommendationService();

        // Initialize models with proper database connection
        $config = require __DIR__ . '/../../config/sikap_db.php';
        $dsn = "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']};charset=utf8mb4";
        $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        $this->jobseekerModel = new Jobseeker($pdo);
        $this->jobPostModel = new JobPost($pdo);
    }

    /**
     * Display recommendations dashboard for admin
     */
    public function index()
    {
        try {
            // Check if user is admin
            if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
                header('Location: ?page=login-admin');
                exit;
            }

            // Get all jobseekers for selection
            $jobseekers = $this->jobseekerModel->getAllWithBasicInfo();

            // Include the view
            include __DIR__ . '/../views/admin/recommendations.php';
        } catch (Exception $e) {
            error_log('Error in recommendations index: ' . $e->getMessage());
            $error = 'Error loading recommendations page';
            include __DIR__ . '/../views/admin/recommendations.php';
        }
    }

    /**
     * Display recommended jobs for jobseeker
     */
    public function recommendedJobs()
    {
        try {
            // Check if user is jobseeker
            if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'jobseeker') {
                header('Location: ?page=login-jobseeker');
                exit;
            }

            $jobseeker = $this->jobseekerModel->findByUserId($_SESSION['user_id']);
            if (!$jobseeker) {
                header('Location: ?page=jobseeker-profile&error=Profile not found');
                exit;
            }

            // Get recommendations from Python service
            $recommendationsResult = $this->recommendationService->getRecommendations(
                $jobseeker['jobseeker_id'],
                10
            );

            $recommendations = [];
            $error = null;

            if ($recommendationsResult['success']) {
                $recommendations = $recommendationsResult['recommendations'] ?? [];
            } else {
                $error = $recommendationsResult['error'] ?? 'Failed to get recommendations';
                error_log('Recommendation error: ' . $error);
            }

            // Include the view
            include __DIR__ . '/../views/jobseekers/recommended-jobs.php';
        } catch (Exception $e) {
            error_log('Error getting recommended jobs: ' . $e->getMessage());
            $error = 'Error loading recommended jobs';
            $recommendations = [];
            include __DIR__ . '/../views/jobseekers/recommended-jobs.php';
        }
    }

    /**
     * API endpoint for getting recommendations
     */
    public function getRecommendationsAPI()
    {
        header('Content-Type: application/json');

        try {
            $jobseeker_id = $_POST['jobseeker_id'] ?? $_GET['jobseeker_id'] ?? null;
            $top_k = (int)($_POST['top_k'] ?? $_GET['top_k'] ?? 10);

            if (!$jobseeker_id) {
                echo json_encode([
                    'success' => false,
                    'error' => 'Jobseeker ID is required'
                ]);
                exit;
            }

            // Validate jobseeker exists
            $jobseeker = $this->jobseekerModel->findByJobseekerId($jobseeker_id);
            if (!$jobseeker) {
                echo json_encode([
                    'success' => false,
                    'error' => 'Jobseeker not found'
                ]);
                exit;
            }

            // Get recommendations
            $result = $this->recommendationService->getRecommendations($jobseeker_id, $top_k);
            echo json_encode($result);
        } catch (Exception $e) {
            error_log('API recommendations error: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'error' => 'Internal server error'
            ]);
        }
        exit;
    }

    /**
     * Test connection to ML service
     */
    public function testConnection()
    {
        header('Content-Type: application/json');

        try {
            $result = $this->recommendationService->testConnection();
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage()
            ]);
        }
        exit;
    }
}
